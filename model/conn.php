<?php

  $serverName     = "(local)"; //serverName\instanceName
  $connectionInfo = array("Database"=>"TCC", "UID"=>"EduardoMZ", "PWD"=>"acbdl1234");
  $conn           = sqlsrv_connect( $serverName, $connectionInfo);

  $options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET ); //Modo de leitura (do início ao fim, linha a linha)
    
  $params    = array(); //Utilizado em SELECT
  $paramsIUD = array(2, 709); //Utilizado em INSERT, UPDATE e DELETE (Verificar se as linhas foram afetadas)

  if (!$conn) header("Location: ../view/500.html");  

?>
