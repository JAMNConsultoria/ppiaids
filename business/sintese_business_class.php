<?php
require_once("../business/base_business_class.php");
require_once("../dao/mysqldaofactory_class.php");
require_once("../dao/sintese_dao_class.php");


class SinteseBusiness extends BaseBusiness {

	public function findSinteseByLocId($locId) {
		$oSdao = new SinteseDAO(1);
		return $oSdao->findSinteseByLocId($locId);
	}

}
        
?>