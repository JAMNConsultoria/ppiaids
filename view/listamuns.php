<?php
require_once("../business/eixo_business_class.php");
session_start();
?>
<script>
            //seleciona todos os ítens (checkboxes) de municipios
            $('#sellMuns').click(function() {
 		$(document).find(':checkbox').attr('checked', this.checked);
            });
</script>
 <form action="pesq03.php" method="post" id="frmLocalidades" name="frmLocalidades">
 
<?php
              require_once("../business/localidade_business_class.php");
              $arrAbrangDesc = array('macroreg'=>'Macro-regiao','drs'=>'Departamento Regional de Saúde - DRS','colegiado'=>'Colegiado','municipio'=>'Município','gve'=>'Grupo de Vigilância Epidemiológica - GVE','grupo'=>'Tipologia de Grupo');
              if(isset($_REQUEST['abrang'])){
                  $abrang=$_REQUEST['abrang'];
              }else{
                  $abrang="macroreg";
              }
              $oLdao = new LocalidadeBusiness();
              $arrLocalidades = $oLdao->ListMunsByAbrangField($abrang);

  $i =0;
 echo "<span><b>".strtoupper($arrAbrangDesc[$abrang])."</b><br></span>";
 echo "<input id=\"sellMuns\" type=\"checkbox\" > <i>Selecionar todos os munic&iacute;pios (645)</i><br>\n";
  foreach ($arrLocalidades as $abrangencia => $arrMuns) {
        $i++;
	$nome ="abrang_{$i}";
        echo "<br/><a href=\"javascript:listaLocs('loc_{$nome}');\"><img src=\"img/mais.png\" border=\"0\"></a><b> {$abrangencia}</b>\n";
        echo "<div id=\"loc_{$nome}\" class=\"div1\">";
        echo "<input type=\"checkbox\" onClick=\"SelAll(this)\"> <i>Selecionar todos os munic&iacute;pios deste n&iacute;vel</i><br>\n";
        foreach ($arrMuns as $mun_cod => $mun_desc) {
            if(isset($_SESSION['localidades'])){
                $checked=(in_array($mun_cod, $_SESSION['localidades'])?'checked':'');
            }else{
                $checked=""; 
            }

            echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"checkbox\" name=\"locs[]\" {$checked} value=\"{$mun_cod}\">&nbsp;{$mun_desc}<br/>\n";
        }
        echo "</div>";	  
  }		
?>
</form>