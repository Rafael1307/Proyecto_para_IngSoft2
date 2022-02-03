<?php
session_start();

$mesa = $_SESSION['MesaC'];

$link = mysqli_connect("localhost", "root", "", "ab_model");
$sql = "UPDATE mesa SET OcupacionCliente = NULL WHERE NumMesa = $mesa";
mysqli_query($link, $sql);

session_destroy();
header("Location: Login.html");
?>