<?php
require_once("../business/base_business_class.php");
require_once("../dao/mysqldaofactory_class.php");
require_once("../domain/dados_dto_class.php");
require_once("../dao/dados_dao_class.php");
#require_once("../constants/global.php");


class DadosBusiness extends BaseBusiness {

	public function findDadosByLocId($locId,$arrIndics) {
		$oIdao = new DadosDAO(1);
		return $oIdao->findDadosByLocId($locId,$arrIndics);
	}

        public function findDadosByLocsAndIndics($arrLocs,$arrIndics,$formato,$painel,$where,$page,$limit,$sidx,$sord) {
 		$oIdao = new DadosDAO(1);
		return $oIdao->findDadosByLocsAndIndics($arrLocs,$arrIndics,$formato,$painel,$where,$page,$limit,$sidx,$sord);
	}
	
	
	
	

}
        
?>