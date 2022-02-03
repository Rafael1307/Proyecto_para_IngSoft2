<?php
	session_start();
	$Correo = $_POST['usuario'];
	$password = $_POST['password'];
	

	$db = "ab_model";
				$link = mysqli_connect("localhost", "root", "", $db) or die ("<h2>No hay conexion</h2>");

		$sql = "SELECT COUNT(*) as cont FROM mesero WHERE Correo = '$Correo' AND Password = '$password'";

		$resultado = mysqli_query($link, $sql);
		$array = mysqli_fetch_array($resultado);

		if ($array['cont']>0) {
			$_SESSION['User']= $Correo;
			header("location: ../ab-model/php/aceptar_pedidos.php");
		}else{
			echo '<script>
				alert("Usuario o Contraseña incorrectos");
				window.location="Login.html";
			</script>';
		}
?>