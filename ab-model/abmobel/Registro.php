<?php
$servername = "";
$database = "ab_model";
$username = "root";
$password = "";
// Create connection
$conn = mysqli_connect($servername,$username, $password, $database);
// Check connection
if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
}
 
echo "Connected successfully";

$Nombre=$_POST['nombre'];
$ApellidoP=$_POST['apellidoP'];
$ApellidoM =$_POST['apellidoM'];
$Correo=$_POST['correo'];
$Password=$_POST['password'];
$Pass =$_POST['passwordd'];

if ($Password != $Pass) {
      echo  '<script> 
                        alert("Las contraseñas no coinciden");
                        window.history.go(-1);</script>';
}else{



$verificar_correo = mysqli_query($conn, "SELECT * FROM cliente WHERE Correo = '$correo'");
      if(mysqli_num_rows($verificar_correo) > 0){
            echo  '<script> 
                        alert("Ya hay un paciente registrado con este Correo");
                        window.history.go(-1);</script>';
            exit;
      }
 
$sql = "INSERT INTO cliente (Nombre, ApellidoP, ApellidoM, Correo, Password) VALUES ('$Nombre', '$ApellidoP', '$ApellidoM', '$Correo', '$Password')";
if (mysqli_query($conn, $sql)) {
      echo '<script> 
                        alert("!El cliente se ha registrado exitosamente!");
                        window.history.go(-2);</script>';
} else {
      echo  '<script> 
                        alert("Error al registrarse");
                        window.history.go(-1);</script>';
      //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}
mysqli_close($conn);
?>