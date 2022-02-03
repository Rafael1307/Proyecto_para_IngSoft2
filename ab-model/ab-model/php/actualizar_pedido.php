<?php
session_start();
	$pedido = $_POST['id'];

	$link = mysqli_connect("localhost", "root", "", "ab_model");
		$sql = "UPDATE pedido SET Status = Status + 1 Where ID = $pedido";

		mysqli_query($link, $sql);
		echo'
			<script>
				window.location = "pedidos.php";
			</script>
		';

?>