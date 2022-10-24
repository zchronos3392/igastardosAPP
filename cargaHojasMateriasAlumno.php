<HTML>
<HEAD>
<title>Administracion Sistema Carpetas :: Asignar Materias</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

</HEAD>
<!--SCRIPTS PRIMERO HAY QUE VINCULAR LA LIBERIA JQUERY PARA QUE RECONOZCA EL $-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!--SCRIPTS-->
	<script src="scripts/carpetas.js"> </script>
    <meta name="description" content="Cargar hojas de carpeta">
	<link rel="icon" href="favicon.ico">
    <link rel="stylesheet" href="styles/iconstyle.css">
    <link rel="stylesheet" href="styles/demo.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

     <!-- Estilos CSS -->
     <link rel="stylesheet" href="styles/estiloGaleriaCarpetas.css">
	<link rel="stylesheet" href="styles/disenioGastardosAPP.css">
	<link rel="stylesheet" href="styles/normalize.css">


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
			var	anioparms = 0;
			anioparms = parametroURL('ianio');
			//$(".errores").html("anio en sesion: "+anioSession);
			//if(anioSession  != 0)
			$("#ianio").val(anioparms);
			
			
			$("#ianio").hide();	//.prop('display', 'none');
			$("#anioTexto").append($("#ianio").val());
			//$("#cursosver").prop('disabled', true);
			$("#cursosver").hide();
/*****************************CARGO LA FECHA DE LA HOJA COMO HOY PARA QUE NO VENGAN NULA*/
		 var f=new Date();
		 var dias = new Array ("01","02","03","04","05","06","07","08","09","10","11","12"
		 				,"13","14","15","16","17","18","19","20","21","22","23","24","25","26"
		 				,"27","28","29","30","31");
		 var meses = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
		 var fecha_ahora = f.getFullYear() + "-" + meses[f.getMonth()] + "-" +dias[(f.getDate()-1)] ;
		 	//alert(fechapartido);
		 	// EL FORMATO SIEMPRE TIENE QUE SER YYYY-MM-DD 
			//fechapartido = '2018-10-16';
		 $("#FechaEnHoja").val(fecha_ahora);
/*****************************CARGO LA FECHA DE LA HOJA COMO HOY PARA QUE NO VENGAN NULA*/

		var llamador=parametroURL('llama');
		var materiaParm="";
			materiaParm = parametroURL('materia');
		var persona = 0;
		var docente = 0;
		if(llamador == 'INDEX'){
				persona = parametroURL('idpersonaINI');
				//docente = parametroURL('docenteINI');
			
		}
		else
		{
		  persona = parametroURL('idpersona');
		  //docente = parametroURL('docente');

		}

//+++++++++++++++++++++++++++++++LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++				
		//SIEMPRE LLEGA UN DOCENTE Y UN ALUMNO, 
			//AL LLAMAR DESDE INDEX, SOLO OCURRE EN LA CARGA LA PRIMERA VEZ
		pedirPersonaTipo('#alumnos',999,'ALUMNO');	
			//pedirDocente('#profesionalSeleccionado',docente,'ESPECIALISTA');	
				$("#alumnos").val(persona);
		var titulo = "Carpetas de<br>"+$("#alumnos option:selected").attr('title');
				$(".titulo").html(titulo);	
		var anioAnalisis = $("#ianio").val();
		llamador='VER';
		//trae el formulario para ccargar imagenes...
		pedirMateriasFiles('#grillamaterias',persona,anioAnalisis,llamador,materiaParm,'#cursoSeleccionado');	 
		//esta funcion deberia mostrar lo cargado recien...HOY..
			pedirGaleriaX("div[name='Xgal']",persona,anioAnalisis,llamador,materiaParm);
			
		$("#volver").on("click",function()
		{
			
			window.location="index.php";
		});
		$("#LimpiaCargaMaterias").on("click",function()
		{
			//e.preventDefault();
			//$(".errores").html("");	//	limpio mensajes
			//$("#formulariocargahojas").reset(); //	limpiar formulario
			$("#formularioHojasCarpeta").hide();
		});
		
		$("#Observaciones1").on("click",function()
		{
			$("#Observaciones1").val('');
		
		});		
		// boton apagar/prender MENU	
		$(".dropdown").on("click",function()
		{
			$(".dropdown-child").toggle();
		
		});		
		//CUANDO CAMBIO EL ALUMNO QUE VISUALIZO, SE CARGAN SUS MATERIAS..
		$("#alumnos").on("change",function()
		{
			var materiaParm="";
			materiaParm = parametroURL('materia');

			var	anioparms = 0;
			anioparms = parametroURL('ianio');

			llamador='VER';//$('#profesionales').val()
			var url = "cargaHojasMateriasAlumno.php?idpersona="+$("#alumnos").val()+"&llama="+llamador+"&ianio="+anioparms;
			window.location.replace(url);
		});		
		//SUBIR IMAGENES CON AJAX !!
	    $("#formulariocargahojas").on('submit', function(e){
	        e.preventDefault();
	        $.ajax({
	            type: 'POST',
	            url:   './apis/curFunciones.php',
	            data: new FormData(this),
	            contentType: false,
	            cache: false,
	            processData:false,
		            beforeSend: function (){
		            	$(".errores").val("Enviando"); // Para input de tipo button
                		$(".uploadear").attr("disabled","disabled");
 						$('#formulariocargahojas').css("opacity",".5");
                		//$(".respuesta").html(parametros);
		            },
					complete:function(data){
	                /*
	                * Se ejecuta al termino de la petición
	                * */
	            	    $(".errores").val("Sube Fotos");
    	           		$(".uploadear").removeAttr("disabled");
        		    },		            
		            success:  function (r){
						$(".errores").html(r);
                		$('#formulariocargahojas').css("opacity","");
                		$('#formulariocargahojas').hide();
                		$("#uploadear").attr("disabled","disabled");
                		var anioAnalisis = $("#faniocurso").val();
//                				pedirGaleria("div[name='Xgal']",persona,anioAnalisis,llamador,materiaParm);
								//esta funcion deberia mostrar lo cargado recien...HOY..
								pedirGaleriaX("div[name='Xgal']",persona,anioAnalisis,llamador,materiaParm);
								//trae el formulario para ccargar imagenes...
								pedirMateriasFiles('#grillamaterias',persona,anioAnalisis,llamador,materiaParm,'#cursoSeleccionado');	 


		            },
					error: function (xhr, ajaxOptions, thrownError) {
						console.log(xhr.responseText);
						console.log(thrownError);
		            }
		            }); // FIN funcion ajax
		});				
});
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
</script>
<BODY>
<?php
	include('header.html');
