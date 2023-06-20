<?php 
	require("header.php");  
  
	if (isset($_GET['action'])) {
		
		$action      = $_GET['action'];
		$actionPost  = "";
		$actionLabel = "";

		switch ($action) {

			case "insert":

				require "../model/PessoaDTO.php";	
				$PessoaDTO = new PessoaDTO();

				$actionPost  = "insert";
				$actionLabel = "Incluir Registro";

			break;
			case "edit":
			case "view":

				foreach ($resultSet as $PessoaDTO);

				$actionPost  = "update&id=". $PessoaDTO->getIdPessoa();
				$actionLabel = ($action == "view" ? "Visualizar" : "Alterar") ." Registro";

			break;
			default:

				header("Location: ../view/500.html"); 

			break;

		}

	}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Administrador</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item">Cadastro</li>
						<li class="breadcrumb-item">Administrador</li>
					</ol>
				</div>
			</div>
		</div>
		<!-- /.container-fluid -->
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<!-- left column -->
				<div class="col-md-12">
					<!-- general form elements -->
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">
								<?php echo $actionLabel ?>
							</h3>
						</div>
						<!-- /.card-header -->
						<form name="cadastroAdministrador" id="cadastroAdministrador" method="post"
							action="../controller/PessoaController.php?action=<?php echo $actionPost ?>">
							<div class="card-body">

								<div class="form-group">
									<label for="itNome">* Nome</label>
									<input maxlength="100" type="text" class="form-control" name="itNome" id="itNome"
										placeholder="Informe seu nome" value="<?php echo $PessoaDTO->getNome(); ?>">
								</div>						
								<div class="card card-primary" style="<?php if ($action != "insert") echo "display: none;"; ?>">
									<div class="card-header">
										<h3 class="card-title">Acesso ao Sistema</h3>
									</div>
									<div class="card-body">
										<div class="row form-group">
											<div class="col-md-6 form-group">
												<label for="itEmail">* Email</label>
												<input maxlength="50 "type="text" class="form-control" name="itEmail" id="itEmail"
													placeholder="Ex. conta@provedor.com">
											</div>
											<div class="col-md-3 form-group">
												<label for="itUsuario">* Usuário</label>
												<input maxlength="10" type="text" class="form-control" name="itUsuario" id="itUsuario"
													placeholder="Ex. user001">
											</div>
											<div class="col-md-3 form-group">
												<label for="ipSenha">* Senha</label>
												<input maxlength="50" type="password" class="form-control" name="ipSenha" id="ipSenha">
											</div>
										</div>
									</div>
								</div>
							</div>

							<input type="hidden" class="form-control" name="ihTipoPessoa" id="ihTipoPessoa" value="1">

							<!-- /.card-body -->
							<div class="card-footer">
								<button type="submit" class="btn btn-primary mr-2" style="<?php if ($action == "view") echo "display: none;"; ?>">Salvar</button>
								<button type="button" class="btn btn-dark"
									onclick="window.history.back();"><?php echo ($action == "view" ? "Voltar" : "Cancelar"); ?></button>
							</div>

					</div>
					</form>
				</div>
				<!-- /.card -->
			</div>
			<!--/.col (right) -->
		</div>
		<!-- /.row -->

		<!-- /.container-fluid -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php 
  require("footer.php");   
?>

<script>

	//Validate
	$(function() {
		$.validator.setDefaults({});

		jQuery.validator.addMethod('emailValido', function(val){ return validarEmail(val); });

		$('#cadastroAdministrador').validate({
		rules: {
			itNome: {
				required: true
			},
			itEmail: {
				required: true,
				emailValido: true
			},
			itUsuario: {
				required: true
			},
			ipSenha: {
				required: true
			}

		},
		messages: {
			itNome: "O campo nome é obrigatório!",			
			itEmail: { required: "O campo email é obrigatório!",
				       emailValido: "Informe um email válido!" },
		    itUsuario: "O campo usuário é obrigatório!",
			ipSenha: "O campo senha é obrigatório!"
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

</script>

</body>
</html>