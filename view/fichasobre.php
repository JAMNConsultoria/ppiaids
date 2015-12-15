<?php
  header('Content-Type: text/html; charset=iso-8859-1');
  require_once("../business/indicador_business_class.php");
  if(isset($_REQUEST['indCod'])){
      $indCod = $_REQUEST['indCod'];
  }else{
      $indCod = 9;
  }
  $oIdao = new IndicadorBusiness();
  $fichaSobre = $oIdao->fichaByIndicadorId($indCod); 
 ?>
        <table cellpadding="2" cellspacing="2" border="0" width="95%" align="center">
        	<tr>
            	<td class="tit">Nome</td>
            </tr>
        	<tr>
            	<td class="texto"><b><?php echo $fichaSobre->getIndicadorNome();?></b></td>
            </tr>
        	<tr>
            	<td class="tit">Conceito</td>
            </tr>
        	<tr>
            	<td class="texto"><?php echo $fichaSobre->getIndicadorDescricao();?></td>
            </tr>
        	<tr>
            	<td class="tit">Interpretação</td>
            </tr>
        	<tr>
            	<td class="texto"><?php echo $fichaSobre->getIndicadorInterpretacao();?></td>
            </tr>
			<?php if(strlen(trim($fichaSobre->getIndicadorLimitacao()))>1){ ?>
        	<tr>
            	<td class="tit">Limitação</td>
            </tr>
        	<tr>
            	<td class="texto"><?php echo $fichaSobre->getIndicadorLimitacao();?></td>
            </tr>
			<?php } ?>
        	<tr>
            	<td class="tit">Fonte</td>
            </tr>
        	<tr>
            	<td class="texto"><?php echo $fichaSobre->getIndicadorFonte();?></td>
            </tr>
        </table>