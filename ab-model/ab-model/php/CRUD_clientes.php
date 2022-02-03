<?php
  date_default_timezone_set('America/Mexico_City');
  $link = mysqli_connect("localhost", "root", "", "ab_model") or die ("<h3> Error de conexion </h3>");

 //*****Strings para realizar querys en la base de datos
  $command = "SELECT NumMesa, OcupacionCliente, AtencionMesero FROM mesa where OcupacionCliente != 'NULL'";
  $command2 = "SELECT * FROM cliente where Correo = ?";
  $command3 = "SELECT COUNT(*) FROM pedido where Mesa = ?";
  $command4 = "INSERT INTO cliente VALUES (?, ?, ?, ?, ?)";
  $command5 = "SELECT COUNT(*) FROM cliente where Correo = ?";
//***

  //Enlazar conexión con la base de datos con un query.
  $query = mysqli_query($link, $command);
  $query2 = $link->prepare($command2);
  $query4 = $link->prepare($command4);
  $query5 = $link->prepare($command5);

  //Inicialización de la sesión. Debido a que se debe asignar un valor a una variable en php, se le asigna un string cualquiera.

  session_start();
  $_SESSION['Correo_cliente'] = 'ejempplo' ;
?>

<!DOCTYPE html>

<?php 
//Envia a la página ver_cliente.php. Tras pequeña comprobación.
  if(isset($_POST['boton_buscar'])){

    $valorconsulta  = $_POST['correo_cliente'];
    $query5->bind_param("s", $valorconsulta);
    if($query5->execute()){
      $resultado = $query5->get_result();
      $comprobacion = $resultado->fetch_array(MYSQLI_NUM);
      if($comprobacion[0] == 1){
        $_SESSION['Correo_cliente'] = $valorconsulta;
        header('Location: ver_cliente.php');
      }
      else{
        echo '<script type="text/javascript">
            alert("No se ha encontrado cliente con ese correo.");</script>';
      }
    }
  }
//Inserción de un nuevo cliente en la mismca página.
  if(isset($_POST['guardar_cliente_new'])){
    $correo = $_POST['email_nuevo'];
    $contrasena = $_POST['contrasena_new'];
    $nombre = $_POST['nombre_nuevo'];
    $apeP = $_POST['apeP_nuevo'];
    $apeM = $_POST['apeM_nuevo'];
    $query4->bind_param("sssss", $correo, $contrasena, $nombre, $apeP, $apeM);
    if($query4->execute()){
      echo '<script type="text/javascript">
            alert("Se ha agregado correctamente");</script>';
    }
  }
