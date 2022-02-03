<?php 
session_start();
$conexion=mysqli_connect("localhost","root","","ab_model");

?>
<html>

 <head> 

  <title>  MENU </title>
     <!--<link rel ="stylesheet" type="text/css" href="css/estilos.css"/>-->
     <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
     <link rel="icon" type="image/png" href="logo.jpg">
 </head>
 <body>
  <section class="a1">
    
    <center><nav class="cl-effect-20">
            <?php $id_user = $_SESSION['User'];
            $_SESSION['nca']= "Invitado";
                $consulta = "SELECT Nombre FROM cliente WHERE Correo = '$id_user'";
                $result = $conexion->query($consulta);
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
 <h1> NUESTRO MENU</h1>
 
 
 <ul class="A">
 
<li class="B"><a href = "#Platos-fuertes">Platos fuertes</a></li>
<li class="B"><a href = "#Bebidas">Bebidas</a></li>
<li class="B"><a href = "#Postres">Postres</a></li>
<li class="B"><a href = "#VerPedido">VER MI PEDIDO</a></li>
<li class="B"><a href = "pedir.php">VER PEDIDOS</a></li>
 </ul>
 <img class="fon" src="imagenes/fonfo.png"alt="Fondo"title="Fondo"width ="100%"/>
 <a name="Platos-fuertes">
  <section class="contenido">
 <div class="Platos"> <li> Platos fuertes </li></div>
  
 <table>
 <?php 
 $consulta= "select *from platillo where ID_platillo LIKE '1%' and Existencia>0";
 $resultado= mysqli_query($conexion,$consulta);
 while($Mostrar=mysqli_fetch_array($resultado)){
	 
 ?>
 <tr>
 <td> <img src="imagenes/<?php echo $Mostrar['ImagenPlatillo'];?>" alt="Hamburguesa Sencilla" title="Hamburguesa Sencilla" width ="30%"/> </td>
 <td><?php echo $Mostrar['Descripcion'];?> </td>
 <td> Precio $<?php echo $Mostrar['Precio'];?> </td>
 <td>

 <form method="POST" action="prueba.php">
  <select name="menu">
  <option value="1" selected>1</option>
  <option value="2" >2</option>
  <option value="3" >3</option>
  <option value="4" >4</option>
  <option value="5" >5</option>
  <option value="6" >6</option>
  
</select>
<td>
  <aside style="display: none">
    <input type="number" name="mesa" value="<?php echo $_SESSION['MesaC'] ?>">
    <input type="text" name="platillo" value="<?php echo $Mostrar['ID_platillo'] ?>">
  </aside>
    <input type="submit" value="A&ntilde;adir" />
</td>
 </form>
 </td>
</tr>
<?php } ?>

 </table>

 <a name="Bebidas"></a>
