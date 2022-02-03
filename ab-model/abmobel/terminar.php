<?php
		session_start();
			date_default_timezone_set('America/Mexico_City');
	$HoraI = date("H:i:s");
	$Fecha = date("Y-m-d");
	$Usuario = $_SESSION['User'];
			$id_pedido = null;
			$conexion=mysqli_connect("localhost","root","","ab_model");
			$conn = "SELECT * FROM pedido ORDER BY ID";
			$resultado= mysqli_query($conexion,$conn);
			while($Mostrar=mysqli_fetch_array($resultado)){
				$_SESSION['id_pedido'] = $Mostrar['ID'];
			}
			$id_pedido = $_SESSION['id_pedido'];
			if ($id_pedido == null) {
				$id_pedido = 1;
			}else{
				$id_pedido = $id_pedido + 1;
			}
			echo $id_pedido;
			$mesa = $_SESSION['MesaC'];
			 $consulta = "SELECT * FROM pedido_temporal LEFT JOIN platillo ON pedido_temporal.Platillo = platillo.ID_platillo WHERE Mesa = $mesa";

			 $resultado= mysqli_query($conexion,$consulta);
			 while($Mostrar=mysqli_fetch_array($resultado)){
			 				 $platillo = $Mostrar['Platillo'];
			 $cantida = $Mostrar['Cantidad'];
			 	$sql = "INSERT INTO pedido(ID, Cliente, Mesa, Platillo, Cantidad, Status, Fecha, Hora) VALUES ($id_pedido, '$Usuario', $mesa, '$platillo', $cantida, 0, '$Fecha', '$HoraI')";
			 	mysqli_query($conexion, $sql);

			 	$sqli = "UPDATE platillo SET Existencia = Existencia-$cantida WHERE ID_platillo = '$platillo'";
			 	mysqli_query($conexion, $sqli);
			 }
			 $q = "DELETE FROM pedido_temporal";
			 mysqli_query($conexion, $q);
			 $consultar = "UPDATE historial SET HoraSalida = '$HoraI' WHERE Fecha = '$Fecha' AND CorreoCliente = '$Usuario'";
		mysqli_query($conexion, $consultar);
		echo '
			<script>
				alert("Su pedido est siendo procesado");
				window.location = "menu.php";
			</script>
		';
?>