?>	
<div class="errores"></div>

<div class="dropdown">
  <button class="mainmenubtn"><span class="icon-layers fuenteGrande"></span></button>
</div> 
<div class="dropdown-child">
<div class="VerMat">
		<div class="itemvm1">Materias año: <span id="anioTexto" class="valoresFijos"></span> </div>
		<div class="itemvm11">
				<select id="ianio" name="ianio" class="ianio">
					<option value="9999">Seleccionar año...</option>
				</select>
	   </div>
	   	<div class="itemvm2">				
		</div>
		<div class="itemvm3">	
	  		  		<select id="alumnos" class="personaSel">
	  		  			<option value="9999">Seleccione persona</option>
	  		  		</select>
					<span id="alumnoSeleccionado" class="valoresFijos"></span>	  		  		
		</div>
		<div class="itemvm4"></div>
		<div class="itemvm44">
		<select id="cursosver" class="cursoSel">
	  		<option value="9999">Seleccione curso</option>
	  	</select>
	  	<span id="cursoSeleccionado" class="valoresFijos15PX"></span>	  		  		
		</div>
		<div class="itemvm5">
	  		  	<button class="accionBoton" id="volver" /><span class="icon-arrow-left fuenteGrande"></span>
		</div>
	</div>
	<div id="grillamaterias" class="grillamaterias3">GRILLA DE CARGA DE ARCHIVOS MULTIPLES
	</div>
	</div> <!-- DROPDOWNCHILD-->
<!-- </div>	  MAIN MENU-->
	<div class="formularioHojasCarpeta" id="formularioHojasCarpeta">
		<form action="" method="post" id="formulariocargahojas" enctype="multipart/form-data">
			<div class="grillaFormularioHojas" id="uploadear">
				<div class="itemform1">AGREGAR HOJA A LA MATERIA: <span  id="nombreMateria" class="textos"></span> </div>			
				<div  class="itemform2">Seleccionar hojas a cargar <input type="file" value="" name="miHojas[]" multiple/> </div>
				<div><input type="hidden" id="faniocurso" name="aniocurso" value=""/> 
					<input type="hidden" id="fidcurso"  name="idcurso" value=""/>
					<input type="hidden" id="fidalumno"  name="idalumno" value=""/>
					<input type="hidden" id="fidmateriaid"  name="idmateriaid" value=""/>
					<input type="hidden" id="llamador"  name="llamador" value="UploadHojasCarpeta"/> 
					<input type="hidden" id="funcion"  name="funcion" value="UploadHojasCarpeta"/>
				</div> 
				<div   class="itemform3"><input type="date" class="" id="FechaEnHoja" name="FechaEnHoja" value="Fecha en Hoja"></input></div>	
				<div   class="itemform31"><input type="text" class="" id="Observaciones1" name="Observaciones1" value="Observaciones / Temas"></input></div>	
				<div   class="itemform33"><input type="submit" class="accionBoton rosa" id="CargarMaterias" value="Cargar Carpeta"></input></div>	
				<div   class="itemform4"><button class="accionBoton bluer" id="LimpiaCargaMaterias"  >Limpiar</button></div>	
			</div>
		</form>
		<div class="visualizarSubido">
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
		</div>
	</div>
	<!-- GALERIA EN SI MISMA -->
     <main class="container">
          <div class="row">
               <div class="col s12 center-align">
                    <h1 class="titulo">Lightbox</h1>
               </div>
          </div>
          <div class="row galeria" name="Xgal">
          </div>
          
     </main>
	
     <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
     <script src="scripts/mainGaleriaCarpetas.js"></script>
	
	
</BODY>
</HTML>
