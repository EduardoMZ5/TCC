<?php 
  require("header.php");   

  //Obtem o id e o tipoPessoa do usuário logado
  $idPessoa   = $_SESSION["idPessoa"];
  $tipoPessoa = $_SESSION["tipoPessoa"];
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Triagem</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">Cadastro</li>
              <li class="breadcrumb-item active">Triagem</li>
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
                  <a href="../view/formTriagem.php?action=insert">
                    <button type="button" class="btn btn-primary float-right" >
                      <i class="fas fa-plus"></i></i>  Incluir Triagem
                    </button>
                  </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="triagem" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Ordem</th>
                    <th>Paciente</th>
                    <th>Data / Hora</th>
                    <th>Classificação</th>
                    <th>Status</th>
                    <th>Ação</th>
                  </tr>
                  </thead>
				          <tbody>

				          <?php

                    if (isset($resultSet)){

				          	  foreach ($resultSet as $TriagemDTO) {

                        //Obtendo os valores que serão usados em algumas condições
                        $classificacao = $TriagemDTO->getClassificacaoRisco();
                        $status        = $TriagemDTO->getStatus();
                        $idEnfermeiro  = $TriagemDTO->getIdEnfermeiro();
                        $idTriagem     = $TriagemDTO->getIdTriagem();

                        //Preparando a demonstração da classificação de risco
                        $classClassificacao = "";
                        $styleClassificacao = "";
                        $textoClassificacao = "";

                        switch ($classificacao) {
                          case 1:
                            $classClassificacao = "bg-danger";
                            $textoClassificacao = "Emergência";
                          break;
                          case 2:
                            $classClassificacao = "bg-danger";
                            $styleClassificacao = "background-color: #ff7607 !important";
                            $textoClassificacao = "Muito Urgente";
                          break;
                          case 3:
                            $classClassificacao = "bg-warning";
                            $textoClassificacao = "Urgente";
                            break;
                          case 4:
                            $classClassificacao = "bg-success";
                            $textoClassificacao = "Pouco Urgente";
                            break;
                          case 5:
                            $classClassificacao = "bg-primary";
                            $textoClassificacao = "Não Urgente";
                            break;  
                        }

                        //Preparando a demonstração do status
                        switch ($status) {
                          case 1:
                            $textoStatus = "Em atendimento";
                          break;
                          case 2:
                            $textoStatus = "Agendado";
                          break;
                          case 3:
                            $textoStatus = "Finalizado";
                            break;
                          case 4:
                            $textoStatus = "Cancelado";
                          break;
                        }
                      
				          	  	echo '<tr>
                                <td>'. $TriagemDTO->getOrdenacao() .'</td>
                                <td>'. $TriagemDTO->getNomePaciente() .'</td>
                                <td>'. $TriagemDTO->getDataHoraAtendimento()->format('d/m/Y H:i') .'</td>
                                <td><div class="bg-primary '.$classClassificacao.'" style="padding: 5px; text-align: center; '.$styleClassificacao.'">'.$textoClassificacao.'</div></td>
                                <td>'.$textoStatus.'</td>                                
                                <td>';

                        if ( $status == 1 && $idEnfermeiro == $idPessoa && $tipoPessoa != 3 ){
                          //Finalizar
                          echo ' <a style="color: black;" href="../controller/TriagemController.php?action=set-status&id='. $idTriagem .'&status=3"><i title="Finalizar Triagem" style="cursor: pointer; margin-right: 10px;" class="fas fa-clipboard-check"></i></a> ';  
                        }

                        if ( $status == 2 && $tipoPessoa != 3){
                          //Iniciar Atendimento
                          echo ' <a style="color: black;" href="../controller/TriagemController.php?action=set-status&id='. $idTriagem .'&status=1"><i title="Iniciar Atendimento" style="cursor: pointer; margin-right: 10px;" class="fas fa-play"></i></a> ';  
                        }

                        if ( $tipoPessoa != 3 && ($idEnfermeiro == null || $idEnfermeiro == $idPessoa) ){
                          if ( $status == 1){
                            //Cancelar
                            echo ' <a style="color: black;" href="../controller/TriagemController.php?action=set-status&id='. $idTriagem .'&status=4"><i title="Cancelar Triagem" style="cursor: pointer; margin-right: 10px;" class="fas fa-window-close"></i></a> ';                            
                          }
                        }

                        //visualizar
                        echo ' <a style="color: black;" href="../controller/TriagemController.php?action=view&id='. $idTriagem .'"><i title="Visualizar Registro" style="cursor: pointer; margin-right: 10px;" class="fas fa-eye"></i></a> ';

                        if (($tipoPessoa == 3 && $idEnfermeiro == null) || ($tipoPessoa != 3 && ($idEnfermeiro == null || $idEnfermeiro == $idPessoa))){
                          if ( $status == 1 || $status == 2 ){
                            //Alterar
                            echo ' <a style="color: black;" href="../controller/TriagemController.php?action=edit&id='. $idTriagem .'"><i title="Alterar registro" style="cursor: pointer; margin-right: 10px;" class="fas fa-pencil-alt"></i></a> ';
                            //Excluir
                            echo ' <i title="Excluir registro" style="cursor: pointer; margin-right: 10px;" class="fas fa-trash" data-target="#modalDelete" data-toggle="modal" onclick="$(\'#id\').val(\''. $idTriagem .'\');"></i> ';
                          }
                        }

                        echo '</td>
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
          <form name="deleteTriagem" id="deleteTriagem" method="get" action="../controller/TriagemController.php">
            <input type="hidden" id="id" name="id">
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
    $("#triagem").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#triagem_wrapper .col-md-6:eq(0)');
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