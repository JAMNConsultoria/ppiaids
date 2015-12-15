<?php
require_once("../business/localidade_business_class.php");
require_once("../business/indicador_business_class.php");
require_once("../business/util_business_class.php");
session_start();
header('Content-Type: text/html; charset=iso-8859-1');
//se o botao excluir foi acionado remove do array Session
if(isset($_POST['btnRemInd'])){
     if(isset($_POST['lstIndic'])){
        foreach($_POST['lstIndic'] as $key => $value){
             if(in_array($value,$_SESSION['indicadores'])){
                  $keyRem = array_search($value,$_SESSION['indicadores']);
                  unset($_SESSION['indicadores'][$keyRem]);
             }
        }
     }
}
//se vazio volta para a página para seleção
if(empty($_SESSION['indicadores'])){
    header("location:pesq01.php");
}


//excluindo localidades da lista
//se o botao excluir foi acionado remove do array Session
if(isset($_POST['btnRemLoc'])){
     if(isset($_POST['lstLoc'])){
        foreach($_POST['lstLoc'] as $key => $value){
             if(in_array($value,$_SESSION['localidades'])){
                  $keyRem = array_search($value,$_SESSION['localidades']);
                  unset($_SESSION['localidades'][$keyRem]);
             }
        }
     }
}

//inclui localidades a session localidades
if (isset($_REQUEST['locs'])) {
    foreach($_REQUEST['locs'] as $loc){
        $_SESSION['localidades'][] = $loc;
    }
    $_SESSION['localidades'] = array_unique($_SESSION['localidades']);
}

//se vazio volta para a página para seleção
if(empty($_SESSION['localidades'])){
    header("location:pesq02.php");
}
?>
<?php include 'incs/cabecalho.php'; ?>

        <script language="javascript">

        $(document).ready(function()     {
            //submete formulario botao Prosseguir>>>
            $('#btnEnviar').click(function() {
                $('#frmLocSel').submit();
            });
           
            //botoes para adicionar localidades e indicadores
            $('#btnAddInd').click(function() {
                document.location.href ="pesq01.php";
            });

            $('#btnAddLoc').click(function() {
                document.location.href ="pesq02.php";
            });


       }); //fim ready

      </script>



<div id="wrapper">           

	<div id="menu"><br />
        <?php include 'incs/menu.php'; ?>
    </div>
    
    <div id="conteudo"><br />

    	<p class="tit">Pesquisa Avan�ada</p>


        <div id="indSelected">

            <table cellpadding="0" cellspacing="0" border="0" width="100%">
            	<tr>
                    <td>
	                    <div class="tit_pesq_tab">Localidades selecionadas:</div>


                        <form id="frmLocSel" name="frmLocSel" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                            <select name="lstLoc[]" multiple id="lstLoc" size="8" style="font-size:12px;color:#666;width:100%;background:#efefef;border:1px solid #cccccc;margin:0px;">
                            <?php
                            //popula o box com de indicadores selecionados
                                $oLdao = new LocalidadeBusiness();

                                $arrObjListLoc=$oLdao->findLocsByArrId($_SESSION['localidades']);
                                foreach($arrObjListLoc as $key => $objListLoc){
                                    echo "<option value=\"{$objListLoc->getMunId()}\">{$objListLoc->getMunNome()}</option>";
                                }
                            ?>
                        </select>
	                 <div class="botoes_pesq_tab"><input type="button" name="btnAddLoc" id="btnAddLoc" value="Adicionar a lista" >&nbsp;&nbsp;<input type="submit" name="btnRemLoc" id="btnRemLoc" value="Remover da lista"></div>
                    </form>
		
                    </td>
                </tr>
            </table>

       	</div>


		<br /><br />

        <div id="indSelected">
            <form id="frmIndSel" name="frmIndSel" action="" method="post">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
            	<tr>
                    <td>
	                    <div class="tit_pesq_tab">Indicadores selecionados:</div>

                    <form id="frmIndSel" name="frmIndSel" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                        <select name="lstIndic[]" multiple id="lstIndic" size="8" style="font-size:12px;color:#666;width:100%;background:#efefef;border:1px solid #cccccc;margin:0px;">
                           <?php
                            //popula o box com de indicadores selecionados
                                $oIdao = new IndicadorBusiness();
                                $arrObjListInd=$oIdao->findIndicadoresByArrId($_SESSION['indicadores']);
                                foreach($arrObjListInd as $indice => $objListInd){
                                    echo "<option value=\"{$objListInd->getIndicadorId()}\">{$objListInd->getIndicadorNome()}</option>";
                                }
                            ?>
                        </select>                           
                        <div class="botoes_pesq_tab"><input type="button" name="btnAddInd" id="btnAddInd" value="Adicionar a lista" >&nbsp;&nbsp;<input type="submit" name="btnRemInd" id="btnRemInd" value="Remover da lista" ></div></td>
                    </form>
                </tr>
            </table>
           	</form>
       	</div>
        
    	<br /><br />
                <div id="botao">
                    <form method="post" action="pesq_avanc.php" name="frmTabela" id="frmTabela" target="_blank">
                        <input type="image" src="img/bt_tabela.gif" name="btnEnviar" id="btnTabela"><br /><br />
                    </form>
               </div>
    	<br />&nbsp;
      
    </div>
 </div>   
<?php include 'incs/rodape.php'; ?> 