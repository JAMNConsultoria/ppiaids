<?php

class FichaDTO {
	
	private $indicadorId;
	private $indicadorNome;        
        private $indicadorFonte;
        private $indicadorInterpretacao;
        private $indicadorLimitacao;
        private $indicadorDescricao;

	
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

   
    public function getIndicadorFonte() {
		return $this->indicadorFonte;
	}

	public function setIndicadorFonte($indicadorFonte) {
		$this->indicadorFonte = $indicadorFonte;
	}


        public function getIndicadorInterpretacao() {
		return $this->indicadorInterpretacao;
	}

	public function setIndicadorInterpretacao($indicadorInterpretacao) {
		$this->indicadorInterpretacao = $indicadorInterpretacao;
	}


        public function getIndicadorLimitacao() {
		return $this->indicadorLimitacao;
	}

	public function setIndicadorLimitacao($indicadorLimitacao) {
		$this->indicadorLimitacao = $indicadorLimitacao;
	}

        public function getIndicadorDescricao() {
		return $this->indicadorDescricao;
	}

	public function setIndicadorDescricao($indicadorDescricao) {
		$this->indicadorDescricao = $indicadorDescricao;
	}

}

?>