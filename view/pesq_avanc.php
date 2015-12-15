<?php
header("Content-Type: text/html; charset=iso-8859-1");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
require_once("../business/indicador_business_class.php");
require_once("../business/eixo_business_class.php");
session_start();
$arrIndicFields = $_SESSION['indicadores'];
$arrCamposTexto = array('mun_desc','grupo_desc','gve_desc','drs_desc','colegiado_desc','macroreg_desc');

  $oIdao = new IndicadorBusiness();
  $arrAtributos = $oIdao->listAtributosIndicadorsByArrCod($arrIndicFields);
  //reordenado o array da sessao
  foreach ($arrAtributos as $field => $obj){
      $lista[] = $obj['campo'];
  }
  $_SESSION['indicadores'] =$lista;

  $titCols=null;
  $colModelNames=null;
  $toolTip=null;
  $cabecFull=null;
  $cabecLight=null;
  foreach($arrAtributos as $campo => $ind){
        $alinhamento = (in_array($ind['campo'], $arrCamposTexto)?'left':'right');

  	$titCols .= "{$ind['nome_curto']}','";
  	$colModelNames.="{name:'{$ind['campo']}', index:'{$ind['campo']}', width:{$ind['tamanho']}, align:'{$alinhamento}', formatter:'{$ind['formato']}'},";
        $toolTip .= " jQuery(\"#list\").jqGrid ('setLabel', '{$ind['campo']}','','textalign',{'title':'{$ind['nome']}'});\r\n";
        $cabecLight .= " jQuery(\"#list\").jqGrid ('setLabel', '{$ind['campo']}','{$ind['nome_curto']}','textalign',{'title':'{$ind['nome']}'});\r\n";
        $cabecFull .= " jQuery(\"#list\").jqGrid ('setLabel', '{$ind['campo']}','{$ind['nome']}','textalign',{'title':'{$ind['nome']}'});\r\n";
  }
  $titCols ="'".substr($titCols,0,strlen($titCols)-2);  
  $colModelNames=substr($colModelNames,0,strlen($colModelNames)-1);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8;charset=iso-8859-1;" />
<title></title>
 
<link rel="stylesheet" type="text/css" media="screen" href="css/redmond/jquery-ui-1.8.2.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="js/src/css/ui.jqgrid.css" />
<link rel="stylesheet" href="css/crt_estilos.css" type="text/css" />

<script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="js/grid.locale-pt-br.js" type="text/javascript"></script>
<script src="js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src="js/ui/jquery-ui-1.8.2.custom.js" type="text/javascript"></script>
<style>
.textalign div { padding: 5px 5px 5px 0px; }
</style>

 
<script type="text/javascript">
jQuery(document).ready(function(){ 
  jQuery("#list").jqGrid({
    url:'tabelajq_avanc.php?tipo=2',
    datatype: 'json',      
    colNames:['COD ','Município',<?php echo $titCols?>],
    colModel :[
      {name:'mun_cod', index:'mun_cod', width:55,align:'left'},
      {name:'mun_desc', index:'mun_desc', align: 'left', width:190, formatter:formatoLinkAnalise},
<?php   echo $colModelNames; ?>
    ],
    shrinkToFit:false,
    width:'850',
    height: "350",
    pager: '#pager',
    rowNum:20,
    rowList:[20,40,60,80,100],
    rownumbers: true,
    rownumWidth: 20,
    gridview: true,
    //loadonce:true,
    sortname: 'mun_desc',
    sortorder: 'asc',
    viewrecords: true,
    toolbar: [true,"top"],
    caption: 'Pesquisa Avançada'
  }); 
jQuery("#list").jqGrid('navGrid','#pager',{edit:false,add:false,del:false,search:false,refresh:true,view:true});


<?php echo $toolTip;?>

//trocar para nome das colunas
jQuery("#list").jqGrid('navButtonAdd',"#pager",{caption:"longo",title:"Título longo",
	onClickButton:function(){
		<?php echo $cabecFull; ?>
	}
});
//nome curto dos indicadores
jQuery("#list").jqGrid('navButtonAdd',"#pager",{caption:"curto",title:"Título curto",
	onClickButton:function(){
		<?php echo $cabecLight; ?>
	}
});


//inibir mostrar colunas
jQuery("#list").jqGrid('navButtonAdd',"#pager",{caption:"colunas",title:" Inibir ou mostrar colunas",
	onClickButton:function(){
			jQuery("#list").jqGrid('setColumns');
	}
});

//resize grid
jQuery("#list").jqGrid('gridResize',{minWidth:350,maxWidth:800,minHeight:80, maxHeight:350});

//filterToolbar
jQuery("#list").jqGrid('filterToolbar','autosearch');


});

 function formatoLinkAnalise(cellvalue, options, rowObject) {
 return ' <a href="pdf/'+ options.rowId + '_Analise.pdf" target="_blank"> <img src="img/icone.jpg" title="Análise Municipal" border="0">  <b>' + cellvalue + "</b></a>";
 }
</script>
</head> 

    <div align="center" class="center">
	<?php //include 'incs/barra.php'; ?>
	<div id="cabec"><a href="index.php"><img src="img/logo_painel.gif" /></a></div>
  <br />
    <div id="tabelas">
      <div class="cabec">
	<div class="tit">Pesquisa Avançada </div>
	<div class="nav"><a href="javascript:window.close();">&laquo; voltar para página inicial</a></div>
      </div>
      <br />
      <table cellpadding="0" cellspacing="0" border="0" width="100%">
           <tr>
            <td>&nbsp;</td>
            <td align="right"><a href="export_painel.php?export=4"><img src="img/icone_print.gif" title="Imprimir" border="0"/></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="export_painel.php?export=1"><img src="img/icone_excel.gif" title="Exportar para Excel" border="0"/></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="export_painel.php?export=2"><img src="img/icone_csv.gif" title="Exportar para CSV" border="0"/></a></td>
          </tr>
       </table>
       <br />
<table id="list"></table> 
<div id="pager"></div> 
<br/>Conven&ccedil;&atilde;o Utilizada: -9,00 = <b>N&atilde;o se aplica.</b><br/>
<?php include 'incs/rodape.php'; ?> 