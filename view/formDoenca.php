<?php 

	require("header.php");  
  
	if (isset($_GET['action'])) {
		
		$action      = $_GET['action'];
		$actionPost  = "";
		$actionLabel = "";

		switch ($action) {

			case "insert":

				require "../model/DoencaDTO.php";	
				$DoencaDTO = new DoencaDTO();

				$actionPost  = "insert";
				$actionLabel = "Incluir Registro";

			break;
			case "edit":
			case "view":

				foreach ($resultSet as $DoencaDTO);

				$actionPost  = "update&id=". $DoencaDTO->getIdDoenca(); ;
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
					<h1>Doença</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item">Cadastro</li>
						<li class="breadcrumb-item">Doença</li>
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
						<form name="cadastroDoenca" id="cadastroDoenca" method="post"
							action="../controller/DoencaController.php?action=<?php echo $actionPost ?>">
							<div class="card-body">

								<div class="form-group">
									<label for="itDescricao">* Descrição</label>
									<input maxlength="400" type="text" class="form-control" name="itDescricao" id="itDescricao"
										placeholder="Informe a descrição" value="<?php echo $DoencaDTO->getDescricao(); ?>">
								</div>

								<div class="row form-group">
									<div class="col-md-8 form-group">
										<label for="seCid">CID</label>
										<select class="form-control select2bs4" style="width: 100%;" name="seIdCid"
											id="seIdCid">

											<?php
												
											  $selected = ($DoencaDTO->getIdCid() == null ? "selected" : "");
											  echo "<option value='0' $selected>Selecione o CID...</option>";

											  //Obtem a conexão com o banco de dados
  											  require "../model/conn.php";

                                              //Select do Relatório
                                              $sql = " SELECT *
										                 FROM dbo.Cid ";
                                            
                                              $qyCid = sqlsrv_query( $conn, $sql, $params, $options ); 
                                            
                                              if (sqlsrv_num_rows($qyCid) != 0) {

												while ($rows = sqlsrv_fetch_array($qyCid)) {

													$idCid     = $rows['IdCid'];
													$descricao = $rows['Codigo'] ." - ". $rows['Descricao'];

													$selected = ($DoencaDTO->getIdCid() == $idCid ? "selected" : "");

													echo "<option value='$idCid' $selected>$descricao</option>";	

												}

											  }

											?>

										</select>
									</div>
									<div class="col-md-2 form-group"> 
										<div class="custom-control custom-switch">
											<div>&nbsp</div>
											<div>&nbsp</div>
                      						<input type="checkbox" class="custom-control-input" name="icEhContagiosa" id="icEhContagiosa" <?php if ($DoencaDTO->getEhContagiosa()) echo "checked"; ?>>
                      						<label class="custom-control-label" for="icEhContagiosa">Contagioso</label>
										</div>
									</div>
									<div class="col-md-2 form-group"> 
										<div class="custom-control custom-switch">
											<div>&nbsp</div>
											<div>&nbsp</div>
                      						<input type="checkbox" class="custom-control-input" name="icEhHereditaria" id="icEhHereditaria" <?php if ($DoencaDTO->getEhHereditaria()) echo "checked"; ?>>
                      						<label class="custom-control-label" for="icEhHereditaria">Hereditário</label>
										</div>
									</div>
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

		$('#cadastroDoenca').validate({
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