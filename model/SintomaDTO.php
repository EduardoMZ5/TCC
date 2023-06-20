<?php

  class SintomaDTO {

    private $IdSintoma;
    private $Descricao;
  
    public function getIdSintoma() {
      return $this->IdSintoma;
    }
    public function setIdSintoma($value) {
      $this->IdSintoma = $value;
    }

    public function getDescricao() {
      return $this->Descricao;
    }
    public function setDescricao($value) {
      $this->Descricao = $value;
    }
  }

?>