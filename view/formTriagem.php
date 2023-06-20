<?php 

	date_default_timezone_set('America/Sao_Paulo');

	require("header.php");  

	//Obtem o id e o tipoPessoa do usuário logado
	$idPessoa   = $_SESSION["idPessoa"];
	$tipoPessoa = $_SESSION["tipoPessoa"];
	$nome       = $_SESSION["nome"];
  
	if (isset($_GET['action'])) {
		
		$action      = $_GET['action'];
		$actionPost  = "";
		$actionLabel = "";

		switch ($action) {

			case "insert":
				
				$currDate  = date('Y-m-d\TH:i');
				$fCurrDate = date('Y-m-d\TH:i', strtotime($currDate));

				$idTriagem = 0;

				require "../model/TriagemDTO.php";	
				$TriagemDTO = new TriagemDTO();

				$actionPost  = "insert";
				$actionLabel = "Incluir Registro";

				//Obtem o id e o tipoPessoa do usuário logado
  				$idPessoa   = $_SESSION["idPessoa"];
  				$tipoPessoa = $_SESSION["tipoPessoa"];

			break;
			case "edit":
			case "view":

				foreach ($resultSet as $TriagemDTO);

				$idTriagem = $TriagemDTO->getIdTriagem();

				$actionPost  = "update&id=$idTriagem";
				$actionLabel = ($action == "view" ? "Visualizar" : "Alterar") ." Registro";

			break;
			default:

				header("Location: ../view/500.html"); 

			break;

		}

	}

?>

