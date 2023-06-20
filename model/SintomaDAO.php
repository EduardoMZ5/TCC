<?php

class SintomaDAO {

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

  public function list($idSintoma = 0){

    $sql = " SELECT *
               FROM dbo.Sintoma ";

    if ($idSintoma != 0){
      $sql .= " WHERE IdSintoma = $idSintoma ";
    } 

    $qySintoma = sqlsrv_query( $this->conn, $sql, $this->params, $this->options ); 

    if (sqlsrv_num_rows($qySintoma) != 0) {

      $resultSet = array();

      while ($rows = sqlsrv_fetch_array($qySintoma)) {

        $SintomaDTO = new SintomaDTO();
        $SintomaDTO->setIdSintoma($rows["IdSintoma"]);
        $SintomaDTO->setDescricao($rows["Descricao"]);;

        $resultSet[] = clone $SintomaDTO;

      }

      return $resultSet;
    
    }

  }

  public function insert($SintomaDTO){

    $sql = " INSERT INTO dbo.Sintoma ( Descricao ) 
                              VALUES ( ? ) ";

    $paramsSql = array( $SintomaDTO->getDescricao() ); 

    if ($stmt = sqlsrv_prepare( $this->conn, $sql, $paramsSql )){

      return (sqlsrv_execute($stmt));

    }  

  }

  public function update($SintomaDTO){

    $sql = " UPDATE dbo.Sintoma
                SET Descricao = ?
              WHERE IdSintoma = ? ";

    $paramsSql = array( $SintomaDTO->getDescricao() ); 

    if ($stmt = sqlsrv_prepare( $this->conn, $sql, $paramsSql )){

      return (sqlsrv_execute($stmt));

    }  

  } 

  public function delete($SintomaDTO){

    $sql = " DELETE 
               FROM dbo.Sintoma
              WHERE IdSintoma = ? ";

    $paramsSql = array( $SintomaDTO->getIdSintoma() ); 

    if ($stmt = sqlsrv_prepare( $this->conn, $sql, $paramsSql )){

      return (sqlsrv_execute($stmt));

    }  

  }

}

?>