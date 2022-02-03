<?php
session_start();
	$mesa = $_POST['mesa'];

	$link = mysqli_connect("localhost", "root", "", "ab_model");
		$sql = "UPDATE pedido SET Status = 5 Where Mesa = $mesa";

		mysqli_query($link, $sql);
		echo'
			<script>
			alert("Cuenta Liquidada");
				window.location = "pre_cuenta.php";
			</script>
		';

?>