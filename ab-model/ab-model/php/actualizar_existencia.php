<?php
session_start();
	$nuevo = $_POST['extra'];
	$pd = $_POST['id'];

	$link = mysqli_connect("localhost", "root", "", "ab_model");
		$sql = "UPDATE platillo SET Existencia = Existencia + $nuevo Where ID_platillo = '$pd'";

		mysqli_query($link, $sql);
		echo'
			<script>
				window.location = "existencia.php";
			</script>
		';

?>