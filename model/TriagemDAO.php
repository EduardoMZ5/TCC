<?php

class TriagemDAO {

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

  public function getMaxId(){

    $sql = " SELECT MAX(IdTriagem) AS IdAtual
               FROM dbo.Triagem ";

    $qyTriagem = sqlsrv_query( $this->conn, $sql, $this->params, $this->options ); 

    if (sqlsrv_num_rows($qyTriagem) != 0) {

      $resultSet = array();

      while ($rows = sqlsrv_fetch_array($qyTriagem)) {

        return $rows["IdAtual"];

      }
      
    }

  }

  public function list($idTriagem = 0, $idPessoa = 0, $tipoPessoa = 0){

    $sql = " SELECT ROW_NUMBER() OVER( ORDER BY Tri.DataHoraAtendimento DESC, Tri.Status, Tri.ClassificacaoRisco ) AS Ordernacao,
                    Tri.IdTriagem,
                    Tri.IdPaciente,
                    Pac.Nome AS NomePaciente,
                    Tri.DataHoraAtendimento,
                    Tri.Status,
                    Tri.ClassificacaoRisco,
                    Tri.IdEnfermeiro,
                    Enf.Nome AS NomeEnfermeiro,
                    Tri.DataHoraTermino,
                    Tri.Peso,
                    Tri.Altura,
                    Tri.PressaoArterial,
                    Tri.FrequenciaRespiratoria,
                    Tri.FrequenciaCardiaca,
                    Tri.Temperatura,
                    Tri.Obersevacao
               FROM dbo.Triagem Tri
         INNER JOIN dbo.Pessoa  Pac ON Tri.IdPaciente   = Pac.IdPessoa
          LEFT JOIN dbo.Pessoa  Enf ON Tri.IdEnfermeiro = Enf.IdPessoa ";

    if ($idTriagem != 0){
      $sql .= " WHERE IdTriagem = $idTriagem ";
    }else if ($idPessoa != 0 && $tipoPessoa == 2){
      $sql .= " WHERE COALESCE(Tri.IdEnfermeiro, $idPessoa) = $idPessoa
                  AND (
                       (CAST(Tri.DataHoraAtendimento AS DATE) >=  CAST(GETDATE() AS DATE) AND Status = 2) OR
                       (Status IN (1,3,4))
                      ) ";
    }else if ($idPessoa != 0 && $tipoPessoa == 3){ 
      $sql .= " WHERE Tri.IdPaciente = $idPessoa
                  AND Status IN (1,2,3)";
    }

    $qyTriagem = sqlsrv_query( $this->conn, $sql, $this->params, $this->options ); 

    if (sqlsrv_num_rows($qyTriagem) != 0) {

      $resultSet = array();

      while ($rows = sqlsrv_fetch_array($qyTriagem)) {

        $TriagemDTO = new TriagemDTO();
        $TriagemDTO->setIdTriagem($rows["IdTriagem"]);
        $TriagemDTO->setOrdenacao($rows["Ordernacao"]);
        $TriagemDTO->setIdPaciente($rows["IdPaciente"]);
        $TriagemDTO->setNomePaciente($rows["NomePaciente"]);
        $TriagemDTO->setDataHoraAtendimento($rows["DataHoraAtendimento"]);
        $TriagemDTO->setStatus($rows["Status"]);
        $TriagemDTO->setClassificacaoRisco($rows["ClassificacaoRisco"]);
        $TriagemDTO->setIdEnfermeiro($rows["IdEnfermeiro"]);
        $TriagemDTO->setNomeEnfermeiro($rows["NomeEnfermeiro"]);
        $TriagemDTO->setDataHoraTermino($rows["DataHoraTermino"]);
        $TriagemDTO->setPeso($rows["Peso"]);
        $TriagemDTO->setAltura($rows["Altura"]);
        $TriagemDTO->setPressaoArterial($rows["PressaoArterial"]);
        $TriagemDTO->setFrequenciaRespiratoria($rows["FrequenciaRespiratoria"]);
        $TriagemDTO->setFrequenciaCardiaca($rows["FrequenciaCardiaca"]);
        $TriagemDTO->setTemperatura($rows["Temperatura"]);
        $TriagemDTO->setObersevacao($rows["Obersevacao"]);

        $resultSet[] = clone $TriagemDTO;

      }

      return $resultSet;
    
    }

  }

