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
					<h1>Enfermeiro</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item">Cadastro</li>
						<li class="breadcrumb-item">Enfermeiro</li>
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
						<form name="cadastroEnfermeiro" id="cadastroEnfermeiro" method="post"
							action="../controller/PessoaController.php?action=<?php echo $actionPost ?>">
							<div class="card-body">

								<div class="form-group">
									<label for="itNome">* Nome</label>
									<input maxlength="100" type="text" class="form-control" name="itNome" id="itNome"
										placeholder="Informe seu nome" value="<?php echo $PessoaDTO->getNome(); ?>">
								</div>

								<div class="row form-group">
									<div class="col-md-2 form-group">
										<label for="itCpf">* CPF</label>
										<input type="text" class="form-control" name="itCpf" id="itCpf"
											placeholder="Ex. 999.999.999-99"
											value="<?php echo $PessoaDTO->getCPF(); ?>">
									</div>
									<div class="col-md-2 form-group">
										<label for="itRg">RG</label>
										<input type="text" class="form-control" name="itRg" id="itRg"
											placeholder="Ex. 00.000.000-X" value="<?php echo $PessoaDTO->getRG(); ?>">
									</div>
									<div class="col-md-2 form-group">
										<label for="itCelular">* Celular</label>
										<input maxlength="20" type="text" class="form-control" name="itCelular" id="itCelular"
											placeholder="Ex. (99) 99999-9999"
											value="<?php echo $PessoaDTO->getTelefoneCelular(); ?>">
									</div>
									<div class="col-md-2 form-group">
										<label for="itTelefoneFixo">Telefone Fixo</label>
										<input maxlength="20" type="text" class="form-control" name="itTelefoneFixo"
											id="itTelefoneFixo" placeholder="Ex. (99) 9999-9999"
											value="<?php echo $PessoaDTO->getTelefoneFixo(); ?>">
									</div>
									<div class="col-md-2 form-group">
										<label for="seSexo">* Gênero</label>
										<select class="form-control" name="seSexo" id="seSexo">
											<option value="0"
												<?php if ($PessoaDTO->getSexo() == null) echo "selected"; ?>>Selecione o
												Sexo</option>
											<option value="1" <?php if ($PessoaDTO->getSexo() == 1) echo "selected"; ?>>
												Masculino</option>
											<option value="2" <?php if ($PessoaDTO->getSexo() == 2) echo "selected"; ?>>
												Feminino</option>
										</select>
									</div>
									<div class="col-md-2 form-group">
										<label for="idDataNascimento">* Nascimento</label>
										<input type="date" class="form-control" name="idDataNascimento"
											id="idDataNascimento"
											value="<?php if ($PessoaDTO->getDataNascimento() != null) echo $PessoaDTO->getDataNascimento()->format('Y-m-d'); ?>">
									</div>
								</div>

								<div class="row form-group">
									<div class="col-md-2 form-group">
										<label for="itCep">CEP</label>
										<input type="text" class="form-control" name="itCep" id="itCep"
											placeholder="Informe seu CEP" onblur="buscaCEP(this);"
											value="<?php echo $PessoaDTO->getCEP(); ?>">
									</div>
									<div class="col-md-3 form-group">
										<label for="itEndereco">Endereço</label>
										<input maxlength="100" type="text" class="form-control" name="itEndereco" id="itEndereco"
											placeholder="Informe seu Endereço"
											value="<?php echo $PessoaDTO->getEndereco(); ?>">
									</div>
									<div class="col-md-1 form-group">
										<label for="itNumero">Número</label>
										<input maxlength="10" type="text" class="form-control" name="itNumero" id="itNumero"
											placeholder="Número" value="<?php echo $PessoaDTO->getNumero(); ?>">
									</div>
									<div class="col-md-3 form-group">
										<label for="itBairro">Bairro</label>
										<input maxlength="100" type="text" class="form-control" name="itBairro" id="itBairro"
											placeholder="Informe seu Bairro"
											value="<?php echo $PessoaDTO->getBairro(); ?>">
									</div>
									<div class="col-md-2 form-group">
										<label for="itCidade">Cidade</label>
										<input maxlength="100" type="text" class="form-control" name="itCidade" id="itCidade"
											placeholder="Informe sua Cidade"
											value="<?php echo $PessoaDTO->getCidade(); ?>">
									</div>
									<div class="col-md-1 form-group">
										<label for="seEstado">Estado</label>
										<select class="form-control" name="seEstado" id="seEstado">
											<option value=""
												<?php if ($PessoaDTO->getEstado() == null) echo "selected"; ?>>Selec.
											</option>
											<option value="AC"
												<?php if ($PessoaDTO->getEstado() == "AC") echo "selected"; ?>>AC
											</option>
											<option value="AL"
												<?php if ($PessoaDTO->getEstado() == "AL") echo "selected"; ?>>AL
											</option>
											<option value="AP"
												<?php if ($PessoaDTO->getEstado() == "AP") echo "selected"; ?>>AP
											</option>
											<option value="AM"
												<?php if ($PessoaDTO->getEstado() == "AM") echo "selected"; ?>>AM
											</option>
											<option value="BA"
												<?php if ($PessoaDTO->getEstado() == "BA") echo "selected"; ?>>BA
											</option>
											<option value="CE"
												<?php if ($PessoaDTO->getEstado() == "CE") echo "selected"; ?>>CE
											</option>
											<option value="ES"
												<?php if ($PessoaDTO->getEstado() == "ES") echo "selected"; ?>>ES
											</option>
											<option value="GO"
												<?php if ($PessoaDTO->getEstado() == "GO") echo "selected"; ?>>GO
											</option>
											<option value="MA"
												<?php if ($PessoaDTO->getEstado() == "MA") echo "selected"; ?>>MA
											</option>
											<option value="MT"
												<?php if ($PessoaDTO->getEstado() == "MT") echo "selected"; ?>>MT
											</option>
											<option value="MS"
												<?php if ($PessoaDTO->getEstado() == "MS") echo "selected"; ?>>MS
											</option>
											<option value="MG"
												<?php if ($PessoaDTO->getEstado() == "MG") echo "selected"; ?>>MG
											</option>
											<option value="PA"
												<?php if ($PessoaDTO->getEstado() == "PA") echo "selected"; ?>>PA
											</option>
											<option value="PB"
												<?php if ($PessoaDTO->getEstado() == "PB") echo "selected"; ?>>PB
											</option>
											<option value="PR"
												<?php if ($PessoaDTO->getEstado() == "PR") echo "selected"; ?>>PR
											</option>
											<option value="PE"
												<?php if ($PessoaDTO->getEstado() == "PE") echo "selected"; ?>>PE
											</option>
											<option value="PI"
												<?php if ($PessoaDTO->getEstado() == "PI") echo "selected"; ?>>PI
											</option>
											<option value="RJ"
												<?php if ($PessoaDTO->getEstado() == "RJ") echo "selected"; ?>>RJ
											</option>
											<option value="RN"
												<?php if ($PessoaDTO->getEstado() == "RN") echo "selected"; ?>>RN
											</option>
											<option value="RS"
												<?php if ($PessoaDTO->getEstado() == "RS") echo "selected"; ?>>RS
											</option>
											<option value="RO"
												<?php if ($PessoaDTO->getEstado() == "RO") echo "selected"; ?>>RO
											</option>
											<option value="RR"
												<?php if ($PessoaDTO->getEstado() == "RR") echo "selected"; ?>>RR
											</option>
											<option value="SC"
												<?php if ($PessoaDTO->getEstado() == "SC") echo "selected"; ?>>SC
											</option>
											<option value="SP"
												<?php if ($PessoaDTO->getEstado() == "SP") echo "selected"; ?>>SP
											</option>
											<option value="SE"
												<?php if ($PessoaDTO->getEstado() == "SE") echo "selected"; ?>>SE
											</option>
											<option value="TO"
												<?php if ($PessoaDTO->getEstado() == "TO") echo "selected"; ?>>TO
											</option>
										</select>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-md-2 form-group">
										<label for="itCns">* Cartão Saúde (CNS)</label>
										<input type="text" class="form-control" name="itCns" id="itCns"
											placeholder="Ex. 999 9999 9999 9999"
											value="<?php echo $PessoaDTO->getCNS(); ?>">
									</div>
									<div class="col-md-2 form-group">
										<label for="itCrm">Concelho R. Medicina (CRM)</label>
										<input maxlength="20" type="text" class="form-control" name="itCrm" id="itCrm"
											placeholder="CRM" value="<?php echo $PessoaDTO->getCNS(); ?>">
									</div>
								</div>

								<div class="card card-primary" style="<?php if ($action != "insert") echo "display: none;"; ?>">
									<div class="card-header">
										<h3 class="card-title">Acesso ao Sistema</h3>
									</div>
									<div class="card-body">
										<div class="row form-group">
											<div class="col-md-6 form-group">
												<label for="itEmail">* Email</label>
												<input maxlength="50" type="text" class="form-control" name="itEmail" id="itEmail"
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

							<input type="hidden" class="form-control" name="ihTipoPessoa" id="ihTipoPessoa" value="2">

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

	//Mask
	$("#itCpf").inputmask("999.999.999-99");
	$("#itRg").inputmask("99.999.999-*");
    $("#itCelular").inputmask("(99) 99999-9999");
    $("#itTelefoneFixo").inputmask("(99) 9999-9999");
    $("#itCep").inputmask("99999-999");
    $("#itCns").inputmask("999 9999 9999 9999");
    $("#itCrm").inputmask("999999");

	//Rotina que busca o CEP no ViaCEP
	function buscaCEP(CEP){

		let cep = $(CEP).val().replace(/\D/g, '');

		if (cep != ""){

			let validacep = /^[0-9]{8}$/;

			if(validacep.test(cep)) {

				toastr.info('Obtendo o endereço pelo CEP...');

				$.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

					if (!("erro" in dados)) {
						$("#itEndereco").val(dados.logradouro);
						$("#itBairro").val(dados.bairro);
						$("#itCidade").val(dados.localidade);
						$("#seEstado").val(dados.uf);						

						toastr.success('Endereço obtido com sucesso!');
					} 
				});
			
			}

		}

	}

	//Validate
	$(function() {
		$.validator.setDefaults({});

		jQuery.validator.addMethod('cpfValido', function(val){ return validarCPF(val); });
		jQuery.validator.addMethod('emailValido', function(val){ return validarEmail(val); });
		jQuery.validator.addMethod('escolheuSexo', function (val){ return (val != "0"); });
		jQuery.validator.addMethod('cnsValido', function(val, element){ return checkCNS(val, element); });
		jQuery.validator.addMethod('ehMaiorIdade', function(val){ return (calcAge(val) >= 18); });

		$('#cadastroEnfermeiro').validate({
		rules: {
			itNome: {
				required: true
			},
			itCpf: {
				required: true,
				cpfValido: true
			},
			itCelular: {
				required: true
			},
			seSexo: {
				escolheuSexo: true
			},
			idDataNascimento: {
				required: true,
				ehMaiorIdade: true
			},
			itCns: {
				required: true,
				cnsValido: true
			},
			itEmail: {
				required: true,
				emailValido: true
			},
			itUsuario: {
				required: true
			},
			ipSenha: {
				required: true,
				minlength: 6
			}

		},
		messages: {
			itNome: "O campo nome é obrigatório!",
			itCpf: {
				required: "O campo CPF é obrigatório!!",
				cpfValido: "Informe um CPF válido!"
			},
			itCelular: "O campo celular é obrigatório!",
			seSexo: { escolheuSexo : "Escolha um sexo!" },
			idDataNascimento: {
				required: "O campo nascimento é obrigatório!",
				ehMaiorIdade: "O paciente precisa ter ao menos 18 anos de idade!"
			},
			itCns: { 
				cnsValido: "Informe um CNS válido!",
				required: "O campo CNS é obrigatório!"
			},
			itEmail: { 
				required: "O campo email é obrigatório!",
				emailValido: "Informe um email válido!" 
			},
		    itUsuario: "O campo usuário é obrigatório!",
			ipSenha: {
				required: "O campo senha é obrigatório!",
				minlength: "A senha deve ter pelo menos 6 caracteres!"
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