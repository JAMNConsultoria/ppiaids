<?php
require_once("../business/eixo_business_class.php");
?>
<style>
    .zebra{background-color:#DFDFDF}
</style>
<form action="pesq02.php" method="post" id="frmIndicadores" name="frmIndicadores" onsubmit="return checkForm2(this)">
<?php
   $oBEixo = new EixoBusiness();
   $eixos = $oBEixo->loadEixoIndicador();
   $sessao = false;
   if (isset($_SESSION['indicadores'])){
   	    $sessao=true;
     	$arrEixos = $oBEixo->findEixosIdByArrIndics($_SESSION['indicadores']);
   }


  foreach ($eixos as $key => $eixo) {
	  if (count($eixo->getIndicadors()) > 0) {
	  	   if(($sessao) and (in_array($eixo->getEixoId(), $arrEixos))){
	  	   	#echo $eixo->getEixoId();
	  	   	 $display="''";	  	   	 
	  	   }else{
	  	   	 $display="none";
	  	   }	  	
            echo "<br/><a href=\"javascript:listaIndics('ind_{$eixo->getEixoId()}');\"><img src=\"img/mais.png\" border=\"0\"></a><b> {$eixo->getEixoNome()}</b>\n";
            echo "<div style=\"display:{$display}; margin-left:22px;\" id=\"ind_{$eixo->getEixoId()}\" class=\"div1\">";           
            echo "<table cellpadding='3' cellspacing='5' style='width:100%;border:1px dotted #DFDFDF;text-align:justify'>";
            echo "<tr><td>";
            echo "<input id=\"chk_{$eixo->getEixoId()}\" type=\"checkbox\" onClick=\"SelAll2('chk_{$eixo->getEixoId()}','ind_{$eixo->getEixoId()}')\"></td><td><b><i>Selecionar todos os indicadores deste n&iacute;vel</i></b></td></tr>\n";
            $cor=1;
            foreach ($eixo->getIndicadors() as $key2 => $indicador) {
                if(isset($_SESSION['indicadores'])){
                    $checked=(in_array($indicador->getIndicadorId(), $_SESSION['indicadores'])?'checked':'');
                }else{
                    $checked="";
                }
                if ($cor){
                    $backg="class='zebra'";
                    $cor=0;
                }else{
                    $backg="";
                    $cor=1;
                }
                echo "<tr {$backg}><td><input type=\"checkbox\" id=\"indicadores\" name=\"indicadors[]\" {$checked} value=\"{$indicador->getIndicadorId()}\"></td><td>&nbsp;{$indicador->getIndicadorNome()}</td></tr>\n";
            }
            echo "</table>";
            echo "</div>";
	  }
  }		
?>
</form>