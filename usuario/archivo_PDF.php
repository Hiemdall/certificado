<?php

//require('fpdf/fpdf.php');
require('lib/fpdf.php');

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


//Fecha actual
//$zona_horaria = new DateTimeZone('America/Bogota');
//$fecha_actual = new DateTime('now', $zona_horaria);
//echo $fecha_actual->format('d/m/Y');



// Verificar si hay resultados
if (mysqli_num_rows($result) > 0) {
    
    // Crear una nueva instancia de la clase FPDF
    $pdf = new FPDF();

    // Añadir una nueva página
    $pdf->AddPage();

    // Establecer la fuente y tamaño
    
    $pdf->SetFont('Arial','',12);
    

         

    // Mostrar resultados
    while ($row = mysqli_fetch_assoc($result)) {
        // Fecha actual
        $fecha_actual = new DateTime('now', new DateTimeZone('America/Bogota'));
        //$fecha_formateada = $fecha_actual->format('d/m/Y H:i:s');
        $fecha_formateada = $fecha_actual->format('m/d/Y');
        $meses1 = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fecha_convertida2 = date("d", strtotime($fecha_formateada)) . " de " . $meses1[date("n", strtotime($fecha_formateada))-1] . " de " . date("Y", strtotime($fecha_formateada));
       
        // Covertir el sueldo con el formato de moneda $
        $sueldo = $row["sue_datos"];
        $sueldo_formateado = "$".number_format($sueldo, 2, ".", ",");
        
        // Fecha inicio del esmpleado
        $selectedDate = $row["fec_ing_datos"];
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fecha_convertida = date("d", strtotime($selectedDate)) . " de " . $meses[date("n", strtotime($selectedDate))-1] . " de " . date("Y", strtotime($selectedDate));
        
        $pdf->Cell(40,10, utf8_decode('Cédula: ').$row["ced_datos"]);
        $pdf->Ln();
        $pdf->Cell(40,10,'Primer Nombre: '.$row["nom1_datos"]);
        $pdf->Ln();
        $pdf->Cell(40,10,'Segundo Nombre: '.$row["nom2_datos"]);
        $pdf->Ln();
        $pdf->Cell(40,10,'Primer Apellido: '.$row["ape1_datos"]);       
        $pdf->Ln();
        $pdf->Cell(40,10,'Segundo Apellido: '.$row["ape2_datos"]);
        $pdf->Ln();
        $pdf->Cell(40,10,'Fecha de Ingreso: '.$fecha_convertida);
        $pdf->Ln();
        $pdf->Cell(40,10, utf8_decode('Cargo: '.$row["cargo"]));
        $pdf->Ln();
        $pdf->Cell(40,10,'Sueldo: '.$sueldo_formateado);
        $pdf->Ln();
        $pdf->Cell(40,10,'Fecha Actual : '.$fecha_convertida2);
        $pdf->Ln();
        $pdf->Ln();
        

      
    }

    // Enviar el archivo PDF al navegador
    $pdf->Output();
} else {
    // Mostrar mensaje de error si no hay resultados
    echo "No se encontraron resultados para la cédula ingresada.";
}

// Cerrar la conexión
mysqli_close($conn);

?>