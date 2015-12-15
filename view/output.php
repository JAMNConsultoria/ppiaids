<?php
  require_once("../business/indicador_business_class.php");
  require_once("../business/dados_business_class.php");
  session_start();
  $output=0;
  //tipos de saídas 0 - array, 1-excel xls, 2-csv e 3-JSON , 4 - html
  if(isset($_REQUEST["export"])){
    $output = $_REQUEST["export"];
  }else{
    $output =4 ; // saída em html
  }

  $arrLocalidades = $_SESSION['localidades'];
  $arrIndicadores = $_SESSION['indicadores'];

  //busca os dados para montagem do output
  $oDdao = new DadosBusiness();
  $tabela_dados = $oDdao->findDadosByLocsAndIndics($arrLocalidades, $arrIndicadores,$output);

switch($output)
{
 case "1":
	//XLS - exibe a tabela pronta em html para XLS
        $data = date('dmY_His');
        $filename = "painel_indic_".$data;
	header("Content-Type:  application/vnd.ms-excel");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header ("Content-Disposition: attachment; filename=\"".$filename.".xls\"" );
	print("$tabela_dados");
	break;
    
case "2": // formato CSV
        $data = date('dmY_His');
        $filename = "painel_indic_".$data;
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
<link rel="stylesheet" href="css/tabela.css" type="text/css" />
<link rel="stylesheet" href="css/crt_estilos.css" type="text/css" />
<script type="text/javascript" src="js/ppiaids.js"></script>
</head>
    <div align="center" class="center">
	<?php include 'incs/barra.php'; ?>
	<div id="cabec"><a href="index.php"><img src="img/logo_painel.gif" /></a></div>
  <br />
    <div id="tabelas">
      <div class="cabec">
	<div class="tit">Pesquisa Avançada - Indicadores Selecionados</div>
	<div class="nav"><a href="javascript:window.close();">&laquo; fechar</a></div>
      </div>
      <br /><br />
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
           <tr>
            <td>&nbsp;</td>
            <td class="nav"><a href="output.php?export=1" class="exp">Exportar para Excel</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="output.php?export=2" class="exp">Exportar para CSV</a></td>
          </tr>
       </table>
       <br /><br />

<?php
	print("$tabela_dados");
?>
	<div id="controls">
		<div id="perpage">
			<select onchange="sorter.size(this.value)">
			<option value="5">5</option>
				<option value="10">10</option>
				<option value="20" selected="selected">20</option>
				<option value="50">50</option>
				<option value="100">100</option>
			</select>
			<span style="font-family: verdana,arial;font-size: 10px; font-weight: bold">Linhas por Página</span>
		</div>
		<div id="navigation">
			<img src="images/first.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1,true)" />
			<img src="images/previous.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1)" />
			<img src="images/next.gif" width="16" height="16" alt="First Page" onclick="sorter.move(1)" />
			<img src="images/last.gif" width="16" height="16" alt="Last Page" onclick="sorter.move(1,true)" />
		</div>
		<div id="text">Mostrando Página <span id="currentpage"></span> de <span id="pagelimit"></span></div>
	</div>
	<script type="text/javascript" src="js/output.js"></script>
	<script type="text/javascript">
  var sorter = new TINY.table.sorter("sorter");
	sorter.head = "head";
	sorter.asc = "asc";
	sorter.desc = "desc";
	sorter.even = "evenrow";
	sorter.odd = "oddrow";
	sorter.evensel = "evenselected";
	sorter.oddsel = "oddselected";
	sorter.paginate = true;
	sorter.currentid = "currentpage";
	sorter.limitid = "pagelimit";
	sorter.init("table",1);
  </script>

   </div>
<br /><br />

<div id="rodape">
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
  	<tr>
     	<td width="21%" align="left"><a href="http://www.saude.sp.gov.br/" target="_blank"><img src="img/logo_ses.jpg" /></a></td>
      <td width="32%" align="center"><a href="http://www.crt.saude.sp.gov.br/" target="_blank"><img src="img/logo_crt.jpg" /></a></td>
    	<td width="22%" align="left"><a href="http://www.ccd.saude.sp.gov.br/" target="_blank"><img src="img/logo_ccd.jpg" /></a></td>
          	<td width="25%" align="right"><a href="http://www.seade.gov.br/" target="_blank"><img src="img/logo_seade.gif" /></a></td>
    </tr>
  </table>
	</div>

</div>

</body>
</html>

<?php
	break;
            
}



?>