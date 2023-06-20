<?php

class TriagemDoencaDAO {

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

  public function list($idTriagemDoenca = 0){

    $sql = " SELECT Tdo.IdTriagemDoenca,
                    Tdo.IdTriagem,
                    Tdo.IdDoenca,
                    Doe.Descricao AS DescricaoDoenca
               FROM dbo.TriagemDoenca Tdo
         INNER JOIN dbo.Doenca        Doe ON Tdo.IdDoenca = Doe.IdDoenca ";

    if ($idTriagemDoenca != 0){
      $sql .= " WHERE IdTriagemDoenca = $idTriagemDoenca ";
    } 

    $qyTriagemDoenca = sqlsrv_query( $this->conn, $sql, $this->params, $this->options ); 

    if (sqlsrv_num_rows($qyTriagemDoenca) != 0) {

      $resultSet = array();

      while ($rows = sqlsrv_fetch_array($qyTriagemDoenca)) {

        $TriagemDoencaDTO = new TriagemDoencaDTO();
        $TriagemDoencaDTO->setIdTriagemDoenca($rows["IdTriagemDoenca"]);
        $TriagemDoencaDTO->setIdTriagem($rows["IdTriagem"]);
        $TriagemDoencaDTO->setIdDoenca($rows["IdDoenca"]);
        $TriagemDoencaDTO->setDescricaoDoenca($rows["DescricaoDoenca"]);

        $resultSet[] = clone $TriagemDoencaDTO;

      }

      return $resultSet;
    
    }

  }

  public function insert($TriagemDoencaDTO){

    $sql = " INSERT INTO dbo.TriagemDoenca ( IdTriagem,
                                             IdDoenca ) 
                              VALUES ( ?, ? ) ";

    $paramsSql = array( $TriagemDoencaDTO->getIdTriagem(),
                        $TriagemDoencaDTO->getIdDoenca() ); 

    if ($stmt = sqlsrv_prepare( $this->conn, $sql, $paramsSql )){

      return (sqlsrv_execute($stmt));

    }  

  }

  public function delete($IdTriagem){

    $sql = " DELETE 
               FROM dbo.TriagemDoenca
              WHERE IdTriagem = ? ";

    $paramsSql = array( $IdTriagem ); 

    if ($stmt = sqlsrv_prepare( $this->conn, $sql, $paramsSql )){

      return (sqlsrv_execute($stmt));

    }  

  }

}

?>