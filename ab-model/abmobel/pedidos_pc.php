<?php
	$db = "ab_model";
	$link = mysqli_connect("localhost", "root", "", $db) or die ("<h2>No hay conexion</h2>");
	session_start();
	if(!isset($_SESSION['User'])){
		header("Location: Login.html");
	}

    $correoCliente = $_SESSION['User'];
    if ($correoCliente == "Invitado") {
        echo '
            <script>
                alert("Cree una cuenta para acceder a esta funcion. Gracias :)");
                history.go(-1);
            </script>
        ';
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pedidos</title>
    <!--<link rel="stylesheet" type="text/css" href="Historial.css">-->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
    <section class="a1">
        <img id="logo" src=logo.jpg>
       <center><nav class="cl-effect-20">
            <?php $id_user = $_SESSION['User'];
            $_SESSION['nca']= "Invitado";
                $consulta = "SELECT Nombre FROM cliente WHERE Correo = '$id_user'";
                $result = $link->query($consulta);
                while($row = $result->fetch_assoc()){
                    $_SESSION['nca']= $row['Nombre'];
                }
                    ?>
                    <a style="color:white" href="menu.php"><span data-hover="Menu">Menu</span></a>
                    <a style="color:white" href="pedidos_pc.php"><span data-hover="Pedido">Pedido</span></a>
                    <a style="color:white" href="historial_pc.php"><span data-hover="Historial">Historial</span></a>
                    <a style="color:white" href="#"><span data-hover="<?php echo $_SESSION['nca']?>"><?php echo $_SESSION['nca']?></span></a>
                </nav></center>
        <a href="logout.php"><img id="usu" src="usua.png"></a>
    </section>

    <section class="A">
    <h1>Lista de pedidos</h1>
    <ul id="listPedidos">
        <?php
            $queryLapso = "SELECT Fecha, HoraEntrada, HoraSalida FROM historial WHERE CorreoCliente = '$correoCliente' ORDER BY Fecha, HoraEntrada";
            $tablaLapso = mysqli_query($link, $queryLapso);
            while ($arrayLapso = mysqli_fetch_array($tablaLapso)) {
                $fecha = $arrayLapso['Fecha'];
                $horaEntrada = $arrayLapso['HoraEntrada'];
                $horaSalida = $arrayLapso['HoraSalida'];

                $queryPedidos = "SELECT Platillo, Cantidad, Hora, Status FROM pedido WHERE Cliente = '" . $correoCliente . "' AND Status != -1 AND Status != 5 AND Fecha = '" . $fecha . "' AND Hora BETWEEN '" . $horaEntrada . "' AND '" . $horaSalida . "'";//Pedidos
                $tablaPedidos = mysqli_query($link, $queryPedidos);
                if (!$arrayPedidos = mysqli_fetch_array($tablaPedidos)) {
                    continue;
                }

                echo '<li class="pedido"><div class="precio"><br>';
                $total = 0;

                $tablaPedidos = mysqli_query($link, $queryPedidos);
                while ($arrayPedidos = mysqli_fetch_array($tablaPedidos)) {
                    $id_platillo = $arrayPedidos['Platillo'];
                    $cantidad = $arrayPedidos['Cantidad'];

                    $queryPlatillos = "SELECT Nombre, Precio FROM platillo WHERE ID_platillo = " . $id_platillo;
                    $tablaPlatillos = mysqli_query($link, $queryPlatillos);
                    $arrayPlatillos = mysqli_fetch_array($tablaPlatillos);
                    $nombre = $arrayPlatillos['Nombre'];
                    $precio = $arrayPlatillos['Precio'];

                    echo "$" . $precio * $cantidad . " - " . $nombre . " x" . $cantidad . "<br>";
                    $total += $precio * $cantidad;

                }

                echo 'TOTAL: $' . $total . '</div><div class="fecha">' . $fecha . '<br>';

                $tablaPedidos = mysqli_query($link, $queryPedidos);
                while ($arrayPedidos = mysqli_fetch_array($tablaPedidos)) {
                    $hora = $arrayPedidos['Hora'];

                    echo $fecha . " &nbsp;&nbsp;&nbsp;" . $hora . "<br>";
                }

                echo '</div><div class="estatus"><br>';

                $tablaPedidos = mysqli_query($link, $queryPedidos);
                while ($arrayPedidos = mysqli_fetch_array($tablaPedidos)) {
                    $status = $arrayPedidos['Status'];

                    if($status == -1){
                        echo "Cancelado<br>";
                    }if($status == 0){
                        echo "Pedido<br>";
                    }if($status == 1){
                        echo "Aceptado<br>";
                    }if($status == 2){
                        echo "Preparado<br>";
                    }if($status == 3){
                        echo "Finalizado<br>";
                    }if($status == 4){
                        echo "Entregado<br>";
                    }if($status == 5){
                        echo "Liquidado<br>";
                    }
                }

                echo '</div></div>';
            }
        ?>
    </ul>
    </section>
</body>
</html>

<style type="text/css">
    *{
        margin: 0%;
        padding: 0%;
    }

    body{
        background: url(restaurante.jpg);
        background-size: cover;
        background-attachment: fixed;
    }

    section.a1{
        width:100%;
        height:85px;
        background-color: #f38029;
    }
    #logo{position: fixed;
        margin-left: 0%;
        padding: 1%;
        top: 0%;
        width: 8%;
        height: 60px;
    }
    #usu{
        position: fixed;
        top: 0%;
        height: 5%;
        width: 3%;
        margin-left: 90%;
        padding: 2%;
    }
    a.Links{
        text-align: right;
        margin-left: 80%;
        color: white; 
    }
    .cl-effect-20 a {
        line-height: 2em;
        -webkit-perspective: 800px;
        -moz-perspective: 800px;
        perspective: 800px;
    }

    .cl-effect-20 a span {
        position: relative;
        top: 35%;
        display: inline-block;
        padding: 10px 15px 0;
        background: #974405;
        box-shadow: inset 0 3px #f32620;
        -webkit-transition: background 0.6s;
        -moz-transition: background 0.6s;
        transition: background 0.6s;
        -webkit-transform-origin: 50% 0;
        -moz-transform-origin: 50% 0;
        transform-origin: 50% 0;
        -webkit-transform-style: preserve-3d;
        -moz-transform-style: preserve-3d;
        transform-style: preserve-3d;
        -webkit-transform-origin: 0% 50%;
        -moz-transform-origin: 0% 50%;
        transform-origin: 0% 50%;
    }

    .cl-effect-20 a span::before {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #f5db64;
        color: #974405;
        content: attr(data-hover);
        -webkit-transform: rotateX(270deg);
        -moz-transform: rotateX(270deg);
        transform: rotateX(270deg);
        -webkit-transition: -webkit-transform 0.6s;
        -moz-transition: -moz-transform 0.6s;
        transition: transform 0.6s;
        -webkit-transform-origin: 0 0;
        -moz-transform-origin: 0 0;
        transform-origin: 0 0;
        pointer-events: none;
    }

    .cl-effect-20 a:hover span,
    .cl-effect-20 a:focus span {
        background: #2f4351;
    }

    .cl-effect-20 a:hover span::before,
    .cl-effect-20 a:focus span::before {
        -webkit-transform: rotateX(10deg);  
        -moz-transform: rotateX(10deg);
        transform: rotateX(10deg);
    }




    h1{
        color: white;
        font-size: 30px;
        font-weight: bold;
        text-decoration: underline;
        margin-top: 2%;
        text-align: center;
        background-color: rgba(0,0,0,0.75);
    }

    ul#listPedidos{
        margin-top: 3%;
        margin-bottom: 3%;
        margin-left: 10%;
        margin-right: 10%;
    }

    li.pedido{
        width: 100%;
        float: left;
        background-color: rgb(151,68,5);
        border: orange 10px inset;
        margin-bottom: 2%;
        color: white;

        display: flex;
        align-items: center;
    }

    div.precio{
        width: 50%;
        float: left;
    }

    div.fecha{
        text-align: center;
        width: 30%;
        float: left;
    }

    div.estatus{
        background-color: green;/*Pedidos*/
        text-align: center;
        width: 20%;
        float: right;
    }



    section.A{
        width:100%;
        height:605px;
    }

    nav{
        width:100%;
        height:70px;
        background-color: #f76d04;
    }

    a{
        text-decoration: none;
    }
</style>