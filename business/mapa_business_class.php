<?php
require_once("../business/base_business_class.php");
require_once("../dao/mapa_dao_class.php");

class MapaBusiness extends BaseBusiness {
	
        public function findCgrsByGrupoSocioAndUf($grupoSocio,$ufId){
            $oMdao = new MapaDAO(1);
	    return $oMdao->findCgrsByGrupoSocioAndUf($grupoSocio,$ufId);
        }
}
?>