<?php
require_once("../business/base_business_class.php");
require_once("../dao/mysqldaofactory_class.php");
require_once("../dao/grupo_dao_class.php");

class GrupoBusiness extends BaseBusiness {

	public function findAllGrupoVars() {
            $oTdao = new GrupoDAO(1);
            return $oTdao->findAllGrupoVars();
                
	}
}
?>