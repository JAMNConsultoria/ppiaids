<?php 
 require_once("../business/eixo_business_class.php"); 
 $oEdao= new EixoBusiness();
 $arrListEixos = $oEdao->listEixos();
 //lista de eixos que não devem aparecer
 $arrEixoExcluir=array(1,8,9);

?>
<div class="item"><a href="index.php">Apresenta&ccedil;&atilde;o</a></div>
<div class="item3"><a href="#" id="lnkIndicadores">Sobre os Indicadores</a></div>
	<div id="eixo2" style="display:none;">
		<div class="eixo_texto">Escolha o Componente:</div>
		<ul>
		<?php
                 $j=1;
                 $qtd = count($arrListEixos);
		 foreach($arrListEixos as $indice => $objEixo){
                        $j++;
		  	if(!in_array($objEixo->getEixoId(),$arrEixoExcluir)){
				echo "<li><a href=\"indicadores.php?eixo={$objEixo->getEixoId()}\">".htmlentities($objEixo->getEixoNome())."</a></li>";
                                if($qtd >= $j){
			  	  echo "<div class=\"fio\"></div>";
                                }
		  	}
		}?>

		</ul>
	</div>

<div class="item3"><a href="#" id="lnkPainel">Painel de Indicadores</a></div>
	<div id="eixo1" style="display:block">
		<div class="eixo_texto">Escolha o Componente:</div>
		<ul>	
		<?php
                  $j=1;
                  $qtd = count($arrListEixos);
		  foreach($arrListEixos as $indice => $objEixo){
                        $j++;
		  	if(!in_array($objEixo->getEixoId(),$arrEixoExcluir)){
				echo "<li><a href=\"painel.php?eixo={$objEixo->getEixoId()}\" target=\"_blank\"><b>".htmlentities($objEixo->getEixoNome())."</b></a></li>";
                                if($qtd >= $j){
			  	  echo "<div class=\"fio\"></div>";
                                }
		  	}
		}?>				
		</ul>
                <div class="eixo_texto">&nbsp;<a href="pesq01.php?clrSession=true">Pesquisa Avan&ccedil;ada</a></div>
                <div class=\"fio\"></div>
	</div>



<div class="item3"><a href="mapa.php">Localiza Munic&iacute;pio</a></div>

<div class="item"><a href="doc_tec.php">Documentos T&eacute;cnicos</a></div>

<div class="item"><a href="glossario.php">Gloss&aacute;rio</a></div>

<div class="item"><a href="ficha.php">Ficha Institucional</a></div>

<div class="item"><a href="fichatec.php">Ficha T&eacute;cnica</a></div>
<br/>
<div id="parceiros" style="padding: 5px 10px 5px 5px; text-align: center;">
	<div class="parceiro"><a href="http://www.saude.sp.gov.br/" target="_blank"><img alt="Secretaria Saude site" title="Secretaria da Saúde" src="img/logo_ses.jpg" /></a></div>
        <div class="parceiro"><a href="http://www.crt.saude.sp.gov.br/" target="_blank"><img alt="CRT site" title="CRT AIDS" src="img/logo_crt.jpg" /></a></div>
        <div class="parceiro"><a href="http://www.ccd.saude.sp.gov.br/" target="_blank"><img alt="CCD site" title="CCD" src="img/logo_ccd.jpg" /></a></div>
        <div class="parceiro"><a href="http://www.isaude.sp.gov.br/" target="_blank"><img alt="Instituto de Saúde de São Paulo site" title="Instituto de Saúde de São Paulo" src="img/logo_institsaudesp.gif" /></a></div>
        <div class="parceiro"><a href="http://www.seade.gov.br/" target="_blank"><img alt="Seade site" title="Fundação Seade" src="img/logo_seade.gif" /></a></div>
        <div class="parceiro"><a href="http://www.fsp.usp.br/" target="_blank"><img alt="Faculdade de Saúde Pública site" title="Faculdade de Saúde Pública" src="img/logo_facsaudepublica.gif" /></a></div>
        <div class="parceiro"><a href="http://www.fm.usp.br/" target="_blank"><img alt="Faculdade de Medicina da USP site" title="Faculdade de Medicina da USP" src="img/logo_facmedicinausp.gif" /></a></div>
    </div>