<?php
require_once("../business/localidade_business_class.php");
require_once("../business/indicador_business_class.php");
require_once("../constants/global.php");
session_start();
header('Content-Type: text/html; charset=iso-8859-1');

//grava na sessÃ£o a lista de indicadores vindos do formulÃ¡rio
if (isset($_REQUEST['indicadors'])) {
    foreach($_REQUEST['indicadors'] as $indic){
        $_SESSION['indicadores'][] = $indic;
    }
    $_SESSION['indicadores'] = array_unique($_SESSION['indicadores']);
}


//se o botao excluir foi acionado remove do array Session
if(isset($_POST['btnRem'])){
     if(isset($_POST['lstIndic'])){
        foreach($_POST['lstIndic'] as $key => $value){
             if(in_array($value,$_SESSION['indicadores'])){
                  $keyRem = array_search($value,$_SESSION['indicadores']);
                  unset($_SESSION['indicadores'][$keyRem]);
                  //se vazio volta para a pagina para selecao de indicadores
                  if(empty($_SESSION['indicadores'])){
                        header("location:pesq01.php");
                  }
             }
        }
     }
}


$arrIndicador = ($_SESSION['indicadores']);
$strIndicador = implode(",", $arrIndicador);

//armazena na sessÃ£o a seleÃ§Ã£o de indicadores

?>

<?php include 'incs/cabecalho.php'; ?>
<div id="wrapper">

<script language="javascript">
     $(document).ready(function()     {

           //seleciona todos os ítens (checkboxes) de municipios
            $('#sellMuns').click(function() {
				//if(jQuery("input:checkbox=:checked").length == 0) {
					$(document).find(':checkbox').attr('checked', this.checked);
					//return;
				//}
            });


            //submete formulario botao Prosseguir>>>
            $('#btnEnviar2').click(function() {
				if(jQuery("input:checkbox=:checked").length == 0) {
					alert("Por favor, selecione alguma localidade.");
					return;
				}
                $('#frmLocalidades').submit();
            });
 
            //submete formulario botao Remover>>>
            $('#btnRem').click(function() {
                $('#frmIndSel').submit();
            });
 
            $('#btnAdd').click(function() {
                document.location.href ="pesq01.php?clrSession=false";
            });
 
			
            $('#btnVoltar').click(function() {
                document.location.href ="index.php?clrSession=false";
            });
 


       $('input:radio[name=grupo]').click(function(){
	   //recebe da tag "<a href" o conteudo da propriedade name (onde coloco o link para o script)
            var abrang = $('input:radio[name=grupo]:checked').val();
       	    var linkLocalidade='listamuns.php?abrang='+abrang;           
	 	    $.ajax({
	       	      type: "POST",
		          url: linkLocalidade,
		          success: function(msg){
	   	              //passa para a div "divInfMun" o conteÃºdo retornado de listaMun.php
	                  $("#Localidade").html(msg);
				   }
	        });
       })//fim grupo

     }); //fim ready
 </script>

	<div id="menu"><br />
        <?php include 'incs/menu.php'; ?>
    </div>
    
    <div id="conteudo"><br />

    	<p class="tit">Pesquisa Avançada</p>


		<div id="grupoTit"><span>Passo 2 &rsaquo;</span> &nbsp;Selecione os MUNICÍPIOS pela área de abrangência:</div>
		<div id="grupoLoc">
            <form action="" method="post" name="frmGrupo" id="frmGrupo" onsubmit="return checkForm(this)">
                <input type="hidden" name="clrSession" value="false">
                <input type="radio" id="grupo" name="grupo" value="macroreg" title="Municípios por Macro-região" checked onchange="this.form.clrSession.value = 'true'"> Macro-região&nbsp;&nbsp;
                <input type="radio" id="grupo" name="grupo" value="drs" title="Municípios por DRS" onchange="this.form.clrSession.value = 'true'"> DRS&nbsp;&nbsp;
                <input type="radio" id="grupo" name="grupo" value="gve" title="Municípios por GVE" onchange="this.form.clrSession.value = 'true'"> GVE&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" id="grupo" name="grupo" value="colegiado" title="Municípios por Colegiado" onchange="this.form.clrSession.value = 'true'"> Colegiado&nbsp;&nbsp;
                <input type="radio" id="grupo" name="grupo" value="municipio" title="Municípios por Letra" onchange="this.form.clrSession.value = 'true'"> Município&nbsp;&nbsp;
                <input type="radio" id="grupo" name="grupo" value="grupo" title="Municípios por Tipologia de Grupo" onchange="this.form.clrSession.value = 'true'"> Grupo&nbsp;&nbsp;
            </form>
     	</div>
        <div id="Localidade">
            <?php include "listamuns.php"?>
        </div>

		<br /><br />

        <div id="indSelected">

           <form id="frmIndSel" name="frmIndSel" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">

<table cellpadding="0" cellspacing="0" border="0" width="96%" style="margin-left:15px;">
<tr><td width="75%">
<div id="textos_ind" style="color:#666;margin-left:0;margin-right:0;"> Indicadores selecionados:</div>
<select name="lstIndic[]" multiple id="lstIndic" size="8" style="font-size:12px;color:#666;width:100%;background:#efefef;border:1px solid #cccccc;margin:0px;">
                           <?php
                            //popula o box com de indicadores selecionados
                                $oIdao = new IndicadorBusiness();
                                $arrObjListInd=$oIdao->findIndicadoresByArrId($_SESSION['indicadores']);
                                foreach($arrObjListInd as $indice => $objListInd){
                                    echo "<option value=\"{$objListInd->getIndicadorId()}\">{$objListInd->getIndicadorNome()}</option>";
                                }
                            ?>
                        </select></td>
			<td valign="middle" align="center"><br />
                        <input type="button" name="btnAdd" id="btnAdd" value="Adicionar a lista" ><br /><br />
                        <input type="submit" name="btnRem" id="btnRem" value="Remover da lista">
                        </td>
</tr></table>
               </form>
            
       	</div>
        
    	<br /><br />
           <div id="botao">
                 <input type="image" src="img/bt_seguir.gif" name="btnEnviar" id="btnEnviar2"> <br /><br />
           </div>
        <br />&nbsp;
    
    </div>
 
 </div>
    
<?php include 'incs/rodape.php'; ?> 