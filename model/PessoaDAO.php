<?php

class PessoaDAO {

  private $conn;
  private $params;
  private $options;

  public function __construct($conn, 
                              $params, 
                              $options) {
    $this->conn    = $conn;
    $this->params  = $params;
    $this->options = $options;

  }

  public function list($tipoPessoa, $idPessoa = 0){

    $sql = " SELECT *
               FROM dbo.Pessoa
              WHERE TipoPessoa = $tipoPessoa ";

    if ($idPessoa != 0){
      $sql .= " AND IdPessoa = $idPessoa ";
    } 

    $qyPessoa = sqlsrv_query( $this->conn, $sql, $this->params, $this->options ); 

    if (sqlsrv_num_rows($qyPessoa) != 0) {

      $resultSet = array();

      while ($rows = sqlsrv_fetch_array($qyPessoa)) {

        $PessoaDTO = new PessoaDTO();
        $PessoaDTO->setIdPessoa($rows["IdPessoa"]);
        $PessoaDTO->setNome($rows["Nome"]);
        $PessoaDTO->setTipoPessoa($rows["TipoPessoa"]);
        $PessoaDTO->setCPF($rows["CPF"]);
        $PessoaDTO->setSexo($rows["Sexo"]);
        $PessoaDTO->setDataNascimento($rows["DataNascimento"]);
        $PessoaDTO->setTelefoneCelular($rows["TelefoneCelular"]);
        $PessoaDTO->setNomeUsuario($rows["NomeUsuario"]);
        $PessoaDTO->setSenha($rows["Senha"]);
        $PessoaDTO->setTelefoneFixo($rows["TelefoneFixo"]);
        $PessoaDTO->setCEP($rows["CEP"]);
        $PessoaDTO->setEndereco($rows["Endereco"]);
        $PessoaDTO->setNumero($rows["Numero"]);
        $PessoaDTO->setBairro($rows["Bairro"]);
        $PessoaDTO->setCidade($rows["Cidade"]);
        $PessoaDTO->setEstado($rows["Estado"]);
        $PessoaDTO->setEmail($rows["Email"]);
        $PessoaDTO->setRG($rows["RG"]);
        $PessoaDTO->setCRM($rows["CRM"]);
        $PessoaDTO->setCNS($rows["CNS"]);

        $resultSet[] = clone $PessoaDTO;

      }

      return $resultSet;
    
    }

  }

  public function insert($PessoaDTO){

    $sql = " INSERT INTO dbo.Pessoa ( Nome,
                                      TipoPessoa,
                                      CPF,
                                      Sexo,
                                      DataNascimento,
                                      TelefoneCelular,
                                      NomeUsuario,
                                      Senha,
                                      TelefoneFixo,
                                      CEP,
                                      Endereco,
                                      Numero,
                                      Bairro,
                                      Cidade,  
                                      Estado,  
                                      Email,                                  
                                      RG,
                                      CRM,
                                      CNS ) 
                             VALUES ( ?, ?, ?, ?, 
                                      ?, ?, ?, ?, 
                                      ?, ?, ?, ?, 
                                      ?, ?, ?, ?,
                                      ?, ?, ? ) ";

    $paramsSql = array( $PessoaDTO->getNome(), 
                        $PessoaDTO->getTipoPessoa(),
                        $PessoaDTO->getCPF(),
                        $PessoaDTO->getSexo(),
                        substr($PessoaDTO->getDataNascimento(),0,4).substr($PessoaDTO->getDataNascimento(),5,2).substr($PessoaDTO->getDataNascimento(),-2),
                        $PessoaDTO->getTelefoneCelular(),
                        $PessoaDTO->getNomeUsuario(),
                        md5($PessoaDTO->getSenha()),
                        $PessoaDTO->getTelefoneFixo(),
                        $PessoaDTO->getCEP(),
                        $PessoaDTO->getEndereco(),
                        $PessoaDTO->getNumero(),                        
                        $PessoaDTO->getBairro(),
                        $PessoaDTO->getCidade(),
                        $PessoaDTO->getEstado(),
                        $PessoaDTO->getEmail(),
                        $PessoaDTO->getRG(),
                        $PessoaDTO->getCRM(),
                        $PessoaDTO->getCNS() ); 

    if ($stmt = sqlsrv_prepare( $this->conn, $sql, $paramsSql )){

      return (sqlsrv_execute($stmt));

    }  

  }

  public function update($PessoaDTO){

    $sql = " UPDATE dbo.Pessoa
                SET Nome = ?,
                    CPF = ?,
                    Sexo = ?,
                    DataNascimento = ?,
                    TelefoneCelular = ?,
                    TelefoneFixo = ?,
                    CEP = ?,
                    Endereco = ?,
                    Numero = ?,
                    Bairro = ?,
                    Cidade = ?,
                    Estado = ?,
                    Email = COALESCE(?,Email),                    
                    RG = ?,
                    CRM = ?,
                    CNS = ?
              WHERE IdPessoa = ? ";

    $paramsSql = array( $PessoaDTO->getNome(), 
                        $PessoaDTO->getCPF(),
                        $PessoaDTO->getSexo(),                        
                        substr($PessoaDTO->getDataNascimento(),0,4).substr($PessoaDTO->getDataNascimento(),5,2).substr($PessoaDTO->getDataNascimento(),-2),
                        $PessoaDTO->getTelefoneCelular(),
                        $PessoaDTO->getTelefoneFixo(),                        
                        $PessoaDTO->getCEP(),
                        $PessoaDTO->getEndereco(),
                        $PessoaDTO->getNumero(),
                        $PessoaDTO->getBairro(),
                        $PessoaDTO->getCidade(),
                        $PessoaDTO->getEstado(),
                        $PessoaDTO->getEmail(),
                        $PessoaDTO->getRG(),
                        $PessoaDTO->getCRM(),
                        $PessoaDTO->getCNS(),
                        $PessoaDTO->getIdPessoa() ); 

    if ($stmt = sqlsrv_prepare( $this->conn, $sql, $paramsSql )){

      return (sqlsrv_execute($stmt));

    }  

  } 

  public function delete($PessoaDTO){

    $sql = " DELETE 
               FROM dbo.Pessoa
              WHERE IdPessoa = ? ";

    $paramsSql = array( $PessoaDTO->getIdPessoa() ); 

    if ($stmt = sqlsrv_prepare( $this->conn, $sql, $paramsSql )){

      return (sqlsrv_execute($stmt));

    }  

  }

}

?>