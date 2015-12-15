<?php
  require_once("../business/indicador_business_class.php");
  require_once("../business/dados_business_class.php");
  require_once("../business/indicador_business_class.php");
  require_once("../business/eixo_business_class.php");
  require_once("../business/localidade_business_class.php");
  session_start();

  $page=1;
  $limit=645;
  $sidx=$_SESSION['sidx'];
  $sord=$_SESSION['sord'];
  $wh=$_SESSION['wh'];
  $arrIndicFields=$_SESSION['arrIndicFields'];
  $arrLocs =$_SESSION['localidades'];

  $output=0;
  //tipos de saídas 0 - array, 1-excel xls, 2-csv e 3-JSON , 4 - html para impressao
  if(isset($_REQUEST["export"])){
    $output = $_REQUEST["export"];
  }else{
    $output =4 ; // saída em html
  }

  if(isset($_REQUEST['eixo'])){
      $eixo = $_REQUEST['eixo'];
      $oEdao = new EixoBusiness();
      $objEixo = $oEdao ->findEixoByCod($eixo);
      $msg = "Painel de Indicadores - ". $objEixo->getEixoNome();
      $arrLocs=null;
  }else{
      $msg = "Pesquisa Avançada - indicadores selecionados";
  }



  //busca os dados para montagem do output
  $oDdao = new DadosBusiness();
  if (isset ($_REQUEST['eixo'])){
      $tipoexp=1; //exportar do painel
  }else{
      $tipoexp=2; //exportar do pesq. avanc.
  }
  //tipo da saida =1 painel no formato output =4 html
  $tabela_dados = $oDdao->findDadosByLocsAndIndics($arrLocs, $arrIndicFields,$output,$tipoexp,$wh,$page,$limit,$sidx,$sord);
  

  $data = date('dmY_His');
  $filename = "ppiaids_".$data;

switch($output) {
 case "1":
	//XLS - exibe a tabela pronta em html para XLS
	header("Content-Type:  application/vnd.ms-excel");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header ("Content-Disposition: attachment; filename=\"".$filename.".xls\"" );
	print("$tabela_dados");
	break;
    
case "2": // formato CSV
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=\"".$filename.".csv\"");
	print("$tabela_dados");
	break;

case "3": // formato JSON
         print($tabela_dados);
         break;

case "4": // formato Html
    header('Content-Type: text/html; charset=iso-8859-1');
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8;charset=iso-8859-1;" />
<title></title>
<link rel="stylesheet" href="css/crt_estilos.css" type="text/css" />
</head>
    <body onload="window.print()">
    <div class="center">

	<div id="cabec"><a href="index.php"><img src="img/logo_painel.gif" /></a></div>
  <br />
    <div id="tabelas">
      <div class="cabec">
	<div class="tit"><?php echo $msg;?></div>
	<div class="nav"><a href="javascript:window.close();">&laquo; fechar</a></div>
      </div>
       <br /><br />
<?php
	print("$tabela_dados"); 
        include 'incs/rodape.php';

	break;          
}
?>