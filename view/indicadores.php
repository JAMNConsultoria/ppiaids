<?php
  header('Content-Type: text/html; charset=iso-8859-1');
  require_once("../business/indicador_business_class.php");
  require_once("../business/eixo_business_class.php");
  include 'incs/cabecalho.php';

  if(isset($_REQUEST['eixo'])){
      $eixoCod = $_REQUEST['eixo'];
  }else{
      $eixoCod = 2;
  }
  $oIdao = new IndicadorBusiness();
  $arrIndics = $oIdao->findIndicadorslistByEixoCod($eixoCod);

  $oEdao = new EixoBusiness();

 ?>
<div id="wrapper">
	<div id="menu"><br />
        <?php include 'incs/menu.php'; ?>
    </div>   
<div id="conteudo"><br />
       <p class="tit">Sobre os Indicadores</p>
       <p class="textos">
       <div id="ListaInd">
       <p>Componente: <b><?php echo $oEdao->findEixoByCod($eixoCod)->getEixoNome(); ?></b></p>
       <ul class="ficha">
       <?php
          foreach($arrIndics as $codigo => $nome){
              echo "<li><a onclick=\"fichaSobre(this)\" name=\"{$codigo}\" target=\"_blank\">{$nome}</a></li>";
          }
       ?>
      </ul>
      </p>
       </div>
  <br />
  <div id="SobreInd" style="border:1px solid #999999;">
  <div id="sobre_nome"><?php echo $oEdao->findEixoByCod($eixoCod)->getEixoNome();?> </div> 
    <div id="bt_fechar"><a id='lnkfechar'>Fechar</a></div>
    <div id="bt_imprimir"><a id='lnkimprimir'>Imprimir</a></div>
    <br /><br />	  
      <div id="Ficha_SobreInd">   </div>
  </div>
</div>
<br />&nbsp;
</div>
<?php include 'incs/rodape.php'; ?> 

