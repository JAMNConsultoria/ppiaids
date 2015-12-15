<?php

class DadosDTO {

    public $conteudoId ;
    public $localidadeId ;
    public $cgrId ;

    function __construct($arrInd) {
        foreach($arrInd as $key => $value){
          $this->$key=$value;
        }
    }

    public function getConteudoId() {
        return $this->conteudoId;
    }

    public function setConteudoId($contudoId) {
        $this->conteudoId = $conteudoId;
    }

    public function getLocalidadeId() {
        return $this->localidadeId;
    }

    public function setLocalidadeId($localidadeId) {
        $this->localidadeId = $localidadeId;
    }

    public function getCgrId() {
        return $this->cgrId;
    }

    public function setCgrId($cgrId) {
        $this->cgrId = $cgrId;
    }

}

?>