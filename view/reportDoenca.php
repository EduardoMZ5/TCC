<?php

  //Inicia a sessão
  session_start();  

  //obtem a conexão com o banco de dados
  require "../model/conn.php";

  //Include do DOMPdf
  require_once "../view/plugins/dompdf/autoload.inc.php";
  use Dompdf\Dompdf;
  $dompdf = new Dompdf();
  
  //Formatando a hora/data de acordo com o fuso horário
  date_default_timezone_set('America/Sao_Paulo');

  $numColumn = 4;
  $orientation = "landscape"; // portrait - landscape

  //Cabeçalho HTML
  $html = '
  <!DOCTYPE html>
  <head>
    <meta charset="utf-8">
    <style>
      body {
        font-family: Verdana, Arial, Helvetica, sans-serif;
      }
    </style>
  </head>
  <body>
    <h1 style="text-align: center; font-size: 30px;">Doenças Cadastradas</h1>
    <div style="font-size: 15px;">
      <table style="font-size: 10px; width: 100%; table-layout: fixed;">
        <tr>
          <td style="width: 50%;">Data Emissão: '.date("d/m/Y").'</td>
          <td style="width: 50%; text-align: right;">Hora Emissão: '.date("H:i:s").'</td>
        </tr>
      </table>
      <br>';
	  
  $qtde = 0;

  //Select do Relatório
  $sql = " SELECT DOE.Descricao,
                  CID.Codigo + ' - ' + CID.Descricao AS Cid,
                  CASE EhContagiosa  WHEN 1 THEN '(x)' ELSE '(  )' END AS EhContagiosa,
                  CASE EhHereditaria WHEN 1 THEN '(x)' ELSE '(  )' END AS EhHereditaria
             FROM Doenca DOE
       INNER JOIN Cid    CID on DOE.IdCid = CID.IdCID";

  $qyRelatorio = sqlsrv_query( $conn, $sql, $params, $options ); 

  if (sqlsrv_num_rows($qyRelatorio) != 0) {

    $html .= '
    <table cellspacing="0.2" style="width: 100%; table-layout: fixed;">
      <tr>
        <td style="width: 30%;"><b>Descricao</b></td>
        <td style="width: 50%;"><b>Cid</b></td>
        <td style="width: 10%; text-align: center;"><b>Contagioso</b></td>
        <td style="width: 10%; text-align: center;"><b>Heraditário</b></td>
      </tr>
      <tr>
        <td colspan="'.$numColumn.'">
          <hr style="height:1px; border:none; color:#333; background-color:#333;">
        </td>
      </tr>';        

    while ($rows = sqlsrv_fetch_array($qyRelatorio)) {
	
      $html.= '<tr>';	 
	    $html.= ' <td style="overflow: hidden;">'.$rows['Descricao'].'</td>';
	    $html.= ' <td style="overflow: hidden;">'.$rows['Cid'].'</td>'; 
	    $html.= ' <td style="text-align: center;">'.$rows['EhContagiosa'].'</td>'; 	 
	    $html.= ' <td style="text-align: center;">'.$rows['EhHereditaria'].'</td>'; 
	    $html.= '</tr>
               <tr>
                 <td colspan="'.$numColumn.'">
                   <hr style="border-bottom: dashed 1px #000000; color:#0000; ">
                 </td>
               </tr>';
	 
      ++$qtde;

    }

    $html .= '
	    <tr>
	      <td style="font-size: 13px; colspan="'.$numColumn.'">Quantidade de Registros: '.$qtde.'</td>
	    </tr>
	  </table>';

  }else{

    $html .= '<br><br><br><br><br><br>
              <p style="text-align: center; font-size: 20px;">Não há dados que atendem a filtragem realizada!</p>';

  }

  //Finalização do relatório
  $html.= ' 
	    </div>
	  </body>
	</html>';

  //Geração do PDF
  $dompdf->loadHtml($html);
  $dompdf->setPaper('A4', $orientation);
  $dompdf->render();
  $dompdf->stream('relatório.pdf', array('Attachment'=>0));
  
?>


 