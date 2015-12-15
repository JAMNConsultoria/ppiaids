<?php
/**
 * @author Jasmil
 *
 */
class DadosDAO extends PDOConnectionFactory {
	
	private $mode = null;
	private $pdo = null;
	
	public function DadosDAO($mode) {
		
		$this->mode = $mode;
		
		$this->pdo = new PDOConnectionFactory();
		
	}
	
	/**
	 * Retorna o array de indicadores pela localidade ID (municipio ou total da CGR).
	 * 
	 */
	public function findDadosByLocId($locid,$arrIndics) {
		
		$conn = $this->pdo->getConnection($this->mode);
        $indics = implode(',',$arrIndics);
		$sql  = " SELECT {$indics} from tb_dado";
		$sql .= " WHERE mun_cod = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(1, $locid);
		$stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
        
	}


         /**
	 * Retorna o array de indicadores pela localidade ID (municipio ou uf ou total da CGR).
         * nos formatos  0=array, 1=html, 2=csv, 3=json
	 *
	 */
	public function findDadosByLocsAndIndics($arrLocs,$arrIndics,$formato=0,$painel,$where,$page,$limit,$sidx,$sord) {

		$conn = $this->pdo->getConnection($this->mode);

                //query para contagem
                $sqlPaginacao = " SELECT count(*) from tb_dado where 1=1 {$where}";
                $stmt1 = $conn->prepare($sqlPaginacao);
                $stmt1->execute();
                //qtde de registros retornados
                $count=$stmt1->fetchColumn();

                if( $count >0 ) {
                    $total_pages = ceil($count/$limit);
                } else {
                    $total_pages = 0;
                }
                if ($page > $total_pages) $page=$total_pages;
                    $start = $limit*$page - $limit;
                    if ($start<0) $start = 0;

                //fim da contagem                
                $indics = implode(',',$arrIndics);
                //1- painel
                if($painel!=1){
                    $sql   = " SELECT  mun_cod, mun_desc,{$indics} ";
                    $arrHeader = array('Código','Município');
                }else{
                    $sql   = " SELECT  macroreg_desc,drs_desc,gve_desc,colegiado_desc,mun_cod, mun_desc,grupo_desc,{$indics} ";
                    $arrHeader = array('Macro-região','DRS','GVE','Colegiado','Código','Município','Grupo');
                }
                $sql  .= " FROM tb_dado ";
                if(is_array($arrLocs)){
                    $locs = implode(',',$arrLocs);
                    $sql  .= " WHERE mun_cod in ({$locs}) {$where}";
                }else{
                    $sql  .= " WHERE 1=1  {$where}";
                }
                $sql  .= " ORDER BY {$sidx} {$sord} limit {$start},{$limit}";
                #echo "<b>{$sql}</b>";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
                $resConsulta = $stmt->fetchAll(PDO::FETCH_ASSOC);                
                
               

                switch ($formato){
                    case 0: //array
                        $result=$resConsulta;
                        break;

                    case EXCEL: // xls
                    case HTML: // html
                        $oIdao = new IndicadorBusiness();
                        $arrDescFields = $oIdao->findDescIndicadoresByArrId($arrIndics);
                        $arrTroca = array(-1001=>'não se aplica',-1002=>'inexistente');
                        $arrAlinhamento =array('drs_cod','gve_desc','mun_cod','colegiado_desc','grupo_desc','drs_desc','macroreg_desc','mun_desc','var090');
                        //cabeçalho da tabela
                        $header="<thead><tr>";
                        foreach ($arrHeader as $indice => $desc){
                            $header.= "<th>{$desc}</th>";
                        }
                        foreach($arrIndics as $indice => $indicadorId){
                            $header.="<th align='right'>{$arrDescFields[$indicadorId]}</th>\r\n";
                        }
                        $header.="</tr></thead><tbody>";
                        //inicio do corpo da tabela
                        $tabela = '<table cellpadding="0" cellspacing="0" border="0" class="geral" width="55%" id="table">';
                        $tabela .= $header;
                        
                        foreach($resConsulta as $indice => $tabelas){
                            $tabela .= "<tr>";

                            foreach($tabelas as $campo => $valor){
                                if (in_array($campo, $arrAlinhamento)){
                                    $tabela .= "\t<td align='left'>";
                                }else{
                                    $tabela .= "\t<td align='right'>";
                                }
                                

                                $tabela .= str_replace(".",",",$valor)."</td>\r\n";
                                
                            }

                            $tabela .= "</tr>";
                        }
                       

                        $tabela .= "</tbody></table>";
                        $result = $tabela;
                        break;

                    case CSV: // CSV
                        $oIdao = new IndicadorBusiness();
                        $arrDescFields = $oIdao->findDescIndicadoresByArrId($arrIndics);
                        #$arrHeader = array('CÓDIGO','MUNICÍPIO');
                        //$arrHeader = array('drs_cod','gve_cod','mun_cod','colegiado_desc','grupo_desc','drs_desc','macroreg_desc','mun_desc');
                        $arrTroca = array(-1001=>'não se aplica',-1002=>'inexistente');
                        $arrAlinhamento =array('drs_cod','gve_desc','mun_cod','colegiado_desc','grupo_desc','drs_desc','macroreg_desc','mun_desc');
                        
                        //cabeçalho da tabela
                        $headerCSV =implode(";",$arrHeader);
                        $headerCSV .=";";

                        foreach($arrIndics as $indice => $indicadorId){
                            $headerCSV.=$arrDescFields[$indicadorId].";";
                        }
                        $headerCSV .="\r\n";
                        foreach($resConsulta as $indice => $tabelas){
                            foreach($tabelas as $campo => $valor){

                                $tabelaCSV .= str_replace(".",",",$valor).";";

                            }
                            $tabelaCSV=substr($tabelaCSV, 0, strlen($tabelaCSV)-1);//retira a último ponte-e-virgula do registro ";"
                            $tabelaCSV.="\r\n"; //pula linha
                        }
                        $result = $headerCSV.$tabelaCSV;
                        break;

                    case JSON: //json
                        $arrSaltar=array("mun_cod");
						$s =  "{";
						$s .= "\"page\":\"{$page}\",";
						$s .= "\"total\":\"{$total_pages}\",";
						$s .= "\"records\":\"{$count}\",";
						$s .= "\"rows\":[";											 
						foreach($resConsulta as $indice => $tabelas) {
						    $s .= "{\"id\":\"". $tabelas['mun_cod']."\",";
						    $s.="\"cell\":[";
						    foreach($tabelas as $campo => $valor){
						    	   //if(!in_array($campo,$arrSaltar))
						    	    $s .= "\"".$valor."\",";						    	
						    }
						    $s=substr($s,0,strlen($s)-1);
						    $s .= "]},"; 
						 }
						$s=substr($s,0,strlen($s)-1);    			
						$s .= "]";//rows
						$s .= "}"; 					
					    $result=$s;
                        break;



                        
                    case XML: //xml                    					 
						$s = "<?xml version='1.0' encoding='iso-8859-1'?>";
						$s .=  "<rows>";
						$s .= "<page>".$page."</page>";
						$s .= "<total>".$total_pages."</total>";
						$s .= "<records>".$count."</records>";					 
						// textos em CDATA
						foreach($resConsulta as $indice => $tabelas) {
						    $s .= "<row id='". $tabelas['mun_cod']."'>";
						    foreach($tabelas as $campo => $valor){
						    	if(is_numeric($valor)){
						    	    $s .= "<cell>". $valor."</cell>";
						    	}else{
						    		$s .= "<cell><![CDATA[". $valor."]]></cell>";
						    	}					    	
						    }
						    $s .= "</row>"; 
						 }    			
	
						$s .= "</rows>"; 					
					    $result=$s;
						break;
                }
                return $result;
	}
        
}

?>