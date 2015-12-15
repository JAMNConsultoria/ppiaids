<?php
  require_once("../business/indicador_business_class.php");
  require_once("../business/dados_business_class.php");
  require_once("../business/indicador_business_class.php");
  require_once("../business/eixo_business_class.php");
  require_once("../business/localidade_business_class.php");
  require_once("../constants/global.php");
  session_start();
  header("Content-Type: text/html; charset=iso-8859-1");
  $arrLocalidades = $_SESSION['localidades'];
  $arrIndicFields = $_SESSION['indicadores'];

  //tratamento paginacao
  $tipo=2;
  $page = $_REQUEST['page']; // get the requested page
  $limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
  $sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
  $sord = $_REQUEST['sord']; // get the direction
  if(!$sidx) $sidx ='mun_cod';
  $arrCamposTexto = array('mun_desc','grupo_desc','gve_desc','drs_desc','colegiado_desc','macroreg_desc');
  $arrCamposDesconsiderar = array('nd','rows','page','sidx','sord','PHPSESSID','_search','tipo');
  $wh = "";
  $searchOn = $_REQUEST['_search'];
  if($searchOn=='true') {
	$sarr = $_REQUEST;
	foreach( $sarr as $k=>$v) {
            if(!in_array($k,$arrCamposDesconsiderar)){
		if(in_array($k,$arrCamposTexto)) {
				$wh .= " AND ".$k." LIKE '".$v."%'";
                }else{
                    $wh .= " AND ".$k." LIKE '".$v."%'";
				#$wh .= " AND ".$k." = ".$v;
		}
	   }
       }
  }
  
  $output =3 ; // saída 2-csv 3-json, 4-html 5-XML
 
  //set variaveis de sessão para impressao e exportações
  $_SESSION['page']=$page;
  $_SESSION['limit']=$limit;
  $_SESSION['sidx']=$sidx;
  $_SESSION['sord']=$sord;
  $_SESSION['wh']=$wh;
  $_SESSION['arrIndicFields']=$arrIndicFields;


  //busca os dados para montagem do output
  $oDdao = new DadosBusiness();
  $tabela_dados = $oDdao->findDadosByLocsAndIndics($arrLocalidades, $arrIndicFields,$output,2,$wh,$page,$limit,$sidx,$sord);

   print("$tabela_dados");
   ?>