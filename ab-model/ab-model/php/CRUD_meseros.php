<?php
  date_default_timezone_set('America/Mexico_City');
  $link = mysqli_connect("localhost", "root", "", "ab_model") or die ("<h3> Error de conexion </h3>");

  //*****Strings para realizar querys en la base de datos
  $command = "SELECT Nombre, Correo FROM mesero";
  $command2 = "SELECT * FROM cliente where Correo = ?";
  $command3 = "SELECT COUNT(*) FROM pedido where Mesa = ?";
  $command4 = "INSERT INTO mesero VALUES (?, ?, ?, ?, ?)";
  $command5 = "SELECT COUNT(*) FROM mesero where Correo = ?";

   //***

  //Enlazar conexión con la base de datos con un query.
  $query = mysqli_query($link, $command);
  $query2 = $link->prepare($command2);
  $query4 = $link->prepare($command4);
  $query5 = $link->prepare($command5);

  //Inicio de sesión.
  session_start();
  $_SESSION['Correo_empleado'] = 'ejemplo' ;
?>

<!DOCTYPE html>

<?php 

//Busca un cliente en específico. Se ubica por debajo de la declaración de html para permitir el cambio de header.

  if(isset($_POST['boton_buscar'])){
    $valorconsulta  = $_POST['correo_empleado'];

    $query5->bind_param("s", $valorconsulta);
    if($query5->execute()){
      $resultado = $query5->get_result();
      $comprobacion = $resultado->fetch_array(MYSQLI_NUM);
      if($comprobacion[0] == 1){
        $_SESSION['Correo_empleado'] = $valorconsulta;
        header('Location: ver_mesero.php');
      }
      else{
        echo '<script type="text/javascript">
            alert("No se ha encontrado mesero con ese correo.");</script>';
      }
    }
  }

  //Inserta un nuevo empleado en la base de datos.

  if(isset($_POST['guardar_emp_new'])){
    $correo = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    $nombre = $_POST['nombre'];
    $apeP = $_POST['apeP'];
    $apeM = $_POST['apeM'];
    $query4->bind_param("sssss", $correo, $contrasena, $nombre, $apeP, $apeM);
    if($query4->execute()){
      echo '<script type="text/javascript">
            alert("Se ha agregado correctamente");</script>';
    }
  }

  //Envía a la página de asignar tras realizar una pequeña comprobación.
  if(isset($_POST['emp_mesa'])){
    $valorconsulta  = $_POST['correo_asignar'];
    $query5->bind_param("s", $valorconsulta);
    if($query5->execute()){
      $resultado = $query5->get_result();
      $comprobacion = $resultado->fetch_array(MYSQLI_NUM);
      if($comprobacion[0] == 1){
        $_SESSION['Correo_empleado'] = $valorconsulta;
        header('Location: asignar.php');
      }
      else{
        echo '<script type="text/javascript">
            alert("No se ha encontrado mesero con ese correo.");</script>';
      }
    }
  }
?>
<html lang="es">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <head>
    <meta charset="UTF-8">

    <script type="text/javascript" src="../js/CRUD.js"></script>

    <title>Sistema de gestión de meseros</title>
  </head>
<link href = "/ab_model/css/CRUD_meseros.css" rel="stylesheet" type="text/css">
</head>

  <!-- Versión del toggle desfazado. 

  <article>
  <header>
    <nav>
      <ul>
      <li><a href="#">Pedidos</a></li>
      <li><a href="#">Clientes</a></li>
      <li><a href="#">Meseros</a></li>
      <li><a href="#">Existencia</a></li>
    </ul>
    </nav>
  </header>
</article> -->

