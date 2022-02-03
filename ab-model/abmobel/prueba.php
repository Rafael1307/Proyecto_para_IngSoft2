<?php 
session_start();
$Usuario = $_SESSION['User'];
$cantidad = $_POST['menu'];
$mesa = $_POST['mesa'];
$platillo = $_POST['platillo'];

$link=mysqli_connect("localhost","root","","ab_model");
$sql = "INSERT INTO pedido_temporal (Mesa, Platillo, Cantidad) VALUES ($mesa, '$platillo', $cantidad)";

if (mysqli_query($link, $sql)) {
		date_default_timezone_set('America/Mexico_City');
		$Hora = date("H:i:s");
		$Fecha = date("Y-m-d");
		$consulta = "UPDATE historial SET HoraSalida = '$Hora' WHERE Fecha = '$Fecha' AND CorreoCliente = '$Usuario' ORDER BY HoraEntrada desc LIMIT 1";
		mysqli_query($link, $consulta);
      echo '<script> 
                        alert("!Pedido registrado exitosamente!");
                        window.history.go(-1);</script>';
} else {
      echo  '<script> 
                        alert("Error al registrar");
                        window.history.go(-1);</script>';
      //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

 ?>