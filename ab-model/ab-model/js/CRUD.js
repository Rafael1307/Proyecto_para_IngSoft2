function abrirDialogo(valor_1){
  var modal = document.getElementById(valor_1);
  modal.style.display = "block";
  document.getElementById("id_emp_new").disabled = true;

}
function abrirDialogocliente(valor_1){
	  var modal = document.getElementById(valor_1);
  modal.style.display = "block";
	 document.getElementById("id_cliente_new").disabled = true;
}
function abrirDialogo2(valor_1, valor_2){
  var modal = document.getElementById(valor_1);
  modal.style.display = "block";
  validacion(valor_2);
}

function cerrarDialogo(valor_1){
	var modal = document.getElementById(valor_1);
  modal.style.display = "none";
}
function rellenardatos(){
document.getElementById("nombre_emp").value = "Ejemplino";
document.getElementById("ape_emp").value = "Ejemplarez Ejemplos";
document.getElementById("nac_emp").value = '1998-12-12';
document.getElementById("telefono_emp").value = "3333335555";
document.getElementById("email_emp").value = "Ejemplino@hotmail.com";
document.getElementById("calle_emp").value = "Ejemplos dorados";
document.getElementById("num_emp").value = "777";
document.getElementById("col_emp").value = "Ejemplares";
document.getElementById("mun_emp").value = "Ejemplotlanejo";
document.getElementById("fecha_con").value = '2020-12-21';
}
function validacion(value_1){
	if(document.getElementById(value_1).checked)
	{
		document.getElementById("nombre_emp").disabled = false;
document.getElementById("ape_emp").disabled  = false;
document.getElementById("nac_emp").disabled  = false;
document.getElementById("telefono_emp").disabled  = false;
document.getElementById("email_emp").disabled  = false;
document.getElementById("calle_emp").disabled  = false;
document.getElementById("num_emp").disabled  = false;
document.getElementById("col_emp").disabled  = false;
document.getElementById("mun_emp").disabled  = false;
document.getElementById("fecha_con").disabled  = false;
		
	}
	else{
		document.getElementById("nombre_emp").disabled = true;
document.getElementById("ape_emp").disabled  = true;
document.getElementById("nac_emp").disabled  = true;
document.getElementById("telefono_emp").disabled  = true;
document.getElementById("email_emp").disabled  = true;
document.getElementById("calle_emp").disabled  = true;
document.getElementById("num_emp").disabled  = true;
document.getElementById("col_emp").disabled  = true;
document.getElementById("mun_emp").disabled  = true;
document.getElementById("fecha_con").disabled  = true;
		
	}
}

function validacioncliente(value_1){
	if(document.getElementById(value_1).checked)
	{
		document.getElementById("nombre_cliente").disabled = false;
document.getElementById("ape_cliente").disabled  = false;
document.getElementById("nac_cliente").disabled  = false;
document.getElementById("telefono_cliente").disabled  = false;
document.getElementById("email_cliente").disabled  = false;
		
	}
	else{
		document.getElementById("nombre_cliente").disabled = true;
document.getElementById("ape_cliente").disabled  = true;
document.getElementById("nac_cliente").disabled  = true;
document.getElementById("telefono_cliente").disabled  = true;
document.getElementById("email_cliente").disabled  = true;

		
	}
}

function guardar_new(value_1){
	document.getElementById("id_emp_new").value = "0015";
	alert('El Id del nuevo empleado es: 0015');

}
function abrirDialogo3(valor_1, valor_2){
  var modal = document.getElementById(valor_1);
  modal.style.display = "block";

  validacioncliente(valor_2);
}