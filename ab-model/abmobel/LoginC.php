<?php
	session_start();
	date_default_timezone_set('America/Mexico_City');
	$HoraI = date("H:i:s");
	$Fecha = date("Y-m-d");

	$Correo = $_POST['usuario'];
	$password = $_POST['password'];
	$mesa = $_POST['mesa'];
	if($mesa == null){
				echo'
					<script>
						alert("No se selecciono una mesa");
						window.location="Login.html";
					</script>
				';
			}
	

	$db = "ab_model";
				$link = mysqli_connect("localhost", "root", "", $db) or die ("<h2>No hay conexion</h2>");

		$sql = "SELECT COUNT(*) as cont FROM cliente WHERE Correo = '$Correo' AND Password = '$password'";

		$resultado = mysqli_query($link, $sql);
		$array = mysqli_fetch_array($resultado);

		if ($array['cont']>0) {
			$consulta = "SELECT * FROM mesa WHERE NumMesa = $mesa";
			$result = $link->query($consulta);
                    while($row = $result->fetch_assoc()){

                    	$_SESSION['temp'] = $row['OcupacionCliente'];
                    }
            if ($_SESSION['temp']==$Correo) {
            	header("location: Inicio.php");
            }elseif ($_SESSION['temp']==null) {
				$_SESSION['User']= $Correo;
				$_SESSION['MesaC'] = $mesa;
				$sq="INSERT INTO `historial` (CorreoCliente, Fecha, HoraEntrada, HoraSalida) VALUES ('$Correo', '$Fecha', '$HoraI', '');";
				mysqli_query($link, $sq);

				$q = "UPDATE mesa SET OcupacionCliente = '$Correo' WHERE NumMesa = $mesa";
				mysqli_query($link, $q);
				header("location: Inicio.php");
			}else{
				echo'
					<script>
						alert("Mesa ocupada");
						window.location="Login.html";
					</script>
				';	
			}
			//header("location: Inicio.php");
		}else{
			include 'LoginM.php';
			
		}
?>