<section class="TBebidas">
<div class="Bebidas"><li> Bebidas </li></div>
 <table>
 <?php 
 $consulta= "select *from platillo where ID_platillo  LIKE'2%' and Existencia>0  ";
 $resultado= mysqli_query($conexion,$consulta);
 while($Mostrar=mysqli_fetch_array($resultado)){	 
 ?>
 <tr>
 <td> <img src="imagenes/<?php echo $Mostrar['ImagenPlatillo'];?>" alt="Coca" title="Coca" width ="30%"/> </td>
 <td> <?php echo $Mostrar['Descripcion'];?></td>
 <td> Precio $<?php echo $Mostrar['Precio'];?> </td>
 <td><form method="POST" action="prueba.php">
  <select name="menu">
   <option value="1" selected>1</option>
  <option value="2" >2</option>
  <option value="2" >2</option>
  <option value="3" >3</option>
  <option value="4" >4</option>
  <option value="5" >5</option>
  <option value="6" >6</option>
  
</select>
<td>
  <aside style="display: none">
    <input type="number" name="mesa" value="<?php echo $_SESSION['MesaC'] ?>">
    <input type="text" name="platillo" value="<?php echo $Mostrar['ID_platillo'] ?>">
  </aside><input type="submit" value="A&ntilde;adir" /></td>
 </form>
</tr>
<?php } ?>
</table>
</section>
<a name="Postres"></a>
<section class="TPostres">
<div class="Postres"><li> Postres </li></div>
 <table>
 <?php 
 $consulta= "select *from platillo where ID_platillo  LIKE'3%' and Existencia>0 ";
 $resultado= mysqli_query($conexion,$consulta);
 while($Mostrar=mysqli_fetch_array($resultado)){
	 
 ?>
 <tr>
 <td> <img src="imagenes/<?php echo $Mostrar['ImagenPlatillo'];?>" alt="helado" title="helado" width ="30%"/> </td>
 <td> <?php echo $Mostrar['Descripcion'];?> </td>
 <td> Precio $<?php echo $Mostrar['Precio'];?> </td>
 <td>

 <form method="POST" action="prueba.php">
  <select name="menu">
  <option value="1" selected>1</option>
  <option value="2" >2</option>
  <option value="2" >2</option>
  <option value="3" >3</option>
  <option value="4" >4</option>
  <option value="5" >5</option>
  <option value="6" >6</option>
  
</select>
<td>
  <aside style="display: none">
    <input type="number" name="mesa" value="<?php echo $_SESSION['MesaC'] ?>">
    <input type="text" name="platillo" value="<?php echo $Mostrar['ID_platillo'] ?>">
  </aside><input type="submit" value="A&ntilde;adir" /></td>
 </form>
</tr>
<?php } ?>
</table>
</div>
</section>
    <nav>
        <ul class="redes">
        <li class="cuadrado"><a href="#"><span></span></a></li>
        <li class="cuadrado"><a href="#"><span></span></a></li>
        <li class="cuadrado"><a href="#"><span></span></a></li>
        <li class="cuadrado"><a href="#"><span></span></a></li>
        <li class="cuadrado"><a href="#"><span></span></a></li>
      </ul>
      <br><a class="Links" href="#">Terminos y Condiciones</a>
      <br><a class="Links" href="#">Aviso de Privacidad</a>
    </nav>
 </body>
 </section>
