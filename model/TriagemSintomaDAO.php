<?php

class TriagemSintomaDAO {

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

  public function list($idTriagemSintoma = 0){

    $sql = " SELECT Tsi.IdTriagemSintoma,
                    Tsi.IdTriagem,
                    Tsi.IdSintoma,
                    Sin.Descricao as DescricaoSintoma
               FROM dbo.TriagemSintoma Tsi
         INNER JOIN dbo.Sintoma        Sin ON Tsi.IdSintoma = Sin.IdSintoma ";

    if ($idTriagemSintoma != 0){
      $sql .= " WHERE IdTriagemSintoma = $idTriagemSintoma ";
    } 

    $qyTriagemSintoma = sqlsrv_query( $this->conn, $sql, $this->params, $this->options ); 

    if (sqlsrv_num_rows($qyTriagemSintoma) != 0) {

      $resultSet = array();

      while ($rows = sqlsrv_fetch_array($qyTriagemSintoma)) {

        $TriagemSintomaDTO = new TriagemSintomaDTO();
        $TriagemSintomaDTO->setIdTriagemSintoma($rows["IdTriagemSintoma"]);
        $TriagemSintomaDTO->setIdTriagem($rows["IdTriagem"]);
        $TriagemSintomaDTO->setIdSintoma($rows["IdSintoma"]);
        $TriagemSintomaDTO->setDescricaoSintoma($rows["DescricaoSintoma"]);

        $resultSet[] = clone $TriagemSintomaDTO;

      }

      return $resultSet;
    
    }

  }

  public function insert($TriagemSintomaDTO){

    $sql = " INSERT INTO dbo.TriagemSintoma ( IdTriagem,
                                              IdSintoma ) 
                              VALUES ( ?, ? ) ";

    $paramsSql = array( $TriagemSintomaDTO->getIdTriagem(),
                        $TriagemSintomaDTO->getIdSintoma() ); 

    if ($stmt = sqlsrv_prepare( $this->conn, $sql, $paramsSql )){

      return (sqlsrv_execute($stmt));

    }  

  }

  public function delete($IdTriagem){

    $sql = " DELETE 
               FROM dbo.TriagemSintoma
              WHERE IdTriagem = ? ";

    $paramsSql = array( $IdTriagem ); 

    if ($stmt = sqlsrv_prepare( $this->conn, $sql, $paramsSql )){

      return (sqlsrv_execute($stmt));

    }  

  }

}

?>