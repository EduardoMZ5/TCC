<?php
  session_start();
    
  unset($_SESSION["idPessoa"]);  
  unset($_SESSION["nome"]);      
  unset($_SESSION["cpf"]);       
  unset($_SESSION["tipoPessoa"]);
  unset($_SESSION["isLogged"]);  
  
  session_destroy();  

  header("Location: ../view/login.php");  
?>