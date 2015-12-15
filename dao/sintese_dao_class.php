<?php
/**
 * @author Jasmil
 *
 */
class SinteseDAO extends PDOConnectionFactory {
	
	private $mode = null;
	private $pdo = null;
	
	public function SinteseDAO($mode) {
		
		$this->mode = $mode;
		
		$this->pdo = new PDOConnectionFactory();
		
	}
	
	/**
	 * Retorna a sintese (todos os indicadores) pelo id do município.
	 * 
	 */
	public function findSinteseByLocId($locId) {
            $conn = $this->pdo->getConnection($this->mode);
            $eixos = array();
            $stmt = $conn->prepare("SELECT eixo_cod, eixo_desc FROM tb_eixo WHERE eixo_cod >= 2 AND eixo_cod <= 6 ORDER BY eixo_ordem");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $eixo) {
                    $eixos[$eixo['eixo_cod']]['nome'] = utf8_encode($eixo['eixo_desc']);
                    $stmt = $conn->prepare("SELECT var_cod, indicador_nome, eixo_cod FROM tb_indicador WHERE eixo_cod = {$eixo['eixo_cod']} ORDER BY eixo_cod, indicador_nome");
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach($result as $indic) {
                            $eixos[$eixo['eixo_cod']]['indicadores'][$indic['var_cod']] = utf8_encode($indic['indicador_nome']);
                    }
            }

            $stmt = $conn->prepare("SELECT * FROM tb_dado where mun_cod = {$locId} ORDER BY mun_cod");
            $stmt->execute();
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
            $campos = array_keys($result[0]);
            $dados = array();
            $arrAlinhamento = array('drs_cod','gve_desc','mun_cod','colegiado_desc','grupo_desc','drs_desc','macroreg_desc','mun_desc', 'var090');
            foreach($result as $mun) {                    
                    foreach($mun as $campo => $valor) {
                            $out = '';                            
                            if($valor=='-1020' or $valor=='-1010'){
                                    $valor='NA';
                            }elseif (is_numeric($valor) && stripos($valor, ".")) {
                                    if ($valor) {
                                            if (stripos($valor, "0.00") === 0) {
                                                    $tmp = number_format($valor, 5, ',', '');
                                            } else {
                                                    $tmp = number_format($valor, 2, ',', '');
                                            }
                                    } else {
                                            $tmp = "-";
                                    }
                            } else {
                                   if(!in_array($campo, $arrAlinhamento)){
                                            $tmp = ($valor?number_format($valor, 0, '', ''):(!is_numeric($valor)?'-':$valor));
                                    }else{                                        
                                            $tmp = ($valor?$valor:(!is_numeric($valor)?'-':$valor));
                                    }
                            }
                            $dados[] = utf8_encode($tmp);
                    }
            }
            $arrResult=array('eixos' => $eixos, 'campos' => $campos, 'dados' => $dados);
            return $arrResult;
        
	}
       
}

?>