  public function insert($TriagemDTO){

    $sql = " INSERT INTO dbo.Triagem ( IdPaciente,
                                       DataHoraAtendimento,
                                       Status,
                                       ClassificacaoRisco,
                                       IdEnfermeiro,
                                       DataHoraTermino,
                                       Peso,
                                       Altura,
                                       PressaoArterial,
                                       FrequenciaRespiratoria,
                                       FrequenciaCardiaca,
                                       Temperatura,
                                       Obersevacao ) 
                              VALUES ( ?, ?, ?, ?,
                                       ?, ?, ?, ?,
                                       ?, ?, ?, ?,
                                       ? ) ";

    //Tratando a data/hora recebida
    $dataAtendimento = $TriagemDTO->getDataHoraAtendimento();
    $dataAtendimento = str_replace("T", " ", $dataAtendimento);
    $dataAtendimento = str_replace("-", "", $dataAtendimento);

    $paramsSql = array( $TriagemDTO->getIdPaciente(),
                        $dataAtendimento,
                        $TriagemDTO->getStatus(),
                        $TriagemDTO->getClassificacaoRisco(),
                        $TriagemDTO->getIdEnfermeiro(),
                        $TriagemDTO->getDataHoraTermino(),
                        $TriagemDTO->getPeso(),
                        $TriagemDTO->getAltura(),
                        $TriagemDTO->getPressaoArterial(),
                        $TriagemDTO->getFrequenciaRespiratoria(),
                        $TriagemDTO->getFrequenciaCardiaca(),
                        $TriagemDTO->getTemperatura(),
                        $TriagemDTO->getObersevacao() );  

    if ($stmt = sqlsrv_prepare( $this->conn, $sql, $paramsSql )){

      return (sqlsrv_execute($stmt));

    }  

  }

  public function update($TriagemDTO){

    $sql = " UPDATE dbo.Triagem
                SET ClassificacaoRisco = ?,
                    Peso = ?,
                    Altura = ?,
                    PressaoArterial = ?,
                    FrequenciaRespiratoria = ?,
                    FrequenciaCardiaca = ?,
                    Temperatura = ?,
                    Obersevacao = ?
              WHERE IdTriagem = ? ";

    $paramsSql = array( $TriagemDTO->getClassificacaoRisco(),
                        $TriagemDTO->getPeso(),
                        $TriagemDTO->getAltura(),
                        $TriagemDTO->getPressaoArterial(),
                        $TriagemDTO->getFrequenciaRespiratoria(),
                        $TriagemDTO->getFrequenciaCardiaca(),
                        $TriagemDTO->getTemperatura(),
                        $TriagemDTO->getObersevacao(),
                        $TriagemDTO->getIdTriagem() ); 

    if ($stmt = sqlsrv_prepare( $this->conn, $sql, $paramsSql )){

      return (sqlsrv_execute($stmt));

    }  

  } 

  public function setStatus($TriagemDTO){

    $sql = " UPDATE dbo.Triagem
                SET Status = ?,
                    DataHoraTermino = (CASE ? WHEN 3 THEN GETDATE() ELSE NULL END),
                    idEnfermeiro = COALESCE(?, idEnfermeiro)              
              WHERE IdTriagem = ? ";

    $paramsSql = array( $TriagemDTO->getStatus(),
                        $TriagemDTO->getStatus(),
                        $TriagemDTO->getIdEnfermeiro(),
                        $TriagemDTO->getIdTriagem() ); 

    if ($stmt = sqlsrv_prepare( $this->conn, $sql, $paramsSql )){

      return (sqlsrv_execute($stmt));

    }  

  } 

  public function delete($TriagemDTO){

    $sql = " DELETE 
               FROM dbo.Triagem
              WHERE IdTriagem = ? ";

    $paramsSql = array( $TriagemDTO->getIdTriagem() ); 

    if ($stmt = sqlsrv_prepare( $this->conn, $sql, $paramsSql )){

      return (sqlsrv_execute($stmt));

    }  

  }

}

?>