<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Recuperar Senha</title>
  <link rel="icon" type="image/x-icon" href="../view/dist/img/favicon.ico">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../view/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../view/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../view/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <div class="h1"><b>Tri</b>Med</div>
    </div>
    <div id="alert" class="alert alert-warning alert-dismissible" style="display: none; padding: 8px; margin: 10px;">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h5><i class="icon fas fa-exclamation-triangle"></i> Atenção!</h5>
      <div id="alert-message"></div>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Alterar Senha</p>
      <form name="recoverPassword" id="recoverPassword" action="../controller/recoverPassword.php" method="post">
        <div class="input-group mb-3 form-group">
          <input type="password" id="itSenha" name="itSenha" class="form-control" placeholder="Digite sua nova Senha">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3 form-group">
          <input type="password" id="itSenhaConfirmacao" name="itSenhaConfirmacao" class="form-control" placeholder="Confirmar Senha">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Confirmar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <br>
      <p class="mb-0">
        Ja possui uma conta? <a href="../view/login.php" class="text-center">Entrar</a>
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
<!-- InputMask -->
<script src="../view/plugins/inputmask/jquery.inputmask.js"></script>
<!-- jquery-validation -->
<script src="../view/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="../view/plugins/jquery-validation/additional-methods.min.js"></script>
<script>

	//Mask
	$("#itCpf").inputmask("999.999.999-99");

  //Validate
	$(function() {
		$.validator.setDefaults({});

		$('#recoverPassword').validate({
		rules: {
      itSenha: {
        required: true,
        minlength: 6
      },
      itSenhaConfirmacao: {
        required: true,
        equalTo: "#itSenha"
      }

		},
		messages: {
      itSenha: {
        required: "O campo senha é obrigatório!",
        minlength: "A senha deve ter pelo menos 6 caracteres"
      },
      itSenhaConfirmacao: {
        required: "O campo confirmar senha é obrigatório!",
        equalTo: "Confirmação de senha inválido!"
      }
		},
		errorElement: 'span',
		errorPlacement: function(error, element) {
			error.addClass('invalid-feedback');
			element.closest('.form-group').append(error);
		},
		highlight: function(element, errorClass, validClass) {
			$(element).addClass('is-invalid');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).removeClass('is-invalid');
		}
		});

	});

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
