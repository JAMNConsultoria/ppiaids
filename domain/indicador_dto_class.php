<?php

class IndicadorDTO {
	
	private $indicadorId;
	private $indicadorNome;
	
	function __construct() {
	}
	
	public function getIndicadorId() {
		return $this->indicadorId;
	}
	
	public function setIndicadorId($indicadorId) {
		$this->indicadorId = $indicadorId;
	}
	
	public function getIndicadorNome() {
		return $this->indicadorNome;
	}
	
	public function setIndicadorNome($indicadorNome) {
		$this->indicadorNome = $indicadorNome;
	}
}

?>