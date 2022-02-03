 <?php 
 session_start();
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
			<li><a href="vista_mesas.php">Administrador</a></li>
        <li><a href="aceptar_pedidos.php">Pedidos</a></li>
        <li><a href="pre_cuenta.php">Cuentas</a></li>
        <li><a href="logOutM.php">Cerrar Sesion</a></li>
		</ul>
	</nav>
<article id="menu"></article>
<article>
	<table>
		<tr>
			<th colspan="3" >Mesa</th>
		</tr>
		<tr>
			<form action="cuenta.php" method="POST">
				<td colspan="2">
					<select name="mesa">
						<?php 
							$consulta = "SELECT * FROM mesa WHERE OcupacionCliente IS NOT NULL";

							$r = mysqli_query($link,$consulta);

							while ($m=mysqli_fetch_array($r)) {
						?>
						<option value="<?php echo $m['NumMesa']; ?>"><?php echo $m['NumMesa']; ?></option>
					<?php } ?>
					</select>


				</td>
				<td><button type="submit">Ver Cuenta</button></td>
			</form>
		</tr>
	</table>
</article>
</body>
</html>