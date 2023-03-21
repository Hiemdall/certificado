<?php
  // Llamar a el archivo conexion.php para hacer la conexion a la base de datos
  include("conexion.php");
  //include("combo_cargo.php");
  
  
  // Obtener los datos del usuario si se ha enviado el formulario
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
   
    
    $cedula = $_POST['input'];
    $nombre1 = $_POST["nombre1"];
    $nombre2 = $_POST["nombre2"];
    $apellido1 = $_POST["apellido1"];
    $apellido2 = $_POST["apellido2"];
    $fecha_ingreso = $_POST["fecha_ingreso"];
    $nom_cargo = $_POST["cargo"];
    $sueldo = $_POST["sueldo"];
    $estatus = $_POST["estatus"];


   
      /*    
     // Obtener el id_cargo correspondiente al nom_cargo que se haya enviado en el formulario
     $query_id_cargo = "SELECT id_cargo FROM cargo WHERE nom_cargo = '$nom_cargo'";
     $result_id_cargo = mysqli_query($conn, $query_id_cargo);
     $row_id_cargo = mysqli_fetch_assoc($result_id_cargo);
     $id_cargo = $row_id_cargo['id_cargo'];
     */
/* 
    //Elimina el signo de dólar y la coma
    $sueldo = str_replace(array("$", ","), "", $sueldo);
    $sueldo = intval($sueldo);
*/     
     
    // Realizar una consulta a la base de datos para actualizar los datos del usuario
    $sql = "UPDATE datos SET nom1_datos='$nombre1',nom2_datos='$nombre2', ape1_datos='$apellido1', ape2_datos='$apellido2', fec_ing_datos='$fecha_ingreso', cargo='$nom_cargo',sue_datos='$sueldo',est_datos='$estatus' WHERE ced_datos='$cedula'";
    if (mysqli_query($conn, $sql)) {
      echo "Datos actualizados correctamente";
    } else {
      echo "Error al actualizar los datos: " . mysqli_error($conn);
    }
    
    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
    
    // Redirigir al usuario a la página de inicio
    header('Location: formulario.php');
    exit;
  }
  
/*
  // Buscar los datos del usuario en la base de datos
  $cedula = (input);
  $sql = "SELECT nombre, apellido, cedula FROM datos WHERE Id='$user_id'";
  $result = mysqli_query($conn, $sql);
  $user = mysqli_fetch_assoc($result);
  */

  // Cerrar la conexión a la base de datos
  mysqli_close($conn);
?>

