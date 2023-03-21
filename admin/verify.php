<?php
// Conexión local
include("conexion.php");

$input = $_POST["input"];

//$sql = "SELECT nombre, apellido, fecha_ingreso, cargo FROM datos WHERE cedula = '$input'";
/*
$sql = "SELECT datos.nombre, datos.apellido, datos.fecha_ingreso, cargo.nom_cargo, sueldo
FROM datos 
INNER JOIN cargo ON datos.cargo = cargo.id_cargo
WHERE datos.cedula = '$input'";
*/

/*
$sql = "SELECT datos.id_empleado, datos.ced_datos, datos.nom1_datos, datos.nom2_datos, datos.ape1_datos, datos.ape2_datos, datos.fec_ing_datos, cargo.nom_cargo, datos.sue_datos 
FROM datos
INNER JOIN cargo ON datos.cargo = cargo.id_cargo 
WHERE ced_datos = '$input'";
*/

$sql = "SELECT id_empleado, ced_datos, nom1_datos, nom2_datos, ape1_datos, ape2_datos, fec_ing_datos, cargo, sue_datos, est_datos
FROM datos WHERE ced_datos = '$input'";
//$result = $conn->query($sql);
$result = mysqli_query($conn, $sql);



//if ($result->num_rows > 0) {
    if (mysqli_num_rows($result) > 0) {
        
        $row = mysqli_fetch_assoc($result);
        
  
    $name = $row["nom1_datos"];
    $name2 = $row["nom2_datos"];
    $apellido1 = $row["ape1_datos"];
    $apellido2 = $row["ape2_datos"];
    $fecha_ingreso = $row["fec_ing_datos"];
    $cargo = $row["cargo"];
    $sueldo = $row["sue_datos"];
    //$sueldo_formateado = "$".number_format($sueldo, 2, ".", ",");
    $estatus = $row["est_datos"];

    
    
   
    //echo json_encode(array("exists" => true, "name" => $name, "apellido" => $apellido, "fecha_ingreso" => $fecha_ingreso, "cargo" => $cargo, "sueldo" => $sueldo_formateado));
    echo json_encode(array("exists" => true, "nombre1" => $name,"nombre2" => $name2, "apellido1" => $apellido1,"apellido2" => $apellido2,"fec_ing_datos" => $fecha_ingreso, "cargo" => $cargo, "sue_datos" => $sueldo, "est_datos" => $estatus ));
    
   // echo "El valor ingresado existe en la base de datos";

  
    
} else {
    echo json_encode(array("exists" => true, "nombre1" => "","nombre2" => "", "apellido1" => "","apellido2" => "","fec_ing_datos" => "", "cargo" => "", "sue_datos" => "", "est_datos" => ""));
    //echo json_encode(array("exists" => true, "name" => "", "apellido" => "", "fecha_ingreso" => "", "cargo" => "", "sueldo" => ""));
    //echo "El valor ingresado no existe en la base de datos";
}

$conn->close();
?>