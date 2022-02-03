<?php
error_reporting(0);
	date_default_timezone_set('America/Mexico_City');
	$link = mysqli_connect("localhost", "root", "", "ab_model") or die ("<h3> Error de conexion </h3>");

 //*****Strings para realizar querys en la base de datos
	$command = "SELECT NumMesa FROM mesa";
	$command2 = "SELECT Nombre, ID_platillo FROM platillo";
	$command3 = "SELECT Platillo, Cantidad FROM pedido WHERE Mesa = ? AND Fecha = ? AND Hora = ?";
	$command4 = "SELECT Nombre FROM platillo where ID_platillo = ?";

	//Considerando eliminación / aceptación de valores nulos en ID, Cliente y Total en pedido:
	$command5 = "INSERT INTO pedido (Mesa, Platillo, Cantidad, Status, Fecha, Hora) VALUES 
	 (?, ?, ?, 0, ?, ?)";
	$command6 = "UPDATE pedido SET Cantidad = ? WHERE Platillo = ?";
	$command7 = "SELECT Cantidad, COUNT(*) FROM pedido WHERE Mesa = ? AND Fecha = ? AND Hora = ? AND Platillo = ?";
	$command8 = "DELETE FROM pedido where Mesa = ? AND Platillo = ? AND Fecha = ? AND Hora = ?";
  //****

  //Enlazar conexión con la base de datos con un query.
	$query = mysqli_query($link, $command);
	$query2 = mysqli_query($link, $command2);
	$query3 = $link->prepare($command3);
	$query4 = $link->prepare($command4);
	$query5 = $link->prepare($command5);
	$query6 = $link->prepare($command6);
	$query7 = $link->prepare($command7);
	$query8 = $link->prepare($command8);
	

	unset($array);
	//Iniciar sesión. Debe de haberse iniciado desde vistas.php
	session_start();
	$_SESSION['inicio'];
	$_SESSION['control'];
	$_SESSION['mesa'];

  //Asignar un valor imposible para manejar la hora actual, mientras $_SESSION['control'] esté en 0, no va a acceder a la información. 

	if($_SESSION['control'] == 0){
		$_SESSION['inicio'] = "23:59";
	}

?>


<!DOCTYPE html>
<html lang="es">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <head>
     <!-- Versión del toggle desfazado.

   <input type="checkbox" id="btn-nav" class="checkbox">
    <header>
      <div class="header-container">
        <label for="btn-nav" class="btn-label">
          <div class="header-button"></div>
        </label>
      </div>
    </header>
    
    <nav class="menu">
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Contacto</a></li>
      </ul>            
    </nav> 


  -->
    <meta charset="UTF-8">
    <title>Administrar mesas</title>

    <link href = "/ab_model/css/mesas.css" rel="stylesheet" type="text/css">

  </head>
  <body>
    <input type="checkbox" id="btn-nav" class="checkbox">
    <header>
      <div class="header-container">
        <label for="btn-nav" class="btn-label">
          <div class="header-button"></div>
        </label>
      </div>
    </header>

  <nav class="menu">
    <ul>
 <li><a href="vista_mesas.php">Administrador</a></li>
        <li><a href="aceptar_pedidos.php">Pedidos</a></li>
        <li><a href="pre_cuenta.php">Cuentas</a></li>
        <li><a href="logOutM.php">Cerrar Sesion</a></li>
    </ul>
  </nav>

