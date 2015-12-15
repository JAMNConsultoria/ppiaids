<?php
// Criando uma tabela com array
include("../helper/ezpdf/class.ezpdf.php"); //Inclui a classe do ezpdf;
 
$pdf = new cezpdf('A4','landscape'); //instancia classe aqui voce poderá definir o tipo de papel a ser utilizado (A4, A5, A6, A7, LETTER, LEGAL, e outros)
$pdf->selectFont('../helper/ezpdf/fonts/Helvetica.afm'); // Seleciona a fonte a ser utilizada na geracao do PDF
 
for($i=0;$i<=30;$i++){
	$dadosTB[]=array('produto'=>'var_'{$i}','valor'=>(rand(1,100)*456,'valor1'=>(rand(1,100)*456,'valor2'=>(rand(1,100)*456,'valor3'=>(rand(1,100)*456));
} 
 
$titulos = array('produto' =>'<i>Produto</i>','valor' => '<b>Valor</b>','valor' => '<b>Valor</b>','valor' => '<b>Valor</b>','valor' => '<b>Valor</b>');
 
$opcoes = array('width' => '780', 'fontSize' => '7', 'xOrientation' => ('center'));
//xOrientation' => 'left','right','center'; define a posicao da tabela na folha
//'fontSize' => 10 // tamanho da fonte na tabela
//'width'=> 250 // tamanho da tabela
 
$pdf->ezText("<b>Dados para venda de produtos</b>\n",16);// Define o texto do seu pdf, e o tamanho da fonte;
$pdf->ezTable($dadosTb,$titulos,'',$opcoes); //define os dados que irão na tabela, titulos e outras especificacoes
 

$dadoscriador = array ( // inserindo um array com os dados de cricao do PDF (titulo, autor, assunto, criador, produtor)
	                'Title'=>'Titulo exemplo',
 
                    'Author'=>'BlogUnique',
 
                    'Subject'=>'Gerando PDF com alteracao dos dados de criacao',
 
                    'Creator'=>'email@email.com.br',
 
                    'Producer'=>'http://www.uniquenet.com.br'
 
                    );
 
$pdf->addInfo($dadoscriador);
$pdf->ezNewPage();

$pdf->ezStream(); //Escreve a saida do PDF via stream;
?>