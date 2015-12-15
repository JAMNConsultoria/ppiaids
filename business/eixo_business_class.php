<?php
require_once("../business/base_business_class.php");
require_once("../domain/eixo_dto_class.php");
require_once("../domain/eixoindicador_dto_class.php");
require_once("../dao/eixo_dao_class.php");

class EixoBusiness extends BaseBusiness {

	public function loadEixoIndicador() {
		$oEdao = new EixoDAO(1);

		// Retorna todos os temas
		$eixos = $oEdao->listEixos();
		foreach($eixos as $key => $eixo) {

			// Retorna uma lista de Indicadores por Tema
			$eixoIndicadors = $oEdao->findEixoIndicadorById($eixo->getEixoId());

			// Seta os indicadores no tema
			$eixo->setIndicadors($eixoIndicadors);
		}

		return $eixos;
	}

        public function findEixoIndicadorById($idEixo) {
            $oEdao = new EixoDAO(1);
            return $oEdao->findEixoIndicadorById($idEixo);
        }

        
        public function findEixosIdByArrIndics($arrIndics){
            $oEdao = new EixoDAO(1);
	        return $oEdao->findEixosIdByArrIndics($arrIndics);
        }

        public function listEixos(){
            $oEdao = new EixoDAO(1);
	        return $oEdao->listEixos();
        }

       public function findEixoByCod($codEixo) {
           $oEdao = new EixoDAO(1);
	       return $oEdao->findEixoByCod($codEixo);
       }



}
?>