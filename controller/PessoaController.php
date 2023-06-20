<?php

  //Inicia a sessão
  @session_start(); 

  //Verifica se o usuário está logado
  if (isset($_SESSION["isLogged"])){
    $isLogged = $_SESSION["isLogged"] == "true";

    $tipoPessoaLogada = $_SESSION["tipoPessoa"];
  }

  //Obtem a conexão com o banco de dados
  require "../model/conn.php";

  //Obtem a classe pessoa DTO e DAO
  require "../model/PessoaDTO.php";
  require "../model/PessoaDAO.php";

  //Obtem a ação a ser executada
  @$action     = $_GET["action"];
  @$tipoPessoa = $_GET["tipoPessoa"];
  @$id         = $_GET["id"];

  if (@$tipoPessoa == null) @$tipoPessoa = $_POST["ihTipoPessoa"];

  //Executa a ação requisitada
  switch ($action) {

    case "list":

      $PessoaDAO = new PessoaDAO( $conn, $params, $options );
      $resultSet = $PessoaDAO->list($tipoPessoa);

      switch ($tipoPessoa) {
        case 1:
          require "../view/listAdministrador.php";
        break;
        case 2:
          require "../view/listEnfermeiro.php";
        break;
        case 3:
          require "../view/listPaciente.php";
        break;
        default:
          require "../view/404.html";              
        break;
      }
    
    break;
    case "edit":
    case "view":

      $PessoaDAO = new PessoaDAO( $conn, $params, $options );
      $resultSet = $PessoaDAO->list($tipoPessoa, $id);     

      switch ($tipoPessoa) {
        case 1:
          require "../view/formAdministrador.php";
        break;
        case 2:
          require "../view/formEnfermeiro.php";
        break;
        case 3:
          require "../view/formPaciente.php";
        break;
        default:
          require "../view/404.html";              
        break;
      }

    break;
    case "insert":

      $PessoaDTO = new PessoaDTO();

      $PessoaDTO->setNome($_POST["itNome"]);
      $PessoaDTO->setTipoPessoa($tipoPessoa);
      $PessoaDTO->setCPF($_POST["itCpf"]);
      $PessoaDTO->setSexo($_POST["seSexo"]);
      $PessoaDTO->setDataNascimento($_POST["idDataNascimento"]);
      $PessoaDTO->setTelefoneCelular($_POST["itCelular"]);
      $PessoaDTO->setTelefoneFixo($_POST["itTelefoneFixo"] ?: null);
      $PessoaDTO->setCEP($_POST["itCep"] ?: null);
      $PessoaDTO->setEndereco($_POST["itEndereco"] ?: null);
      $PessoaDTO->setNumero($_POST["itNumero"] ?: null);
      $PessoaDTO->setBairro($_POST["itBairro"] ?: null);
      $PessoaDTO->setCidade($_POST["itCidade"] ?: null);
      $PessoaDTO->setEstado($_POST["seEstado"] ?: null); 
      $PessoaDTO->setEmail($_POST["itEmail"] ?: null);        
      $PessoaDTO->setRG($_POST["itRg"] ?: null);
      $PessoaDTO->setCRM($_POST["itCrm"] ?: null);
      $PessoaDTO->setCNS($_POST["itCns"] ?: null);

      if ($tipoPessoa == 3){
        $PessoaDTO->setNomeUsuario(str_replace([".","-"] ,"", $PessoaDTO->getCPF())); //Por padrão, gera o usuário usando o CPF (sem pontos)
        
        if (isset($_POST["ipSenha"])){
          $PessoaDTO->setSenha($_POST["ipSenha"]);
        }else{
          $PessoaDTO->setSenha(str_replace([".","-"] ,"", $PessoaDTO->getCPF())); //Por padrão, gera a senha usando o CPF (sem pontos)
        }
      }else{
        $PessoaDTO->setNomeUsuario($_POST["itUsuario"]); 
        $PessoaDTO->setSenha($_POST["ipSenha"]);
      }

      /* Caso necessitar validar algo, validar aqui */

      $PessoaDAO = new PessoaDAO( $conn, $paramsIUD, $options );

      if ($PessoaDAO->insert($PessoaDTO)){

        if (! $isLogged){
          $_SESSION["execJS"] = "aviso('Usuário cadastrado! efetue o login...','alert-success');";
          header("Location: ../view/login.php");  
        }else{
          $_SESSION["execJS"] = " toastr.success('Registro inserido com sucesso!'); ";
          header("Location: ../controller/PessoaController.php?action=list&tipoPessoa=$tipoPessoa");
        }
        
      }else{
        $_SESSION["execJS"] = " toastr.error('Erro ao inserir o registro!'); ";
        header("Location: ../controller/PessoaController.php?action=list&tipoPessoa=$tipoPessoa");
      }
 
    break;
    case "update":

      $PessoaDTO = new PessoaDTO();

      $PessoaDTO->setIdPessoa($id);
      $PessoaDTO->setNome($_POST["itNome"]);
      $PessoaDTO->setCPF($_POST["itCpf"]);
      $PessoaDTO->setSexo($_POST["seSexo"]);
      $PessoaDTO->setDataNascimento($_POST["idDataNascimento"]);
      $PessoaDTO->setTelefoneCelular($_POST["itCelular"]);
      $PessoaDTO->setTelefoneFixo($_POST["itTelefoneFixo"] ?: null);
      $PessoaDTO->setCEP($_POST["itCep"] ?: null);
      $PessoaDTO->setEndereco($_POST["itEndereco"] ?: null);
      $PessoaDTO->setNumero($_POST["itNumero"] ?: null);      
      $PessoaDTO->setBairro($_POST["itBairro"] ?: null);
      $PessoaDTO->setCidade($_POST["itCidade"] ?: null);
      $PessoaDTO->setEstado($_POST["seEstado"] ?: null);
      $PessoaDTO->setEmail($_POST["itEmail"] ?: null);
      $PessoaDTO->setRG($_POST["itRg"] ?: null);
      $PessoaDTO->setCRM($_POST["itCrm"] ?: null);
      $PessoaDTO->setCNS($_POST["itCns"] ?: null);

      /* Caso necessitar validar algo, validar aqui */

      $PessoaDAO = new PessoaDAO( $conn, $paramsIUD, $options );

      if ($PessoaDAO->update($PessoaDTO)){
        $_SESSION["execJS"] = " toastr.success('Registro atualizado com sucesso!'); ";
      }else{
        $_SESSION["execJS"] = " toastr.error('Erro ao atualizar o registro!'); ";
      }

      if ($tipoPessoaLogada == 3){
        header("Location: ../view/dashboard.php");
      }else{
        header("Location: ../controller/PessoaController.php?action=list&tipoPessoa=$tipoPessoa");
      }


    
    break;
    case "delete":

      $PessoaDTO = new PessoaDTO();
      $PessoaDTO->setIdPessoa($id);
      $PessoaDAO = new PessoaDAO( $conn, $paramsIUD, $options );

      /* Caso necessitar validar algo, validar aqui */

      if ($PessoaDAO->delete($PessoaDTO)){
        $_SESSION["execJS"] = " toastr.success('Registro excluído com sucesso!'); ";
      }else{
        $_SESSION["execJS"] = " toastr.error('Erro ao excluir o registro!'); ";
      }

      header("Location: ../controller/PessoaController.php?action=list&tipoPessoa=$tipoPessoa");

    break;
    default:

      require "../view/404.html";
            
    break;

    @sqlsrv_close($conn); 
    @sqlsrv_free_stmt($stmt); 

  }

?>