<article id="menu"></article>
  	<div id = "gran_contenedor_2">

    <div id="seleccion_mesa">
      <p class="administrar_mesas">Selecciona la mesa: </p>

      <form action="mesa_orden_trad.php" id="form_1" method ="POST">
      	
      <select class="input_position" name= "select_mesa">
      	<option value= "0" >Seleccione</option>
      	<?php 
      	while($valores_mesa = mysqli_fetch_array($query)){
      		echo '<option value = "'.$valores_mesa[NumMesa].'">'.$valores_mesa[NumMesa].'</option>';
      		}
      	?>
       </select> 
    </div>

      <div id = "contenedor_tabla">
  <table class="tabla_general">
    <tr>
      <td>
         <table id = "cabecera">
           <tr>
              <th>Platillo</th>
              <th>ID</th>
           </tr>
         </table>
      </td>
    </tr>
    <tr>
      <td>
         <div id = "tabla_menu">
           <table class="tabla_general">
	           	<?php
	      			while($valores_platillo = mysqli_fetch_array($query2)){
	      			echo '
	      					<tr>
	     					<td class = "td_borde">'.$valores_platillo['Nombre'].'</td>
	      					<td class = "td_borde">'.$valores_platillo['ID_platillo'].'</td>
	      					</tr>
	      					';
	      			}
	      		?>
           </table>  
         </div>
      </td>
    </tr>
  </table>
  
  </div>
  <div id = "id_producto">
    <p class = "administrar_mesas">Id del platillo: </p>
    <input id = "id_p" class="input_position" type="text" name="id_producto_pedido">
  </div>
  <div id = "prod_cantidad">
    <p class = "administrar_mesas">Cantidad: </p>
    <input class="input_position" type="number" name="prod_cantidad", max ="30", min="1">
  </div>
  <div id = "agregar">
    <button id="boton_agregar" name="boton_agregar" onclick="add()">Agregar</button>
  </div>
  <div id = "eliminar">
    <button id = "boton_eliminar" name="boton_eliminar" >Eliminar</button>
  </div>
  <div id = "eliminar">
    <!-- 
      Botón extra. Funcionalidad extra. No integrado.

      <button id = "boton_limpiar" name="Limpiar" >Limpiar tabla</button> 

    -->
  </div>
</form>



  <div id = "contenedor_tabla">
  <table class="tabla_general">
    <tr>
      <td>
         <table id = "cabecera">
           <tr>
              <th>Platillo</th>
              <th>Cantidad</th>
           </tr>
         </table>
      </td>
    </tr>
    <tr>
      <td>
         <div id = "tabla_menu">
           <table class="tabla_general">

            <!-- Tabla para ver los pedidos realizados en determinada hora -->
           	<?php
           		$fecha =  date("Y-m-d");
           		$query3->bind_param("iss", $_SESSION['mesa'], $fecha, $_SESSION['inicio']);
           		if($query3->execute()){
           			$resultado_pedidos = $query3->get_result();
           			while($tabla_valores = $resultado_pedidos->fetch_array(MYSQLI_NUM)){
           				$query4->bind_param("s", $tabla_valores[0]);
           				if($query4->execute()){
           					$res = $query4->get_result();
           					$nombre_platillo = $res->fetch_array(MYSQLI_NUM);
	           				echo '
	           				<tr>
	           					<td class = td_borde>'.$nombre_platillo[0].'</td>
	           					<td class = td_borde>'.$tabla_valores[1].'</td>
	           				</tr>';
	           			}
           			}

           		}
           	?>
           </table>  
         </div>
      </td>
    </tr>
  </table>
  </div>
  
  <form action="mesa_orden_trad.php" method="POST">
  <div id = "finalizar">
   <button id = "boton_finalizar" name="boton_finalizar">Finalizar Pedido</button>
  </div>
</form>

</div>
</body>
</html>
<style type="text/css">
      * {
  margin: 0;
  padding: 0;
}

.checkbox {
  display: none;
}
header {
  background-color: aqua;
  position: fixed;
  width: 100%;
  margin-top: -10px;
  z-index: 10;
}
.header-container {
  width: 90%;
  position: relative;
  margin: 1rem auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
  float: right;
}
.header-logo {
  width: 3rem;
}
.btn-label {
  width: 2rem;
  height: 1.4rem;
}
.header-button {
  width: 2rem;
  height: 0.3rem;
  background: #000;
  position: absolute;
  top: .5rem;  
  transition: all 0.2s;
}
.header-button::before,
.header-button::after {
  content: "";
  width: 2rem;
  height: 0.3rem;
  background: #000;
  position: absolute;
  top: -0.4rem;
  transition: all 0.2s;
}
.header-button::after {
  top: 0.4rem;
}
.menu {
  background: red;
  width: 100%;
  height: 13rem;
  position: fixed;
  z-index: 9;
  top: -12rem;
  display: flex;
  flex-direction: column;
  justify-content: space-around;
  text-align: center;
  padding-top: 2rem;
  transition: all 0.5s;
}

