<?php

  //Inicia a sessão
  session_start();  

  //Obtem a conexão com o banco de dados
  require "../model/conn.php";

  //Obtem a classe doenca DTO e DAO
  require "../model/DoencaDTO.php";
  require "../model/DoencaDAO.php";

  //Obtem a ação a ser executada
  @$action     = $_GET["action"];
  @$id         = $_GET["id"];

  //Executa a ação requisitada
  switch ($action) {

    case "list":

      $DoencaDAO = new DoencaDAO( $conn, $params, $options );
      $resultSet = $DoencaDAO->list();
          
      require "../view/listDoenca.php";
    
    break;
    case "edit":
    case "view":

      $DoencaDAO = new DoencaDAO( $conn, $params, $options );
      $resultSet = $DoencaDAO->list($id);     

      require "../view/formDoenca.php";

    break;
    case "insert":

      $DoencaDTO = new DoencaDTO();

      $DoencaDTO->setDescricao($_POST["itDescricao"]);
      if ($_POST["seIdCid"] != 0) $DoencaDTO->setIdCid($_POST["seIdCid"]);
      $DoencaDTO->setEhContagiosa($_POST["icEhContagiosa"] == "on");
      $DoencaDTO->setEhHereditaria($_POST["icEhHereditaria"] == "on");

      /* Caso necessitar validar algo, validar aqui */

      $DoencaDAO = new DoencaDAO( $conn, $paramsIUD, $options );

      if ($DoencaDAO->insert($DoencaDTO)){
        $_SESSION["execJS"] = " toastr.success('Registro inserido com sucesso!'); ";
      }else{
        $_SESSION["execJS"] = " toastr.error('Erro ao inserir o registro!'); ";
      }

      header("Location: ../controller/DoencaController.php?action=list");
    
    break;
    case "update":

      $DoencaDTO = new DoencaDTO();

      $DoencaDTO->setIdDoenca($id);
      $DoencaDTO->setDescricao($_POST["itDescricao"]);
      if ($_POST["seIdCid"] != 0) $DoencaDTO->setIdCid($_POST["seIdCid"]);
      $DoencaDTO->setEhContagiosa($_POST["icEhContagiosa"] == "on");
      $DoencaDTO->setEhHereditaria($_POST["icEhHereditaria"] == "on");

      /* Caso necessitar validar algo, validar aqui */

      $DoencaDAO = new DoencaDAO( $conn, $paramsIUD, $options );

      if ($DoencaDAO->update($DoencaDTO)){
        $_SESSION["execJS"] = " toastr.success('Registro atualizado com sucesso!'); ";
      }else{
        $_SESSION["execJS"] = " toastr.error('Erro ao atualizar o registro!'); ";
      }

      header("Location: ../controller/DoencaController.php?action=list");
    
    break;
    case "delete":

      $DoencaDTO = new DoencaDTO();
      $DoencaDTO->setIdDoenca($id);
      $DoencaDAO = new DoencaDAO( $conn, $paramsIUD, $options );

      /* Caso necessitar validar algo, validar aqui */

      if ($DoencaDAO->delete($DoencaDTO)){
        $_SESSION["execJS"] = " toastr.success('Registro excluído com sucesso!'); ";
      }else{
        $_SESSION["execJS"] = " toastr.error('Erro ao excluir o registro!'); ";
      }

      header("Location: ../controller/DoencaController.php?action=list");

    break;
    default:

      require "../view/404.html";
            
    break;

    @sqlsrv_close($conn); 
    @sqlsrv_free_stmt($stmt); 

  }

?>
