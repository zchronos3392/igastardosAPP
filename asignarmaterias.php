<HTML>
<HEAD>
<title>Administracion Sistema Carpetas :: Asignar Materias</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="styles/disenioGastardosAPP.css">
	<link rel="stylesheet" href="styles/normalize.css">
	<link rel="icon" href="favicon.ico">
</HEAD>
<!--SCRIPTS PRIMERO HAY QUE VINCULAR LA LIBERIA JQUERY PARA QUE RECONOZCA EL $-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!--SCRIPTS-->
	<script src="scripts/carpetas.js"> </script>
	
<script>
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$(document).ready(function(){

			var f=new Date();
			var FechaHoy = f.getFullYear()-1 ;
			fechainicial = FechaHoy -10;
			fechaFinal   = FechaHoy +10;
			for (var i = fechainicial; i < fechaFinal; i++) 
			{
				if(i == FechaHoy) $("#ianio").prepend('<option selected>' + (i + 1) + '</option>');
				else  $("#ianio").prepend('<option>' + (i + 1) + '</option>');
			}
			$("#ianio").prop('disabled', true);
/* RECIBO EL AÑO POR PARAMETROS..
			var anioSession = 0;
				anioSession = leersesion("IANIO");
			//$(".errores").html("anio en sesion: "+anioSession);
			if(anioSession  != 0)
					$("#ianio").val(anioSession);
*/

//+++++++++++++++++++++++++++++++LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++				
	
		var persona = parametroURL('idpersona');
		var anioParms = parametroURL('ianio');
			$("#ianio").val(anioParms);
			
			pedirPersona('#personas',persona);	
			//alert(persona);
		 $('#personas').val(persona);
	
//		pedirNiveles('#niveles');	
		pedirColegio('#colegios');
		pedirCursos('#cursos');	 
			pedirMaterias2('#grillaseleccionmaterias',persona,$("#ianio").val(),$("#cursos").val() );	 
			
		$("#volver").on("click",function()
		{
			
			window.location="index.php";
		});
		
		$("#AgregaMaterias").on("click",function()
		{
			var cursoElegido = $("#cursos").val();
			agregamateriaPersona(persona,cursoElegido);
		});
		
		$("#cursos").on("change",function()
		{
			var cursoElegido = $("#cursos").val();
				$("#grillaseleccionmaterias").html('');
				pedirMaterias2('#grillaseleccionmaterias',persona,$("#ianio").val(),cursoElegido );	 
		});
			
});
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
</script>
<BODY>
<?php
	include('header.html');
?>	
<div class="errores"></div>
<div class="AsignMatG">
	<div class="itemamg1">Asignar Materias
			<select id="ianio" name="ianio" class="ianio">
				<option value="9999">Seleccionar año...</option>
			</select>	
  		  		<select id="personas" class="personaSel">
  		  			<option value="9999">Seleccione persona</option>
  		  		</select>
  		  	<button class="accionBoton PEQUENIO" id="volver" />volver	

	</div>
	<div class="itemamg2">
		<div class="cabeceraAsignar">
			<div class="icabasign1">Colegio</div>
			<div class="icabasign2">
  		  		<select id="colegios" class="colegioSel">
  		  			<option value="9999">Seleccione colegio</option>
  		  		</select>				
			</div>
			<div class="icabasign3">Curso</div>
			<div class="icabasign4">
  		  		<select id="cursos" class="cursoSel">
  		  				<option value="9999">Seleccione curso</option>
  		  		</select>
			</div>
			<div class="icabasign5">
  		  	<button class="agregarBoton" id="AgregaMaterias" title="Agrega todas las Materias" />+
  		  	<button class="agregarBoton" id="EliminarMaterias" title="Elimina todas las Materias"/>-
			</div>
		</div>
	</div>
	<div id="grillaseleccionmaterias" class="itemamg3">GRILLA DE SELECCION MULTIPLE
	</div>
	
</div>

</BODY>
</HTML>
