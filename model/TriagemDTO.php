<?php

  class TriagemDTO {

    private $IdTriagem;
    private $Ordenacao;
    private $IdPaciente;
    private $NomePaciente;
    private $DataHoraAtendimento;
    private $Status;
    private $ClassificacaoRisco;
    private $IdEnfermeiro;
    private $NomeEnfermeiro;
    private $DataHoraTermino;
    private $Peso;
    private $Altura;
    private $PressaoArterial;
    private $FrequenciaRespiratoria;
    private $FrequenciaCardiaca;
    private $Temperatura;
    private $Obersevacao;

    public function getIdTriagem() {
      return $this->IdTriagem;
    }
    public function setIdTriagem($value) {
      $this->IdTriagem = $value;
    }

    public function getOrdenacao() {
      return $this->Ordenacao;
    }
    public function setOrdenacao($value) {
      $this->Ordenacao = $value;
    }

    public function getIdPaciente() {
      return $this->IdPaciente;
    }
    public function setIdPaciente($value) {
      $this->IdPaciente = $value;
    }

    public function getNomePaciente() {
      return $this->NomePaciente;
    }
    public function setNomePaciente($value) {
      $this->NomePaciente = $value;
    }

    public function getDataHoraAtendimento() {
      return $this->DataHoraAtendimento;
    }
    public function setDataHoraAtendimento($value) {
      $this->DataHoraAtendimento = $value;
    }

    public function getStatus() {
      return $this->Status;
    }
    public function setStatus($value) {
      $this->Status = $value;
    }

    public function getClassificacaoRisco() {
      return $this->ClassificacaoRisco;
    }
    public function setClassificacaoRisco($value) {
      $this->ClassificacaoRisco = $value;
    }

    public function getIdEnfermeiro() {
      return $this->IdEnfermeiro;
    }
    public function setIdEnfermeiro($value) {
      $this->IdEnfermeiro = $value;
    }

    public function getNomeEnfermeiro() {
      return $this->NomeEnfermeiro;
    }
    public function setNomeEnfermeiro($value) {
      $this->NomeEnfermeiro = $value;
    }

    public function getDataHoraTermino() {
      return $this->DataHoraTermino;
    }
    public function setDataHoraTermino($value) {
      $this->DataHoraTermino = $value;
    }

    public function getPeso() {
      return $this->Peso;
    }
    public function setPeso($value) {
      $this->Peso = $value;
    }

    public function getAltura() {
      return $this->Altura;
    }
    public function setAltura($value) {
      $this->Altura = $value;
    }

    public function getPressaoArterial() {
      return $this->PressaoArterial;
    }
    public function setPressaoArterial($value) {
      $this->PressaoArterial = $value;
    }

    public function getFrequenciaRespiratoria() {
      return $this->FrequenciaRespiratoria;
    }
    public function setFrequenciaRespiratoria($value) {
      $this->FrequenciaRespiratoria = $value;
    }

    public function getFrequenciaCardiaca() {
      return $this->FrequenciaCardiaca;
    }
    public function setFrequenciaCardiaca($value) {
      $this->FrequenciaCardiaca = $value;
    }

    public function getTemperatura() {
      return $this->Temperatura;
    }
    public function setTemperatura($value) {
      $this->Temperatura = $value;
    }

    public function getObersevacao() {
      return $this->Obersevacao;
    }
    public function setObersevacao($value) {
      $this->Obersevacao = $value;
    }
  }
?>