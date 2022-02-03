
<?php
session_start();
$mesa = $_POST['mesa'];
$platillo = $_POST['platillo'];
$cantidad = $_POST['cantidad'];
$conexion=mysqli_connect("localhost","root","","ab_model");
 $consulta = "DELETE FROM pedido_temporal WHERE Mesa = $mesa AND Platillo = '$platillo' AND Cantidad = $cantidad LIMIT 1";

if (mysqli_query($conexion, $consulta)) {
  echo '<script> 
            alert("Platillo eliminado");
         window.history.go(-1);</script>';
}else{
	echo '<script> 
            alert("Todo mal");
         </script>';
         echo "Error: " . $consulta . "<br>" . mysqli_error($conexion);
}

?>