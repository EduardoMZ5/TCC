<?php

  //Inicia a sessão
  session_start();  

  //Obtem a conexão com o banco de dados
  require "../model/conn.php";

  //Obtem a classe sintoma DTO e DAO
  require "../model/SintomaDTO.php";
  require "../model/SintomaDAO.php";

  //Obtem a ação a ser executada
  @$action     = $_GET["action"];
  @$id         = $_GET["id"];

  //Executa a ação requisitada
  switch ($action) {

    case "list":

      $SintomaDAO = new SintomaDAO( $conn, $params, $options );
      $resultSet = $SintomaDAO->list();
          
      require "../view/listSintoma.php";
    
    break;
    case "edit":
    case "view":

      $SintomaDAO = new SintomaDAO( $conn, $params, $options );
      $resultSet = $SintomaDAO->list($id);     

      require "../view/formSintoma.php";

    break;
    case "insert":

      $SintomaDTO = new SintomaDTO();

      $SintomaDTO->setDescricao($_POST["itDescricao"]);

      /* Caso necessitar validar algo, validar aqui */

      $SintomaDAO = new SintomaDAO( $conn, $paramsIUD, $options );

      if ($SintomaDAO->insert($SintomaDTO)){
        $_SESSION["execJS"] = " toastr.success('Registro inserido com sucesso!'); ";
      }else{
        $_SESSION["execJS"] = " toastr.error('Erro ao inserir o registro!'); ";
      }

      header("Location: ../controller/SintomaController.php?action=list");
    
    break;
    case "update":

      $SintomaDTO = new SintomaDTO();

      $SintomaDTO->setIdSintoma($id);
      $SintomaDTO->setDescricao($_POST["itDescricao"]);

      /* Caso necessitar validar algo, validar aqui */

      $SintomaDAO = new SintomaDAO( $conn, $paramsIUD, $options );

      if ($SintomaDAO->update($SintomaDTO)){
        $_SESSION["execJS"] = " toastr.success('Registro atualizado com sucesso!'); ";
      }else{
        $_SESSION["execJS"] = " toastr.error('Erro ao atualizar o registro!'); ";
      }

      header("Location: ../controller/SintomaController.php?action=list");
    
    break;
    case "delete":

      $SintomaDTO = new SintomaDTO();
      $SintomaDTO->setIdSintoma($id);
      $SintomaDAO = new SintomaDAO( $conn, $paramsIUD, $options );

      /* Caso necessitar validar algo, validar aqui */

      if ($SintomaDAO->delete($SintomaDTO)){
        $_SESSION["execJS"] = " toastr.success('Registro excluído com sucesso!'); ";
      }else{
        $_SESSION["execJS"] = " toastr.error('Erro ao excluir o registro!'); ";
      }

      header("Location: ../controller/SintomaController.php?action=list");

    break;
    default:

      require "../view/404.html";
            
    break;

    @sqlsrv_close($conn); 
    @sqlsrv_free_stmt($stmt); 

  }

?>
