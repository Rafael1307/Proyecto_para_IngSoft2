<?php 
$db = "ab_model";
				$link = mysqli_connect("localhost", "root", "", $db) or die ("<h2>No hay conexion</h2>");
		session_start();
		if(!isset($_SESSION['User'])){
				header("Location: Login.html");
		}?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>El Gordito Feliz</title>
    <link rel="icon" type="image/png" href="logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css4.css" />
    <script src="java.js"></script>
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Pattaya&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="styles/start.css" media="(max-width:1600px) and (min-width: 821px)">
     <link rel="stylesheet" type="text/css" href="responsiveautores.css" media="(max-width:820px) and (min-width: 200px)">

</head>
<body>
	<section class="a1">
		<img id="logo" src=logo.png>
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
	<center><big><big><h1 style="color: black">El Gordito Feliz</h1></big></big></center><br>
	<article>
		<!-- <center><DIV STYLE="position:absolute; top:20%; left:12%; visibility:visible z-index:1">
<IMG height="470" width="1080" SRC="fondo.jpg" width="800">
</div></center> -->
		<!-- Slideshow container -->
		<div class="slideshow-container">

		  <!-- Full-width images with number and caption text -->
		  <div class="mySlides fade">
		    <div class="numbertext">1 / 3</div>
		    <img src="img4.jpg" style="width:100%">
		    <div class="text">Bienvenida</div>
		  </div>

		  <div class="mySlides fade">
		    <div class="numbertext">2 / 3</div>
		    <img src="img5.jpg" style="width:100%">
		    <div class="text">Promoción</div>
		  </div>

		  <div class="mySlides fade">
		    <div class="numbertext">3 / 3</div>
		    <img src="img6.jpg" style="width:100%">
		    <div class="text">Especiales</div>
		  </div>

		  <!-- Next and previous buttons -->
		  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
		  <a class="next" onclick="plusSlides(1)">&#10095;</a>
		</div>
		<br>

		<!-- The dots/circles -->
		<div style="text-align:center">
		  <span class="dot" onclick="currentSlide(1)"></span>
		  <span class="dot" onclick="currentSlide(2)"></span>
		  <span class="dot" onclick="currentSlide(3)"></span>
		</div>
	</article>
	<center><big><big><h1 style="color: black">Panza llena corazón contento</h1></big></big></center>
	</section>
		<nav><br>
		   	<ul>
				<li><a href="#"><span></span></a></li>
				<li><a href="#"><span></span></a></li>
				<li><a href="#"><span></span></a></li>
				<li><a href="#"><span></span></a></li>
				<li><a href="#"><span></span></a></li>
			</ul>
		   </nav>
</body>
</html>