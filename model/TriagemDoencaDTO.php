<?php

  class TriagemDoencaDTO {

    private $IdTriagemDoenca;
    private $IdTriagem;
    private $IdDoenca;
    private $DescricaoDoenca;

    public function getIdTriagemDoenca() {
      return $this->IdTriagemDoenca;
    }
    public function setIdTriagemDoenca($value) {
      $this->IdTriagemDoenca = $value;
    }

    public function getIdTriagem() {
      return $this->IdTriagem;
    }
    public function setIdTriagem($value) {
      $this->IdTriagem = $value;
    }

    public function getIdDoenca() {
      return $this->IdDoenca;
    }
    public function setIdDoenca($value) {
      $this->IdDoenca = $value;
    }

    public function getDescricaoDoenca() {
      return $this->DescricaoDoenca;
    }
    public function setDescricaoDoenca($value) {
      $this->DescricaoDoenca = $value;
    }
  }

?>