<style>
	.disable-pointer-events {
  		pointer-events: none;
		height: 36px !important;
	}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Triagem Médica</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item">Triagem Médica</li>
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
						<form name="cadastroTriagem" id="cadastroTriagem" method="post"
							action="../controller/TriagemController.php?action=<?php echo $actionPost ?>">
							<div class="card-body">
								<div class="row form-group">
									<div class="col-md-2 form-group">
										<label for="idDataAtendimento">Data de Atendimento</label>
										<input type="datetime-local" class="form-control" name="idDataAtendimento" <?php if ($action == "edit") { echo 'disabled'; } ?>
											id="idDataAtendimento" value="<?php if ($action == "insert" && isset($fCurrDate)) { echo $fCurrDate; } else { echo $TriagemDTO->getDataHoraAtendimento()->format('Y-m-d\TH:i'); } ?>">
									</div>

									<div class="col-md-8 form-group">
										<label class="control-label" for="seIdPaciente">* Paciente</label>
										<div class="input-group">
											<select class="form-control select2bs4 select2-allow-clear" name="seIdPaciente" <?php if ($action == "edit") { echo 'disabled'; } ?>
												id="seIdPaciente">

												<?php

													if ($tipoPessoa == 3){

														echo "<option value='$idPessoa' selected>$nome</option>";

													}else{

														$selected = ($TriagemDTO->getIdPaciente() == null ? "selected" : "");
														echo "<option value='0' $selected>Selecione o Paciente...</option>";
	  
														//Obtem a conexão com o banco de dados
														  require "../model/conn.php";
		
														//Select do Relatório
														$sql = " SELECT *
																   FROM dbo.Pessoa
																  WHERE IdPessoa = 3 ";
	
														$qyCid = sqlsrv_query( $conn, $sql, $params, $options ); 
	
														if (sqlsrv_num_rows($qyCid) != 0) {
														
														  while ($rows = sqlsrv_fetch_array($qyCid)) {
														
															  $idPessoaPaciente  = $rows['IdPessoa'];
															  $nome              = $rows['Nome'];
	
															  $selected = ($TriagemDTO->getIdPaciente() == $idPessoaPaciente ? "selected" : "");
														
															  echo "<option value='$idPessoaPaciente' $selected>$nome</option>";	
														
														  }
													  
														}

													}
  
											  ?>
											</select>
											<div class="input-group-append" <?php if($tipoPessoa == 3){ echo "style='display: none;'"; } ?>>
												<a href="../view/formPaciente.php?action=insert" class="btn btn-default" type="button" data-select2-open="single-append-text" <?php if ($action == "edit") { echo 'disabled'; } ?>>
													<span class="fas fa-plus"></span> 
												</a>
											</div>
										</div>
									</div>

									<div class="col-md-2 form-group">
										<label for="seClassificacaoRisco">* Classificação de Risco</label>
										<select class="form-control" style="width: 100%;" name="seClassificacaoRisco"
											id="seClassificacaoRisco" onchange="setColorClassificacao();">
											<option value="5" <?php if ($TriagemDTO->getClassificacaoRisco() == null || $TriagemDTO->getClassificacaoRisco() == 5) echo "selected"; ?>>Não Urgente</option>
											<option value="4" <?php if ($TriagemDTO->getClassificacaoRisco() == 4) echo "selected"; ?>>Pouco Urgente</option>
											<option value="3" <?php if ($TriagemDTO->getClassificacaoRisco() == 3) echo "selected"; ?>>Urgente</option>
											<option value="2" <?php if ($TriagemDTO->getClassificacaoRisco() == 2) echo "selected"; ?>>Muito Urgente</option>
											<option value="1" <?php if ($TriagemDTO->getClassificacaoRisco() == 1) echo "selected"; ?>>Emergência</option> 
										</select>
									</div>

								</div>

								<div class="row form-group">
									<div class="col-md-4">

										<div class="card card-primary equal-height-col">
											<div class="card-header">
												<h3 class="card-title">Aferição</h3>
											</div>

											<div class="card-body">
												<div class="row form-group">
													<div class="col-md-3 form-group">
														<label for="itPeso">Peso</label>
														<input type="text" class="form-control" name="itPeso" value="<?php echo str_replace(".",",",$TriagemDTO->getPeso()); ?>"
															id="itPeso" maxlength="6" onblur="setIMC();" placeholder="kg">
													</div>
													<div class="col-md-3 form-group">
														<label for="itAltura">Altura</label>
														<input type="text" class="form-control" name="itAltura" value="<?php echo str_replace(".",",",$TriagemDTO->getAltura()); ?>"
															id="itAltura" maxlength="4" onblur="setIMC();" placeholder="m">
													</div>
													<div class="col-md-6 form-group">
														<label for="itIMC">I.M.C.</label>
														<input type="text" class="form-control" name="itIMC"
															id="itIMC" value="" disabled>
													</div>
												</div>
												<div class="row form-group" <?php if($tipoPessoa == 3) echo " style='display: none;'"; ?>>
													<div class="col-md-3 form-group">
														<label for="itPressao">Pressão</label>
														<input type="text" class="form-control" name="itPressao" value="<?php echo $TriagemDTO->getPressaoArterial(); ?>"
															id="itPressao" placeholder="mmHg">
													</div>
													<div class="col-md-3 form-group">
														<label for="itFrequenciaRespiratoria">F. Respi.</label>
														<input type="text" class="form-control" name="itFrequenciaRespiratoria" value="<?php echo $TriagemDTO->getFrequenciaRespiratoria(); ?>"
															id="itFrequenciaRespiratoria" placeholder="mpm" maxlength="2">
													</div>
													<div class="col-md-3 form-group">
														<label for="itFrequenciaCardiaca">F. Cardi.</label>
														<input type="text" class="form-control" name="itFrequenciaCardiaca" value="<?php echo $TriagemDTO->getFrequenciaCardiaca(); ?>"
															id="itFrequenciaCardiaca" placeholder="bpm" maxlength="3">
													</div>
													<div class="col-md-3 form-group">
														<label for="itTemperatura">Tempe.</label>
														<input type="text" class="form-control" name="itTemperatura" value="<?php echo $TriagemDTO->getTemperatura(); ?>"
															id="itTemperatura" placeholder="°C" maxlength="2">
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-8">
										<div class="card card-primary equal-height-col">
											<div class="card-header">
												<h3 class="card-title">Sintomas / Doenças do Paciente</h3>
											</div>
											<div class="card-body">
												<div class="col-md-12 form-group">
													<label for="seSintoma">Sintomas</label>
													<select class="form-control select2bs4" data-placeholder="Sintomas..." multiple="multiple" style="width: 100%;"
														name="seSintoma[]" id="seSintoma">
														
														<?php

														  //Obtem a conexão com o banco de dados
															require "../model/conn.php";

														  //Select do Relatório
														  $sql = " SELECT Sin.*,
														                  COALESCE(( SELECT TOP 1 'selected' 
																		               FROM dbo.TriagemSintoma Tsi
																			          WHERE Tsi.IdSintoma = Sin.IdSintoma
																			            AND Tsi.IdTriagem = $idTriagem ),'') AS Selected
																	 FROM dbo.Sintoma Sin ";

														  $qySintoma = sqlsrv_query( $conn, $sql, $params, $options ); 

														  if (sqlsrv_num_rows($qySintoma) != 0) {
														
															while ($rows = sqlsrv_fetch_array($qySintoma)) {
															
																$idSintoma = $rows['IdSintoma'];
																$descricao = $rows['Descricao'];
																$selected  = $rows['Selected']; 
															
																echo "<option value='$idSintoma' $selected>$descricao</option>";	
															
															}
														
														  }
													  
														?>

													</select>
												</div>
												<div class="col-md-12 form-group" <?php if($tipoPessoa == 3) echo "style='display: none;'"; ?>>
													<label for="seDoenca">Doenças</label>
													<select class="form-control select2bs4" data-placeholder="Doenças..." multiple="multiple" style="width: 100%;"
														name="seDoenca[]" id="seDoenca">
														
														<?php

														  //Obtem a conexão com o banco de dados
															require "../model/conn.php";

														  //Select do Relatório
														  $sql = " SELECT Doe.*,
														                  COALESCE(( SELECT TOP 1 'selected' 
																		               FROM dbo.TriagemDoenca Tdo
																			          WHERE Tdo.IdDoenca = Doe.IdDoenca
																			            AND Tdo.IdTriagem = $idTriagem ),'') AS Selected
																	 FROM dbo.Doenca Doe ";

														  $qyDoenca = sqlsrv_query( $conn, $sql, $params, $options ); 

														  if (sqlsrv_num_rows($qyDoenca) != 0) {
														
															while ($rows = sqlsrv_fetch_array($qyDoenca)) {
															
																$idDoenca  = $rows['IdDoenca'];
																$descricao = $rows['Descricao'];
																$selected = $rows['Selected'];
															
																echo "<option value='$idDoenca' $selected>$descricao</option>";	
															
															}
														
														  }
													  
														?>

													</select>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-md-12 form-group">
										<label for="taObservacao">Observação</label>
										<textarea class="form-control" id="taObservacao" name="taObservacao" rows="3" placeholder="Digite a Observação..."><?php echo $TriagemDTO->getObersevacao(); ?></textarea>
									</div>
								</div>

							</div>
							<!-- /.card-body -->
							<div class="card-footer">
								<button type="submit" class="btn btn-primary mr-2" style="<?php if ($action == "view") echo "display: none;"; ?>">Salvar</button>
								<button type="button" class="btn btn-dark"
									onclick="window.history.back();"><?php echo ($action == "view" ? "Voltar" : "Cancelar"); ?></button>
							</div>
						</form>
					</div>
					<!-- /.card -->
				</div>
				<!--/.col (right) -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container-fluid -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php 
  require("footer.php");   
