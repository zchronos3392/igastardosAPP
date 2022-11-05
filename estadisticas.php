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
	<!--SCRIPTS-->
		<script src="scripts/gastardosAPP.js"> </script>
<script>

function pedirProductoResumen(destinoid){
	var productos='';
	// Cargo la moneda elegida
	stringmoneda = '';
	monedaSeleccionada='';
	$(".selectedMon").each(function(index) {
	 //     console.log(index + ": " + $(this).text());
	 	  stringmoneda = $(this).attr('id').split("_");
	  });	
	monedaSeleccionada = stringmoneda[1];
	// Cargo el medio de pago elegido..
	stringmepago = '';		
	mformapago = '';
	$(".selectedMPago").each(function(index) {
	   //   console.log(index + ": " + $(this).text());
	 	  stringmepago = $(this).attr('id').split("_");
	  });	
	mformapago = stringmepago[1];

	
	var parametros={
			"llama":"pedirproductosResumen",
			"funcion":"GETRESUMEN",
			"comercio":$("#stcomercios").val(),
			"producto":$("#stproductos").val(),
			"FechaDesde": $("#sFechaBuscarDde").val(),
			"palabraClave": $("#fBuscartexto").val(),
			"FechaHasta":$("#sFechaBuscarHta").val(),
			"FormaPago":mformapago ,
			"Moneda"   :monedaSeleccionada
			};
 	$.ajax({ 
	url:   './apis/iobjconsumo.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){
    	$(destinoid).empty();
    	var productos='';
    },
    done: function(data){},
    success:  function (re){
			//idpersona, usuariopersona, nombrepersona, tipopersona         	  
	   if(re.indexOf("<br />") > -1)
					$(".errores").append(re);
		else
		{
		var r = JSON.parse(re);
		//alert(r['estado']);
        if(r['estado'] == 1) {
        var totalConsulta=0;
        var moneda ='';
         $(r['ObjCons']).each(function(i, v)
		        { // indice, valor
		        detalleProd='';
				var total=0;
		        //console.log(v.Detalle);
	           $(v.Detalles).each(function(u, z){
					//console.log(z.gasFecha);
		        	moneda = z.abrmoneda;
		        	detalleProd += '<div class="claseProducto fondoBlanco">'+
										'<div class="clasePrdIt1">'+z.gasFecha+'</div>'+
										'<div class="clasePrdIt2">'+z.descripcionComercio+'</div>'+
										'<div class="clasePrdIt3">'+z.nombreabrev+'</div>'+
										'<div class="clasePrdIt4">'+z.abrmoneda+'</div>'+
										'<div class="clasePrdIt5">'+z.gasCant+'</div>'+
										'<div class="clasePrdIt6">'+z.gasPUnit+'</div>'+
										'<div class="clasePrdIt7">'+z.descuento+'</div>'+
										'<div class="clasePrdIt8">Ult compra '+z.UltimaVez+' d.</div>'+'</div>';
						var recargo = (-1)*(z.descuento);
						if( z.EsRecargo == 1 )
							{
							   recargo = z.descuento;
							}	 

				       var Cantidad = z.gasCant;
			           var precioUnitario = z.gasPUnit;
						//totalLinea =  (x.gasPUnit*x.gasCant) ;	
		            	total += parseFloat(Cantidad) * parseFloat(precioUnitario) + 
            					     parseFloat(recargo);

				});
				//console.log(totalConsulta);	
					productos +='<div class="ProductoContent">'+
							'<span id="nombreprod" name="nombreprod">'+v.descripcionObjetoCons+'</span>'+
							'<div class="claseProductoCab">'+
								'<div class="clasePrdIt11">Total producto '+moneda+' '+total+ '</div>'+
								'<div class="clasePrdIt12">Total sobre la semana (%)</div>'+
								'<div class="clasePrdIt1">DIA</div>'+
								'<div class="clasePrdIt2">COM.</div>'+
								'<div class="clasePrdIt3">F.DE PAGO</div>'+
								'<div class="clasePrdIt4">PRODUCTO</div>'+
								'<div class="clasePrdIt5">CANT.</div>'+
								'<div class="clasePrdIt6">MON.</div>'+
								'<div class="clasePrdIt7">P. UNI.</div>'+
								'<div class="clasePrdIt8">DESC.</div>'+
							'</div>'+detalleProd+'</div>';
		        	totalConsulta = parseFloat(totalConsulta) + parseFloat(total) ;	
		        });
		        $(destinoid).append(productos);
		        $("#totalConsulta").val(moneda+" "+totalConsulta);
		}
		else {			
				$(".errores").append(re);
			};
		}	
       $(destinoid).prop('disabled', false);
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
				$(".errores").append(xhr);
		}
    });

}

// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$(document).ready(function(){

		var pFechaIni ='';
			pFechaIni = parametroURL('finicio');
		var pFechaFin = '';
			pFechaFin = parametroURL('ffin');
			
		if(pFechaIni != '') $("#sFechaBuscarDde").val(pFechaIni);
		if(pFechaFin != '') $("#sFechaBuscarHta").val(pFechaFin);	
				if(pFechaIni !='' && pFechaFin != '') pedirProductoResumen("#grillaObjetivos");
		
		
		pedirmediospago3('#itemFMPSTS1','mpagoFiltro_',999); // para FILTROS DE BUSQUEDA
		pedirmonedas3('#itemFmonSTS1','monedaFiltro_',999);  // para FILTROS DE BUSQUEDA
		
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
		
		pedircomercio("#stcomercios",99);
		pedirProductos("#stproductos",'');
		
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
			location.href='objetivos.php';
		});
		
		$(".icono2").on("click",function(){
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
			$("#aplicarfiltro").on("click",function(){

			  if( $("#aplicarfiltro").is(':checked') )
  				{
					pedirProductoResumen("#grillaObjetivos");
				}	
			});
		
		
	}); // parentesis del READY
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
</script>

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
	<div class="icono2"></div>
	<div class="icono3"></div>
	<div class="icono4"></div>
	<div class="icono5"></div>
	<div class="icono6"></div>
</div>
<div class="itemAcceso2" id="AdmObjetivos">
	<div class="grillaGastos" id="filtrosGrillaGastos">
           <div class="grillaFiltros">
           	<div class="grillaFiltrositem1">
           		<div class="grillaDeTres">
           			<div class="gDtres01">FILTROS</div>
           			<div class="gDtres02">Aplicar </div>
           			<div class="gDtres03">
           				<input type="checkbox" placeholder="Aplicar Filtros" id="aplicarfiltro"/>
           			</div>
           		</div>
           	</div>
           	<div class="grillaFiltrositem10">Fecha Específica</div>           	
           	<div class="grillaFiltrositem11">
           		<div class="grillaDeDos">
           			<div>
           				<input  type="date" id="sFechaBuscarDde" name="FechaBuscar"/>
           			</div>
           			<div></div>
           			<div>
           				<input  type="date" id="sFechaBuscarHta" name="FechaBuscar"/>
           			</div>
           		</div>	
           	
           	</div>           	
           	<div class="grillaFiltrositem15">
           		MEDIOS DE PAGO
				<div class="itemFMP2" id="itemFMPSTS1"></div>
			</div>
           	<div class="grillaFiltrositem16">
           		MONEDAS
				<div class="itemFmon2" id="itemFmonSTS1"></div>           	
           	</div>
           	<div class="grillaFiltrositem2">
           		 <input  type="text" id="fBuscartexto" name="fBuscartexto" placeholder="Busque palabra exacta"/>
           	</div>
           	<div class="grillaFiltrositem3">
					<select id="stproductos" class="comercioSel">
		  		  		<option value="9999">Seleccione producto...</option>
		  		  	</select>
           	</div>
           	<div  class="grillaFiltrositem4">
  		  		<select id="stcomercios" class="comercioSel">
  		  				<option value="9999">Seleccione comercios...</option>
  		  		</select>
           	</div>
			
           	<div  class="grillaFiltrositem70">
			<div class="gFitem70A">TOTAL DE LA CONSULTA</div>
			<div class="gFitem70B">
				<input id="totalConsulta" name="totalConsulta" type="text" value="" placeholder="Monto total de la consulta" disabled="true" />
			</div>
           	</div>
           	<div  class="grillaFiltrositem5">
				<div class="itemFmon2" id="itemFmon2">
				</div>
           	</div>
           	<div  class="grillaFiltrositem6">
				<div class="itemFMP2" id="itemFMP2">
				</div>
           	</div>           	
           </div>
	</div>
</div>
</div> <!-- lisgta accesos -->

  <!-- grilla de novedades, ultimos cargados -->
	<div class="grillaObjetivos" id="grillaObjetivos">

		  <!-- grilla de novedades, ultimos cargados -->
	</div> <!-- andamioHeader -->
</BODY>
</HTML>