<body>
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
  <article></article>
    <div id= "gran_contenedor3">

      <div id="titulo_seccion"><h1>SECCIÓN: MESEROS</h1></div>

      <!-- Tabla para visualizar mesero y su correo-->
          <div class="contenedor_tabla">
          <table class="tabla_general" id = "cabecera_meseros">
    <tr>
      <td>
           <tr>
              <th class="th_meseros">Mesero</th>
              <th class="th_meseros">Correo de mesero</th>
           </tr>
      </td>
    </tr>
    <tr>
              <?php
              while($valores_mesero = mysqli_fetch_array($query)){
              echo '
                  <tr>
                <td class = "td_mesero">'.$valores_mesero['Nombre'].'</td>
                  <td class = "td_mesero">'.$valores_mesero['Correo'].'</td>
                  </tr>
                  ';
              }
            ?>
             
           </div> 
         </div>
    </tr>
  </table>

      <div id="boton_principal">
      <button class="boton_dialogo" id="open_update_mesero" onclick="abrirDialogo2('modal_update_mesero', 'checkbox_mod')">Ver datos de Mesero</button>
    </div>

      <div id= "boton_principal_new">
      <button class="boton_dialogo" id="open_update_mesero" onclick="abrirDialogo('modal_agregar_mesero')">Agregar nuevo Mesero</button>
    </div>

    <div id= "boton_principal_new">
      <button class="boton_dialogo" id="open_update_mesero" onclick="abrirDialogo('modal_agregar_relacion')">Ver asignación de mesas</button>
    </div>

      <form id="form1" method="post">
      <div id ="modal_update_mesero" class="modal">
        <div class="modal_contenido_2">

          <div class="cabecera_modal">
          <h2 class="titulo_modal">Datos de Mesero</h2>
        </div>
            <div class="renglon">
            <p >Correo de mesero: </p>
            <input type="text" name="correo_empleado">
              </div>

              <div class="renglon">
             <button class="boton_dialogo_in" name= "boton_buscar" id="buscar_emp" onclick="rellenardatos()">Buscar empleado</button>

         
             <button class="boton_dialogo_in" id="Salir_emp" onclick="cerrarDialogo('modal_update_mesero')">Salir</button>
           </div>
          
        
        </div>
      </div>
    </form>

      <form id="form2" method="post">
      <div id ="modal_agregar_mesero" class="modal">
        <div class="modal_contenido">

          <div class ="cabecera_modal">
          <h2 class="titulo_modal_new">Agregar nuevo Mesero</h2>
        </div>


          <div class="renglon">
          <div class="columna">
            <p class="p_modal">Nombre: </p>
            <input id="nombre_emp_new" class= "text_modal" type="text" name="nombre">
          </div>

          <div class = "columna">
            <p class="p_modal">contrasena: </p>
            <input id="ape_emp_new" class= "text_modal" type="text" name="contrasena">
          </div>

          <div class="columna">
          <p class="p_modal">Apellido Paterno: </p>
          <input id="nac_emp_new" class= "fecha_modal"type="text" name="apeP">
          </div>
        </div>

          <div class="renglon">
            <div class="columna">
          <p class="p_modal">Apellido Materno</p>
          <input id="telefono_emp_new" class= "text_modal" type="text" name="apeM">
        </div>

        <div class="columna">
          <p class="p_modal">Email</p>
          <input id="email_emp_new" class= "text_modal" type="email" name="email">
        </div>
      </div>

      <div class="renglon">
           <div class="columna">
            <button class="boton_dialogo_in" id="vaciar_empleado" onclick="cerrarDialogo('modal_update_mesero')">Vaciar formularios</button>
          </div>

          <div class="columna">
             <button name= "guardar_emp_new" class="boton_dialogo_in" id="guardar_emp_new" onclick="guardar_new('modal_update_mesero')">Guardar cambios</button>
             
           </div>
         </form>

           <div class="columna">
             <button class="boton_dialogo_in" id="salir_emp_new" onclick="cerrarDialogo('modal_agregar_mesero')">Salir</button>
           </div>
        </div>
        </div>
      </div>


      <form id= "form3" method="POST">
      <div id ="modal_agregar_relacion" class="modal">
        <div class="modal_contenido_2">

          <div class ="cabecera_modal">
          <h2 class="titulo_modal_new">Asignaciones mesero-mesa</h2>
        </div>
        <br>
        <br>
        <div class="renglon">

          <p class="p_modal">Correo de mesero: </p>
            <input id ="id_emp_tabla" class= "text_modal" type="text" name="correo_asignar">
         </div>
         <div class="renglon">
                   
             <button class="boton_dialogo_in" name="emp_mesa" id="buscar_emp_mesa">Ver mesas asignadas</button>
          
         

           <button class="boton_dialogo_in" id="salir_emp_new" onclick="cerrarDialogo('modal_agregar_relacion')">Salir</button>
       
         </div>
       </div>
     </div>
   </form>
         
        </div>
      </div>
    </div>
  </body>
  </html>
  <style type="text/css">
    *{
      margin: 0;
      padding: 0;
    }
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

#gran_contenedor3{
  padding-bottom: 100%;
  float: left;
  height: 100px;
  width: 100%;
  background-color: rgb(245, 207, 131);
  text-align: center;
}
.boton_dialogo{
  margin-top: 3%;
  float: center;
  padding: 13px;
  width: 27%;
  height: 20%;
  font-size: 15px;
  border-radius: 12px;
  border-width: 1px;
}
.modal {
  text-align: left;
  display: none; 
  position: fixed; 
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
  width: 80%;
  height: 65%;
  overflow: auto;
  border-radius: 12px;
}
.p_modal{
  float: left;
  margin: 2px; 
  margin-left: 10px;
  width: 30%;
}
.text_modal{
  float: left;
  width: 55%;
  height: 30%;
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

.cabecera_modal{
  width: 100%;
  padding: 2px;
  background-color: beige;
}

.boton_dialogo_in{
    margin-top: 5%;
  height: 45%;
  width: 35%;
  border-radius: 8px;
  border-width: 1px;
  margin-left: 4px;
  margin-right: 4px;
}
.boton_dialogo_in2{
  margin-top: 5%;
  height: 40px;
  width: 45%;
  font-size: 15px;
  border-radius: 8px;
  border-width: 1px;
}
.th_meseros{
  height: 12%;
  width: 45%;
  text-align: center;
  padding: auto;
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
.td_mesero{
  height: 12%;
  width: 45%;
  text-align: center;
  background-color: beige;
  padding: auto;
  font-size: 19px;
}
.contenedor_tabla{
  width: 70%;
  margin-left: 15%
}
.tabla_general{
  height: 20%;
  table-layout: fixed;
  width: 100%;
  overflow: scroll;
}

#titulo_seccion{
  width: 100%;
  background-color: rgb(250, 182, 130);
  padding-top: 2%;
  padding-bottom: 2%;
}
.buscar{
  float: left;
  margin-bottom: 2%;
  padding-top: 2%;
  padding-bottom: 2%;
  height: 15%;
  margin-left: 4%;
  width: 15%;
  font-size: 10px;
}

#buscar_emp_mesa{
  height: 50%;
}

.modal_contenido_2{
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border-width: 1px;
  border-style: solid;
  border-color:  #888;
  width: 45%;
  height: 60%;
  overflow: auto;
  border-radius: 12px;
}
article{
  width: 100%;
  margin-top: 10px;
  }
nav{
  position: fixed;
  width: 100%;
  height: 60px;
  background:aqua;
  text-align: center;
  float: left; 
  margin-top: -10px;
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

  </style>