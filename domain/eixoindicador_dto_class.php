<?php

class EixoIndicadorDTO {
	
	private $eixoindicadorId;
	private $eixoId;
	private $indicadorId;
	private $indicadorNome;
	private $grupoId;
	
	function __construct() {
	}
	
	public function getEixoindicadorId() {
		return $this->eixoindicadorId;
	}
	
	public function setEixoindicadorId($eixoindicadorId) {
		$this->eixoindicadorId = $eixoindicadorId;
	}
	
	public function getEixoId() {
		return $this->eixoId;
	}
	
	public function setEixoId($eixoId) {
		$this->eixoId = $eixoId;
	}
	
	public function setIndicadorId($indicadorId) {
		$this->indicadorId = $indicadorId;
	}

	public function getIndicadorId() {
		return $this->indicadorId;
	}
		
	public function getIndicadorNome() {
		return $this->indicadorNome;
	}
	
	public function setIndicadorNome($indicadorNome) {
		$this->indicadorNome = $indicadorNome;
	}
		
	public function setGrupoId($grupoId) {
		$this->grupoId = $grupoId;
	}
	public function getGrupoId() {
		return $this->grupoId;
	}
}

?>