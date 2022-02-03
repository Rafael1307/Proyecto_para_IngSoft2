<?php
  date_default_timezone_set('America/Mexico_City');
  $link = mysqli_connect("localhost", "root", "", "ab_model") or die ("<h3> Error de conexion </h3>");

  $command = "SELECT Nombre, Correo FROM mesero where Correo = ?";
  $command2 = "SELECT COUNT(*) FROM mesa where NumMesa = ?";
  $command3 = "UPDATE mesa SET AtencionMesero = ? WHERE NumMesa = ?";
  $command4 = "SELECT NumMesa FROM mesa where AtencionMesero = ?";
  $command5 = "INSERT INTO mesa VALUES (?, ?, NULL, ?)";
  $command6 = "UPDATE mesa SET AtencionMesero = NULL WHERE NumMesa = ? AND AtencionMesero= ?";
  $command7 = "DELETE FROM pedido where Mesa = ?";
  $command8 = "DELETE FROM mesa where NumMesa = ?";


  $query =  $link->prepare($command);
  $query2 = $link->prepare($command2);
  $query3 = $link->prepare($command3);
  $query4 = $link->prepare($command4);
  $query5 = $link->prepare($command5);
  $query6 = $link->prepare($command6);
  $query7 = $link->prepare($command7);
  $query8 = $link->prepare($command8);


  session_start();
  $_SESSION['Correo_empleado'];
?>

<!DOCTYPE html>
<?php
    
  if(isset($_POST['guardar_cliente'])){
    $correo = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    $nombre = $_POST['nombre'];
    $apeP = $_POST['apellidoP'];
    $apeM = $_POST['apellidoM'];
    $antiguo_correo =  $_SESSION['Correo_empleado'];
 
    $query3->bind_param('ssssss', $correo, $contrasena, $nombre, $apeP, $apeM, $antiguo_correo);

    if($query3->execute()){
      echo '<script type="text/javascript">
            alert("Se han guardado los cambios");</script>';

  }
  else{
    echo $query3->last_error();
  }
  
}

if(isset($_POST['eliminar'])){
  $query6->bind_param("ss", $_POST['id_mesa'], $_SESSION['Correo_empleado']);

  if($query6->execute()){
         echo '<script type="text/javascript">
              alert("Se ha eliminado correctamente");</script>';
              header('Location: CRUD_meseros.php');
  }
}

  if(isset($_POST['salir'])){
    header('Location: CRUD_meseros.php');
  }
  if(isset($_POST['asignar'])){
    $query2->bind_param("s", $_POST['id_mesa']);
    if($query2->execute()){
      $result_num = $query2->get_result();
      $num = $result_num->fetch_array(MYSQLI_NUM);
      if($num[0] != 0){
        $query3->bind_param("ss", $_SESSION['Correo_empleado'], $_POST['id_mesa']);
        if($query3->execute()){
          echo '<script type="text/javascript">
              alert("Nueva relación mesero-mesa");</script>';
        }
      }
      else{
        $a = rand(1000, 999999999);
        $query5->bind_param("sss", $_POST['id_mesa'], $a, $_SESSION['Correo_empleado']);
        if($query5->execute()){
          echo '<script type="text/javascript">
              alert("Nueva relación mesero-mesa");</script>';
        }
      }
    }
  }

if(isset($_POST['eliminar_mesa'])){
  $query7->bind_param("s", $_POST['id_mesa']);
  if($query7->execute()){
    $query8->bind_param("s", $_POST['id_mesa']);
    if($query8->execute()){
      echo '<script type="text/javascript">
              alert("Se ha eliminado la mesa");</script>';
    }
  }
}
?>
<html lang="es">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <head>
    <meta charset="UTF-8">

    <!-- <link rel="stylesheet" href="main.css"> -->

    <!--<link rel="stylesheet" type="text/css" href="CRUD.css"> -->
    <script type="text/javascript" src="CRUD.js"></script>

    <title>Sistema de gestión de meseros</title>
  </head>

  <!--  <input type="checkbox" id="btn-nav" class="checkbox">
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
    </nav> -->
<link href = "/ab_model/css/asignar.css" rel="stylesheet" type="text/css">
</head>

