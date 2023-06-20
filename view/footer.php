      <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
          <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2023 TriMed.</strong> All rights reserved.
      </footer>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark"></aside>

    <!-- /.control-sidebar -->
    </div>

    <!-- TriMed Geral -->
    <script src="../view/dist/js/trimed.geral.js"></script>
    <!-- jQuery -->
    <script src="../view/plugins/jquery/jquery.min.js"></script>
    <script src="../view/plugins/jquery-matchheight/jquery.matchHeight-min.js"></script>
    <!-- InputMask -->
    <script src="../view/plugins/inputmask/jquery.inputmask.js"></script>
    <!-- MaskMoney --> 
    <script src="../view/plugins/jquery-maskmoney/jquery.maskMoney.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../view/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../view/dist/js/adminlte.min.js"></script>
    <!-- jquery-validation -->
    <script src="../view/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../view/plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- Toastr -->
    <script src="../view/plugins/toastr/toastr.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../view/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../view/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../view/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../view/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../view/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../view/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../view/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../view/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../view/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="../view/plugins/jszip/jszip.min.js"></script>
    <script src="../view/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../view/plugins/pdfmake/vfs_fonts.js"></script>
    <!-- Select2 -->
    <script src="../view/plugins/select2/js/select2.full.min.js"></script>

    <script>
    	//Initialize Select2 Elements
    	$('.select2').select2();

    	$('.select2bs4').select2({
        theme: 'bootstrap4'
      })
    
      <?php
        if (isset($_SESSION["execJS"])) {
        	echo $_SESSION["execJS"];
        	unset($_SESSION["execJS"]);
        }
    	?>

      //set dark theme
      //$('body').toggleClass("dark-mode");
    </script>