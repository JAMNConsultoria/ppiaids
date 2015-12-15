<?php

class EixoDTO {

    var $eixoId;
    var $eixoNome;
    var $indicadors;
	
    function  __construct() {

    }

    public function getEixoId() {
        return $this->eixoId;
    }
    
    public function setEixoId($eixoId) {
    	$this->eixoId = $eixoId;
    }
	
	public function getEixoNome() {
        return $this->eixoNome;
    }
    
    public function setEixoNome($eixoNome) {
        $this->eixoNome = $eixoNome;
    }
	
	public function getIndicadors() {
        return $this->indicadors;
    }
    
    public function setIndicadors($indicadors) {
        $this->indicadors = $indicadors;
    }
}

?>