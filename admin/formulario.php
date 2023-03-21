
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="estilo.css">
  <!--Libreria para utilizar  la función de la mascara en el input del sueldo -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
  
  <title>Integartic Empleado</title>
  
  </head>
<body>

<form method="post">
<img src="logo.png" alt="Integratic" width="200" height="80">
<h1>Formulario de Empleado</h1>
  <label for="input">Cédula:</label>
  <input type="text" id="input" name="input" required>
  <label for="nombr1">Primer Nombre:</label>
  <input type="text" id="nombre1" name="nombre1" required>
  <label for="nombre2">Segundo Nombre:</label>
  <input type="text" id="nombre2" name="nombre2">
  <label for="apellido">Primer Apellido:</label>
  <input type="text" id="apellido1" name="apellido1" required>
  <label for="apellido2">Segundo Apellido:</label>
  <input type="text" id="apellido2" name="apellido2">
  <label for="fecha_ingreso">Fecha Ingreso:</label>
  <input type="date" id="fecha_ingreso" name="fecha_ingreso" required>
  <label for="cargo">Cargo:</label>
  <select id="cargo" name="cargo">
  <option value="">Seleccionar cargo</option>
  <?php
  // Conexión local
  include("combo_cargo.php");
  ?>
  </select>


  <label for="sueldo">Sueldo:</label>
  <input type="text" id="sueldo" name="sueldo">
  <label for="estatus">Estatus:</label>
  <input type="text" id="estatus" name="estatus">

  
  <input type="submit" name="agregar" value="Agregar">
  <input type="submit" name="editar" value="Editar">
  <input type="submit" name="eliminar" value="Eliminar">
</form>

<?php
  //Acciones de los submit
if (isset($_POST['agregar'])) {
  // Código para manejar la búsqueda
  //echo "Mensaje pdp";
  include('Insertar.php');
    
} else if (isset($_POST['editar'])) {
  // Código para manejar la edición de un registro
   // include('actualizar.php');
  // echo "Mensaje editar";
   include('modificar.php');


} else if (isset($_POST['eliminar'])) {
  // Código para manejar la eliminación de un registro
 // echo "Mensaje eliminar";
  include('eliminar.php');
}
?>

<!--Script para buscar en tiempo real la cedula, llamando el archivo verify.php-->
<script>
//Mascar del input sueldo
$(document).ready(function() {
		    $('#sueldo').inputmask('currency', {
                prefix: '$',
		        radixPoint: '.',
		        groupSeparator: ',',
		        digits: 2,
		        autoGroup: true,
		        rightAlign: false,
		        allowMinus: false,
		        removeMaskOnSubmit: true
		    });
		});

//La infomación de la base de datos va a cada input del formulario
document.getElementById("input").addEventListener("input", function() {
  var input = this.value;

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "verify.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      var response = JSON.parse(this.responseText);
      if (response.exists) {
        document.getElementById("nombre1").value = response.nombre1;
        document.getElementById("nombre2").value = response.nombre2;
        document.getElementById("apellido1").value = response.apellido1;
        document.getElementById("apellido2").value = response.apellido2;
        document.getElementById("fecha_ingreso").value = response.fec_ing_datos;
        
        //document.getElementById("sueldo").value = response.sue_datos;
      
      //Este codigo se utiliza para cargar el combox con lo que esta en la base de datos
      // Obtener el elemento select
        const selectElement = document.getElementById("cargo");
      // Buscar si existe una opción con el valor de response.cargo
        let option = selectElement.querySelector(`option[value="${response.cargo}"]`);
        if (!option) {
      // Si no existe la opción, agregar una nueva
        option = document.createElement("option");
        option.value = response.cargo;
        option.textContent = response.cargo;
        selectElement.appendChild(option);
        }
       // Establecer el atributo selected de la opción
        option.selected = true;


        document.getElementById("sueldo").value = response.sue_datos;
        document.getElementById("estatus").value = response.est_datos;
     

        
      }
    }
  };
  xhr.send("input=" + input);
});
</script>

</body>
</html>



