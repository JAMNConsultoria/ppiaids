<?php

/**
 * @author Jasmil Oliveira
 *
 */
class LocalidadeDAO extends PDOConnectionFactory {
	
	private $mode = null;
	private $pdo = null;
	
	public function LocalidadeDAO($mode) {

		$this->mode = $mode;
		
		$this->pdo = new PDOConnectionFactory();

	}

	/**
	 * Retorna o objeto Localidade utilizando o Id.
	 * 
	 */
	public function findLocById($locId) {

		$conn = $this->pdo->getConnection($this->mode);
                $sql  = " SELECT mun_cod, mun_desc, grupo_desc,  macroreg_desc, gve_desc, drs_desc, colegiado_desc";
                $sql .= " FROM tb_localidade";
                $sql .= " WHERE mun_cod = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(1, $locId);
		$stmt->execute();


    	        foreach ($stmt as $row){
			$obj = new LocalidadeDTO();
			$obj->setMunId($row[0]);
                        $obj->setMunNome($row[1]);
                        $obj->setGrupoNome($row[2]);
                        $obj->setMacroRegNome($row[3]);
                        $obj->setGveNome($row[4]);
                        $obj->setDrsNome($row[5]);
                        $obj->setColegiadoNome($row[6]);
		}
		return $obj;
	}


	/**
	 * Retorna o objeto Localidade utilizando o campo da area de abrangência.
	 *
	 */
	public function ListMunsByAbrangField($abrangencia) {

		$conn = $this->pdo->getConnection($this->mode);
                $sql = null;
                $sql = " SELECT mun_cod,mun_desc";
                switch ($abrangencia) {

                    case "macroreg":
                        $sql .=",macroreg_cod,macroreg_desc";
                        $orderby = " ORDER BY macroreg_desc, mun_desc";
                        break;
                    case "drs":
                        $sql .=",drs_cod,drs_desc";
                        $orderby = " ORDER BY drs_desc, mun_desc";
                        break;
                    case "gve":
                        $sql .=",gve_cod,gve_desc";
                        $orderby = " ORDER BY gve_desc, mun_desc";
                        break;
                    case "colegiado":
                        $sql .=",colegiado_cod,colegiado_desc";
                        $orderby = " ORDER BY colegiado_desc, mun_desc";
                        break;
                    case "municipio":
                    	$sql .=",mun_cod,substring(upper(mun_desc),1,1) as mun_alfa";
                        $orderby = " ORDER BY mun_desc";
                        break;
                    case "grupo":
                        $sql .=",grupo_cod,grupo_desc";
                        $orderby = " ORDER BY grupo_desc, mun_desc";
                        break;
                    default:
                        $sql .=",macroreg_cod,macroreg_desc";
                        $orderby = " ORDER BY macroreg_desc, mun_desc";
                        break;
                }
                $sql .= " FROM tb_localidade";
                $sql .= $orderby;
                
		$stmt = $conn->prepare($sql);
		$stmt->execute();
        $arrLoc = array();
                
    	foreach ($stmt as $row){
    		if($abrangencia=='municipio'){
    			$letra = ereg_replace("[^a-zA-Z0-9_.]", "", strtr($row[3], "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_"));
				$arrLoc[htmlentities($letra)][$row[0]] = htmlentities($row[1]);
    		}else{
    			$arrLoc[htmlentities($row[3])][$row[0]] = htmlentities($row[1]);
    		}
		}
		return $arrLoc;
	}




      /**
	 * Retorna todos os MunicÃ­pios ou RegiÃµes do Brasil segundo o nÃ­vel (2 - municipio ou 1-CGR).
	 * 
	 * @Return Array
	 */
	public function findLocsByNivelId($nivelId) {

		$conn = $this->pdo->getConnection($this->mode);
                $sql  = " SELECT localidadeId,regiaoId,localidadeNome,localidadeOrdem,localidadeNivel";
                $sql .= " FROM tblocalidade";
                $sql .= " WHERE localidadeNivel = ?";
                $sql .= " ORDER BY localidadeNome ASC";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(1, $nivelId);
		$stmt->execute();
                $arrObj = array();

    	        foreach ($stmt as $row){
			$obj = new LocalidadeDTO();
			$obj->setLocalidadeId($row[0]);
                        $obj->setRegiaoId($row[1]);
                        $obj->setLocalidadeNome($row[2]);
                        $obj->setLocalidadeOrdem($row[3]);
                        $obj->setLocalidadeNivel($row[4]);
                        $arrObj[$row[0]] = $obj;
		}
		return $arrObj;
	}


        public function findLocsByArrId($arrLocId) {
		$lstLocs = implode(",",$arrLocId);
                echo $lstLocs;
		$conn = $this->pdo->getConnection($this->mode);
		$sql  = " select mun_cod,mun_desc";
		$sql .= " from tb_localidade WHERE mun_cod in ($lstLocs)";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$arrObj = array();
		foreach ($stmt as $row){
			$obj = new LocalidadeDTO();
                        $obj->setMunId($row[0]);
                        $obj->setMunNome($row[1]);
                        $arrObj[$row[0]] = $obj;
		}
		return $arrObj;

        }

      /**
	 * Retorna todas Regioes segundo o nível.
	 * 
	 * @Return Array
	 */
public function ListAbrangByTipo($tipo) {

		$conn = $this->pdo->getConnection($this->mode);
                $sql = null;
                $sql = " SELECT";
                switch ($tipo) {

                    case "macroreg":
                        $sql .=" macroreg_cod,macroreg_desc";
                        $orderby = " ORDER BY macroreg_desc";
                        break;
                    case "drs":
                        $sql .=" drs_cod,drs_desc";
                        $orderby = " ORDER BY drs_desc";
                        break;
                    case "gve":
                        $sql .=" gve_cod,gve_desc";
                        $orderby = " ORDER BY gve_desc";
                        break;
                    case "colegiado":
                        $sql .=" colegiado_cod,colegiado_desc";
                        $orderby = " ORDER BY colegiado_desc";
                        break;
                    case "municipio":
                    	$sql .=" mun_cod, mun_desc";
                        $orderby = " ORDER BY mun_desc";
                        break;
                    case "grupo":
                        $sql .=" grupo_cod,grupo_desc";
                        $orderby = " ORDER BY grupo_desc";
                        break;
                    default:
                        $sql .=" macroreg_cod,macroreg_desc";
                        $orderby = " ORDER BY macroreg_desc";
                        break;
                }
                $sql .= " FROM tb_localidade";
                $sql .= $orderby;

		$stmt = $conn->prepare($sql);
		$stmt->execute();
                $arrLoc = array();

                foreach ($stmt as $row){
    			$arrLoc[$row[0]] = $row[1];
        	}
		return $arrLoc;
	}


}

?>