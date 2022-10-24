<HTML>
<HEAD>
<title>Inicio. Administracion Sistema Gastos</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="styles/disenioGastardosAPP.css">
	<link rel="stylesheet" href="styles/normalize.css">

    <link rel="stylesheet" href="styles/iconstyle.css">
    <link rel="stylesheet" href="styles/demo.css">

	<link rel="icon" href="favicon.ico">
</HEAD>
<!--SCRIPTS PRIMERO HAY QUE VINCULAR LA LIBERIA JQUERY PARA QUE RECONOZCA EL $-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!-- BARRAS DE PROGRESO CIRCULARES 
	https://codepen.io/Sai2003312/pen/OJJMOyL
-->
<!-- Load c3.js -->
<!--SCRIPTS-->
<script src="scripts/knobGraphics.js"></script>
<script src="scripts/gastardosAPP.js"> </script>
<script>

// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$(document).ready(function(){


$("#cargarotroanio").on("click",function()
{
  if( $("#cargarotroanio").is(':checked') )
  {
	    $("#ianio").prop('disabled', false);

  } else
   {
		$("#ianio").prop('disabled', true);
		var f=new Date();
		var FechaHoy = f.getFullYear() ;
		$("#ianio").val(FechaHoy);
		//grabar año en sesion
			grabarsesion("IANIO",$("#ianio").val());
}
});
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		 var fecHoy=new Date();
		 var dias = new Array ("01","02","03","04","05","06","07","08","09","10","11","12"
		 				,"13","14","15","16","17","18","19","20","21","22","23","24","25","26"
		 				,"27","28","29","30","31");
		 var meses = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
		 var FechaDia = fecHoy.getFullYear() + "-" + meses[fecHoy.getMonth()] + "-" +dias[(fecHoy.getDate()-1)] ;

// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++


			var contadorDescripcionItems=1;
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
			//me fijo sino exsitia, sino lo grabo yo..porque sno vendra vacio 
			// en las otras pantallas..
			var anioSession = 0;
			//DEFINIR ESTA FUNCION...
				anioSession = leersesion("IANIO");
			//$(".errores").html("anio en sesion: "+anioSession);
			if(anioSession  != 0)
					$("#ianio").val(anioSession);
			else
					grabarsesion("IANIO",$("#ianio").val());					
//		$("#filtroFechaGastos").val('ESTAQUINCENA');
//+++++++++++++++++++++++++++++++LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++
		pedirObjetivos('#iobjetivos',"select",99);
		pedirObjeCns("#grillaObjetosConsumoVer","grid",99);

		$(".itemAcceso1").hide();
		$(".itemAcceso3").hide();
		$(".itemAcceso4").hide();
		$(".itemAcceso5").hide();
		$(".itemAcceso6").hide();
		$(".itemAcceso7").hide();
		$(".itemAcceso8").hide();
		$(".itemAcceso9").hide();				
//++++++++++++++++++++++FIN DE LA LLAMADA AL GET++++++++++++++++++++++++++++++++++++++++++++++++++++
		$(".icono1").on("click",function(){
			//CARGAR/INGRESAR GASTO...
			location.href='index.php';
		});
		
		$(".icono2").on("click",function(){
			//CARGAR/INGRESAR GASTO...
				location.href='estadisticas.php';

			$(".itemAcceso2").toggle();				
				$(".itemAcceso1").hide();
					$(".grillaGastos").toggle();
				$(".itemAcceso3").hide();
				$(".itemAcceso4").hide();
				$(".itemAcceso5").hide();
				$(".itemAcceso6").hide();
				$(".itemAcceso7").hide();
				$(".itemAcceso8").hide();
				$(".itemAcceso9").hide();
		});

		$(".icono3").on("click",function(){
			$(".itemAcceso3").toggle();
				$(".itemAcceso1").hide();
				$(".grillaGastos").toggle();
				$(".itemAcceso2").hide();
				$(".itemAcceso4").hide();
				$(".itemAcceso5").hide();
				$(".itemAcceso6").hide();
				$(".itemAcceso7").hide();
				$(".itemAcceso8").hide();
				$(".itemAcceso9").hide();							
		});

		$(".icono4").on("click",function(){
			$(".itemAcceso4").show();				
				$(".itemAcceso1").hide();
				$(".itemAcceso2").hide();
				$(".grillaGastos").toggle();
				$(".itemAcceso3").hide();
				$(".itemAcceso5").hide();
				$(".itemAcceso6").hide();
				$(".itemAcceso7").hide();
				$(".itemAcceso8").hide();
				$(".itemAcceso9").hide();			
		});

		$(".icono5").on("click",function(){
			$(".itemAcceso5").toggle();				
				$(".itemAcceso1").hide();
				$(".grillaGastos").toggle();
				$(".itemAcceso2").hide();
				$(".itemAcceso3").hide();
				$(".itemAcceso4").hide();
				$(".itemAcceso6").hide();
				$(".itemAcceso7").hide();
				$(".itemAcceso8").hide();
				$(".itemAcceso9").hide();			
		});

		$(".icono6").on("click",function(){
			$(".itemAcceso6").toggle();				
				$(".itemAcceso1").hide();
				$(".grillaGastos").toggle();
				$(".itemAcceso2").hide();
				$(".itemAcceso3").hide();
				$(".itemAcceso4").hide();
				$(".itemAcceso5").hide();
				$(".itemAcceso7").hide();
				$(".itemAcceso8").hide();
				$(".itemAcceso9").hide();			
		});
		
		$(".icono7").on("click",function(){
			$(".itemAcceso7").toggle();				
				$(".itemAcceso1").hide();
				$(".grillaGastos").toggle();
				$(".itemAcceso2").hide();
				$(".itemAcceso3").hide();
				$(".itemAcceso4").hide();
				$(".itemAcceso5").hide();
				$(".itemAcceso6").hide();
				$(".itemAcceso8").hide();
				$(".itemAcceso9").hide();
		});
		
		$("#iobjetivos").on("click",function(){
			
			
		});
	}); // parentesis del READY
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
</script>

