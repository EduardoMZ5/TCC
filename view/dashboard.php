<?php 

  require("header.php");  

  //Obtem o id e o tipoPessoa do usuário logado
  $idPessoa   = $_SESSION["idPessoa"];
  $tipoPessoa = $_SESSION["tipoPessoa"];

  //obtem a conexão com o banco de dados
  require "../model/conn.php";

  //Iniciando as variáveis
  $pacienteCadastrado  = 0; 
  $triagensAgendadas   = 0;
  $triagensRealizadas  = 0;
  $triagensHoje        = 0;
  $triagensAberto      = 0;
  $triagensFinalizadas = 0;

  //Select do dashboard
  $sql = " 
  DECLARE @PacienteCadastrado  Int,
          @TriagensAgendadas   Int,
          @TriagensRealizadas  Int,
          @TriagensHoje        Int,
          @TriagensAberto      Int,
          @TriagensFinalizadas Int

  SET @PacienteCadastrado  = COALESCE(( SELECT COUNT(*) FROM Pessoa WHERE TipoPessoa = 3 ),0)
  SET @TriagensAgendadas   = COALESCE(( SELECT COUNT(*) FROM Triagem WHERE Status = 2 ),0)
  SET @TriagensRealizadas  = COALESCE(( SELECT COUNT(*) FROM Triagem WHERE Status = 1 ),0)
  SET @TriagensHoje        = COALESCE(( SELECT COUNT(*) FROM Triagem WHERE Status IN (1,2) AND $idPessoa IN (IdEnfermeiro,$idPessoa) AND CAST(DataHoraAtendimento AS DATE) = CAST(GETDATE() AS DATE) ),0)
  SET @TriagensAberto      = COALESCE(( SELECT COUNT(*) FROM Triagem WHERE Status IN (1,2) AND IdPaciente = $idPessoa ),0)
  SET @TriagensFinalizadas = COALESCE(( SELECT COUNT(*) FROM Triagem WHERE Status = 3 AND IdPaciente = $idPessoa ),0)

 SELECT @PacienteCadastrado  AS PacienteCadastrado,
        @TriagensAgendadas   AS TriagensAgendadas,
        @TriagensRealizadas  AS TriagensRealizadas,
        @TriagensHoje        AS TriagensHoje,
        @TriagensAberto      AS TriagensAberto,
        @TriagensFinalizadas AS TriagensFinalizadas ";

  $qyDashboard = sqlsrv_query( $conn, $sql,$params, $options ); 

  if (sqlsrv_num_rows($qyDashboard) != 0) {

    $resultSet = array();

    while ($rows = sqlsrv_fetch_array($qyDashboard)) {

      $pacienteCadastrado  = $rows['PacienteCadastrado']; 
      $triagensAgendadas   = $rows['TriagensAgendadas'];  
      $triagensRealizadas  = $rows['TriagensRealizadas']; 
      $triagensHoje        = $rows['TriagensHoje']; 
      $triagensAberto      = $rows['TriagensAberto']; 
      $triagensFinalizadas = $rows['TriagensFinalizadas'];

    }

  }


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 col-6" style="<?php if ($tipoPessoa == 3) echo "display: none;"; ?>">
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?php echo $pacienteCadastrado; ?></h3>
            <p>Pacientes Cadastrados</p>
          </div>
          <div class="icon">
            <i class="ion ion-person"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6" style="<?php if ($tipoPessoa == 3) echo "display: none;"; ?>">
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?php echo $triagensAgendadas; ?></h3>
            <p>Triagens Agendadas</p>
          </div>
          <div class="icon">
            <i class="ion ion-calendar"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6" style="<?php if ($tipoPessoa >= 2) echo "display: none;"; ?>">
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?php echo $triagensRealizadas; ?></h3>
            <p>Triagens Concluidas</p>
          </div>
          <div class="icon">
            <i class="ion ion-android-clipboard"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6" style="<?php if ($tipoPessoa == 3) echo "display: none;"; ?>">
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?php echo $triagensHoje; ?></h3>
            <p>Triagens Realizadas Hoje</p>
          </div>
          <div class="icon">
            <i class="ion ion-android-calendar"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6" style="<?php if ($tipoPessoa < 3) echo "display: none;"; ?>">
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?php echo $triagensAberto; ?></h3>
            <p>Triagens em Aberto</p>
          </div>
          <div class="icon">
            <i class="ion ion-pin"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6" style="<?php if ($tipoPessoa < 3) echo "display: none;"; ?>">
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?php echo $triagensFinalizadas; ?></h3>
            <p>Triagens Finalizadas</p>
          </div>
          <div class="icon">
            <i class="ion ion-android-checkbox-outline"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.content-wrapper -->

<?php 
  require("footer.php");   
?>

</body>
</html>