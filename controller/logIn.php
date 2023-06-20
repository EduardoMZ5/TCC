<?php

  //Inicia a sessão
  session_start();  

  //obtem a conexão com o banco de dados
  require "../model/conn.php";

  //Obtem os parâmetros via POST
  $login = $_POST["itLogin"];
  $senha = md5($_POST["ipSenha"]);  

  //Realizando a consulta no banco para verificar se o usuário existe
  $sql = " SELECT IdPessoa,
                  Nome,
                  CPF,
                  TipoPessoa
             FROM dbo.Pessoa 
            WHERE NomeUsuario = '$login' 
              AND Senha = '$senha' ";

  $qyUsuario = sqlsrv_query( $conn, $sql, $params, $options ); 
  
  //Caso não retornar nada, o login ou senha está inválido, se não, armazena na sessão os dados do usuário
  if (sqlsrv_num_rows($qyUsuario) == 0) {

    $_SESSION["execJS"] = " aviso('Login ou senha inválidos!', 'alert-warning'); ";
    header("Location: ../view/login.php");
	  exit;

  }else{

    while ($rows = sqlsrv_fetch_array($qyUsuario)) {

      $_SESSION["idPessoa"]   = $rows["IdPessoa"]; 
      $_SESSION["nome"]       = $rows["Nome"]; 
      $_SESSION["cpf"]        = $rows["CPF"]; 
      $_SESSION["tipoPessoa"] = $rows["TipoPessoa"];
      $_SESSION["isLogged"]   = "true";

      //redireciona para o dashboard
      header("Location: ../view/dashboard.php");

    }

  }

   //fechando a conexão com o banco
   sqlsrv_close($conn);    

?>