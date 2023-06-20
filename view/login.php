<?php
  //Verifica se o usuário está logado, caso sim, 
  //impede que ele acessa o login e redireciona para o dashboard 
  session_start();

  if (isset($_SESSION["isLogged"])){
    $isLogged = $_SESSION["isLogged"] == "true";

    if ($isLogged){
      header("Location: ../view/dashboard.php");  
      exit;
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Entrar na conta</title>
  <link rel="icon" type="image/x-icon" href="../view/dist/img/favicon.ico">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../view/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../view/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../view/dist/css/adminlte.min.css">
  <!-- Image background -->
  <style>
    .bg-image {
      background-image: url('../view/dist/img/background.jpg');
      background-size: cover;
      background-position: center center;
      height: 100vh; /* Adjust the height as needed */
    }
  </style>
</head>
<body class="hold-transition login-page bg-image">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <div class="h1"><b>Tri</b>Med</div>
    </div>
    <div id="alert" class="alert alert-dismissible" style="display: none; padding: 8px; margin: 10px;">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h5><i class="icon fas fa-exclamation-triangle"></i> Atenção!</h5>
      <div id="alert-message"></div>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Entrar na conta</p>
      <form name="login" id="login" action="../controller/logIn.php" method="post">
        <div class="input-group mb-3">
          <input type="text" id="itLogin" name="itLogin" class="form-control" placeholder="Login">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="ipSenha" id="ipSenha" class="form-control" placeholder="Senha">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <br>
      <!-- Nao implementado 
      <p class="mb-1">
        <br>
        <a href="../view/forgotPassword.php">Esqueceu a senha?</a>
      </p> -->
      <p class="mb-0">
        Não tem uma conta? <a href="../view/register.php" class="text-center">Crie uma</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../view/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../view/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../view/dist/js/adminlte.min.js"></script>
<!-- TriMed Geral -->
<script src="../view/dist/js/trimed.geral.js"></script>
<script>

  //Rotina que pega o js armazenado na sessão para ser executada
  <?php
    if (isset($_SESSION["execJS"])) {
      echo $_SESSION["execJS"];
      unset($_SESSION["execJS"]);
    }
  ?>

</script>
</body>
</html>
