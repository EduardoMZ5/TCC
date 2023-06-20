<?php 

	require("header.php");  
  
	if (isset($_GET['action'])) {
		
		$action      = $_GET['action'];
		$actionPost  = "";
		$actionLabel = "";

		switch ($action) {

			case "insert":

				require "../model/SintomaDTO.php";	
				$SintomaDTO = new SintomaDTO();

				$actionPost  = "insert";
				$actionLabel = "Incluir Registro";

			break;
			case "edit":
			case "view":

				foreach ($resultSet as $SintomaDTO);

				$actionPost  = "update&id=". $SintomaDTO->getIdSintoma(); ;
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
					<h1>Sintoma</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item">Cadastro</li>
						<li class="breadcrumb-item">Sintoma</li>
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
						<form name="cadastroSintoma" id="cadastroSintoma" method="post"
							action="../controller/SintomaController.php?action=<?php echo $actionPost ?>">
							<div class="card-body">

								<div class="form-group">
									<label for="itDescricao">* Descrição</label>
									<input maxlength="200" type="text" class="form-control" name="itDescricao" id="itDescricao"
										placeholder="Informe a descrição" value="<?php echo $SintomaDTO->getDescricao(); ?>">
								</div>
							
							</div>

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

		$('#cadastroSintoma').validate({
		rules: {
			itDescricao: {
				required: true
			}

		},
		messages: {
			itDescricao: "O campo descrição é obrigatório!"
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