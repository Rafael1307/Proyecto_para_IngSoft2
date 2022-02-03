<?php 
session_start();
$conexion=mysqli_connect("localhost","root","","ab_model");

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript">
		function regresar() {
			history.go(-1);
		}
	</script>
</head>
	<body>
		<nav><center>
			<button onclick="regresar()">Seguir pidiendo</button>
		</center></nav>
		<table>
			<tr>
				<th>Platillo</th>
				<th>Cantidad</th>
				<th>Total</th>
				<th></th>
			</tr>
			 <?php 
			 $mesa = $_SESSION['MesaC'];
			 $consulta = "SELECT * FROM pedido_temporal LEFT JOIN platillo ON pedido_temporal.Platillo = platillo.ID_platillo WHERE Mesa = $mesa";
			 $resultado= mysqli_query($conexion,$consulta);
			 while($Mostrar=mysqli_fetch_array($resultado)){
 ?>
 			<tr>
 				<td><?php echo $Mostrar['Nombre']; ?></td>
 				<td><?php echo $Mostrar['Cantidad']; ?></td>
 				<td>$<?php echo $Mostrar['Cantidad'] * $Mostrar['Precio']; ?></td>
 				<td>
                    <form method="POST" action="eliminar_temp.php">
                        <aside style="display: none;">
                            <input type="number" name="mesa" value="<?php echo $Mostrar['Mesa']; ?>">
                            <input type="number" name="cantidad" value="<?php echo $Mostrar['Cantidad']; ?>">
                            <input type="text" name="platillo" value="<?php echo $Mostrar['Platillo']; ?>">
                        </aside>
                        <button type="submit">ELIMINAR</button>
                    </form>           
                </td>
 			</tr>
 		<?php } ?>
		</table>
		<nav><center><a href="terminar.php"><button>Terminar Pedido</button></a></center></nav>
	</body>
</html>
<style type="text/css">
	    *{
    		margin: 0%;
    		padding: 0%;
    	}

    body{ background: #f5db64;}
        table{
    	border:4px solid #FFFFFF;
    	width:100%;
    	height:auto;
    	position:relative;
    	bottom: 3%;
    	border-spacing:0;

    }
    table td{
    	border:2px solid #974405 ;
    	font-size: 130%;
    	text-align:center;
    	width:auto;
	
    }
    nav, footer{
    	width:100%;
    	height: 80px;
    	background: #974405;
    }
    button{
    	 background-color: #f5db64;
    border: none;
    padding: 10px 12px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    margin: 10px 1px;
    cursor: pointer;
    }
</style>