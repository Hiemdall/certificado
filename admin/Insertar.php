<?php
 // Llamar a el archivo conexion.php para hacer la conexion a la base de datos
 include("conexion.php");


$cedula = $_POST['input'];
$nombre1 = $_POST["nombre1"];
$nombre2 = $_POST["nombre2"];
$apellido1 = $_POST["apellido1"];
$apellido2 = $_POST["apellido2"];
$fecha_ingreso = $_POST["fecha_ingreso"];
$cargo = $_POST["cargo"];
$sueldo = $_POST["sueldo"];
$estatus = $_POST["estatus"];



// Insertar los datos en la base de datos
$sql = "INSERT INTO datos (ced_datos, nom1_datos, nom2_datos, ape1_datos, ape2_datos, fec_ing_datos, cargo, sue_datos, est_datos)
        VALUES ('$cedula', '$nombre1', '$nombre2', '$apellido1', '$apellido2', '$fecha_ingreso', '$cargo', '$sueldo', $estatus)";

if ($conn->query($sql) === TRUE) {
  echo "Los datos se insertaron correctamente.";
} else {
  echo "Error al insertar los datos: " . $conn->error;
}


mysqli_close($conn);
?>