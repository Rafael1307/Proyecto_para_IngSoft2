<?php
session_start();

$User = $_SESSION['User'];

$link = mysqli_connect("localhost", "root", "", "ab_model");
$sql = "UPDATE mesa SET AtencionMesero = NULL WHERE AtencionMesero = '$User'";
mysqli_query($link, $sql);

session_destroy();
header("Location: ../../abmobel/Login.html");
?>