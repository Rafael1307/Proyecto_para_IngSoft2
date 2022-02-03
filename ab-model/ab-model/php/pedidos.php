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
		*{
  margin: 0;
  padding: 0;
}

body{
  background:url("../IMG/relajado.jpg");
  width: 100%;
}

header{
  position: fixed;
  width: 100%;
  height: 60px;
  margin-top: -80px;
  background-color: aqua;
}
article{
  margin-top: 80px;
}
div{
  width: 20%;
  height: 100%;
  background: transparent;
  float: left;
}
nav{
  width: 79%;
  height: 100%;
  background:transparent;
  text-align: center;
  float: left; 
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
		.id-orden{
		  width: 8%;
		}
		.status{
		  font-weight: bold;
		}
	</style>
</head>
	
<body>
	<header>
	<nav>
		<ul>
			<li><a href="pedidos.php">Pedidos</a></li>
      <li><a href="CRUD_clientes.php">Clientes</a></li>
      <li><a href="CRUD_meseros.php">Meseros</a></li>
<li><a href="mesasFull.php">Mesas</a></li>
      <li><a href="existencia.php">Existencia</a></li>
      <li><a href="LogOutA.php">Cerrar Sesion</a></li>
		</ul>
	</nav>
</header>
<article>
	<table>
		<tr>
			<th>ID</th>
			<th>Platillo</th>
			<th>Cantidad</th>
			<th>Estado</th>
			<th>Preparar/Finalizar</th>
		</tr>
		<?php 
			$sql = "SELECT * FROM pedido LEFT JOIN platillo ON pedido.Platillo = platillo.ID_platillo WHERE Status < 3 AND Status > 0";

			$resultado = mysqli_query($link,$sql);

			while ($mostrar=mysqli_fetch_array($resultado)) {
		?>
		<tr style="background-color: <?php 
			if($mostrar['Status']==2)
				echo "yellow";
			elseif ($mostrar['Status']==3)
			 	echo "green";
			else
				echo "orange";
			?>
		">
			<td class="id-orden"><?php echo $mostrar['ID']; ?></td>
			<td><?php  echo $mostrar['Nombre'] ?></td>
			<td><?php  echo $mostrar['Cantidad'] ?></td>
			<td class="status"><?php  if ($mostrar['Status']==1)
				echo "Aceptado";
			elseif ($mostrar['Status']==2)
				echo "Preparando";
			?></td>
			<td>
				<form method="POST" action="actualizar_pedido.php">
					<aside style="display: none;">
						<input type="nnumber" name="id" value="<?php echo $mostrar['ID'] ?>">
					</aside>
					<input type="" name="" style="display: none;" value="">
					<button type="submit">Preparar/Finalizar</button>
				</form>
			</td>
		</tr>
		<?php } ?>
	</table>
</article>
</body>
</html>