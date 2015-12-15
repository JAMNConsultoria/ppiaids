<?php
header('Content-Type: text/html; charset=iso-8859-1');
require_once("../business/sintese_business_class.php");
require_once("../business/localidade_business_class.php");

if(isset($_REQUEST['munId'])){
    $munId = $_REQUEST['munId'];
}else{
    $munId = 350010;
}

$sDao = new SinteseBusiness();
$arrDados = $sDao->findSinteseByLocId($munId);

$lDao = new LocalidadeBusiness();
$objLoc = $lDao->findLocById($munId);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8;charset=iso-8859-1;" />
<title><?php echo htmlentities("Síntese do município");?></title>

<link rel="stylesheet" type="text/css" media="screen" href="css/redmond/jquery-ui-1.8.2.custom.css" />
<link rel="stylesheet" href="css/crt_estilos.css" type="text/css" />
<script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script>
 $(document).ready(function(){
	$('a.newlink').click(function() {
		var divName ="#" + $(this).attr("name");               
		if ($(divName).css("display") =='none'){
			$(divName).show();
		}else{
			$(divName).hide();
		}
	});
});
</script>
<style>
a.newlink, a.newlink:visited, a.newlink:active {color:#cc0000; font-family:verdana; font-size:14px; font-weight:bold; text-decoration:underline;}
a.newlink:hover {color:#f00; font-family:verdana; font-size:14px; font-weight:bold; text-decoration:none;}
</style>
</head>
  <body style="margin-left: 10px;margin-top: 10px">
      <div id="titulo"  style="width: 525px;border: 1px solid #000;border-bottom: 1px solid #DFDFDF; background:#DFDFDF;padding: 5px 5px">
          <?php echo "<b>Informações do Município de <font color='#FF0000'>".$objLoc->getMunNome()."</font></b>"; ?>&nbsp;&nbsp; <a href="pdf/analise_<?php echo $objLoc->getMunId()?>.pdf" title="Análise Municipal" target="_blank"><img border="0" src="img/icone_analise.gif" title="Análise Municipal"/></a>
          <img src="img/icone_print.gif"/><img src="img/icone_csv.gif"/><img src="img/icone_excel.gif"/>
      </div>
    <div id="informacoes"  style="width: 515px; height: 498px; border: 1px solid #000;border-top: 1px solid #DFDFDF;padding: 15px 15px 5px 5px;overflow: auto;">
<?php
echo '<div id="tabelas">';
foreach($arrDados['eixos'] as $eixoId => $eixo){

    echo '<div style="text-align:left;border: 1px dotted #bdbdbd;width: 485px;padding: 5px 5px 5px 5px;"><b><a href="#" class="newlink" name="eixo_'.$eixoId.'">'. utf8_decode($eixo['nome'])."</a></b></div>";
    echo '<div id="eixo_'.$eixoId.'" style="display:none">';
    echo "<table class='geral' style='width:500px'>";
    $c=0;
    foreach($eixo['indicadores'] as $indCod => $indNome){
        $c++;
        $chave = array_search($indCod,$arrDados['campos']);
        $class =($c%2?'class = cor':'');
        echo "<tr $class><td>".utf8_decode($indNome)."</td><td width='60'>".$arrDados['dados'][$chave]."</td></tr>";
    }
    echo '</table>';
    echo '</div><br/>';
}
echo '</div>';
?>
      </div>
  </body>
</html>