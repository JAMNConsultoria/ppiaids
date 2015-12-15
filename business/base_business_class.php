<?php
require_once("../dao/mysqldaofactory_class.php");
require_once("../constants/global.php");
require_once("../constants/message.php");

date_default_timezone_set("America/Sao_Paulo");

class BaseBusiness {


	public function setMessage($m) {
		$this->message = $m;
	}

	public function getMessage() {
		return $this->message;
	}

	public function setError($e) {
		$this->error = $e;
	}

	public function getError() {
		return $this->error;
	}

}

?>