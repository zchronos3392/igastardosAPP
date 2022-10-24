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

		$(".itemAcceso1").hide();
		$(".itemAcceso3").hide();
		$(".itemAcceso4").hide();
		$(".itemAcceso5").hide();
		$(".itemAcceso6").hide();
		$(".itemAcceso7").hide();
		$(".itemAcceso8").hide();
		$(".itemAcceso9").hide();	
		$(".objitem2").hide();			
//++++++++++++++++++++++FIN DE LA LLAMADA AL GET++++++++++++++++++++++++++++++++++++++++++++++++++++
		$(".icono1").on("click",function(){
			//CARGAR/INGRESAR GASTO...
			location.href='index.php';
		});

		$(".icono2").on("click",function(){
			//CARGAR/INGRESAR GASTO...
				location.href='objetivos.php';
		});
				
		$(".icono3").on("click",function(){
			//CARGAR/INGRESAR GASTO...
				location.href='estadisticas.php';
		});


		$(".icono4").on("click",function(){
			location.href='abmobjetivos.php';
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
			
			pedirObjetivos('#grillaObjetivosVer',"verDIV",$("#iobjetivos").val());
			
		});
		$("#AgregarForm").on("click",function(){
			$(".objitem2").toggle();
			pedirObjetivos('#grillaObjetivosVer',"verDIV2",$("#iobjetivos").val());

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
.contieneRenglones11{grid-area: contieneRenglones11;}
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
 grid-template-areas: 'contieneRenglones1 contieneRenglones1 contieneRenglones11' 
 					  'contieneRenglones2 contieneRenglones2 contieneRenglones2'
 					  'contieneRenglones20 contieneRenglones20 contieneRenglones20'
 					  'contieneRenglones3 contieneRenglones4 contieneRenglones4'
 					  'contieneRenglones5 contieneRenglones6 contieneRenglones6'
 					  'contieneRenglones7 contieneRenglones8 contieneRenglones8'; 
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
	<div class="icono2"><span class="icon-time-slot" title="Resumen"></span></div>
	<div class="icono3"><span class="icon-controller-volume" title="estadisticas"></span></div>
	<div class="icono4"><span class="icon-adjust" title="abm objetivos"></span></div>
	<div class="icono5"></div>
	<div class="icono6"></div>
</div>
<div class="itemAcceso2" id="AdmObjetivos">
<div class="GrillaObjetivos">
	<div class="objitem1">
		<div class="grillaTitulo">
			<div class="gtititem10">OBJETIVOS</div>		
			<div class="gtititem11">
				<select id="iobjetivos">
					<option value="0">Seleccionar objetivos...</option>
				</select>
			</div>	
			<div class="gtititem2">
			</div>
			<div class="gtititem21">
			</div>			
			<div class="gtititem20">
			</div>			
			<div class="gtititem22">
			</div>			

			</div>							
		</div>
	</div>
	<div class="objitem2">
<div class="GrillaObjetivos">
	<div class="objitem1">
		<div class="grillaTitulo">
			<div class="gtititem10">OBJETIVOS</div>		
			<div class="gtititem1">VIGENCIA</div>
			<div class="gtititem2">
				<input type="hidden" id="idobjetivo" value="0" placeholder="Id del objetivo"></input> 
			</div>
			<div class="gtititem20">
			</div>			
		</div>
	</div>
	<div class="objitem2">
		<div class="grillaFechaObjs">
			<div class="gobjFecha1">
				Fecha Desde
			</div>
			<div class="gobjFecha2">	
				<input type="date" value="" id="FechaDesdeVigencia" placeholder="Vigencia, inicio"/>
			</div>
			<div class="gobjFecha3">
				Fecha Hasta
			</div>	
			<div class="gobjFecha4">
				<input type="date" value="" id="FechaHastaVigencia" placeholder="Vigencia, fin"/>
			</div>							
		</div>
	</div>
	<div class="objitem3">
		<div class="grillaFraccion">
			<div class="itemFraccion1">Fracción</div>			
			<div class="itemFraccion2">
				<input type="number" id="fraccion" value="" placeholder="Fraccion del Monto de Control"/>
			</div>			
			<div class="itemFraccion20">
				Fracción Tiempo
			</div>						
			<div class="itemFraccion21">
				<input type="number" id="fraccionTiempo" value="" placeholder="Fraccion de DIAS que se divide el periodo completo"/><span> DIAS</span>
			</div>						
			
			<div class="itemFraccion3">Fracción Tipo</div>			
			<div class="itemFraccion4">
				<select id="fraccionTipo">
					<option value="SEMANA">SEMANA</option>
					<option value="DIA">DIA</option>
					<option value="QUINCENA">QUINCENA</option>
				</select>
			</div>									
		</div>
	</div>
	<div class="objitem30">
		<div class="TitgrillaSubFraccion">
			<div class="TITitemSUFraccion1">SubId</div>			
			<div class="TITitemSUFraccion2">Moneda</div>			
			<div class="TITitemSUFraccion3">MPago</div>			
			<div class="TITitemSUFraccion4">Fracción</div>			
			<div class="TITitemSUFraccion5">Fracción Total</div>
			<div class="TITitemSUFraccion6">
				<span class="icon-circle-with-plus" title="Agregar sub objetivo" id="crearsubobjetivo"></span>
			   <span id="contadorSubObjetivos" style="display: none;"></span>
	
			</div>									
		</div>
		<div id="grillaSubObjs" name="grillaSubObjs"></div>
	</div>	
	<div class="objitem4">
		<div class="grillaMontos">
			<div class="itemMont1">Monto Objetivo</div>			
			<div class="itemMont2">
				<input type="number" id="montoobjetivo" value="" placeholder="Monto de Control" />
			</div>			
			<div class="itemMont3">Avisar En Monto</div>			
			<div class="itemMont4">
				<input type="number" id="montocontrol" value="" placeholder="Monto de Alarma" />			    </div>									
		</div>
	</div>	
	<div class="objitem5">
		<textarea id="objobservaciones1" class="objobservaciones1" rows="5" cols="50" placeholder="Descripcion del objetivo"></textarea>
	</div>
	</div>	
	
	</div>
</div>
</div> <!-- lisgta accesos -->

  <!-- grilla de novedades, ultimos cargados -->
	<div class="grillaObjetivos" id="grillaObjetivosVer">

	</div>
  <!-- grilla de novedades, ultimos cargados -->
</div> <!-- andamioHeader -->
</BODY>
</HTML>
