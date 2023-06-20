<?php

  class PessoaDTO {

    private $idPessoa;
    private $nome;
    private $tipoPessoa;
    private $cpf;
    private $sexo;
    private $dataNascimento;
    private $telefoneCelular;
    private $nomeUsuario;
    private $senha;
    private $telefoneFixo;
    private $cep;
    private $endereco;
    private $numero;
    private $bairro;
    private $cidade;
    private $estado;
    private $email;
    private $rg;
    private $crm;
    private $cns;

    public function getIdPessoa() {
      return $this->idPessoa;
    }
    public function setIdPessoa($value) {
      $this->idPessoa = $value;
    }

    public function getNome() {
      return $this->nome;
    }
    public function setNome($value) {
      $this->nome = $value;
    }

    public function getTipoPessoa() {
      return $this->tipoPessoa;
    }
    public function setTipoPessoa($value) {
      $this->tipoPessoa = $value;
    }

    public function getCpf() {
      return $this->cpf;
    }
    public function setCpf($value) {
      $this->cpf = $value;
    }

    public function getSexo() {
      return $this->sexo;
    }
    public function setSexo($value) {
      $this->sexo = $value;
    }

    public function getDataNascimento() {
      return $this->dataNascimento;
    }
    public function setDataNascimento($value) {
      $this->dataNascimento = $value;
    }

    public function getTelefoneCelular() {
      return $this->telefoneCelular;
    }
    public function setTelefoneCelular($value) {
      $this->telefoneCelular = $value;
    }

    public function getNomeUsuario() {
      return $this->nomeUsuario;
    }
    public function setNomeUsuario($value) {
      $this->nomeUsuario = $value;
    }

    public function getSenha() {
      return $this->senha;
    }
    public function setSenha($value) {
      $this->senha = $value;
    }

    public function getTelefoneFixo() {
      return $this->telefoneFixo;
    }
    public function setTelefoneFixo($value) {
      $this->telefoneFixo = $value;
    }

    public function getCep() {
      return $this->cep;
    }
    public function setCep($value) {
      $this->cep = $value;
    }

    public function getEndereco() {
      return $this->endereco;
    }
    public function setEndereco($value) {
      $this->endereco = $value;
    }

    public function getNumero() {
      return $this->numero;
    }
    public function setNumero($value) {
      $this->numero = $value;
    }

    public function getBairro() {
      return $this->bairro;
    }
    public function setBairro($value) {
      $this->bairro = $value;
    }

    public function getCidade() {
      return $this->cidade;
    }
    public function setCidade($value) {
      $this->cidade = $value;
    }

    public function getEstado() {
      return $this->estado;
    }
    public function setEstado($value) {
      $this->estado = $value;
    }

    public function getEmail() {
      return $this->email;
    }
    public function setEmail($value) {
      $this->email = $value;
    }

    public function getRg() {
      return $this->rg;
    }
    public function setRg($value) {
      $this->rg = $value;
    }

    public function getCrm() {
      return $this->crm;
    }
    public function setCrm($value) {
      $this->crm = $value;
    }

    public function getCns() {
      return $this->cns;
    }
    public function setCns($value) {
      $this->cns = $value;
    }

  }

?>