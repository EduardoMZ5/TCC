<?php

class DoencaDAO {

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

  public function list($idDoenca = 0){

    $sql = " SELECT Doe.IdDoenca,
                    Doe.Descricao,
                    Doe.IdCid,
                    Doe.EhContagiosa,
                    Doe.EhHereditaria,
                    Cid.Codigo + ' - ' + Cid.Descricao AS Cid
               FROM dbo.Doenca Doe
          LEFT JOIN dbo.Cid    Cid ON Doe.IdCid = Cid.IdCid ";

    if ($idDoenca != 0){
      $sql .= " WHERE IdDoenca = $idDoenca ";
    } 

    $qyDoenca = sqlsrv_query( $this->conn, $sql, $this->params, $this->options ); 

    if (sqlsrv_num_rows($qyDoenca) != 0) {

      $resultSet = array();

      while ($rows = sqlsrv_fetch_array($qyDoenca)) {

        $DoencaDTO = new DoencaDTO();
        $DoencaDTO->setIdDoenca($rows["IdDoenca"]);
        $DoencaDTO->setDescricao($rows["Descricao"]);
        $DoencaDTO->setIdCid($rows["IdCid"]);
        $DoencaDTO->setEhContagiosa($rows["EhContagiosa"]);
        $DoencaDTO->setEhHereditaria($rows["EhHereditaria"]);
        $DoencaDTO->setDescricaoCid($rows["Cid"]);

        $resultSet[] = clone $DoencaDTO;

      }

      return $resultSet;
    
    }

  }

  public function insert($DoencaDTO){

    $sql = " INSERT INTO dbo.Doenca ( Descricao,
                                      IdCid,
                                      EhContagiosa,
                                      EhHereditaria ) 
                             VALUES ( ?, ?, ?, ? ) ";

    $paramsSql = array( $DoencaDTO->getDescricao(), 
                        $DoencaDTO->getIdCid(),
                        $DoencaDTO->getEhContagiosa(),
                        $DoencaDTO->getEhHereditaria() ); 

    if ($stmt = sqlsrv_prepare( $this->conn, $sql, $paramsSql )){

      return (sqlsrv_execute($stmt));

    }  

  }

  public function update($DoencaDTO){

    $sql = " UPDATE dbo.Doenca
                SET Descricao = ?,
                    IdCid = ?,
                    EhContagiosa = ?,
                    EhHereditaria = ?
              WHERE IdDoenca = ? ";

    $paramsSql = array( $DoencaDTO->getDescricao(), 
                        $DoencaDTO->getIdCid(),
                        $DoencaDTO->getEhContagiosa(),
                        $DoencaDTO->getEhHereditaria(),
                        $DoencaDTO->getIdDoenca() ); 

    if ($stmt = sqlsrv_prepare( $this->conn, $sql, $paramsSql )){

      return (sqlsrv_execute($stmt));

    }  

  } 

  public function delete($DoencaDTO){

    $sql = " DELETE 
               FROM dbo.Doenca
              WHERE IdDoenca = ? ";

    $paramsSql = array( $DoencaDTO->getIdDoenca() ); 

    if ($stmt = sqlsrv_prepare( $this->conn, $sql, $paramsSql )){

      return (sqlsrv_execute($stmt));

    }  

  }

}

?>