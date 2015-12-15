<?php

/**
 * @author Jasmil
 *
 */
class PainelDAO extends PDOConnectionFactory {
	
	private $mode = null;
	private $pdo = null;
	
	public function PainelDAO($mode) {
		
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
              $stmt->closeCursor();
              return $result;
	}


         /**
	 * Retorna o array de indicadores pela localidade ID (municipio ou uf ou total da CGR).
         * nos formatos  0=array, 1=html, 2=csv, 3=json
	 *
	 */
	public function findDadosByLocsAndIndics($arrLocs,$arrIndics,$formato=0) {

		$conn = $this->pdo->getConnection($this->mode);
                $indics = implode(',',$arrIndics);
                $locs = implode(',',$arrLocs);

                #$sql   = " SELECT mun_cod, mun_desc,grupo_desc,drs_desc,colegiado_desc,{$indics} ";

		$sql   = " SELECT {$indics} ";
                $sql  .= " FROM tb_dado ";
		$sql  .= " WHERE mun_cod in ({$locs})";
                $sql  .= " ORDER BY mun_desc ASC";
                #echo "<b>{$sql}</b>";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
                #echo "formato=".$formato;
                $resConsulta = $stmt->fetchAll(PDO::FETCH_ASSOC);
		  $stmt->closeCursor();

                switch ($formato){
                    case 0: //array
                        $result=$resConsulta;
                        break;

                    case 1: // xls
                    case 4: // html
                        $oIdao = new IndicadorBusiness();
                        $arrDescFields = $oIdao->findDescIndicadoresByArrId($arrIndics);
                        #$arrHeader = array('CÓDIGO','Município','Grupo','drs','colegiado');
                        $arrTroca = array(-1001=>'não se aplica',-1002=>'inexistente');
                        $arrAlinhamento =array('drs_cod','gve_cod','mun_cod','colegiado_desc','grupo_desc','drs_desc','macroreg_desc','mun_desc');
                        //cabeçalho da tabela
                        $header="<thead><tr>";
                        /*foreach ($arrHeader as $indice => $desc){
                            $header.= "<th><h3 align='center'>&nbsp;&nbsp;{$desc}&nbsp;&nbsp;</h3></th>";
                        }*/
                        foreach($arrIndics as $indice => $indicadorId){
                            $header.="<th align='right'><h3 align='left'>&nbsp;{$arrDescFields[$indicadorId]}&nbsp;</h3></th>\r\n";
                        }
                        $header.="</tr></thead><tbody>";
                        //inicio do corpo da tabela
                        $tabela = '<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable">';
                        $tabela .= $header;
                        
                        foreach($resConsulta as $indice => $tabelas){
                            $tabela .= "<tr>";
                             //foreach do marcio

                            foreach($tabelas as $campo => $valor){
                                if (in_array($campo, $arrAlinhamento)){
                                    $tabela .= "\t<td align='left'>";
                                }else{
                                    $tabela .= "\t<td align='right'>";
                                }
								//não se aplica ou não disponível
								if($valor=='-1001' or $valor=='-1002'){
								 $valor='NA';
								}
                                if (is_numeric($valor) && stripos($valor, ".")) {
                                        if ($valor) {
                                                if (stripos($valor, "0.00") === 0) {
                                                        $tabela .= number_format($valor, 5, ',', '');
                                                }
                                                else {
                                                        $tabela .= number_format($valor, 2, ',', '');
                                                }
                                        }
                                        else {
                                                $tabela .= "-";
                                        }
                                }
                                else {
                                    if(!in_array($campo, $arrAlinhamento)){
                                        $tabela .= ($valor?number_format($valor, 0, '', ''):(!is_numeric($valor)?'-':$valor));
                                    }else{
                                        $tabela .= ($valor?$valor:(!is_numeric($valor)?'-':$valor));
                                    }
                                }

                                $tabela .= stripos($valor, "0.00")."</td>\r\n";
                                
                            }
                        //fim foreach marcio

                         //
                         //   foreach($tabelas as $campo => $valor){
                         //       $tabela .= "\t<td>".($valor?$valor:'-')."</td>\r\n";
                         //   }

                            $tabela .= "</tr>";
                        }
                       

                        $tabela .= "</tbody></table>";
                        $result = $tabela;
                        break;

                    case 2: // CSV
                        $oIdao = new IndicadorBusiness();
                        $arrDescFields = $oIdao->findDescIndicadoresByArrId($arrIndics);
                        #$arrHeader = array('CÓDIGO','Tipo Localidade','UF','CGR','Município');
                        $arrHeader = array('drs_cod','gve_cod','mun_cod','colegiado_desc','grupo_desc','drs_desc','macroreg_desc','mun_desc');
                        $arrTroca = array(-1001=>'não se aplica',-1002=>'inexistente');
                        $arrAlinhamento =array('drs_cod','gve_cod','mun_cod','colegiado_desc','grupo_desc','drs_desc','macroreg_desc','mun_desc');
                        
                        //cabeçalho da tabela
                        $headerCSV =implode(";",$arrHeader);
                        $headerCSV .=";";

                        foreach($arrIndics as $indice => $indicadorId){
                            $headerCSV=$arrDescFields[$indicadorId].";";
                        }
                        $headerCSV .="\r\n";
                        foreach($resConsulta as $indice => $tabelas){
                            foreach($tabelas as $campo => $valor){
                                if (is_numeric($valor) && stripos($valor, ".")) {
                                        if ($valor) {
                                                if (stripos($valor, "0.00") === 0) {
                                                        $tabelaCSV .= number_format($valor, 5, ',', '.');
                                                }
                                                else {
                                                        $tabelaCSV .= number_format($valor, 2, ',', '.');
                                                }
                                        }
                                        else {
                                                $tabelaCSV .= "-";
                                        }
                                }
                                else {
                                    if(!in_array($campo, $arrAlinhamento)){
                                        $tabelaCSV .= ($valor?number_format($valor, 0, '', '.'):(!is_numeric($valor)?'-':$valor));
                                    }else{
                                        $tabelaCSV .= ($valor?$valor:(!is_numeric($valor)?'-':$valor));
                                    }
                                }

                                $tabelaCSV .= stripos($valor, "0.00").";";

                            }
                            $tabelaCSV=substr($tabelaCSV, 0, strlen($tabelaCSV)-1);//retira a último ponte-e-virgula do registro ";"
                            $tabelaCSV.="\r\n"; //pula linha
                        }
                        $result = $headerCSV.$tabelaCSV;
                        break;


                    case 3: //json
                        $json = json_encode($resConsulta);
                        $result=$json;
                        break;

                }
                return $result;
	}
        
}

?>