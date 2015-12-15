<?php
  session_start();
  header('Content-Type: text/html; charset=iso-8859-1');
  require_once("../business/indicador_business_class.php");


if (isset($_REQUEST['clrSession']) && ($_GET['clrSession'] == "true" || empty($_GET['clrSession']))) {
	unset($_SESSION['localidades']);
	unset($_SESSION['indicadores']);
}
?>
<?php include 'incs/cabecalho.php'; ?>
<div id="wrapper">
<div id="menu"><br /><?php include 'incs/menu.php'; ?></div>
<div id="conteudo"><br />
	<p class="tit">Pesquisa Avançada</p>
	<div id="grupoTit"><span>Passo 1 &rsaquo;</span> &nbsp;Selecione os INDICADORES:</div>
	<div id="grupoInd">
        <?php include("eixoindicadores.php");?>
	</div>
    <br />
    <br />
    <div id="botao">
        <input type="image" src="img/bt_seguir.gif" name="btnEnviar" id="btnEnviar"> <br /><br />
    </div>
  <br />&nbsp;
</div>

</div>
<?php include 'incs/rodape.php'; ?> 