</html>
<style type="text/css">
    *{
    		margin: 0%;
    		padding: 0%;
    	}

    body{ background: #f5db64;}
    section.a1{
        width:100%;
        height:85px;
        background-color: #f38029;
    }
    #logo{position: fixed;
        margin-left: 2%;
        padding: 1%;
        top: 6%;
        width:8%;
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
    	color:black;
    	font-family:"Helvetica";
    	text-align: center;
    	font-size: 300%;
    	margin: 1% 1%;
    	padding: 1%;
    	
    	
    }
    .fon{
    	width:90%;
    	height:auto;
    	padding:5%;
    	margin-top:10%;
    	

    	
    }
    ul.A{
    		
    	width:95%;
    	background: #f38029;
    	margin: 2% 1%;
    	padding: 1% 1%;
    	list-style:none;
    	border:4px solid #974405;
    	position: fixed;
    	z-index:100;
      
    		
    }

    ul.A li.B{
    	display:inline-block;
    	margin: 0% ;
    	padding: 0% 4%;
    }
    ul.A li.B a{
    	color: white;
    	font-size: 150%;
    	padding:5% 2%;
    	display:block;
    	margin: 0% ;
    	padding: 0%;
    	text-decoration:none;	
    	box-shadow:0px 3px 0px #974405;
    	
    }
    ul.A li.B a:hover{
    	background:#974405;
    	color:white;
    		
    }
    ul.A li.B a:active{
    	box-shadow:none;
    }


    div  li{
    	color: white;
    	font-size:150%;
    	background: #974405;
    	margin: 1%% 5%;
    	padding: 2%;
    	border:2px solid #FFFFFF;
       
    		
    }


    table{
    	border:4px solid #FFFFFF;
    	width:100%;
    	height:auto;
    	position:relative;
    	bottom: 3%;
    	border-spacing:0;

    }
    .contenido{
    	padding-top:23%;
    }
    .TBebidas{
    	padding-top:23%;
    }
    .TPostres{
    	padding-top:23%;
    }


     table td{
    	border:2px solid #974405 ;
    	font-size: 130%;
    	text-align:center;
    	width:auto;
    	
    	
    	
    }



    img{
    	width:40%;
    	height:40%;
    	border-radius:5%;
    	border:1px solid #974405;
    	padding:2% 3%;
    	margin: auto;
    	display:block;
    }



    input{
    	background: #f32620;
    	border:none;
    	color: black;
    	padding:10% 10%;
        margin:auto;
    	text-align:center;
    	text-decoration: none;
    	display: block;
    	font-size:100%;
    	
    	
    	
    }
    input:hover{
    	background:#974405;
    	color: white;
    	cursor:pointer;
    		
    }

    nav{
        width:100%;
        height:70px;
        background-color: #f76d04;
    }
    select{
    	background: #FFFFFF;
    	border:none;
    	color: black;
    	padding:10% 10%;
        margin:auto;
    	text-align:center;
    	text-decoration: none;
    	display: block;
    	font-size:100%;
    }

    ul.redes{
        position: absolute;
        top: 1105%;
        left: 10%;
        transform: translate(-50%, -50%);
        margin: 0;
        padding: 0;
        display: flex;
    }

    a{
        text-decoration: none;
    }

    ul.redes li.cuadrado{
        position: relative;
        list-style: none;
        margin: 0 2px;
    }

    ul.redes li.cuadrado:before{
        content: '';
        position: absolute;
        left: 0;
        bottom: -4px;
        width: 40px;
        background: #000000;
        border-radius: 50%;
        transition: 0.5s;
        opacity: 0; 
        filter: blur(2px);
        transform: scale(0.8);
    }

    ul.redes li.cuadrado:hover:before{
        transition-delay: 0.2s;
        opacity: 0.2;
        transform: scale(1);
    }

    ul.redes li.cuadrado a{
        width: 40px;
        height: 40px;
        display: block;
        transition: 0.5s;
        background: #ccc;
    }

    ul.redes li.cuadrado:hover a{
        transform: translateY(-10px);
    }

    ul.redes li.cuadrado a span{
        width: 100%;
        height: 100%;
    }

    ul.redes li.cuadrado a span:before{
        font-family: fontAwesome;
        text-align: center;
        line-heigth: 40px;
        position: absolute;
        top: 30%;
        left: 0%; 
        width: 100%;
        height: 100%;
        backgroud: #fff;
        color: #262626;
        transform-origin: top;
        transition: transform 0.5s;
    }

    ul.redes li.cuadrado:hover a span:before{
        transform: rotateX(90deg) translateY(-50%);
    }

    ul.redes li.cuadrado a span:after{
        font-family: fontAwesome;
        text-align: center;
        line-heigth: 40px;
        position: absolute;
        top: 0;
        left: 0; 
        width: 100%;
        height: 100%;
        backgroud: #fff;
        color: #fff;
        transform-origin: bottom;
        transition: transform 0.5s;
        transform: rotateX(90deg) translateY(50%);
    }

    ul.redes li.cuadrado:hover a span:after{
        transform: rotateX(0deg) translateY(0);
    }

    ul.redes li.cuadrado:nth-child(1) a span:before, 
    ul.redes li.cuadrado:nth-child(1) a span:after{
        content:'\f09a';
    }

    ul.redes li.cuadrado:nth-child(2) a span:before, 
    ul.redes li.cuadrado:nth-child(2) a span:after{
        content:'\f099';    
    }

    ul.redes li.cuadrado:nth-child(3) a span:before, 
    ul.redes li.cuadrado:nth-child(3) a span:after{
        content:'\f0d5';
    }

    ul.redes li.cuadrado:nth-child(4) a span:before, 
    ul.redes li.cuadrado:nth-child(4) a span:after{
        content:'\f0e1';
    }

    ul.redes li.cuadrado:nth-child(5) a span:before, 
    ul.redes li.cuadrado:nth-child(5) a span:after{
        content:'\f16d';
    }

    ul.redes li.cuadrado:nth-child(1) a span:after{
        background: #3b5999;
    }

    ul.redes li.cuadrado:nth-child(2) a span:after{
        background: #55acce;
    }

    ul.redes li.cuadrado:nth-child(3) a span:after{
        background: #dd4b39;
    }

    ul.redes li.cuadrado:nth-child(4) a span:after{
        background: #0077b5;
    }

    ul.redes li.cuadrado:nth-child(5) a span:after{
        background: #e4405f;
    }
</style>