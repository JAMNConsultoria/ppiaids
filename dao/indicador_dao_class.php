<?php

/**
 * @author Jasmil A. Oliveira
 *
 */
class IndicadorDAO extends PDOConnectionFactory {
	
	private $mode = null;
	private $pdo = null;
	
	public function IndicadorDAO($mode) {
		
		$this->mode = $mode;
		
		$this->pdo = new PDOConnectionFactory();
		
	}
	
	/**
	 * Retorna o objeto Indicador utilizando o Id.
	 * 
	 */
	public function findIndicadorById($indId) {
		
		$conn = $this->pdo->getConnection($this->mode);
		$sql  = " select indicador_cod,var_cod,indicador_nome";
		$sql .= " from tb_indicador WHERE var_cod = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(1, $indId);
		$stmt->execute();
		$arrObj = array();
		foreach ($stmt as $row){
			$obj = new IndicadorDTO();
			$obj->setIndicadorId($row[1]);
			$obj->setIndicadorNome($row[2]);
		}
		return $obj;
	}



	/**
	 * Retorna o objeto tabela indicador completo utilizando o Id.
	 *
	 */
	public function fichaByIndicadorId($indId) {

		$conn = $this->pdo->getConnection($this->mode);
		$sql  = " select indicador_cod, indicador_nome, 
                    indicador_fonte, indicador_interpretacao,
                    indicador_limitacao, indicador_descricao
                    from tb_indicador WHERE indicador_cod = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(1, $indId);
		$stmt->execute();
		$arrObj = array();
		foreach ($stmt as $row){
			$obj = new FichaDTO();
			$obj->setIndicadorId($row[0]);
			$obj->setIndicadorNome($row[1]);			
			$obj->setIndicadorFonte($row[2]);
			$obj->setIndicadorInterpretacao($row[3]);
			$obj->setIndicadorLimitacao($row[4]);
			$obj->setIndicadorDescricao($row[5]);
		}
		return $obj;
	}


      	/**
	 * Retorna o objeto Indicadores segundo os codigos(array) de indicadores passados.
	 *
	 */
        public function findIndicadoresByArrId($arrIndId) {
		$lstIndicadores = "'".implode("','",$arrIndId)."'";
                //echo $lstIndicadores;
		$conn = $this->pdo->getConnection($this->mode);
		$sql  = " select indicador_cod,var_cod,indicador_nome";
		$sql .= " from tb_indicador WHERE var_cod in ($lstIndicadores)";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$arrObj = array();
		foreach ($stmt as $row){
			$obj = new IndicadorDTO();
			$obj->setIndicadorId($row[1]);
			$obj->setIndicadorNome($row[2]);
                        $arrObj[$row[0]] = $obj;
		}
		return $arrObj;
	}
        /**
	 * Retorna um array de Indicadores com codigo e descriчуo segundo os codigos(array) de indicadores passados.
	 *
	 */
        public function findDescIndicadoresByArrId($arrIndId) {
		$lstIndicadores = "'".implode("','",$arrIndId)."'";
                //echo $lstIndicadores;
		$conn = $this->pdo->getConnection($this->mode);
		$sql  = " select indicador_cod, var_cod,indicador_nome";
		$sql .= " from tb_indicador WHERE var_cod in ($lstIndicadores)";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$arrDescInd = array();
		foreach ($stmt as $row){
                        $arrDescInd[$row[1]] = $row[2];
		}
		return $arrDescInd;
	}

        public function listFieldsByEixoCod($eixoCod) {
		$conn = $this->pdo->getConnection($this->mode);
		$sql  = " select var_cod from tb_indicador";
                $sql .= " WHERE eixo_cod = ?;";
                $stmt = $conn->prepare($sql);
		$stmt->bindValue(1, $eixoCod);
		$stmt->execute();
                $arrFields = array();
		foreach ($stmt as $row){
                        $arrFields[] = $row[0];
		}
		return $arrFields;
	}

        public function findIndicadorslistByEixoCod($eixoCod) {
		$conn = $this->pdo->getConnection($this->mode);
		$sql  = " select indicador_cod, indicador_nome from tb_indicador";
                $sql .= " WHERE eixo_cod = ?;";
                $stmt = $conn->prepare($sql);
		$stmt->bindValue(1, $eixoCod);
		$stmt->execute();
                $arrIndicadores = array();
		foreach ($stmt as $row){
                        $arrIndicadores[$row[0]] = $row[1];
		}
		return $arrIndicadores;
	}


    public function listAtributosIndicadorsByEixoCod($eixoCod) {
		$conn = $this->pdo->getConnection($this->mode);
		$sql  = " select eixo_cod,indicador_cod,var_cod,indicador_nome,indicador_original,";
		$sql .= " indicador_tamanho,indicador_formato,";
		$sql .= " indicador_alinhamento from tb_indicador";
                $sql .= " WHERE eixo_cod = ?;";
                $stmt = $conn->prepare($sql);
		$stmt->bindValue(1, $eixoCod);
		$stmt->execute();
                $arrIndicadores = array();
		foreach ($stmt as $row){
                    $arrIndicadores[$row[2]] = array('id'=>$row[1],'campo'=>$row[2],'nome'=>$row[3],'nome_curto'=>$row[4],'tamanho'=>$row[5],'formato'=>$row[6]);
		}
		return $arrIndicadores;
	}


        public function listAtributosIndicadorsByArrCod($arrIndics) {
                $indics = implode("','",$arrIndics);
		$conn = $this->pdo->getConnection($this->mode);
		$sql  = " select eixo_cod,indicador_cod,var_cod,indicador_nome,indicador_original,";
		$sql .= " indicador_tamanho,indicador_formato,";
		$sql .= " indicador_alinhamento from tb_indicador";
                $sql .= " WHERE var_cod in('".$indics."')";
                $sql .= " ORDER by indicador_cod ";
                $stmt = $conn->prepare($sql);
		$stmt->execute();
                $arrIndicadores = array();
		foreach ($stmt as $row){
                    $arrIndicadores[$row[2]] = array('id'=>$row[1],'campo'=>$row[2],'nome'=>addslashes($row[3]),'nome_curto'=>addslashes($row[4]),'tamanho'=>$row[5],'formato'=>$row[6]);
		}
		return $arrIndicadores;
	}


       	
}

?>