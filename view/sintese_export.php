<?php
header('Content-Type: text/html; charset=iso-8859-1');
require_once("../business/sintese_business_class.php");
require_once("../business/localidade_business_class.php");

if(isset($_REQUEST['munId'])){
    $munId = $_REQUEST['munId'];
}else{
    $munId = 350010;
}
//tipo de exportacao csv ou xls
if(isset($_REQUEST['texp'])){
    $tipo = $_REQUEST['texp'];
}else{
    $tipo = 'xls';
}

$sDao = new SinteseBusiness();
$arrDados = $sDao->findSinteseByLocId($munId);

$lDao = new LocalidadeBusiness();
$objLoc = $lDao->findLocById($munId);

$data = date('dmY_His');
$filename = "ppiaids_".$data;

switch ($tipo){
    case 'xls':
        //XLS- exibe a tabela pronta em html para XLS
	header("Content-Type:  application/vnd.ms-excel");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header ("Content-Disposition: attachment; filename=\"".$filename.".xls\"" );?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8;charset=iso-8859-1;" />
            <title><?php echo htmlentities("Síntese do município");?></title>
        </head>
        <body>
            <div id="tabelas">
            <?php
                echo "<b>Informações do Município de <font color='#FF0000'>".$objLoc->getMunNome()."</font></b><br/><br/>";
                foreach($arrDados['eixos'] as $eixoId => $eixo){
                    echo '<div style="text-align:left;border: 1px dotted #bdbdbd;width: 485px;padding: 5px 5px 5px 5px;"><b>'. utf8_decode($eixo['nome'])."</b></div>";
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
            ?>
            </div>
        </body>
        </html>
        <?php
        break;
    case 'csv':
	//CSV - formato texto
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=\"".$filename.".csv\"");
        $tabela="";
        $tabela= "Informações do Município de".$objLoc->getMunNome().";\r\n";
        foreach($arrDados['eixos'] as $eixoId => $eixo){
              $tabela.= 'Eixo: '. utf8_decode($eixo['nome']).";Valor\r\n";
              foreach($eixo['indicadores'] as $indCod => $indNome){
                        $chave = array_search($indCod,$arrDados['campos']);
                        $tabela.= utf8_decode($indNome).";".$arrDados['dados'][$chave]."\r\n";
              }
        }
        print($tabela);
        break;
}
?>