<?php
	session_start();

	$mesa = $_POST['mesa'];
	$clave = $_POST['clave'];
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

		$sql = "SELECT COUNT(*) as cont FROM mesa WHERE NumMesa = $mesa AND Clave = '$clave'";

		$resultado = mysqli_query($link, $sql);
		$array = mysqli_fetch_array($resultado);

		if ($array['cont']>0) {
			$consulta = "SELECT * FROM mesa WHERE NumMesa = $mesa";
			$result = $link->query($consulta);
                    while($row = $result->fetch_assoc()){

                    	$_SESSION['temp'] = $row['OcupacionCliente'];
                    }
            if ($_SESSION['temp']=="Invitado") {
            	header("location: Inicio.php");
            }elseif ($_SESSION['temp']==null) {
				$_SESSION['User']= "Invitado";
				$_SESSION['MesaC'] = $mesa;

				$q = "UPDATE mesa SET OcupacionCliente = 'Invitado' WHERE NumMesa = $mesa";
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
			
		}
?>