<?php
 // Llamar a el archivo conexion.php para hacer la conexion a la base de datos
 include("conexion.php");

// Recibir datos del formulario
//$search_term = "%" . $_POST['cedula'] . "%";
$search_term = $_POST['input'];


// Preparar la consulta SQL
// $sql = "SELECT * FROM datos WHERE cedula LIKE ?";
/*
// Ejemplo de código SQL, datos y cargo son las tablas de esa base de datos
$sql = "SELECT datos.id_empleado, datos.ced_datos, datos.nom1_datos, datos.nom2_datos, datos.ape1_datos, datos.ape2_datos, datos.fec_ing_datos, cargo.nom_cargo, datos.sue_datos, datos.est_datos FROM datos
INNER JOIN cargo ON datos.cargo = cargo.id_cargo WHERE ced_datos LIKE ?";
*/

$sql = "SELECT id_empleado, ced_datos, nom1_datos, nom2_datos, ape1_datos, ape2_datos, fec_ing_datos, cargo, sue_datos, est_datos FROM datos
WHERE ced_datos LIKE ?";

// Preparar la sentencia
$stmt = mysqli_prepare($conn, $sql);

// Vincular los parámetros
mysqli_stmt_bind_param($stmt, "s", $search_term);

// Ejecutar la sentencia
mysqli_stmt_execute($stmt);

// Obtener resultados
$result = mysqli_stmt_get_result($stmt);

$fila = mysqli_fetch_assoc($result);

$fecha_actual = new DateTime('now', new DateTimeZone('America/Bogota'));
//$fecha_formateada = $fecha_actual->format('d/m/Y H:i:s');
$fecha_formateada = $fecha_actual->format('m/d/Y');
$meses1 = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$fecha_convertida2 = date("d", strtotime($fecha_formateada)) . " de " . $meses1[date("n", strtotime($fecha_formateada))-1] . " de " . date("Y", strtotime($fecha_formateada));

// Covertir el sueldo con el formato de moneda $
$sueldo = $fila["sue_datos"];
$sueldo_formateado = "$".number_format($sueldo, 2, ".", ",");

// Fecha inicio del esmpleado
$selectedDate = $fila["fec_ing_datos"];
$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$fecha_convertida = date("d", strtotime($selectedDate)) . " de " . $meses[date("n", strtotime($selectedDate))-1] . " de " . date("Y", strtotime($selectedDate));

// Crear el objeto dompdf
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

// Creamos el HTML que se convertirá en PDF
$html = '
  <html>
    <head>
      <meta charset="UTF-8">
      <title>Certificado</title>
      
      <style>
        body {
          font-family: Arial, sans-serif;
          font-size: 16px;
          line-height: 1,5;
          margin: 80px;
        }
        .img{
          position: absolute;
          margin: 0;
          width: 800px; 
          height: 120px; 
          top: -5%; 
          left: -7%;
      
          }
          .img2{
            position: absolute;
            margin: 0;
            width: 800px; 
            height: 220px; 
            top: 84%; 
            left: -7%;
          }

          .img3{
            position: absolute;
            margin: 0;
            width: 600px; 
            height: 400px; 
            top: 35%; 
            left: 9%;
            background-repeat: repeat;
            opacity: 0.2;
        
            }

        h1 {
          font-size: 20px;
          text-align: center;
          margin-top: 20%;
          margin-bottom: 30px;
          height: 1px
          
        }
        h2 {
            font-size: 20px;
            text-align: center;
            margin-top: 1%;
            margin-bottom: 30px;
            height: 80px
        }
            h3 {
                font-size: 30px;
                text-align: center;
                margin-top: 15%;
                margin-bottom: 30px;
                line-height: 0.1;
            }
        p {
          text-align: center;
          margin-top: 30px;
          margin-bottom: 30px;
          text-align: justify;

        }
        .fecha{
          text-align: right;
        }
        
        
      </style>
    </head>
    <body>
    <header>
    <img src="encabezado.jpg" alt= integratic logo " class=img >
    </header>
    <img src="marcadeagua.jpg" alt= integratic logo " class=img3 >
    <footer>
    <img src="piedepagina.jpg" alt= integratic logo " class=img2 >
    </footer>
      <main>
      <p class=fecha>Santiago de Cali, '.$fecha_convertida2.'</p>
      <h1>Integratic Tecnologias de optimización S.A.S.</h1>
      <h2>NIT.901.145.160-1</h2>
      <h3>Certifica</h3>
      <p>Que el señor(a) ' . $fila['nom1_datos'] . ' ' . $fila['nom2_datos'] . ' ' . $fila['ape1_datos'] . ' ' . $fila['ape2_datos'] . ' identificado(a) con la Cédula de identidad no: ' . $fila['ced_datos'] . ' ' . 'expedida en la ciudad de Cali, labora en la compañia desde el ' .$fecha_convertida.' la fecha, desempeñando el cargo de '.$fila["cargo"].' con un contrato a término indefinido desvengando un salario básico de '.$sueldo_formateado.' pesos MCTE.</p>
      <p>Para constancia se firma en Cali a los '.$fecha_convertida2.'</p>
      </main>
    </body>
  </html>
';

$dompdf->setPaper('A4', 'portrait');
// Renderizar el contenido HTML en PDF
$dompdf->loadHtml($html);
$dompdf->render();


// Descargar el archivo PDF
// Nombre del archivo:
//$dompdf->stream("carta_de_trabajo.pdf");
$dompdf->stream("certificado_laboral_",[ "Attachment" => false]);




?>