<?php

class EixoDAO extends PDOConnectionFactory {
	
	private $mode = null;
	private $pdo = null;
	
	public function EixoDAO($mode) {

		$this->mode = $mode;
		
		$this->pdo = new PDOConnectionFactory();

	}

	public function listEixos() {

		$conn = $this->pdo->getConnection($this->mode);
		$stmt = $conn->prepare("SELECT eixo_cod, eixo_desc FROM tb_eixo order by eixo_ordem");
		$stmt->execute();

		$eixos = array();
                foreach ($stmt as $row) {
			$obj = new EixoDTO();
			$obj->setEixoId($row[0]);
			$obj->setEixoNome($row[1]);
			$eixos[$row[0]] = $obj;
		}
		return $eixos;
	}

        public function findEixoIndicadorById($idEixo) {

		$conn = $this->pdo->getConnection($this->mode);
                $sql  = " SELECT indicador_cod, var_cod, indicador_nome,eixo_cod  FROM tb_indicador";
                $sql .= " where eixo_cod = ?";
                $sql .= " order by indicador_ordem,indicador_nome;";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(1, $idEixo);
		$stmt->execute();

		$eixos = array();

                foreach ($stmt as $row) {
			$obj = new EixoIndicadorDTO();
			$obj->setIndicadorId($row[1]);
			$obj->setIndicadorNome($row[2]);
			$obj->setEixoId($row[3]);
			$eixos[$row[0]] = $obj;
		}
		return $eixos;
	}

        public function findEixosIdByArrIndics($arrIndics){
            $conn = $this->pdo->getConnection($this->mode);
            $lstIndics = implode("','",$arrIndics);
            $sql = "SELECT distinct eixo_cod from tb_indicador WHERE var_cod in('{$lstIndics}')";
            //echo $sql;
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $eixos = array();
            foreach ($stmt as $row) {
				$eixos[] = $row[0];
	     	}
	     return  $eixos;
        }

        public function findEixoByCod($codEixo) {
		$conn = $this->pdo->getConnection($this->mode);
		$stmt = $conn->prepare("SELECT eixo_cod, eixo_desc FROM tb_eixo WHERE eixo_cod=?");
		$stmt->bindValue(1, $codEixo);
		$stmt->execute();

                foreach ($stmt as $row) {
			$obj = new EixoDTO();
			$obj->setEixoId($row[0]);
			$obj->setEixoNome($row[1]);
		}
		return $obj;
	}


}
?>