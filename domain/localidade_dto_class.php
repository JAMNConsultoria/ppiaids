<?php

class LocalidadeDTO {

    private $munId;
    private $munNome;
    private $grupoNome;
    private $macroRegNome;
    private $gveNome;
    private $drsNome;
    private $colegiadoNome;
    
    function __construct() {
    }
    public function getMunId() {
        return $this->munId;
    }   
    public function setMunId($munId) {
    	$this->munId = $munId;
    }
    public function getMunNome() {
        return $this->munNome;
    }    
    public function setMunNome($munNome) {
        $this->munNome = $munNome;
    }
    public function getGrupoNome() {
        return $this->grupoNome;
    }
    public function setGrupoNome($grupoNome) {
        $this->grupoNome = $grupoNome;
    }

    public function getMacroRegNome() {
        return $this->macroRegNome;
    }
    public function setMacroRegNome($macroRegNome) {
        $this->macroRegNome = $macroRegNome;
    }

    public function getGveNome() {
        return $this->gveNome;
    }
    public function setGveNome($gveNome) {
        $this->gveNome = $gveNome;
    }


    public function getDrsNome() {
        return $this->drsNome;
    }
    public function setDrsNome($drsNome) {
        $this->drsNome = $drsNome;
    }


    public function getColegiadoNome() {
        return $this->colegiadoNome;
    }
    public function setColegiadoNome($colegiadoNome) {
        $this->colegiadoNome = $colegiadoNome;
    }


}

?>