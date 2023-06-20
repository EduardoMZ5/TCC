<?php

  //Inicia a sessão
  session_start();  

  //Obtem a conexão com o banco de dados
  require "../model/conn.php";

  //Obtem a classe triagem DTO e DAO
  require "../model/TriagemDTO.php";
  require "../model/TriagemDAO.php";

  require "../model/TriagemSintomaDTO.php";
  require "../model/TriagemSintomaDAO.php";

  require "../model/TriagemDoencaDTO.php";
  require "../model/TriagemDoencaDAO.php";

  //Obtem a ação a ser executada
  @$action = $_GET["action"];
  @$id     = $_GET["id"];

  //Obtem o id e o tipoPessoa do usuário logado
  $idPessoa   = $_SESSION["idPessoa"];
  $tipoPessoa = $_SESSION["tipoPessoa"];

  //variáveis globais
  $currtDate = date('Y-m-d');

  //Executa a ação requisitada
  switch ($action) {

    case "list":

      $TriagemDAO = new TriagemDAO( $conn, $params, $options );

      $resultSet = $TriagemDAO->list(0, $idPessoa, $tipoPessoa);
          
      require "../view/listTriagem.php";
    
    break;
    case "edit":
    case "view":

      $TriagemDAO = new TriagemDAO( $conn, $params, $options );
      $resultSet = $TriagemDAO->list($id);     

      require "../view/formTriagem.php";

    break;
    case "set-status":

      $TriagemDTO = new TriagemDTO();

      $TriagemDTO->setIdTriagem($id);
      $TriagemDTO->setStatus($_GET["status"]);

      if ($_GET["status"] == 1){
        $TriagemDTO->setIdEnfermeiro($idPessoa);
      }
      
      $TriagemDAO = new TriagemDAO( $conn, $paramsIUD, $options );

      if ($TriagemDAO->setStatus($TriagemDTO)){

        switch ($_GET["status"]) {
          case 1:
            $msg = "Triagem Inicializada!";
          break;
          case 3:
            $msg = "Triagem Finalizada!";
            break;
          case 4:
            $msg = "Triagem Cancelada!";
          break;
          default:
            require "../view/505.html";            
          break;
        }
      
        $_SESSION["execJS"] = " toastr.success('$msg'); ";
      }else{
        $_SESSION["execJS"] = " toastr.error('Erro ao atualizar o status!'); ";
      }

      header("Location: ../controller/TriagemController.php?action=list");

    break;
    case "insert":

      $TriagemDTO = new TriagemDTO();

      $TriagemDTO->setIdPaciente($_POST["seIdPaciente"]);
      $TriagemDTO->setDataHoraAtendimento($_POST["idDataAtendimento"]);
      $TriagemDTO->setStatus(($tipoPessoa == 3 || strtotime($currtDate) < strtotime(substr($_POST["idDataAtendimento"],0,10)) ? 2 : 1 ));      
      $TriagemDTO->setClassificacaoRisco($_POST["seClassificacaoRisco"]);
      $TriagemDTO->setIdEnfermeiro((($TriagemDTO->getStatus() == 1 && $tipoPessoa == 2) ? $idPessoa : null));    
      $TriagemDTO->setPeso(str_replace(",", ".", $_POST["itPeso"]) ?: null);
      $TriagemDTO->setAltura(str_replace(",", ".", $_POST["itAltura"]) ?: null);
      $TriagemDTO->setPressaoArterial($_POST["itPressao"] ?: null);
      $TriagemDTO->setFrequenciaRespiratoria($_POST["itFrequenciaRespiratoria"] ?: null);
      $TriagemDTO->setFrequenciaCardiaca($_POST["itFrequenciaCardiaca"] ?: null);
      $TriagemDTO->setTemperatura($_POST["itTemperatura"] ?: null);
      $TriagemDTO->setObersevacao($_POST["taObservacao"] ?: null);

      /* Caso necessitar validar algo, validar aqui */

      $TriagemDAO = new TriagemDAO( $conn, $paramsIUD, $options );

      if ($TriagemDAO->insert($TriagemDTO)){

        //Obtem o Id da Triagem criada
        $idTriagem = $TriagemDAO->getMaxId();

        //Obtendo e gravando sintomas
        $sintomas = $_POST["seSintoma"];

        //Percorrendo e gravando os sintomas
        foreach ($sintomas as $idSintoma) {

          $TriagemSintomaDTO = new TriagemSintomaDTO();
          $TriagemSintomaDTO->setIdSintoma($idSintoma);
          $TriagemSintomaDTO->setIdTriagem($idTriagem);

          $TriagemSintomaDAO = new TriagemSintomaDAO( $conn, $paramsIUD, $options );
          $TriagemSintomaDAO->insert($TriagemSintomaDTO);

        }

        //Obtendo e gravando as doenças
        $doencas = $_POST["seDoenca"];

        //Percorrendo e gravando os sintomas
        foreach ($doencas as $idDoenca) {

          $TriagemDoencaDTO = new TriagemDoencaDTO();
          $TriagemDoencaDTO->setIdDoenca($idDoenca);
          $TriagemDoencaDTO->setIdTriagem($idTriagem);

          $TriagemDoencaDAO = new TriagemDoencaDAO( $conn, $paramsIUD, $options );
          $TriagemDoencaDAO->insert($TriagemDoencaDTO);

        }

        $_SESSION["execJS"] = " toastr.success('Registro inserido com sucesso!'); ";
      }else{
        $_SESSION["execJS"] = " toastr.error('Erro ao inserir o registro!'); ";
      }

      header("Location: ../controller/TriagemController.php?action=list");
    
    break;
    case "update":

      $TriagemDTO = new TriagemDTO();

      $TriagemDTO->setIdTriagem($id);
      $TriagemDTO->setClassificacaoRisco($_POST["seClassificacaoRisco"]); 
      $TriagemDTO->setPeso(str_replace(",", ".", $_POST["itPeso"]) ?: null);
      $TriagemDTO->setAltura(str_replace(",", ".", $_POST["itAltura"]) ?: null);
      $TriagemDTO->setPressaoArterial($_POST["itPressao"] ?: null);
      $TriagemDTO->setFrequenciaRespiratoria($_POST["itFrequenciaRespiratoria"] ?: null);
      $TriagemDTO->setFrequenciaCardiaca($_POST["itFrequenciaCardiaca"] ?: null);
      $TriagemDTO->setTemperatura($_POST["itTemperatura"] ?: null);
      $TriagemDTO->setObersevacao($_POST["taObservacao"] ?: null);

      /* Caso necessitar validar algo, validar aqui */

      $TriagemDAO = new TriagemDAO( $conn, $paramsIUD, $options );

      if ($TriagemDAO->update($TriagemDTO)){

        //Cria as classes DAO
        $TriagemSintomaDAO = new TriagemSintomaDAO( $conn, $paramsIUD, $options );
        $TriagemDoencaDAO  = new TriagemDoencaDAO( $conn, $paramsIUD, $options );

        //Obtendo os arrays de sintoma e doença
        $sintomas = $_POST["seSintoma"];
        $doencas  = $_POST["seDoenca"];

        //deleta os sintomas e doenças anteriores
        $TriagemSintomaDAO->delete($id);
        $TriagemDoencaDAO->delete($id);        

        //Percorrendo e gravando os sintomas
        foreach ($sintomas as $idSintoma) {
          $TriagemSintomaDTO = new TriagemSintomaDTO();

          $TriagemSintomaDTO->setIdSintoma($idSintoma);
          $TriagemSintomaDTO->setIdTriagem($id);

          $TriagemSintomaDAO->insert($TriagemSintomaDTO);
        }          

        //Percorrendo e gravando os sintomas
        foreach ($doencas as $idDoenca) {
          $TriagemDoencaDTO = new TriagemDoencaDTO();

          $TriagemDoencaDTO->setIdDoenca($idDoenca);
          $TriagemDoencaDTO->setIdTriagem($id);

          $TriagemDoencaDAO->insert($TriagemDoencaDTO);
        }

        $_SESSION["execJS"] = " toastr.success('Registro atualizado com sucesso!'); ";
      }else{
        $_SESSION["execJS"] = " toastr.error('Erro ao atualizar o registro!'); ";
      }

      header("Location: ../controller/TriagemController.php?action=list");
    
    break;
    case "delete":

      $TriagemDTO = new TriagemDTO();
      $TriagemDTO->setIdTriagem($id);
      $TriagemDAO = new TriagemDAO( $conn, $paramsIUD, $options );

      /* Caso necessitar validar algo, validar aqui */

      if ($TriagemDAO->delete($TriagemDTO)){
        $_SESSION["execJS"] = " toastr.success('Registro excluído com sucesso!'); ";
      }else{
        $_SESSION["execJS"] = " toastr.error('Erro ao excluir o registro!'); ";
      }

      header("Location: ../controller/TriagemController.php?action=list");

    break;
    default:

      require "../view/404.html";
            
    break;

    @sqlsrv_close($conn); 
    @sqlsrv_free_stmt($stmt); 

  }

?>