<div id ="modal_agregar_relacion" class="modal">
        <div class="modal_contenido">

          <div class ="cabecera_modal">
          <h2 class="titulo_modal_new">Asignaciones mesero-mesa</h2>
        </div>

         <div class = "contenedor_tabla_pequeno">
          <table class="tabla_general" id = "cabecera_tabla_mesas">
    <tr>
      <td>
           <tr>
              <?php 
                  $query->bind_param("s", $_SESSION['Correo_empleado']);
                  if($query->execute()){
                    $resultado = $query->get_result();
                    $empleado = $resultado->fetch_array(MYSQLI_NUM);
                    echo '<th class= "th_meseros">'.$empleado[0]." ".$empleado[1].'</th>';
                  }
               ?>
           </tr>
      </td>
    </tr>
    <tr>
            <?php 
              $query4->bind_param("s", $_SESSION['Correo_empleado']);
              if($query4->execute()){
                $result_mesas = $query4->get_result();
                while($valor = $result_mesas->fetch_array(MYSQLI_NUM)){
                  echo '
                      <tr>
                        <td class="td_mesero">'.'Mesa: '.$valor[0].'</td>
                        </tr>
                  ';
                }
              }
            ?>
             
           </div> 

           <form id ="form" method="POST">
    </tr>
  </table>
</div>
          <div class="renglon">
            <br>
            <br>

          <div class = "columna">
            <p class="p_modal">ID de mesa: </p>
            <input id="id_mesa_asignar" class= "text_modal" type="text" name="id_mesa">
          </div>
        </div>


            <div class="renglon" id="more_margin2">

           <div class="columna">                      
            <button name="eliminar" class="boton_dialogo_in" id="eliminar_relacion" onclick="eliminarRelacion('modal_update_mesero')">Eliminar asginación</button>
           </div>

           <div class="columna">

             <button name="asignar" class="boton_dialogo_in" id="agregar_relacion" onclick="asignaMesa()">Asignar</button>
             
           </div>

           <div class="columna">
             <button name="salir" class="boton_dialogo_in" id="salir_emp_asignar" onclick="cerrarDialogo('modal_agregar_relacion')">Salir</button>
           </div>

           <div class="columna">
             <button name="eliminar_mesa" class="boton_dialogo_in" id="salir_emp_asignar">Eliminar Mesa</button>
           </div>
        </div>
      </form>

    </div>
  </body>
  </html>
  <style type="text/css">
    body{
  height: 25%;
}

header{
  position: fixed;
  width: 100%;
  height: 60px;
  background-color: aqua;
}
article{
  height: 60px;
  width: 100%;
}
#m_header{
  height: 60px;
  width: 100%;
}
#superior{
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
  margin-left: 50%;
    list-style: none;
    padding-right: 20px;
  }
  
    nav ul li {
      display: inline-block;
      line-height: 60px;
    }
      
      nav ul li a {
        color: black;
        font-weight: normal;
        display: block;
        padding: 10px;
        text-decoration: none;
         font-family: "Times New Roman";
           font-size: 15px;
      }
      
        nav ul li a:hover {
          color: black;
          background: white;
          font-family: "Times New Roman";
           font-size: 17px;
        }
p{
  
}
#gran_contenedor3{
  padding-bottom: 100%;
  float: left;
  height: 100px;
  width: 100%;
  background-color: rgb(245, 207, 131);
  text-align: center;
}
#gran_contenedor4{
  padding-bottom: 100%;
  float: left;
  height: 100px;
  width: 100%;
  background-color: rgb(251, 242, 210);
  text-align: center;
}
#tabla_meseros{
  float: left;
  width:100%;
   height:40%;
   overflow:auto;
     background-color: transparent;
}
.boton_dialogo{
  margin-top: 5%;
  float: center;
  padding: 13px;
  width: 27%;
  height: 20%;
  font-size: 15px;
  border-radius: 12px;
  border-width: 1px;
}
}
dialog{
  position: fixed;
  height: 75%;
  width: 75%;
  background-color: white;
  border-color: red;
  border-width: 1px;
  border-radius: 8px;
}
.modal {
  text-align: left;
  position: fixed; 
  z-index: 1; 
  padding-top: 50px; 
  left: 0;
  top: 0;
  width: 100%; 
  height: 100%; 
  overflow: auto; 
  background-color: rgba(0,0,0,0.4);
}
.modal_2 {
  text-align: left;
  position: fixed; 
  display: none;
  z-index: 1; 
  padding-top: 100px; 
  left: 0;
  top: 0;
  width: 100%; 
  height: 100%; 
  overflow: auto; 
  background-color: rgba(0,0,0,0.4);
}

.modal_contenido {
  text-align: left;
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border-width: 1px;
  border-style: solid;
  border-color:  #888;
  width: 60%;
  height: 77%;
  overflow: auto;
  border-radius: 12px;
}
.modal_cont_cliente {
  text-align: center;
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border-width: 1px;
  border-style: solid;
  border-color:  #888;
  width: 80%;
  height: 800px;
  overflow: auto;
  border-radius: 12px;
}
.titulo_dialogo{
  float: left;
  font-size: 20px;
  color: black;
  text-align: center;
  padding-bottom: 15px;
}

