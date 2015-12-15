<?php

/**
 * @author Jasmil
 *
 */
class GrupoDAO extends PDOConnectionFactory {

	private $conn = null;

	public function GrupoDAO($mode) {

		$this->conn = PDOConnectionFactory::getConnection($mode);

	}

	/**
	 * Retorna um array de tipos de grupos de variáveis.
	 *
	 */
	public function findAllGrupoVars() {

		$stmt = $this->conn->prepare("SELECT grupoId, grupoNome FROM tbgrupo");
		$stmt->execute();
		$arrTipos = array();
    	        foreach ($stmt as $row){
    		   $arrTipos[$row[0]] = $row[1];
		}
		return $arrTipos;
	}
}

?>