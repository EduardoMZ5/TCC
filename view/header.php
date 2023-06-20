<?php

  //Verifica se o usuário está logado
  @session_start();

  if (isset($_SESSION["isLogged"])){
    $isLogged = $_SESSION["isLogged"] == "true";

    //Obtem o id e o tipoPessoa do usuário logado
    $idPessoa   = $_SESSION["idPessoa"];
    $tipoPessoa = $_SESSION["tipoPessoa"];
  }

  if (! $isLogged){
    $_SESSION["execJS"] = "aviso('Usuário não logado!','alert-warning');";
    header("Location: ../view/login.php");  
    exit;
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TriMed</title>
  <link rel="icon" type="image/x-icon" href="../view/dist/img/favicon.ico">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../view/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../view/dist/css/adminlte.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../view/plugins/toastr/toastr.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../view/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../view/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../view/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../view/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../view/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Ion Icons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">

        <li class="nav-item" title="Tela cheia">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item" title="Sair do sistema">
          <a class="nav-link" href="../controller/logoff.php" role="button">
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="../view/dashboard.php" class="brand-link">
        <img src="../view/dist/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
          style="opacity: .8">
        <span class="brand-text font-weight-light">TriMed</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="../view/dist/img/user.png" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?php echo $_SESSION["nome"] ?></a>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Buscar" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            
            <?php

              //Treeview de retorno
              $htmlRetorno = '';
              
              //Variável auxiliar de item
              $htmlAux = '';

              //Constantes utilizadas nos itens / subitens do menu
              $htmlBaseMenu = '<li class="nav-item">
                                 <a href="{HREF}" class="nav-link" id="menu{ID}">
                                   <i class="nav-icon {ICO}"></i>
                                   <p>
                                     {TITLE}
                                     <i class="right {ICO_RIGHT}"></i>
                                   </p>
                                 </a>';
              
              $htmlBaseItem = '<ul class="nav nav-treeview" id="menu{ID}">
                                 <li class="nav-item">
                                   <a href="{HREF}" target="{TARGET}" class="nav-link">
                                     &nbsp&nbsp&nbsp
                                     <i class="fas fa-file-alt nav-icon"></i>
                                     <p>{TITLE}</p>
                                   </a>
                                 </li>
                               </ul>';

              //Menu de cadastro
              if ($tipoPessoa != 3){
              
                //Cadastro {INICIO}
                $htmlAux = $htmlBaseMenu;
                $htmlAux = str_replace("{HREF}", "#", $htmlAux);
                $htmlAux = str_replace("{ID}", "Cadastro", $htmlAux);
                $htmlAux = str_replace("{ICO}", "fas fa-edit", $htmlAux);
                $htmlAux = str_replace("{ICO_RIGHT}", "fas fa-angle-left", $htmlAux); 
                $htmlAux = str_replace("{TITLE}", "Cadastro", $htmlAux);
                $htmlRetorno .= $htmlAux;

                  //Paciente
                  $htmlAux = $htmlBaseItem;
                  $htmlAux = str_replace("{HREF}", "../controller/PessoaController.php?action=list&tipoPessoa=3", $htmlAux);
                  $htmlAux = str_replace("{ID}", "CadastroPaciente", $htmlAux);
                  $htmlAux = str_replace("{TITLE}", "Paciente", $htmlAux);
                  $htmlAux = str_replace("{TARGET}", "_self", $htmlAux);   
                  if ($tipoPessoa != 3) $htmlRetorno .= $htmlAux;

                  //Enfermeiro(a)
                  $htmlAux = $htmlBaseItem;
                  $htmlAux = str_replace("{HREF}", "../controller/PessoaController.php?action=list&tipoPessoa=2", $htmlAux);
                  $htmlAux = str_replace("{ID}", "CadastroEnfermeiro", $htmlAux);
                  $htmlAux = str_replace("{TITLE}", "Enfermeiro(a)", $htmlAux);
                  $htmlAux = str_replace("{TARGET}", "_self", $htmlAux);   
                  if ($tipoPessoa == 1) $htmlRetorno .= $htmlAux;   
                  
                  //Administrador
                  $htmlAux = $htmlBaseItem;
                  $htmlAux = str_replace("{HREF}", "../controller/PessoaController.php?action=list&tipoPessoa=1", $htmlAux);
                  $htmlAux = str_replace("{ID}", "CadastroAdministrador", $htmlAux);
                  $htmlAux = str_replace("{TITLE}", "Administrador", $htmlAux);
                  $htmlAux = str_replace("{TARGET}", "_self", $htmlAux);   
                  if ($tipoPessoa == 1) $htmlRetorno .= $htmlAux;       

                  //Doença
                  $htmlAux = $htmlBaseItem;
                  $htmlAux = str_replace("{HREF}", "../controller/DoencaController.php?action=list", $htmlAux);
                  $htmlAux = str_replace("{ID}", "CadastroDoenca", $htmlAux);
                  $htmlAux = str_replace("{TITLE}", "Doença", $htmlAux);
                  $htmlAux = str_replace("{TARGET}", "_self", $htmlAux);   
                  if ($tipoPessoa != 3) $htmlRetorno .= $htmlAux;
                  
                  //Sintoma
                  $htmlAux = $htmlBaseItem;
                  $htmlAux = str_replace("{HREF}", "../controller/SintomaController.php?action=list", $htmlAux);
                  $htmlAux = str_replace("{ID}", "CadastroSintoma", $htmlAux);
                  $htmlAux = str_replace("{TITLE}", "Sintoma", $htmlAux);
                  $htmlAux = str_replace("{TARGET}", "_self", $htmlAux);   
                  if ($tipoPessoa != 3) $htmlRetorno .= $htmlAux; 

                //Cadastro {FIM}
                $htmlRetorno .= '</li>';

              }

              //Menu de triagem
              if ($tipoPessoa > 1){

                //Triagem {INICIO}
                $htmlAux = $htmlBaseMenu;
                $htmlAux = str_replace("{HREF}", "../controller/TriagemController.php?action=list", $htmlAux);
                $htmlAux = str_replace("{ID}", "Triagem", $htmlAux);
                $htmlAux = str_replace("{ICO}", "fas fa-notes-medical", $htmlAux);
                $htmlAux = str_replace("{ICO_RIGHT}", "", $htmlAux);                  
                $htmlAux = str_replace("{TITLE}", "Triagem Médica", $htmlAux);
                $htmlRetorno .= $htmlAux;   

                //Triagem {FIM}
                $htmlRetorno .= '</li>';

              }

              //Menu de atualização cadastral (paciente)
              if ($tipoPessoa == 3){

                //Cadastro {INICIO}
                $htmlAux = $htmlBaseMenu;
                $htmlAux = str_replace("{HREF}", "../controller/PessoaController.php?action=edit&id=$idPessoa&tipoPessoa=3", $htmlAux);
                $htmlAux = str_replace("{ID}", "AlterarDados", $htmlAux);
                $htmlAux = str_replace("{ICO}", "fas fa-user-edit", $htmlAux);
                $htmlAux = str_replace("{ICO_RIGHT}", "", $htmlAux);                  
                $htmlAux = str_replace("{TITLE}", "Alterar dados", $htmlAux);
                $htmlRetorno .= $htmlAux;   

                //Cadastro {FIM}
                $htmlRetorno .= '</li>';

              }

              //Menu de relatório
              if ($tipoPessoa != 3){

                //Relatório {INICIO}
                $htmlAux = $htmlBaseMenu;
                $htmlAux = str_replace("{HREF}", "#", $htmlAux);
                $htmlAux = str_replace("{ID}", "Relatorio", $htmlAux);
                $htmlAux = str_replace("{ICO}", "fas fa-print", $htmlAux);
                $htmlAux = str_replace("{ICO_RIGHT}", "fas fa-angle-left", $htmlAux); 
                $htmlAux = str_replace("{TITLE}", "Relatórios", $htmlAux);
                $htmlRetorno .= $htmlAux;

                  //Paciente
                  $htmlAux = $htmlBaseItem;
                  $htmlAux = str_replace("{HREF}", "../view/reportPaciente.php", $htmlAux);
                  $htmlAux = str_replace("{ID}", "ReportPaciente", $htmlAux);
                  $htmlAux = str_replace("{TITLE}", "Paciente", $htmlAux);
                  $htmlAux = str_replace("{TARGET}", "_blank", $htmlAux);   
                  if ($tipoPessoa <= 2) $htmlRetorno .= $htmlAux;

                  //Enfermeiro(a)
                  $htmlAux = $htmlBaseItem;
                  $htmlAux = str_replace("{HREF}", "../view/reportEnfermeiro.php", $htmlAux);
                  $htmlAux = str_replace("{ID}", "ReportEnfermeiro", $htmlAux);
                  $htmlAux = str_replace("{TITLE}", "Enfermeiro(a)", $htmlAux);
                  $htmlAux = str_replace("{TARGET}", "_blank", $htmlAux);   
                  if ($tipoPessoa == 1) $htmlRetorno .= $htmlAux;   
                  
                  //Doença
                  $htmlAux = $htmlBaseItem;
                  $htmlAux = str_replace("{HREF}", "../view/reportDoenca.php", $htmlAux);
                  $htmlAux = str_replace("{ID}", "ReportDoenca", $htmlAux);
                  $htmlAux = str_replace("{TITLE}", "Doença", $htmlAux);
                  $htmlAux = str_replace("{TARGET}", "_blank", $htmlAux);                    
                  if ($tipoPessoa <= 2) $htmlRetorno .= $htmlAux;       

                //Relatório {FIM}
                $htmlRetorno .= '</li>';

              }

              //Retorno do menu com controle de acesso
              echo $htmlRetorno;

            ?>

          </ul>          
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>