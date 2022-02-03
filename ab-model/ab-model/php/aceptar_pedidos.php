<?php
session_start();
	$mesero = $_SESSION['User'];
	$link = mysqli_connect("localhost", "root", "", "ab_model");
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
<meta charset="utf-8">
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
  margin-top: -100px;
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
  margin-top: 100px;
}
body{
  background:url("../IMG/relajado.jpg");
}
table {
		  font-family: Arial, Helvetica, sans-serif;
		  border-collapse: collapse;
		  width: 95%;
		  margin: auto;
		  margin-top: 15px;
		}
		table td, table th {
		  border: 1px solid #ddd;
		  padding: 8px;
		  text-align: center;
		}

		table tr{background-color: #f2f2f2;}

		table tr:hover {background-color: #ddd;}

		table th {
		  padding-top: 12px;
		  padding-bottom: 12px;
		  text-align: left;
		  background-color: #005757;
		  color: white;
		}
.mesa{
  width: 10%;
}
.eboton{
  width: 10%;
}
.aboton{
  background-color: #005757;
    border: none;
    color: white;
    padding: 6px 12px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    margin: 2px 1px;
    cursor: pointer;
}
	</style>
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
        <li><a href="#">Administrador</a></li>
        <li><a href="#">Pedidos</a></li>
        <li><a href="pre_cuenta.php">Cuentas</a></li>
        <li><a href="#">Cerrar Sesion</a></li>
      </ul>            
    </nav>

    <article id="menu"></article>
    <center>
     <table>
     	<tr>
	     	<th class="mesa">Mesa</th>
	    	<th>Pedido</th>
	    	<th>Cantidad</th>
	    	<th class="eboton">Aceptar</th>
	        <th class="eboton">Rechazar</th>
	    </tr>
	    <?php 
	    	$sql = "SELECT pedido.*, mesa.*, platillo.Nombre FROM pedido LEFT JOIN platillo ON pedido.Platillo = platillo.ID_platillo LEFT JOIN mesa on pedido.Mesa = mesa.NumMesa LEFT JOIN mesero ON mesa.AtencionMesero = mesero.Correo WHERE mesero.Correo = '$mesero' AND Status = 0";

	    	$resultado = mysqli_query($link,$sql);

			while ($mostrar=mysqli_fetch_array($resultado)) {
	     ?>
	    <tr>
	    	<td class="mesa"><?php echo $mostrar['Mesa']; ?></td>
          	<td><?php echo $mostrar['Nombre']; ?></td>
          	<td><?php echo $mostrar['Cantidad']; ?></td>

          	<td class="eboton">
          		<form method="POST" action="aceptar.php">
          			<aside style="display: none;">
          				<input type="number" name="pedido" value="<?php echo $mostrar['ID'] ?>">
          			</aside>
          			<button class="aboton" type="submit">ACEPTAR</button>
          		</form>
          	</td>
          	<td class="eboton">
          		<form method="POST" action="cancelar.php">
          			<aside style="display: none;">
          				<input type="number" name="pedido" value="<?php echo $mostrar['ID'] ?>">
          			</aside>
          			<button class="aboton" type="submit">CANCELAR</button>
          		</form>
          	</td>
	    </tr>
	<?php } ?>
     </table>
    </center>

</body>
</html>