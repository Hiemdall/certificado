<?php
include 'conexion.php'; // incluir el archivo que contiene la conexión a la base de datos

// verificar si se ha enviado el formulario
if(isset($_POST['input'])) {
  $cedula = $_POST['input'];

   // ver si el campo cedula esta vacio
   if (empty($cedula)) {
    echo "Error: El campo cedula no puede estar vacio";
  } else {
    // preparar la consulta para eliminar el registro
    $stmt = $conn->prepare('DELETE FROM datos WHERE ced_datos = ?');
    $stmt->bind_param('s', $cedula);
    $stmt->execute();
    
    // ver si se eliminó el registro
    if ($stmt->affected_rows > 0) {
      header("Location: index.php");
      exit();
    } else {
      echo "No hay registro para eliminar"; 
      $error = "Error: No se pudo eliminar el registro";
    }
  }
}
mysqli_close($conn);
?>