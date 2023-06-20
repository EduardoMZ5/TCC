<?php

  class TriagemSintomaDTO {

    private $IdTriagemSintoma;
    private $IdTriagem;
    private $IdSintoma;
    private $DescricaoSintoma;

  public function getIdTriagemSintoma() {
      return $this->IdTriagemSintoma;
    }
    public function setIdTriagemSintoma($value) {
      $this->IdTriagemSintoma = $value;
    }

    public function getIdTriagem() {
      return $this->IdTriagem;
    }
    public function setIdTriagem($value) {
      $this->IdTriagem = $value;
    }

    public function getIdSintoma() {
      return $this->IdSintoma;
    }
    public function setIdSintoma($value) {
      $this->IdSintoma = $value;
    }

    public function getDescricaoSintoma() {
      return $this->DescricaoSintoma;
    }
    public function setDescricaoSintoma($value) {
      $this->DescricaoSintoma = $value;
    }

  }

?>