<?php
session_start();
	$pedido = $_POST['pedido'];

	$link = mysqli_connect("localhost", "root", "", "ab_model");
		$sql = "UPDATE pedido SET Status = -1 Where ID = $pedido";

		mysqli_query($link, $sql);
		echo'
			<script>
				alert(Pedido Cancelado);
				window.location = "aceptar_pedidos.php";
			</script>
		';

?>