?>

<script>

	$(document).ready(function() {
    	// Inicialize o plugin matchHeight
    	$('.equal-height-col').matchHeight();

		<?php
			if($tipoPessoa == 3){
				echo " $('#seClassificacaoRisco').css('pointer-events','none'); ";
				echo " $('#seIdPaciente').select2({ containerCssClass: 'disable-pointer-events' }); ";
			}
		?>
  	});

    //Mask
	$("#itPeso,#itAltura").maskMoney({allowNegative: false, thousands:'.', decimal:','});
	$("#itPressao").inputmask("999/999");
	$("#itFrequenciaRespiratoria").inputmask("99");
	$("#itFrequenciaCardiaca").inputmask("999");
	$("#itTemperatura").inputmask("99");

	//Classificação de Risco
	function setColorClassificacao(){

		var comp = $('#seClassificacaoRisco');
		
		//limpa os fundos inseridos
		comp.removeAttr('class')
		    .removeAttr('style')
		    .addClass('form-control')
		    .attr('style', 'width: 100%;');

		if (comp.val() == 1) comp.addClass('bg-danger');
		else if (comp.val() == 2) comp.addClass('bg-danger').attr('style', 'background-color: #ff7607 !important');
		else if (comp.val() == 3) comp.addClass('bg-warning');
		else if (comp.val() == 4) comp.addClass('bg-success');
		else if (comp.val() == 5) comp.addClass('bg-primary');

	}

	setColorClassificacao();

	//IMC
	function setIMC(){

		var comp = $("#itIMC");
				
		//limpa componente do IMC
		comp.removeAttr('class')
		    .addClass('form-control')
			.val("");

		//caso informado inválido, cancela o calculo
		if ($("#itPeso").hasClass("is-invalid") || $("#itAltura").hasClass("is-invalid")) return false;

		//calcula o IMC
		peso   = $("#itPeso").val().replace(",",".");
		altura = $("#itAltura").val().replace(",",".");

		if (peso != "" && altura != "" && peso != "0.00" && altura != "0.00"){

			imc = peso / (altura * altura);			

			if (imc < 18.5) comp.addClass('bg-primary').val("Baixo peso");
			else if (imc >= 18.5 && imc <= 24.99) comp.addClass('bg-success').val("Normal");
			else if (imc >= 25 && imc <= 29.99) comp.addClass('bg-warning').val("Sobrepeso");
			else if (imc >= 30) comp.addClass('bg-danger').val("Obesidade");
		}

	}

	setIMC();

    //Validate
	$(function() {
		$.validator.setDefaults({});

		jQuery.validator.addMethod('informouPaciente', function (val) { return val != 0 });
		jQuery.validator.addMethod("validarPeso", function (val) {
			if (val == "") return true; 
		    var vFloat = parseFloat(val.replace(",", "."));
		    return vFloat == 0 || (vFloat >= 2 && vFloat <= 300);
		});
		jQuery.validator.addMethod("validarAltura", function (val) {
			if (val == "") return true; 
		    var vFloat = parseFloat(val.replace(",", "."));
		    return vFloat == 0 || (vFloat >= 0.30 && vFloat < 3.00);
		});
		jQuery.validator.addMethod("validarPressao", function (val) {
            if (val == "") return true;
            
            var valores = val.split("/");
            var pas = parseInt(valores[0]);
            var pad = parseInt(valores[1]);
        
            return (
                pas >= 50 && pas <= 300 &&
                pad >= 20 && pad <= 250 &&
                (pas - pad) >= 20
            );
        });
		jQuery.validator.addMethod("validarFrequenciaRespiratoria", function (val) {
        	if (val == "") return true;
        
        	var frequencia = parseInt(val);
        
        	return frequencia >= 5 && frequencia <= 80;
        });
		jQuery.validator.addMethod("validarFrequenciaCardiaca", function (val) {
            if (val == "") return true;
            
            var frequencia = parseInt(val);
            
            return frequencia >= 30 && frequencia <= 200;
        });
		jQuery.validator.addMethod("validarTemperatura", function (val) {
            if (val == "") return true;
            
            var temperatura = parseFloat(val.replace(",", "."));
            
            return temperatura >= 20 && temperatura <= 45;
        });
		jQuery.validator.addMethod("validarDataAtendimento", function(val) {
  			var dataAtendimento = new Date(val);
  			var dataAtual = new Date();

  			// Ajustar as horas, minutos e segundos para zero para comparar apenas a data
  			dataAtendimento.setHours(0, 0, 0, 0);
  			dataAtual.setHours(0, 0, 0, 0);

  			return dataAtendimento >= dataAtual;
		});
		jQuery.validator.addMethod('validarSintoma', function (val, element) {
    		return val !== null && val.length > 0;
		});
		
		$('#cadastroTriagem').validate({
		rules: {
			seIdPaciente: {
				informouPaciente: true
			},
			idDataAtendimento: {
				required: true,
				validarDataAtendimento: true
			},
			itPeso: {
				validarPeso: true
			},
			itAltura: {
				validarAltura: true
			},
			itPressao: {
				validarPressao: true
			},
			itFrequenciaRespiratoria: {
				validarFrequenciaRespiratoria: true
			},
			itFrequenciaCardiaca: {
				validarFrequenciaCardiaca: true
			},
			itTemperatura: {
				validarTemperatura: true
			},
			'seSintoma[]': {
				validarSintoma: true
			}
		},
		messages: {

			seIdPaciente: {
				informouPaciente: "O campo paciente é obrigatório!"
			},
			idDataAtendimento: {
				validarDataAtendimento: "A data deve ser maior ou igual a data atual!",
				required: "O campo data de atendimento é obrigatório!"
			},
			itPeso: {
				validarPeso: "Peso inválido!"
			},
			itAltura: {
				validarAltura: "Altura inválido!"
			},
			itPressao: {
				validarPressao: "Pressão inválido!"
			},
			itFrequenciaRespiratoria: {
				validarFrequenciaRespiratoria: "Freq. Resp. inválido!"
			},
			itFrequenciaCardiaca: {
				validarFrequenciaCardiaca: "Freq. Card. inválida!"
			},
			itTemperatura: {
				validarTemperatura: "Temp. inválida!"
			},
			'seSintoma[]': {
				validarSintoma: "Selecione pelo menos um sintoma!"
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

</script>

</body>
</html>