<?php

class Utils {

	public static function datetimeFormatBR($strData) {
		$dia = substr($strData,8,2);
		$mes = substr($strData,5,2);
		$ano = substr($strData,0,4);
		$hour = substr($strData,11,15);
		return "$dia/$mes/$ano $hour";
	}

	public static function dateFormatBR($strData) {
		$dia = substr($strData,8,2);
		$mes = substr($strData,5,2);
		$ano = substr($strData,0,4);
		return "$dia/$mes/$ano";
	}

	public static function dateFormatEN($strData) {
		$dia = substr($strData,0,2);
		$mes = substr($strData,3,2);
		$ano = substr($strData,6,9);
		return "$ano-$mes-$dia";
	}

	public static function isNumber($n) {

		if($n == "")
			return false;

		if(preg_match ("/^([0-9.,-]+)$/", $n)) {
			return true;
		}
		return false;
	}

	public static function getDescrByTipo($t) {
		$d = "";
		switch ($t) {
		case "A":
			$d = "Administrador";
			break;
		case "C":
			$d = "Coordenador";
			break;
		case "P":
			$d = "Pesquisador";
			break;
		case "I":
			$d = "Informante";
			break;
		case "K":
			$d = "Contato";
			break;
		}
		return $d;
	}

	public static function createFile($filename, $content) {

		$fileHandle = fopen($filename, 'w') or die("can't open file");

		if (is_writable($filename)) {

			if (!fwrite($fileHandle, $content)) {
				print "Erro escrevendo no arquivo ($filename)";
				exit;
			}

		} else {
			print "The file $filename is not writable";
		}
		fclose($fileHandle);
	}
}

?>