<?php
session_start();

session_destroy();
header("Location: ../../abmobel/Login.html");
?>