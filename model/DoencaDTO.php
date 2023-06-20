<?php

  class DoencaDTO {

    private $IdDoenca;
    private $Descricao;
    private $IdCid;
    private $DescricaoCid;
    private $EhContagiosa;
    private $EhHereditaria;

    public function getIdDoenca() {
      return $this->IdDoenca;
    }
    public function setIdDoenca($value) {
      $this->IdDoenca = $value;
    }

    public function getDescricao() {
      return $this->Descricao;
    }
    public function setDescricao($value) {
      $this->Descricao = $value;
    }

    public function getIdCid() {
      return $this->IdCid;
    }
    public function setIdCid($value) {
      $this->IdCid = $value;
    }

    public function getDescricaoCid() {
      return $this->DescricaoCid;
    }
    public function setDescricaoCid($value) {
      $this->DescricaoCid = $value;
    }

    public function getEhContagiosa() {
      return $this->EhContagiosa;
    }
    public function setEhContagiosa($value) {
      $this->EhContagiosa = $value;
    }

    public function getEhHereditaria() {
      return $this->EhHereditaria;
    }
    public function setEhHereditaria($value) {
      $this->EhHereditaria = $value;
    }
  }

?>