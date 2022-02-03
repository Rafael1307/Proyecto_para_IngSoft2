<?php
	date_default_timezone_set('America/Mexico_City');
	$link = mysqli_connect("localhost", "root", "", "ab_model") or die ("<h3> Error de conexion </h3>");

  //*****Strings para realizar querys en la base de datos
	$command = "SELECT NumMesa FROM mesa where AtencionMesero = ?";
	$command2 = "SELECT COUNT(*) FROM pedido where Mesa = ? AND Status= 0";
    //****

  //Enlazar conexión con la base de datos con un query.
	$query = $link->prepare($command);
	$query2 = $link->prepare($command2);
	unset($array);

  //Inicio de sesión.
	session_start();

  error_reporting(0);

  //************IMPORTANTE

	$_SESSION['correo_mesero']; //Se debe de haber iniciado sesión en la página de login, si no marcará error.

  //**************

	$_SESSION['control'] = 0;
	$_SESSION['inicio'] = "9999-01-01";
	$_SESSION['mesa'] = -1;
	
?>

<!DOCTYPE html>
<html lang="es">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <head>
    <meta charset="UTF-8">
    <title>Vista Mesas</title>

    <link href = "/ab_model/css/vista_mesas.css" rel="stylesheet" type="text/css">
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
    	 <div id = "gran_contenedor">
      <div id = "titulo_tabla">
        <h2>Tabla de mesas</h2>
      </div>
      <table class = "mesa">

<?php
        //A partir del correo ubicado en SESSION, se obtiene la información por medio de los querys.


      	$query->bind_param("s", $_SESSION['correo_mesero']);

      	if($query->execute()){
      		$result = $query->get_result();
      		
      	while($valores_mesas = $result->fetch_array(MYSQLI_NUM)){
      		echo '<tr>
      				<th> Id de Mesa</th>
      				<td>'.$valores_mesas[0].'</td>
      				</tr>
      				<tr>
      				<th>Notificaciones</th>';

      		$query2->bind_param("i", $valores_mesas[0]);

      		if($query2->execute()){
	      		$result_2 = $query2->get_result();

	      		$valor_notificacion = $result_2->fetch_array(MYSQLI_NUM);

      			if($valor_notificacion[0] > 0){
      				echo '<td class="col_derecha"><img class="imagen_tabla" src="../img/advertencia_naranja.png"></td>
      				</tr>
      				<tr>
			          <th><button>Pedidos</button></th>
			          <th><button>Cuenta</button></th>
			        </tr>
			        <tr>
			          <td class = "especial"></td>
			        </tr>';
      			}
      			elseif ($valor_notificacion[0] == 0) {
      				echo '<td class="col_derecha">-</td>
      				</tr>
      				<tr>
			          <th><button>Pedidos</button></th>
			          <th><button>Cuenta</button></th>
			        </tr>
			        <tr>
			          <td class = "especial"></td>
			        </tr>';
      			}
      		}
      	}
      	}
      	
?>

      </table>
      <div id= "boton_final">
        <button id="tradicional"><a href="mesas.php">Hacer pedido Tradicional</a></button>

      </div>
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
  #gran_contenedor{
  padding-bottom: 100%;
  float: left;
  width: 100%;
  margin-top: 53px;
  background-color: rgb(199, 226, 246);
    background-image: url("../img/relajado.jpg");
    background-repeat: repeat;
}
.mesa{
  width: 100%;
  padding: auto;
  align-items: center;

}
th{
  text-align: center;
  background-color: rgb(199, 246, 219);
  font-size: 20px;
  border-style: solid;
  border-color: green;
  border-width: 1px;
}
td{
  height: 30px;
  font-size: 16px;
  text-align: center;
  background-color: rgb(246, 243, 199);
  border-style: solid;
  border-color:  beige;
  border-width: 1px;
}
.especial{
  height: 15px;
  background-color: transparent;
  border-width: 0px;
}
th button{
  font-size: inherit;
  padding: inherit;
  height: 100%;
  width: 100%;
  border-width: 1px;
}

th button:hover{
  background-color: lightgray;
  opacity: .8;
}

.imagen_tabla{
  width: 26px;
  height: 26px;
  animation-duration: 2s;
  animation-name: slidein;
  animation-iteration-count: infinite;
  animation-direction: alternate;
}
@keyframes slidein{
  from{
    width: 26px;
    height: 26px;
  }
  to{
    margin-right: 3px;
    margin-top: 3px;
    width: 22px;
    height: 22px;
  }
}
h2{
  padding: 2px;
  font-size: 27px;
  text-align: center;
}

#titulo_tabla{
  border-style: solid;
  border-width: 3px;
  background-color:  lightblue;
  
}

#boton_final{
  float: left;
  width: 100%
}
#tradicional{
  background-color: lightyellow;
  width: 96%;
  padding-top: 2px;
  padding-bottom: 2px;
  margin-left: 2%;
  text-align: center;
  font-size: 20px;
}
</style>