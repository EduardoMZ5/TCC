<?php 
  require("header.php");   
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Enfermeiro(a)</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">Cadastro</li>
              <li class="breadcrumb-item active">Enfermeiro(a)</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Registros cadastrados</h3>
                  <a href="../view/formEnfermeiro.php?action=insert">
                    <button type="button" class="btn btn-primary float-right" >
                      <i class="fas fa-plus"></i></i>  Incluir Enfermeiro(a)
                    </button>
                  </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="enfermeiro" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Cartão Saúde (CNS)</th>
                    <th>Usuário</th>
                    <th>Email</th>
					          <th>Ações</th>
                  </tr>
                  </thead>
				          <tbody>

				          <?php

                    if (isset($resultSet)){

				          	  foreach ($resultSet as $PessoaDTO) {
                      
				          	  	echo '<tr>
				          	  			  	<td>'. $PessoaDTO->getIdPessoa() .'</td>
				          	  			  	<td>'. $PessoaDTO->getNome() .'</td>
				          	  			  	<td>'. $PessoaDTO->getCNS() .'</td>
				          	  			  	<td>'. $PessoaDTO->getNomeUsuario() .'</td>
				          	  			  	<td>'. $PessoaDTO->getEmail() .'</td>
				          	  			  	<td>
                                  <a style="color: black;" href="../controller/PessoaController.php?action=view&id='. $PessoaDTO->getIdPessoa() .'&tipoPessoa=2"><i title="Visualizar registro" style="cursor: pointer; margin-right: 10px;" class="fas fa-eye"></i></a>
                                  <a style="color: black;" href="../controller/PessoaController.php?action=edit&id='. $PessoaDTO->getIdPessoa() .'&tipoPessoa=2"><i title="Alterar registro" style="cursor: pointer; margin-right: 10px;" class="fas fa-pencil-alt"></i></a>
                                  <i title="Excluir registro" style="cursor: pointer; margin-right: 10px;" class="fas fa-trash" data-target="#modalDelete" data-toggle="modal" onclick="$(\'#id\').val(\''. $PessoaDTO->getIdPessoa() .'\');"></i>
				          	  			  	</td>
				          	  			  </tr> ';

				          	  }
                  
                    }
                    
				          ?>

					        <tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <!-- modal -->
  <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Excluir Registro</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Deseja realmente excluir esse registro?
        </div>
        <div class="modal-footer">
          <form name="deletePaciente" id="deletePaciente" method="get" action="../controller/PessoaController.php">
            <input type="hidden" id="id" name="id">
            <input type="hidden" id="tipoPessoa" name="tipoPessoa" value="2">
            <input type="hidden" id="action" name="action" value="delete">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
            <button type="submit" class="btn btn-primary">Sim</button>
          </form>            
        </div>
      </div>
    </div>
  </div>
  <!-- / .modal -->

<?php 
  require("footer.php");   
?>

<script>
  $(function () {
    $("#enfermeiro").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#enfermeiro_wrapper .col-md-6:eq(0)');
  });

	<?php
    	if (isset($_SESSION["execJS"])) {
    		echo $_SESSION["execJS"];
    		unset($_SESSION["execJS"]);
    	}
	?>
</script>

</body>
</html>