.p_modal{
  float: left;
  margin: 2px; 
  margin-left: 10px;
}
.text_modal{
  float: left;
  width: 51%;
  text-align: center;
  margin-bottom: 1%;
}

.fecha_modal{
  float: left;
  width: 45%;
  height: 30px;
  margin-left: 9px;
}
.renglon{
  float: left;
  margin-top: 1%;
  width: 100%;
  height: 20%;
  text-align: center;
}

.columna{
  margin-left: 2px;
  float: left;
  height: 100%;
  width: 33%;
}

.columna_renglon{

  width: 90%
  margin-top: 0%;
  margin-left: 3%;
  float: left;
}

.boton_modal_2{
  margin-top: 14%;
  width: 25%;
  height: 15%;
}
#boton_izq{
  float: left;
  margin-left: 3%;
}
#boton_der{
  float: right;
  margin-right: 3%;
}

#checkbox_mod{
  float: left;
}


.cabecera_modal{
  width: 100%;
  padding: 2px;
  background-color: beige;
}

.block_checkbox{
  float: left;
  width: 100%;
  margin-top: 4%;
  margin-bottom: 4%;
}
.boton_dialogo_in{
  margin-top: 5%;
  height: 45%;
  width: 50%;
  font-size: 14px;
  border-radius: 8px;
  border-width: 1px;
}
.boton_dialogo_in2{
  margin-top: 5%;
  height: 40px;
  width: 25%;
  font-size: 15px;
  border-radius: 8px;
  border-width: 1px;
}


.th_meseros{
  height: 12%;
  width: 45%;
  text-align: center;
  padding: auto;
  font-size: 15px;
}

#cabecera_meseros{
  border-radius: 15px;
  margin-top: 10%;
  table-layout: fixed;
  text-align: center;
  align-items: center;
  padding:3px;
  font-size: 24px;
  background-color: rgb(250, 182, 130);
}
#cabecera_clientes{
  border-radius: 15px;
  margin-top: 10%;
  table-layout: fixed;
  text-align: center;
  align-items: center;
  padding: 3px;
  font-size: 24px;
  background-color: rgb(232, 202, 88);
}

#cabecera_clientes_inner{
  width: 60%;
  margin-top: 1%;
  margin-left: 20%;
  border-radius: 15px;
  table-layout: fixed;
  text-align: center;
  align-items: center;
  font-size: 15px;
  background-color: rgb(232, 202, 88);
}
#cabecera_tabla_mesas{
  border-radius: 15px;
  margin-top: 10%;
  table-layout: fixed;
  text-align: center;
  align-items: center;
  padding: 3px;
  font-size: 24px;
  background-color: rgb(251, 196, 153);
  float:left;
}
.td_mesero{
  height: 12%;
  width: 45%;
  text-align: center;
  background-color: beige;
  padding: auto;
  font-size: 19px;
}
.td_cliente{
  height: 12%;
  width: 45%;
  text-align: center;
  background-color: rgb(245, 233, 189);
  padding: auto;
  font-size: 19px;
}

.contenedor_tabla{
  width: 70%;
  margin-left: 15%
}
.contenedor_tabla_pequeno{
  width: 20%; 
  height: 22%;
  margin-left: 40%

}
.tabla_general{
  table-layout: fixed;
  width: auto;

}

#boton_principal{
  width: 100%;
}

#titulo_seccion{
  width: 100%;
  background-color: rgb(250, 182, 130);
  padding-top: 2%;
  padding-bottom: 2%;
}
#vaciar_empleado{
  float: left;
}
#guadar_emp_new{
  float: right;
}
#id_emp_new_box{
  float: left;
  height: 75%;
  width: 100%;
}

#titulo_seccion_cliente{
  width: 100%;
  background-color: rgb(254, 225, 120);
  padding-top: 2%;
  padding-bottom: 2%;
}
#boton_izq_cliente{
  float: left;
  margin-left: 3%;
}
#boton_der_cliente{
  float: right;
  margin-right: 3%;
}
#eliminar_cliente{
  width: 30%;
  height: 30%;
  margin-top: 10%;
}
#id_cliente{
  height: 25%;
  float: left;

}
#id_cliente_box{
  height: 45%;
  width: 50%;
  margin-left: 4px;
  margin-top: 3%;
  font-size: 10px
}
#guardar_cliente{
  float: right;
}
#restablecer_cliente{
  float: left;
}
#id_cliente_new_box{
  float: left;
  height: 75%;
  width: 100%;
}

#vaciar_cliente{
  float: left;
}
#guadar_cliente_new{
  float: right;
}
#id_new_cliente_p{
  float: left;
  margin-right: 4%;
  height: 18;
  width: 10%;
}
#id_cliente_new{
  float: center;
  height: 25%;
  margin-right: 1%;
  width: 80%;
  margin-left: 4%;
}

  </style>