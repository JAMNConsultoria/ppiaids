<?php
require_once("../business/base_business_class.php");
require_once("../dao/mysqldaofactory_class.php");
require_once("../domain/localidade_dto_class.php");
require_once("../dao/localidade_dao_class.php");


class LocalidadeBusiness extends BaseBusiness {

	public function findLocById($locId) {
		$oLdao = new LocalidadeDAO(1);
		return $oLdao->findLocById($locId);
	}

        public function ListMunsByAbrangField($abrangencia){
            $oLdao = new LocalidadeDAO(1);
            return $oLdao->ListMunsByAbrangField($abrangencia);
        }
        
        public function findLocsByCgrId($cgrId) {
		$oLdao = new LocalidadeDAO(1);
		return $oLdao->findLocsByCgrId($cgrId);
	}

        public function findLocsByNivelId($nivelId) {
		$oLdao = new LocalidadeDAO(1);
		return $oLdao->findLocsByNivelId($nivelId);
	}

        public function findLocsByArrId($arrLocId) {
		$oIdao = new LocalidadeDAO(1);
		return $oIdao->findLocsByArrId($arrLocId);
	}

        public function ListAbrangByTipo($tipo){
		$oIdao = new LocalidadeDAO(1);
		return $oIdao->ListAbrangByTipo($tipo);
	}


}
        
?>