?>
<html lang="es">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <head>
    <meta charset="UTF-8">

    <!-- <link rel="stylesheet" href="main.css"> -->

    <!--<link rel="stylesheet" type="text/css" href="CRUD.css"> -->
    <script type="text/javascript" src="../js/CRUD.js"></script>

    <title>Sistema CRUD de Clientes</title>
  </head>
  <body>
 <!-- <input type="checkbox" id="btn-nav" class="checkbox">
    <header>
      <div class="header-container">
        <label for="btn-nav" class="btn-label">
          <div class="header-button"></div>
        </label>
      </div>
    </head>

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
</article>
-->
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
    <link href = "/ab_model/css/CRUD_clientes.css" rel="stylesheet" type="text/css">

    <div id= "gran_contenedor4">

      <div id="titulo_seccion_cliente"><h1>SECCIÓN: CLIENTES</h1></div>
          <div class="contenedor_tabla">
          <table class="tabla_general" id = "cabecera_clientes">
    <tr>
      <td>
           <tr>
              <th class="th_meseros">Cliente en línea</th>
              <th class="th_meseros">Mesero encargado</th>
              <th class="th_meseros">ID de Mesa ocupada</th>
           </tr>
      </td>
    </tr>
    <tr>
            <?php
              while($valores_ocupacion = mysqli_fetch_array($query)){
              echo '
                  <tr>
                <td class = "td_cliente">'.$valores_ocupacion[1].'</td>
                <td class = "td_cliente">'.$valores_ocupacion[2].'</td>
                <td class = "td_cliente">'.$valores_ocupacion[0].'</td>
                  </tr>
                  ';
              }
            ?>
           </tr>
           </div>     
  </table>



      <div id="boton_principal_cliente">
      <button class="boton_dialogo" id="open_update_cliente" name="abrir" onclick="abrirDialogo3('modal_update_cliente', 'checkbox_mod_cliente')">Ver datos de Cliente</button>
    </div>

      <div id= "boton_principal_new_cliente">
      <button class="boton_dialogo" id="open_new_cliente" onclick="abrirDialogocliente('modal_agregar_cliente')">Agregar nuevo Cliente</button>
    </div>

      <div id ="modal_update_cliente" class="modal">
        <div class="modal_cont_cliente">

          <div class ="cabecera_modal">
          <h2 class="titulo_modal">Datos de Clientes</h2>
        </div>


       
        <form id="form_1" method="POST">    
            <div class="columna_superior">
            <p id="id_cliente">Correo del Cliente: </p>
            <input id ="id_cliente_box" class= "text_modal" type="text" name="correo_cliente" placeholder="ejemplo@ejempplo.com" required>
             <button   class="buscar" id="buscar_cliente" name= "boton_buscar" onclick = "rellenardatos()">Buscar Cliente</button>
           </div>
          </div>
        </form>

           <div class="columna">
             <button class="boton_dialogo_in2" id="Salir_cliente" onclick="cerrarDialogo('modal_update_cliente')">Salir</button>
           </div>
        </div>
        </form>

      </div>

          <form id ="form_2" method="POST">
      <div id ="modal_agregar_cliente" class="modal">
        <div class="modal_cont_cliente">


          <div class ="cabecera_modal">
          <h2 class="titulo_modal_new">Agregar nuevo Cliente</h2>
        </div>


          <div class="renglon">
          <div class="columna">
            <p class="p_modal">Nombre: </p>
            <input id="nombre_cliente_new" class= "text_modal" type="text" name="nombre_nuevo" required>
          </div>

          <div class = "columna">
            <p class="p_modal">Apellido Paterno: </p>
            <input id="apeP_cliente_new" class= "text_modal" type="text" name="apeP_nuevo" required>
          </div>
        </div>

          <div class="renglon">
            <div class="columna">
          <p class="p_modal">Apellido Materno: </p>
          <input id="apeM_cliente_new" class= "text_modal" type="text" name="apeM_nuevo">
        </div>

        <div class="columna">
          <p class="p_modal">Email: </p>
          <input id="email_cliente_new" class= "text_modal" type="email" name="email_nuevo" required>
        </div>

        <div class="columna">
          <p class="p_modal">Contraseña: </p>
          <input id="contrasena_cliente_new" class= "text_modal" type="text" name="contrasena_new" required>
        </div>
      </div>

            <div class="renglon" id="more_margin2">

           <div class="columna">
            <button type= "reset" class="boton_dialogo_in2" id="vaciar_cliente">Vaciar formularios</button>

             <button class="boton_dialogo_in2" id="guardar_cliente_new" name="guardar_cliente_new" onclick="guardar_new('modal_update_cliente')">Guardar cambios</button>
             
           </div>

           <div class="columna">
             <button type="button" class="boton_dialogo_in2" id="salir_cliente_new" onclick="cerrarDialogo('modal_agregar_cliente')">Salir</button>
           </div>
        </div>
        </div>
      </div>
    </form>

    </div>
  </body>
  </html>


<script type="text/javascript">

function validacioncliente(value_1){
  if(document.getElementById(value_1).checked)
  {
    document.getElementById("nombre_cliente").disabled = false;
    document.getElementById("apeP_cliente").disabled  = false;
    document.getElementById("apeM_cliente").disabled  = false;
    document.getElementById("email_cliente").disabled  = false;
    document.getElementById("contrasena").disabled  = false;
    
  }
  else{
    document.getElementById("nombre_cliente").disabled = true;
    document.getElementById("apeP_cliente").disabled  = true;
    document.getElementById("apeM_cliente").disabled  = true;
    document.getElementById("email_cliente").disabled  = true;
    document.getElementById("contrasena").disabled  = true;

    
  }
}

function abrirDialogo3(valor_1, valor_2){
  var modal = document.getElementById(valor_1);
  modal.style.display = "block";
  validacioncliente(valor_2);
}

function abrirDialogocliente(valor_1){
    var modal = document.getElementById(valor_1);
  modal.style.display = "block";
   document.getElementById("id_cliente_new").disabled = true;
}

function rellenardatos(){
  var correo = "<?php echo $valores_mesas[0] ?>";
  var contra = "<?php echo $valores_mesas[1] ?>";
  var nom = "<?php echo $valores_mesas[2] ?>";
  var apeP = "<?php echo $valores_mesas[3] ?>";
  var apeM = "<?php echo $valores_mesas[4] ?>";
document.getElementById("nombre_cliente").value = correo;
document.getElementById("contrasena").value = contra;
document.getElementById("apeP_cliente").value = nom;
document.getElementById("apeM_cliente").value = apeP;
document.getElementById("email_cliente").value = apeM;

  if(window.history.replaceState){
    window.history.replaceState(null, null, null, window.location.href);
  }

} 

</script>
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
  padding-bottom: 4px;
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

.modal_cont_cliente {
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

.cabecera_modal{
  width: 100%;
  padding: 2px;
  background-color: beige;
}

.boton_dialogo_in{
  margin-top: 5%;
  height: 45%;
  width: 35%;
  font-size: 17px;
  border-radius: 8px;
  border-width: 1px;
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

.tabla_general{
  height: 20%;
  table-layout: fixed;
  width: 100%;
  overflow: scroll;
}

#titulo_seccion_cliente{
  width: 100%;
  background-color: rgb(254, 225, 120);
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

.columna_superior{
  float: left;
  width: 60%;
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