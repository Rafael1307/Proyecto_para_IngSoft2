<?php 
error_reporting(0);
	$link = mysqli_connect("localhost", "root", "", "ab_model");
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<style type="text/css">
		*{
  margin: 0;
  padding: 0;
}

body{
  background:url("../IMG/relajado.jpg");
  width: 100%;
}
article{
	width: 100%;
	margin-top: 100px;
}
nav{
	position: fixed;
  width: 100%;
  height: 60px;
  background:aqua;
  text-align: center;
  float: left; 
  margin-top: -100px;
}
nav ul {
    list-style: none;
    padding-right: 20px;
  }
  
    nav ul li {
      display: inline-block;
      line-height: 60px;
    }
      
      nav ul li a {
        color: black;
        display: block;
        padding: 0 10px;
        text-decoration: none;
      }
      
        nav ul li a:hover {
          color: black;
          background: white;
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
		button#next{
		  margin-top: 10px;
		  margin-left: 20%;
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

		button{
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
	<nav>
		<ul>
			<li><a href="pedidos.php">Pedidos</a></li>
      <li><a href="CRUD_clientes.php">Clientes</a></li>
      <li><a href="CRUD_meseros.php">Meseros</a></li>
      <li><a href="existencia.php">Existencia</a></li>
      <li><a href="mesasFull.php">Mesas</a></li>
      <li><a href="LogOutA.php">Cerrar Sesion</a></li>
		</ul>
	</nav>
	<article>
	<table>
		<tr>
			<form method="GET">
				<td>
					<select name="pd">
						<option value="">Ver todos</option>
						<?php
							$sql = "SELECT * FROM mesa";
							$resultado = mysqli_query($link,$sql);

							while ($mostrar=mysqli_fetch_array($resultado)) {
						?>
						<option value="<?php echo $mostrar['NumMesa']; ?>"><?php echo $mostrar['NumMesa']; ?></option>
					<?php } ?>
					</select>
				</td>
				<td>
					<button type="submit">MOSTRAR</button>
				</td>
			</form>
		</tr>
	</table>
	<table>
		<tr>
			<th>Mesa</th>
			<th>Clave</th>
			<th>Cliente</th>
			<th>Mesero</th>
		</tr>
		<?php
		$idtemp = $_GET['pd'];
			$sql = "SELECT * FROM mesa WHERE NumMesa LIKE '$idtemp%'";
			$resultado = mysqli_query($link,$sql);
			while ($mostrar=mysqli_fetch_array($resultado)) {
		?>
		<tr>
			<td><?php echo $mostrar['NumMesa']; ?></td>
			<td><?php echo $mostrar['Clave']; ?></td>
			<td><?php echo $mostrar['OcupacionCliente']; ?></td>
			<td><?php echo $mostrar['AtencionMesero']; ?></td>
		</tr>
	<?php } ?>
	</table>
</article>
</body>
</html>