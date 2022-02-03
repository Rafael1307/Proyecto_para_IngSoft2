<?php
  date_default_timezone_set('America/Mexico_City');
  $link = mysqli_connect("localhost", "root", "", "ab_model") or die ("<h3> Error de conexion </h3>");

  $command = "SELECT Nombre, Correo FROM mesero";
  $command2 = "SELECT * FROM mesero where Correo = ?";
  $command3 = "UPDATE mesero SET Correo = ?, Password = ?, Nombre = ?, ApellidoP = ?, ApellidoM = ? WHERE Correo = ?";
  $command4 = "SELECT NumMesa FROM mesa where AtencionMesero = ?";
  $command5 = "DELETE FROM mesa where AtencionMesero = ?";
  $command6 = "DELETE FROM pedido WHERE Mesa = ?";
  $command7 = "DELETE FROM mesero WHERE Correo = ?";

  $query = mysqli_query($link, $command);
  $query2 = $link->prepare($command2);
  $query3 = $link->prepare($command3);
  $query4 = $link->prepare($command4);
  $query5 = $link->prepare($command5);
  $query6 = $link->prepare($command6);
  $query7 = $link->prepare($command7);

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
  $query4->bind_param("s", $_SESSION['Correo_empleado']);
  $query5->bind_param("s", $_SESSION['Correo_empleado']);

  $query7->bind_param("s", $_SESSION['Correo_empleado']);
  
  if($query4->execute()){
    $result_2 = $query4->get_result();

    while($valor = $result_2->fetch_array(MYSQLI_NUM)){
    $query6->bind_param("s", $valor[0]);
    if($query6->execute()){
      if($query5->execute()){


         echo '<script type="text/javascript">
              alert("Se ha eliminado correctamente");</script>';
              header('Location: CRUD_meseros.php');
            }
          }
        }
       if($query7->execute()){
header('Location: CRUD_meseros.php');
      }
    }
  }
  if(isset($_POST['salir'])){
    header('Location: CRUD_meseros.php');
  }
?>
<html lang="es">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <head>
    <meta charset="UTF-8">

    <!-- <link rel="stylesheet" href="main.css"> -->

    <!--<link rel="stylesheet" type="text/css" href="CRUD.css"> -->
    <script type="text/javascript" src="../js/CRUD.js"></script>

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
<link href = "/ab_model/css/ver_mesero.css" rel="stylesheet" type="text/css">
</head>

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

<body>
    <div id= "gran_contenedor3">
   
     <div id ="modal_update_mesero" class="modal">
        <div class="modal_cont_cliente">

          <div class ="cabecera_modal">
          <h2 class="titulo_modal">Datos del Mesero</h2>
        </div>

         <table class="tabla_general" id = "cabecera_clientes_inner">
              <tr>
                <td>
                     <tr>
                        <th class="th_meseros">Dato</th>
                        <th class="th_meseros">Valor</th>
                     </tr>
                </td>
              </tr>
              <tr>
                      <?php
                      $valorconsulta  = $_SESSION["Correo_empleado"];
                      $query2->bind_param("s", $valorconsulta);
                      if($query2->execute()){
                          $result = $query2->get_result();
                          while($datos_emp = $result->fetch_array(MYSQLI_NUM)){
                        echo '
                            <tr>
                          <td class = "td_cliente">Correo</td>
                          <td class = "td_cliente">'.$datos_emp[0].'</td>
                          </tr>
                          <tr>
                          <td class = "td_cliente">Nombre</td>
                          <td class = "td_cliente">'.$datos_emp[2].'</td>
                           </tr>
                          <tr>
                          <td class = "td_cliente">Contraseña</td>
                          <td class = "td_cliente">'.$datos_emp[1].'</td>
                           </tr>
                          <tr>
                          <td class = "td_cliente">Apellido Paterno</td>
                          <td class = "td_cliente">'.$datos_emp[3].'</td>
                           </tr>
                          <tr>
                          <td class = "td_cliente">Apellido Materno</td>
                          <td class = "td_cliente">'.$datos_emp[4].'</td>
                            </tr>
                            ';
                        }
                      }
                      ?>
                     </tr>
                        
            </table>
        <form id="form_2" method="POST"> 
          <br>
          <h4>Modificar datos: </h4>
            <input id="nombre_emp" class= "text_modal" type="text" name="nombre" placeholder="Nombre" required>

            <input id="apeP_emp" class= "text_modal" type="text" name="apellidoP" placeholder="Apellido Paterno" required>
  
          <input id="apeM_emp" class= "text_modal" type="text" name="apellidoM" placeholder="Apellido Materno" required>


          <input id="email_emp" class= "text_modal" type="email" name="email" placeholder="Correo" required>
          <input id="email_emp" class= "text_modal" type="text" name="contrasena" placeholder="Contraseña" required>
              <button type="reset" class="boton_dialogo_in2" id="restablecer_cliente">Vaciar formulario</button>

             <button class="boton_dialogo_in2" id="guardar_cliente" name="guardar_cliente">Guardar cambios</button>

            

           </form >

           <form id="form_4" method="POST">

            <button name= "salir" class="boton_dialogo_in2" id="Salir_emp" onclick="cerrarDialogo('modal_update_cliente')">Salir</button> 

             <button type = "button" class="boton_dialogo_in2" id="boton_eliminar_emp" onclick="abrirDialogo('modal_eliminar_emp')">Eliminar Empleado</button>

             <div id = "modal_eliminar_emp" class="modal_2">
               <div id = "eliminar_emp" class="modal_contenido">
                 <h2>Eliminar Empleado</h2>
                 <p>Este efecto es irreversible y toda la información del empleado no podrá ser recuperada. ¿Continuar?</p>
                 <button id="boton_izq_cliente"  name="eliminar" >Eliminar</button>

                 <button id="boton_der_cliente"  >Cancelar</button>

               </div>

             </div>

          </form>

            

        </div>
        
</div>
      </div>

    </div>
  </body>
  </html>


<script type="text/javascript">
function abrirDialogo(valor_1){
  var modal = document.getElementById(valor_1);
  modal.style.display = "block";
} 
function cerrarDialogo(valor_1){
  var modal = document.getElementById(valor_1);
  modal.style.display = "none";
}
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
  "<?php echo 'hola' ?>";
  var correo = "<?php echo $datos_cliente[0]; ?>";
  var contra = "<?php echo $datos_cliente[1]; ?>";
  var nom = "<?php echo $datos_cliente[2]; ?>";
  var apeP = "<?php echo $datos_cliente[3]; ?>";
  var apeM = "<?php echo $datos_cliente[4]; ?>";
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

.modal {
  text-align: left;
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
  width: 30%;
}
.text_modal{
  float: left;
  width: 51%;
  margin-left: 24%;
  text-align: center;
  margin-bottom: 1%;
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
  font-size: 17px;
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
  margin-left: 40%;
}
.tabla_general{
  table-layout: fixed;
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

.columna_superior{
  float: left;
  width: 60%;
}
</style>