<style>

.contieneGrafico{
  margin:0 auto;
  text-align: center
}

.contieneRenglones1{grid-area: contieneRenglones1;}
.contieneRenglones2{grid-area: contieneRenglones2;}
.contieneRenglones20{grid-area: contieneRenglones20;}
.contieneRenglones3{grid-area: contieneRenglones3;}
.contieneRenglones3 input {
	box-shadow: inset 0 -0px #e7e7e7;
}
.contieneRenglones4{grid-area: contieneRenglones4;}
.contieneRenglones4 input {
	box-shadow: inset 0 -0px #e7e7e7;
}
.contieneRenglones5{grid-area: contieneRenglones5;}
.contieneRenglones5 input {
	box-shadow: inset 0 -0px #e7e7e7;
}
.contieneRenglones6{grid-area: contieneRenglones6;}
.contieneRenglones6 input {
	box-shadow: inset 0 -0px #e7e7e7;
}

.contieneRenglones7{grid-area: contieneRenglones7;}
.contieneRenglones7 input {
	box-shadow: inset 0 -0px #e7e7e7;
}
.contieneRenglones8{grid-area: contieneRenglones8;}
.contieneRenglones8 input {
	box-shadow: inset 0 -0px #e7e7e7;
}
.contieneGraficoRenglones{
 display: grid;
 grid-template-areas: 'contieneRenglones1 contieneRenglones1' 
 					  'contieneRenglones2 contieneRenglones2'
 					  'contieneRenglones20 contieneRenglones20'
 					  'contieneRenglones3 contieneRenglones4'
 					  'contieneRenglones5 contieneRenglones6'
 					  'contieneRenglones7 contieneRenglones8'; 
  text-align: center;
  color: #fff;
background-color: #040c31;
padding: 0.5em;
	/*bordes redondeados*/
		border: 1px solid #000000;
		-moz-border-radius: 7px;
		-webkit-border-radius: 7px;
	/*bordes redondeados*/		
}

h1{
  font-family: 'raleway';
  font-size:40px;
  margin-bottom: 100px;
}	
	
	
</style>
<BODY>
<?php
	include('header.html');
?>	
  <div class="andamioHeader">	
  <div class="errores"></div>
  <div class="listaAccesos">

  <div class="grillaCambioAnio">
 	<div class="itemcambioanio1">
	   <A>\Gastos i0</A>
 	</div>
 	<div class="itemcambioanio2">
		<select id="ianio" name="ianio" class="ianio">
				<option value="9999">Seleccionar año...</option>
		</select>	
 	</div>
 	<div class="itemcambioanio3">
		<input type="checkbox" value="" id="cargarotroanio" ></input>
 	</div>
  </div>

<div class="iconosFunciones">
	<div class="icono1"><span class="icon-arrow-left" title="volver al main"></span></div>	
	<div class="icono2"><span class="icon-controller-volume" title="buscar"></span></div>
	<div class="icono3"></div>
	<div class="icono4"></div>
	<div class="icono5"></div>
	<div class="icono6"></div>
</div>
<div class="itemAcceso2" id="AdmObjetivos">
<div class="GrillaObjetivos">
	<div class="objitem1">
		<div class="grillaTitulo">
			<div class="gtititem10">OBJETOS DE CONSUMO</div>		
			<div class="gtititem11">

			</div>					
		</div>
	</div>
	<div class="objitem2">
	</div>
</div>
</div>
</div> <!-- lisgta accesos -->

  <!-- grilla de novedades, ultimos cargados -->
	<div class="grillaObjeConsumo" id="grillaObjetosConsumoVer">

	</div>
  <!-- grilla de novedades, ultimos cargados -->
</div> <!-- andamioHeader -->
</BODY>
</HTML>
