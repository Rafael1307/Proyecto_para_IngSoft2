<?php
	date_default_timezone_set('America/Mexico_City');
	$link = mysqli_connect("localhost", "root", "", "ab_model") or die ("<h3> Error de conexion </h3>");

	$command = "SELECT NumMesa FROM mesa";
	$command2 = "SELECT Nombre, ID_platillo FROM platillo";
	$command3 = "SELECT Platillo, Cantidad FROM pedido WHERE Mesa = ? AND Fecha = ? AND Hora = ?";
	$command4 = "SELECT Nombre FROM platillo where ID_platillo = ?";

	//Considerando eliminación / aceptación de valores nulos en ID, Cliente y Total en pedido:
	$command5 = "INSERT INTO pedido (Mesa, Platillo, Cantidad, Status, Fecha, Hora) VALUES 
	 (?, ?, ?, 0, ?, ?)";
	$command6 = "UPDATE pedido SET Cantidad = ? WHERE Platillo = ? AND Mesa = ? AND Hora = ? AND Fecha = ?";
	$command7 = "SELECT Cantidad, COUNT(*) FROM pedido WHERE Mesa = ? AND Fecha = ? AND Hora = ? AND Platillo = ?";
	$command8 = "DELETE FROM pedido where Mesa = ? AND Platillo = ? AND Fecha = ? AND Hora = ?";

	$query = mysqli_query($link, $command);
	$query2 = mysqli_query($link, $command2);
	$query3 = $link->prepare($command3);
	$query4 = $link->prepare($command4);
	$query5 = $link->prepare($command5);
	$query6 = $link->prepare($command6);
	$query7 = $link->prepare($command7);
	$query8 = $link->prepare($command8);
	

	unset($array);
	
	session_start();
	$_SESSION['inicio'];
	$_SESSION['control'];
	$_SESSION['mesa'];

   	if(isset($_POST['boton_agregar'])){
   		$actual = date('Y-m-d H:i:s', time());
   		$fecha = date('Y-m-d', strtotime($actual));
   		$tiempo = date('H:i:s', strtotime($actual));
   		$platillo = $_POST['id_producto_pedido'];
   		$mesa = $_POST['select_mesa'];
   		$cantidad = $_POST['prod_cantidad'];
   		$_SESSION['mesa'] = $mesa;

   		if($_SESSION['control'] != 1){
   			$_SESSION['inicio'] = $tiempo;
   			$_SESSION['control'] = 1;
   		}
   		$tiempo = $_SESSION['inicio'];
			$query7->bind_param("isss", $mesa, $fecha, $tiempo, $platillo);
			if($query7->execute()){
				$resultados_previos = $query7->get_result();
				$valores_previos = $resultados_previos->fetch_array(MYSQLI_NUM);


				if($valores_previos[1] > 0){
					$cantidad_cambiar = $cantidad + $valores_previos[0];
					$query6->bind_param("isiss", $cantidad_cambiar, $platillo, $mesa, $tiempo, $fecha);
					if($query6->execute()){
						unset($_POST['boton_agregar']);
						header('Location: /ab_model/mesas.php');
					}
				}
				else{
					$query5->bind_param("isiss", $mesa, $platillo, $cantidad, $fecha, $tiempo);
					if($query5->execute()){
						unset($_POST['boton_agregar']);
						header('Location: /ab_model/mesas.php');
					}
				}
			}
			else{
				echo 'error';
			}
			header('Location: /ab_model/mesas.php');
   	}

   	if(isset($_POST['boton_eliminar'])){
   		$fecha = date('Y-m-d');
   		$tiempo = $_SESSION['inicio'];
   		$platillo = $_POST['id_producto_pedido'];
   		$mesa = $_POST['select_mesa'];
   		$cantidad = $_POST['prod_cantidad'];
   		$_SESSION['mesa'] = $mesa;

   		if($_SESSION['control'] == 1){
   			$query7->bind_param("isss", $mesa, $fecha, $tiempo, $platillo);
   			if($query7->execute()){
   				$resultados_previos = $query7->get_result();
   				$valores_previos = $resultados_previos->fetch_array(MYSQLI_NUM);
   				echo "Hola";
   				if($valores_previos[1] > 0){
   					$cantidad_cambiar = $valores_previos[0] - $cantidad;
   					if($cantidad_cambiar > 0){
       					$query6->bind_param("isiss", $cantidad_cambiar, $platillo, $mesa, $tiempo, $fecha);
       					if($query6->execute()){
       						unset($_POST['boton_eliminar']);
       						header('Location: /ab_model/mesas.php');
       					}
       				}
       				else{
   					$query8->bind_param("isss", $mesa, $platillo, $fecha, $tiempo);
   					if($query8->execute()){
   						unset($_POST['boton_eliminar']);
   						header('Location: /ab_model/mesas.php');
   					}
   				}
   				}
   				
   			}
   		}
   		header('Location: /ab_model/mesas.php');
   	}
	if(isset($_POST['boton_finalizar'])){
		$_SESSION['control'] = 0;
		header('Location: /ab_model/mesas.php');
	}
  ?>	