.menu ul {
  list-style: none;
}

.menu ul a{
  text-decoration: none;
}
  
.menu ul li a{
  color: black;
  font-weight: bold;
  display: block;
  line-height: 40px;
}
    
.menu ul li a:hover{
  background: white;
}
.checkbox:checked ~ .menu {
  background: blue;
  top: 0rem;
}
.checkbox:checked + header .header-container label .header-button {
  background: none;
}
.checkbox:checked + header .header-container label .header-button::before {
  transform: rotate(35deg);
  top: 0;
}
.checkbox:checked + header .header-container label .header-button::after {
  transform: rotate(-35deg);
  top: 0;
}
article#menu{
  width: 100%;
  margin-top: 10px;
}
  .tabla_general{
  float: left;
  width: 100%;
  padding: auto;
  align-items: center;
  border-color: black;
  background-color: transparent;
}
#tabla_menu{
  float: left;
  width:100%;
   height:auto;
   overflow:auto;
     background-color: transparent;
}
#gran_contenedor_2{
  padding-bottom: 100%;
  float: left;
  width: auto;
  background-color: rgb(199, 226, 246);
  background-image: url("../img/relajante.jpg");
  margin-left: -7px;
}
#cabecera{
  float: left;
  width: 100%;
  padding: auto;
  align-items: center;
    background-color: transparent;
}
#contenedor_tabla{
  width: 100%;
  float: left;
  margin-top: 10px;
}
#seleccion_mesa{
  float: left;
  width: 70%;
  margin-left: 20%;
  margin-top: 73px;
  font-size: 15px;
}

.administrar_mesas{
  float: left;
  font-size: 17px;
}

.input_position{
  float: left;
  margin-top: 16px;
  margin-left: 10px;
}
.input_position_2{
  float: left;
  margin-top: 16px;
  margin-left: 10px;
  width: 15%;
}

#id_producto{
  width: 77%;
  float: left;
  margin-top: 10px;
  margin-left: 23%;
}
#id_p{
  width: 25%;
}
#prod_cantidad{
  width: 70%;
  margin-left: 30%;
  float: left;
  margin-top: 10px;
}
#agregar{
  float: left;
  margin-top: 10px;
  margin-left: 25%
}
#eliminar{
  float: right;
  margin-top: 10px;
  margin-right: 25%;
}

#finalizar{
  float: left;
  margin-top: 15px;
  margin-left: 40%;
}
#boton_agregar{
  height: 45px;
  width: 80px;
  font-size: 15;
  background-color: rgb(127,221,97);
  color: white;
  border-color: rgb(67, 190, 22);
}
#boton_eliminar{
  height: 45px;
  width: 80px;
  font-size: 15;
  background-color: rgb(234, 85, 68);
  color: white;
  border-color: rgb(195, 54, 38);
}
#boton_finalizar{
  height: 45px;
  width: 80px;
  font-size: 15;
  background-color: rgb(23, 174, 133);
  color: black;
  border-color: rgb(23, 174, 57);
}
body{
  width: 100%;
  height: 100%;
}

.td_borde{
  background-color: rgb(179, 240, 246);
  padding: 2px;
  width: 50%;
  border-style: solid;
  border-color: lightblue;
  border-width: 1px;
  text-align: center;
}
th{
  background-color: rgb(71, 166, 178);
  padding: 2px;
  width: 50%;
  border-style: solid;
  border-color: rgb(42, 133, 165);
  border-width: 1px;
  text-align: center;
}
</style>
