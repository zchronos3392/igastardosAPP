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


var contadorDescripcionItems=1;
var contadorSubObjetivos=1;//#contadorSubObjetivos


 
function elimnaritem(itemID){
	//alert(itemID);
	$("#"+itemID).remove();
	var numeroItem = $("#contadorItemsVer").text();
	numeroItem--;
	contadorDescripcionItems=numeroItem;
	if(numeroItem==0){
		$("#contadorItemsVer").text('');
	}
	else{
		$("#contadorItemsVer").text(numeroItem);
	}
	totalCalcular();		
}

function sumar(idaSumar){
	var objetoIncrementar = $("#"+idaSumar).val();
		objetoIncrementar++;
	$("#"+idaSumar).val(objetoIncrementar);
	totalCalcular();
	
}

function restar(idaRestar){
	var objetoIncrementar = $("#"+idaRestar).val();
		objetoIncrementar--;
	$("#"+idaRestar).val(objetoIncrementar);
	totalCalcular();
}

function pedirResumen(mesId)
{

	var cadenaHTML="";
	//console.log('mes recibido a consultar: '+mesId);

	$(".selectedMPago").each(function(index) {
	 //     console.log(index + ": " + $(this).text());
	 	  stringmepago = $(this).attr('id').split("_");
	  });	

	// var stringmepago = $( ".itemgMPa BUTTON.selectedMPago" ).attr("id").split("_");
	mformapago = stringmepago[1];
	//alert( " id ("+mformapago+" ) de la MEDIO DE PAGO SELECC., Descripcion abreviada:" + $( ".itemgMPa BUTTON.selectedMPago" ).html());

	var parametros=
	{
			"funcion":"RESUMES",
			"ianio": $("#ianio").val(),
			"imes" : mesId,
			"mformapago": mformapago,
	};


	$.ajax({ 
    url:   './apis/ioegresos.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function ( ){},
    done: function(data){},
    success:  function (re){

		if(re.indexOf("<br />") > -1)
					$(".errores").append(re);
		else
		{
		var r = JSON.parse(re);
        if(r['estado'] == 1)
		{
		 $(".grillaTotales").empty();	
		 $(".grillaResumenitem3").empty();
		 
         $(r['gastos']).each(function(i, v)
		    { // indice, valor
					// <div class="grillaTotales">
					// 		<div class="gIngreso">
					// 			<div>$ PESO</div>		
					// 			<div>333.222,055</div>
					// 			<div>SAC ACRED</div>
					// 		</div>
					// 		<div class="gEgreso">

					cadenaHTML='<div class="gRestante">'+
							'<div>Restante efectivo</div>'+		
							'<div>'+v['RestanteEFEMON']+'</div>'+		
							'<div>'+v['RestanteEFE']+'</div>'+
							'<div>'+$("#selectMes option:selected").text()+'</div>'+
							'</div>';	
				$(".grillaTotales").append(cadenaHTML);
						
				$(v['Ingresos']).each(function(j, w)
		        { // indice, valor
					cadenaHTML='<div class="gIngreso">'+
								'<div>'+w.moneda+'</div>'+		
								'<div>'+w.Monto+'</div>'+
								'<div>'+w.gasDescripcion+'</div>'+
								'</div>';	
					$(".grillaTotales").append(cadenaHTML);
				});
				cadenaHTML='';
				// hay varios egresos, por medio de pago y moneda
				$(v['Egreso']).each(function(j, w)
		        { // indice, valor
					 cadenaHTML ='<div class="gEgreso">'+
								    '<div class="gEgreso1">'+w.descripcionmediopago+'</div>'+		
								    '<div class="gEgreso2">'+w.moneda+'</div>'+		
								    '<div class="gEgreso3">'+w.Monto+'</div>'+
								     '<div class="gEgreso4"> Gtos de '+$("#selectMes option:selected").text()+'</div>'+
								  '</div>';	
						$(".grillaTotales").append(cadenaHTML);
				});
				// 	TOPS PARA EL RESUMEN CON FECHA TOTAL DE INTERVALO
					// MAS COMPRADOS
					// MAS CAROS
				cadenaHTML ='';
				var Estado='OK';
				if(v['xTopGastosRepetido'].length > 0)
				{
					$(v['xTopGastosRepetido']).each(function(y, z)
								{ // indice, valor
									$(z).each(function(a, b)
										{ // indice, valor
										if(y==0 && a==0)
										{
										cadenaHTML+= '<div class="xgrillaTopsResumen xTITrepetidos">'+	
											'		<div class="igtopres_1">Compras</div>'+
											'		<div class="igtopres_2">repetidas</div>'+
											'		<div class="igtopres_3">en</div>'+
											'		<div class="igtopres_4">el</div>'+
											'		<div class="igtopres_5">mes</div>'+
											'   </div>';
										}			
										//console.log(' indice: '+a+' valor: '+b.descripcionComercio);
										cadenaHTML += '	<div class="xgrillaTopsResumen xrepetidos">	<div class="igtopres_1">'+b.gasDescripcion+'</div>'+
											'		<div class="igtopres_2">'+b.Conteo+'</div>'+
											'		<div class="igtopres_3">'+b.Monto+'</div>'+
											'		<div class="igtopres_4"></div>'+
											'		<div class="igtopres_5"></div>'+
											'   </div>';
										});
								});
				}	
				if(v['xTopGastosGrandes'].length > 0)
				{
					$(v['xTopGastosGrandes']).each(function(y, z)
								{ // indice, valor
									$(z).each(function(a, b)
										{ // indice, valor
										if(y==0 && a==0)
										{
										cadenaHTML += '<div class="xgrillaTopsResumen xTITgasGrandes">'+	
											'		<div class="igtopres_1"></div>'+
											'		<div class="igtopres_2">Mayores compras</div>'+
											'		<div class="igtopres_3">realizadas</div>'+
											'		<div class="igtopres_4">en el </div>'+
											'		<div class="igtopres_5">mes</div>'+
											'   </div>';
										}			

										//console.log(' indice: '+a+' valor: '+b.descripcionComercio);
										cadenaHTML += '	<div class="xgrillaTopsResumen xgasGrandes">	<div class="igtopres_1">'+b.gasDescripcion+'</div>'+
											'		<div class="igtopres_2">'+b.Conteo+'</div>'+
											'		<div class="igtopres_3">'+b.Monto+'</div>'+
											'		<div class="igtopres_4"></div>'+
											'		<div class="igtopres_5"></div>'+
											'   </div>';

										});
								});
				}				
				// 	TOPS PARA EL RESUMEN CON FECHA TOTAL DE INTERVALO
				$(".grillaTotales").append(cadenaHTML);
				cadenaHTML='';
				if(v['Semanas'].length > 0)
				{
					$(v['Semanas']).each(function(i, j)
					{ // indice, valor
						// console.log('inicio: ' +j.FechaInicio+' fin '+ j.FechaFin);	
						AcumuladosGastos = '';
						GastosComercio   = '';
						TopsResumen   = '';
					var GastosCargados = 0;		
						$(j.OBJETIVODETALLE).each(function(w, u) //W=0,1,2
						{ // indice, valor
							Estado='OK';
							// console.log(' indice: '+w+' valor: '+u.medionombre);
							if(u.montoTotal > u.montoFraccion)
								Estado='NOOK';

							AcumuladosGastos+= '	<div class="grillaMPMonObjetivos">	<div class="igobjeti_1">'+u.medionombre+'</div>'+
											'		<div class="igobjeti_2">'+u.monedanombre+' - '+u.montoFraccion+'</div>'+
											'		<div class="igobjeti_3">'+u.monedanombre+' - '+u.montoTotal+'</div>'+
											'		<div class="igobjeti_4">'+Estado+'</div>'+
											'		<div class="igobjeti_5"></div>'+
											'   </div>';
							if(GastosCargados == 0){	
							$(u.GastosDetalle).each(function(y, z)
								{ // indice, valor
									$(z).each(function(a, b)
										{ // indice, valor
										//console.log(' indice: '+a+' valor: '+b.descripcionComercio);
										GastosComercio+= 	'<div class="GastoComX">'+
										    '					<div class="DGastoComX1">'+b.gasFecha+'</div>'+										
											'					<div class="DGastoComX1">'+b.descripcionComercio+'</div>'+
											'					<div class="DGastoComX11">'+b.nombreabrev+'</div>'+									
											'						<div class="DGastoComX2">'+b.moneda+' - '+b.Monto+'</div>'+
											'					</div>';
										});
										GastosCargados =1;
								});

								$(u.TopGastosRepetido).each(function(y, z)
								{ // indice, valor
									$(z).each(function(a, b)
										{ // indice, valor
										if(y==0 && a==0)
										{
										TopsResumen += '<div class="grillaTopsResumen TITrepetidos">'+	
											'		<div class="igtopres_1">DESCRIPCION</div>'+
											'		<div class="igtopres_2">Repeticiones</div>'+
											'		<div class="igtopres_3">Monto</div>'+
											'		<div class="igtopres_4"></div>'+
											'		<div class="igtopres_5"></div>'+
											'   </div>';
										}			
										//console.log(' indice: '+a+' valor: '+b.descripcionComercio);
										TopsResumen += '	<div class="grillaTopsResumen repetidos">	<div class="igtopres_1">'+b.gasDescripcion+'</div>'+
											'		<div class="igtopres_2">'+b.Conteo+'</div>'+
											'		<div class="igtopres_3">'+b.Monto+'</div>'+
											'		<div class="igtopres_4"></div>'+
											'		<div class="igtopres_5"></div>'+
											'   </div>';
										});
								});
								
								$(u.TopGastosGrandes).each(function(y, z)
								{ // indice, valor
									$(z).each(function(a, b)
										{ // indice, valor
										if(y==0 && a==0)
										{
										TopsResumen += '<div class="grillaTopsResumen TITgasGrandes">'+	
											'		<div class="igtopres_1">DESCRIPCION</div>'+
											'		<div class="igtopres_2">Repeticiones</div>'+
											'		<div class="igtopres_3">Monto</div>'+
											'		<div class="igtopres_4"></div>'+
											'		<div class="igtopres_5"></div>'+
											'   </div>';
										}			

										//console.log(' indice: '+a+' valor: '+b.descripcionComercio);
										TopsResumen += '	<div class="grillaTopsResumen gasGrandes">	<div class="igtopres_1">'+b.gasDescripcion+'</div>'+
											'		<div class="igtopres_2">'+b.Conteo+'</div>'+
											'		<div class="igtopres_3">'+b.Monto+'</div>'+
											'		<div class="igtopres_4"></div>'+
											'		<div class="igtopres_5"></div>'+
											'   </div>';

										});
								});


							}	

						});
					// GastosComercio+
					//  console.log(GastosComercio);
						cadenaHTML += '<div class="Semana">'+
									'<div class="itemsemana1">SEMANA</div>'+
									'<div class="itemsemana2">'+(i+1)+'</div>'+
										'<div class="itemsemana3">MES</div>'+
										'<div class="itemsemana4">'+$("#selectMes option:selected").text()+'</div>'+
										'<div class="itemsemana5">'+
										'	<div class="grillaMPMonOBj">'+
												AcumuladosGastos+
												TopsResumen+
										'	</div>'+
										'</div>'+
										'<div class="itemsemana6">'+
										'	<div class="DetalleGasto">'+
										'		<div class="DlleGto1">Detalle del gasto por semana</div>'+
										'			<div class="DlleGto2" id="DlleGto2">'+
														GastosComercio+
										'		    </div>'+
										'	</div>'+
										'</div>'+
									'</div>';						
						$(".grillaResumenitem3").append(cadenaHTML);
						cadenaHTML ='';
					});
			    }
			    else
			    	$(".grillaResumenitem3").append('<div>No hay objetivos cargados.No es posible el analisis</div>');
		    });
		}
		else {			
				$(".errores").append(re);
			};
		}			

	},
    	error: function (xhr, ajaxOptions, thrownError)
    	{
				$(".errores").append(xhr);
		}
    	});	



}
function pedirMeses(destinoID){


	var parametros=
	{
			"funcion":"MESES",
			"ianio": $("#ianio").val()
	};


 	$.ajax({ 
    url:   './apis/ioegresos.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function ( ){$(destinoID).empty();},
    done: function(data){},
    success:  function (re){

		if(re.indexOf("<br />") > -1)
					$(".errores").append(re);
		else
		{
		var r = JSON.parse(re);
        if(r['estado'] == 1)
		{
         $(r['gastos']).each(function(i, v)
		        { // indice, valor
		    //TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
			// unidadmedidaid, descripcionumedida
		        	if (! $(destinoID).find("option[value='" + v.MesVal+ "']").length)
		        	{						
						  $(destinoID).append('<option value="' + v.MesVal + '">' +
						   v.MesDescripcion+'</option>');
					}		
		        });
		}
		else {			
				$(".errores").append(re);
			};
		}			

	},
    	error: function (xhr, ajaxOptions, thrownError)
    	{
				$(".errores").append(xhr);
		}
    	});	

}

// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$(document).ready(function(){

	$("#grillaResultadosExtra").hide();

	$("#ianio").on("change",function()
	{
		$("#ianio").prop('disabled', true);
		//grabar año en sesion
			grabarsesion("IANIO",$("#ianio").val());
			location.reload();
	});

$("#BuscarExtras").on("click",function()
{
	// pedirResumenExtraFiltros("#iGexRes3");
		pedirResumenExtraFiltros("#grillaResultadosExtra");
		$("#grillaResultadosExtra").toggle();
});


$("#cargarotroanio").on("click",function()
{
  if( $("#cargarotroanio").is(':checked') )
  {
	    $("#ianio").prop('disabled', false);

  } else
   {
		//SI ESTABA ABIERTO, DESACTIVO EL COMBO DE AÑO Y LO PONGO EN AÑO ACTUAL
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

			$("#FechaTicket").val(FechaDia);
			$("#FechaDesdeVigencia").val(FechaDia);
			$("#FechaHastaVigencia").val(FechaDia);
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		$("#grillaResumen").hide();
		$("#grillaExtras").hide();


		$("#verFiltros").on("click",function()
		{
			$("#grillaFiltros").toggle();
				$("#grillaGastos").toggle();
			$("#grillaResumen").hide();
			$("#grillaExtras").hide();
		
		});	
		$("#verResumen").on("click",function()
		{
			$("#grillaFiltros").hide();
				$("#grillaGastos").hide();
			$("#grillaResumen").toggle();
			$("#grillaExtras").hide();
				pedirMeses('#selectMes');
		
		});	

		$("#selectMes").on("change click",function(){
				pedirResumen( $("#selectMes").val() );

		});


		$("#verExtras").on("click",function()
		{
			$("#grillaFiltros").hide();	
				$("#grillaGastos").hide();
			$("#grillaResumen").hide();
			$("#grillaExtras").toggle();
		
		});					

			$("#fraccionTipo").on("click change",function()
			{
			   if($("#fraccionTipo").val() == 'DIA') $("#fraccionTiempo").val(1);	
			   if($("#fraccionTipo").val() == 'SEMANA') $("#fraccionTiempo").val(7);	
			   if($("#fraccionTipo").val() == 'QUINCENA') $("#fraccionTiempo").val(15);			
			});

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
		$("#filtroFechaGastos").val('ESTAQUINCENA');
//+++++++++++++++++++++++++++++++LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++
		pedircomercio('#comercios',99);
			pedircomercio('#gcomercio',99);
				pedircomercio('#fcomercios',99);
					pedircomercio('#GEXcomercios',99);

		pedirmonedas('#imonedas',99);
			pedirmonedas2('#itemgmon2',99);
			//pedirmonedas2('#itemFmon2',99);//FILTROS DE BUSQUEDA
			pedirmonedas3('#itemFmon2','monedaFiltro_',99);//FILTROS DE BUSQUEDA
		pedirObjetivos('#iobjetivos',"select",99);
			
		pedirmediospago('#imediospago',99);
		pedirmediospago3('#RESgMPa','resMPGA_',999); // para FILTROS DE BUSQUEDA

			pedirmediospago2('#itemgmpa2',99);

			//pedirmediospago2('#itemFMP2',99); //para FILTROS DE BUSQUEDA
			pedirmediospago3('#itemFMP2','mpagoFiltro_',99); //para FILTROS DE BUSQUEDA
		pedirumedidas('#iumed',99);
		pedirtipos('#igtipos','');
		pedirtipos('#comerciotipo','COMERCIO');
		
		
		pedirTickets("#grillaGastos",99);
			pedirProductos("#gproductos",'');
			pedirProductos("#GEXproductos",'');

		$("#FechaBuscarDde").on("change",function(){
			//pedirTickets("#grillaGastos",99);
			$("#FechaBuscarHta").val($("#FechaBuscarDde").val());			
		});
		$("#FechaBuscarHta").on("change",function(){
			pedirTickets("#grillaGastos",99);			
		});

		
		$("#SonCuotas").on("change",function(){
			pedirTickets("#grillaGastos",99);			
		});
		
		$("#filtroFechaGastos").on("change",function(){
			pedirTickets("#grillaGastos",99);			
		});
		

		$("#gproductos").on("change",function(){
			pedirTickets("#grillaGastos",99);			
		});

		$("#fcomercios").on("change",function(){
			pedirTickets("#grillaGastos",99);			
		});

		$("#iobjetivos").on("click",function(){
			
			pedirObjetivos('#GrillaObjetivos',"verDIV2",$("#iobjetivos").val());
				pedirSubObjetivos($("#iobjetivos").val());
	
		});
		
		
		$("#gComFiltro").on("change",function(){
			filtrarComercio("#gcomercio","gComFiltro");
		});

		$("#comerciobuscar").on("change",function(){
			filtrarComercio("#fcomercios","comerciobuscar");
		});

		$("#GEXcomerciobuscar").on("change",function(){
			filtrarComercio("#GEXcomercios","GEXcomerciobuscar");
		});


		$("#productobuscar").on("change",function(){
			filtrarProducto("#gproductos","productobuscar");
		});
		$("#GEXproductobuscar").on("change",function(){
			filtrarProducto("#GEXproductos","GEXproductobuscar");
		});



		
  		  	//<input type="text" class="FormNombres" id="descripciontipo" />
  		  	//<input type="text" class="FormNombres" id="tablaPertenece" />

		$(".itemAcceso1").hide();
		$(".itemAcceso2").hide();
		$(".itemAcceso3").hide();
		$(".itemAcceso4").hide();
		$(".itemAcceso5").hide();
		$(".itemAcceso6").hide();
		$(".itemAcceso7").hide();
		$(".itemAcceso8").hide();
		$(".itemAcceso9").hide();				

		$("#comercios").on("click change",function(){

			var datosComercio =$("#comercios option:selected").text().split('-');	
				//console.log(datosComercio[0] +' / ' +datosComercio[1]);
			 $('#comercioNombre').val(datosComercio[0]);
			 $('#comerciotipo').val(datosComercio[1].trim());
			 $('#comercioID').val($("#comercios option:selected").val());
		});

		$("#AgregaComercio").on("click",function(){
			agregacomercio('#comercios');
		});

		$("#EliminarComercio").on("click",function(){
			eliminacomercio('#comercios');
					pedircomercio('#gcomercio',99);
					pedircomercio('#fcomercios',99);
					pedircomercio('#GEXcomercios',99);
		});
		
		$("#AgregaMP").on("click",function(){
			agregampago('#imediospago');
				pedirmediospago2('#itemgmpa2',99);
				pedirmediospago2('#itemFMP2',99); //para FILTROS DE BUSQUEDA
			
		});

		$("#EliminarMP").on("click",function(){
			eliminampago('#imediospago');
				pedirmediospago2('#itemgmpa2',99);
				pedirmediospago2('#itemFMP2',99); //para FILTROS DE BUSQUEDA

		});

		$("#AgregaMon").on("click",function(){
			agregamoneda('#imonedas');
				pedirmonedas2('#itemgmon2',99);
				pedirmonedas2('#itemFmon2',99);//FILTROS DE BUSQUEDA
			
		});

		$("#EliminarMon").on("click",function(){
			eliminamoneda('#imonedas');
				pedirmonedas2('#itemgmon2',99);
				pedirmonedas2('#itemFmon2',99);//FILTROS DE BUSQUEDA
		});


		$("#AgregaUM").on("click",function(){
			agregaunimedidas('#iumed');
		});

		$("#EliminarUM").on("click",function(){
			eliminaunimedidas('#iumed');
		});


		$("#AgregaTipoTabla").on("click",function(){
			agregatipos('#igtipos');
				pedirtipos('#comerciotipo','COMERCIO');
				pedirtipos('#tablaPertenece','');				
			
		});

		$("#EliminarTipo").on("click",function(){
			eliminatipos('#igtipos');
				pedirtipos('#comerciotipo','COMERCIO');			
				pedirtipos('#tablaPertenece','');								
		});


		$("#correrstoreprocedure01").on("click",function(){
			agregaobjetosconsumo();						

		});


		$("#irObjConsumoLista").on("click",function(){
			location.href='objetosconsumo.php'; 
		});

		// Copia estructura descripcion ,ACA HAY MODIFICAR PARA
		// HACER CAMBIOS EN EL FORMULARIO DE INGRESO DE GASTOS..
		$("#agregaDescripcion").on("click",function(){
			if($("#contadorItemsVer").text() == '')
				contadorDescripcionItems = 1;
			else{
				contadorDescripcionItems  = $("#contadorItemsVer").text();
				contadorDescripcionItems++;	
			}
			
			$("#contadorItemsVer").text(contadorDescripcionItems);

// AGREGAMOS UNA COPIA CON EL NUEVO ESTILO HASTA QUE FUNCIONE 
	// .descitem1 ID RENGLON 
	// .descitem2,Titulo Descripción 
	// .descitem3, eliminar producto 
	// .descitem4, texto sugerible de producto 
	// .descitem5,cantidad 
	// .descitem6, precio unitario 
	// .descitem7, umedidas 
	// .descitem8, descuentos 
	// .descitem9, monto total acumulado.
			$("#itemsTicket").append( 
				'<div id="DSCCONTENEDOR_'+contadorDescripcionItems+'" >'+
					'<div class="idescripcion">'+
					'<input type="hidden" id="idregistro_0" value="0"></input> '+
					'<div class="idescitem1">Item</div>'+
					'<div class="idescitem11">Producto</div>'+
					'<div class="idescitem12">Cantidad</div>'+
					'<div class="idescitem13">Precio Unitario</div>'+
					'<div class="idescitem14">Unidades</div>'+
					'<div class="idescitem15">Descuento</div>'+
					'<div class="idescitem16">Total Parcial</div>'+
					'<div class="idescitem2" onclick="elimnaritem(\'DSCCONTENEDOR_'+contadorDescripcionItems+'\');">(X)</div>'+

					'<div class="idescitem10">'+contadorDescripcionItems+'</div>'+
					'<div class="idescitem4">'+
						'<input type="text" value="" class="descripciontext" id="descripcion_'+contadorDescripcionItems+'"  onkeyUp="sugerir(this.id,'+contadorDescripcionItems+');" /><div id="suggestions_'+contadorDescripcionItems+'" class="suggestions" ></div>'+
					'</div>'+
					'<div class="icantidad idescitem5">'+
						'<div class="iitemcant1">'+
							'<input type="number" value="" id="cantidad_'+contadorDescripcionItems+'"  onclick="borrarSugerencia('+contadorDescripcionItems+');" onkeyup="totalCalcular();"  />'+
						'</div>'+
					'</div>'+
					'<div class="ipreciounit idescitem6">'+
						'<div class="iitempun1">'+
							'<input type="number" value="" id="pun_'+contadorDescripcionItems+'" onkeyup="totalCalcular();" />'+
						'</div>'+
					'</div>'+
					'<div class="iumedidas idescitem7">'+
						  '<div class="iitemumed1">'+
						  '<select id="iumedidas_'+contadorDescripcionItems+'" class="comercioSel">'+
  		  					'<option value="9999">Unidad medida</option>'+
  		  				  '</select>'+
  		  				  '</div>'+
					'</div>'+
					'<div class="idescuento idescitem8">'+
						'<div class="iitemdis1">'+
							'<input type="number" value="" id="dis_'+contadorDescripcionItems+'" onkeyup="totalCalcular();" ></input>'+
						'</div>'+
						'<div class="iitemdis2">'+
							'<input type="checkbox" id="EsRecargo_'+contadorDescripcionItems+'" value="0"  onclick="totalCalcular();" ></input>'+
						'</div>'+
					'</div>'+
					'<div class="idescitem9"><input type="text" id="montoparcial_'+contadorDescripcionItems+'" disabled="true"></input></div>'+
				'</div>');
// COPIA CON EL NUEVO ESTILO HASTA QUE FUNCIONE										
				pedirumedidas('#iumedidas_'+contadorDescripcionItems,99);	
				
		});

	
	$("#InsertaGasto").on("click",function(){

	//necesito cargar las descripciones:
	var items= new Array();	

	items = cargarItems(); //VECTOR CON INDICE A PARTIR DE 1
	//console.log(	items.toString() );

	var stringmoneda = $( ".itemgmon BUTTON.selectedMon" ).attr("id").split("_");
	monedaSeleccionada = stringmoneda[1];
	//alert( " id ("+monedaSeleccionada+") de la MONEDA SELECCIONADA, abrev: " + $( ".itemgmon BUTTON.selectedMon" ).html());	
	var stringmepago = $( ".itemgMPa BUTTON.selectedMPago" ).attr("id").split("_");
	mformapago = stringmepago[1];
	
	var stringtipomov1 = $( ".inputI.selectedINPUT" ).attr("id");
	var stringtipomov2 = $( ".inputE.selectedINPUT" ).attr("id");
	var TipoMovParm = '';
	
	if(stringtipomov1 != undefined) 
		TipoMovParm= $( ".inputI.selectedINPUT" ).html();

	if(stringtipomov2 != undefined) 
		TipoMovParm= $( ".inputE.selectedINPUT" ).html();
	
	//alert( " id1 ("+stringtipomov1+" ) de la TIPO MOV SELECC., Descripcion abreviada:" + $( ".inputI.selectedINPUT" ).html());
	//alert( " id2 ("+stringtipomov2+" ) de la TIPO MOV SELECC., Descripcion abreviada:" + $( ".inputE.selectedINPUT" ).html());

	//alert(TipoMovParm);

	 
	var esGastoFijo = 0;
	if( $("#EsGastoFix").is(':checked') )
		esGastoFijo=1;


	var parametros=
	{
		    "gasFecha": $("#FechaTicket").val(),
		    "ComercioId": $("#gcomercio").val(),
		    "items"		: items,
		    "moneda": monedaSeleccionada,
		    "descgenDesc":$("#descgenDesc").val(),
		    "descuentogenmonto":$("#descuentogenmonto").val(),
		    "mformapago": mformapago,
		    "cuotas":$("#numcuotas").val(),
		    "totalCuotas" : $("#totalCalculado").val(),
			"llama":"insertar",
			"tipoMovimiento":TipoMovParm,
			"esGastoFijo":esGastoFijo,
			"funcion":"PUT"
	};


 	$.ajax({ 
    url:   './apis/ioegresos.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){},
    done: function(data){},
    success:  function (re){
    	 location.reload();
     },
    	error: function (xhr, ajaxOptions, thrownError)
    	{
				$(".errores").append(xhr);
		}
    	});

	}); // fin funcion InsertaGasto

		$("#botonvolverMain").on("click",function(){
			location.reload();
		});

		$("#mediopagonombre").on("click change",function(){$("#mediopagonombre").html();});
		$("#mediopagoabrev").on("click change",function(){$("#mediopagoabrev").html();});
		
		$(".icono1").on("click",function(){
			//CARGAR/INGRESAR GASTO...
			$(".itemAcceso1").toggle();
				$(".itemAcceso2").hide();
					$(".grillaGastos").toggle();
				$(".itemAcceso3").hide();
				$(".itemAcceso4").hide();
				$(".itemAcceso5").hide();
				$(".itemAcceso6").hide();
				$(".itemAcceso7").hide();
				$(".itemAcceso8").hide();
				$(".itemAcceso9").hide();								
		});
		
		$(".icono2").on("click",function(){
				location.href='objetivos.php';
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
		
		$(".icono8").on("click",function(){
			$(".itemAcceso8").toggle();				
				$(".itemAcceso1").hide();
				$(".grillaGastos").toggle();
				$(".itemAcceso2").hide();
				$(".itemAcceso3").hide();
				$(".itemAcceso4").hide();
				$(".itemAcceso5").hide();
				$(".itemAcceso6").hide();
				$(".itemAcceso9").hide();
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
	<div class="icono1"><span class="icon-upload" title="GASTOS"></span></div>	
	<div class="icono2"><span class="icon-time-slot" title="OBJETIVOS"></span></div>
	<div class="icono3"><span class="icon-shopping-cart" title="Comercios"></span></div>
	<div class="icono4"><span class="icon-credit-card" title="medios de pago"></span></div>
	<div class="icono5"><span class="icon-vinyl" title="Monedas"></span></div>
	<div class="icono6"><span class="icon-ruler" title="Unidades"></span></div>
	<div class="icono7"><span class="icon-bookmarks" title="Tipos por tabla"></span></div>
	<div class="icono8"><span class="icon-archive" title="Procesos"></span></div>
	<div class="icono9"><span class=""></span></div>
	<div class="icono10"><span class=""></span></div>
</div>
<div class="itemAcceso1" id="AdmGastos">
		<div class="FormEgresos">
		<div class="AccionesEgresos">
			<div class="itemaccioneg1">
				<input type="date" id="FechaTicket"/>
			</div>
			<div class="itemaccioneg2">
				<button class="botonMas" id="InsertaGasto" title="Grabar evento en base">+</button>
			</div>
			<div class="itemaccioneg22">
				<button class="botonvolverMain" id="botonvolverMain">
					<span class="icon-arrow-left"></span>
				</button>
			</div>			
			<div class="itemaccioneg3">
					<button  class="botonMasDsc" id="agregaDescripcion" title="Generar nuevo item">+</button>
			</div>
			<div class="itemaccioneg4">
					Total a Pagar
					<input type="text" id="totalCalculado" disabled="true"/>
			</div>					
			<div class="itemaccioneg43">
					Desc Total
					<input type="text" id="totalDescuentos" disabled="true"/>
			</div>					

			<div class="itemaccioneg44">
					<span id="contadorItemsVer"></span>
			</div>
			<div class="itemaccioneg45">
				<div class="itac45a">DESC.GEN.CONCPT</div>
				<div class="itac45b">
				  <input type="text" id="descgenDesc" placeholder="Descuento general ticket razón" value="No"/>				</div>
			<div class="itac45c">
				<input  type="number" id="descuentogenmonto" placeholder="0.000" value="0.000"/>
			</div>
			<div class="itac45D">Fijo</div>
			<div class="itac45E">
	           	<input  type="checkbox" id="EsGastoFix" name="EsGastoFix"/>
			</div>
		  	</div>	
			<div class="itemaccioneg5">
				<div class="gCom">
					<div class="itemgcom10">Filtro Com.</div>
					<div class="itemgcom11"><input type="text" id="gComFiltro" name="gComFiltro" /></div>
					<div class="itemgcom1">Comercio</div>
					<div class="itemgcom2">
		  		  		<select id="gcomercio" class="comercioSel">
		  		  				<option value="9999">Seleccione comercio</option>
		  		  		</select>
					</div>					
				</div>
			</div>				
			<div class="itemaccioneg52">
				<div class="gTipoEI">
					<div class="itemgTipoEI1">Tipo</div>
					<div class="itemgTipoEI2">
						<button class="inputI" id="EsIngreso" onclick="seleccionIE('EsIngreso');">I</button>
					</div>
					<div class="itemgTipoEI3">
						<button class="inputE" id="EsEgreso" onclick="seleccionIE('EsEgreso');">E</button>
					</div>	  		  		
				</div>
			</div>							
			<div class="itemaccioneg51">
				<div class="gCuotas">
					<div class="itemgcuota1">Cuotas</div>
					<div class="itemgcuota2">
						<input type="number" id="numcuotas"  name="numcuotas" placeholder="Cantidad de cuotas a dividir el monto" value="0"/>
					</div>
					<div class="itemgcuota3">Descripcion cuota</div>					
					<div class="itemgcuota4">
						  <input type="text" id="observaciones1"  name="observaciones1" placeholder="Descripcion de cuota" value="." disabled="true"/>
					</div>	  		  		
				</div>
			</div>				
			<div class="itemaccioneg6">
				<div class="gMon" id="gMon">
					<div class="itemgmon1">Monedas</div>
					<div class="itemgmon2" id="itemgmon2">
					</div>
				</div>	
			</div>
			<div class="itemaccioneg7">
				<div class="gMPa" id="gMPa">
					<div class="itemgmpa1">Medios Pago</div>
					<div class="itemgmpa2"  id="itemgmpa2">
							<div class="itemgMPa">
									<button class="moneda" id="MPAGO">MPAGO</button>
							</div>					
							<div class="itemgMPa">
									<button class="moneda" id="MPAGO">MPAGO</button>
							</div>					
							<div class="itemgMPa">
									<button class="moneda" id="MPAGO">MPAGO</button>
							</div>					
							<div class="itemgMPa">
									<button class="moneda" id="MPAGO">MPAGO</button>
							</div>					
							<div class="itemgMPa">
									<button class="moneda" id="MPAGO">MPAGO</button>
							</div>					
							<div class="itemgMPa">
									<button class="moneda" id="MPAGO">MPAGO</button>
							</div>																					</div>									
				</div>	
			</div>
			<div class="itemaccioneg8">
			</div>				
		</div>
		<div class="itemsTicket" id="itemsTicket"></div>
	</div>
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
				<button class="accionBoton" value="Agrega objetivo" id="AgregarObjetivo">+</button>
			</div>
			<div class="gtititem21">
			 <button class="accionBoton" value="Elimina objetivo" id="EliminarObjetivo">-</button>
			</div>			
			<div class="gtititem20">
				<button class="agregarBoton" value="Objetivos" id="irObjetivos">-></button>
			</div>			
					
		</div>
	</div>
	<div class="objitem2">

	</div>
</div>



</div>
</div>
<div class="itemAcceso3" id="AdmComercio">
  		<div class="FormComercios">
  		  <div class="itemFCom1">Comercios</div>
  		  <div class="itemFCom2">
  		  		<select id="comercios" class="comercioSel">
  		  				<option value="9999">Seleccione comercio</option>
  		  		</select>
  		  </div>  		  
  		  <div  class="itemFCom3">
  		  	<button class="agregarBoton" id="EliminarComercio" />-
  		  </div>  		   
  		  <div class="itemFCom4"><span>Comercio</span><input type="text" class="FormNombres" id="comercioNombre" />
</div>
  		  <div class="itemFCom5"><span>Tipo</span>
  		  		<select id="comerciotipo" class="comercioSel">
  		  				<option value="9999">Seleccione Tipo</option>
  		  		</select>
  		  </div>
  		  <div  class="itemFCom6">
  		  	<button class="agregarBoton" id="AgregaComercio" />+
			<input type="hidden" id="comercioID" name="comercioID" value="0" />
  		  </div>  		   
  		</div>	
</div>
<div class="itemAcceso4"  id="AdmMediosPago">
  		<div class="FormMediosPago">
  		  <div class="itemFMP1">Medios de Pago</div>
  		  <div class="itemFMP22">
  		  		<select id="imediospago" class="comercioSel">
  		  				<option value="9999">Seleccione Forma de pago</option>
  		  		</select>
  		  </div>  		  
  		  <div  class="itemFMP3">
  		  	<button class="agregarBoton" id="EliminarMP" />-
  		  </div>  		   
  		  <div class="itemFMP4">Medio Pago</div>
  		  <div class="itemFMP5">
  		  		<input type="text" class="FormNombres" id="mediopagonombre" placeholder="FRANCES BBVA"/>
  		  </div>
  		  <div class="itemFMP555">
  		  		<input type="text" class="FormNombres" id="mediopagoabrev" placeholder="BBVA"/>
  		  </div>  		  
  		  <div  class="itemFMP6">
  		  	<button class="agregarBoton" id="AgregaMP" />+
  		  </div>  		   
  		</div>	
</div>
<div class="itemAcceso5"  id="AdmMonedas">
  		<div class="FormMonedas">
  		  <div class="itemFMon1">Monedas</div>
  		  <div class="itemFMon22">
  		  		<select id="imonedas" class="comercioSel">
  		  				<option value="9999">Seleccione moneda</option>
  		  		</select>
  		  </div>  		  
  		  <div  class="itemFMon3">
  		  	<button class="agregarBoton" id="EliminarMon" />-
  		  </div>  		   
  		  <div class="itemFMon4"><span>Moneda</span><input type="text" class="FormNombres" id="monnombre" />
</div>
  		  <div class="itemFMon5"><span>Mon.Abr.</span>
  		  		<input type="text" class="FormNombres" id="abreviatura" />
  		  </div>
  		  <div  class="itemFMon6">
  		  	<button class="agregarBoton" id="AgregaMon" />+
  		  </div>  		   
  		</div>	
</div>  	
<div class="itemAcceso6"  id="AdmUMed">
  		<div class="FormUMed">
  		  <div class="itemFUM1">UNIDADES</div>
  		  <div class="itemFUM2">
  		  		<select id="iumed" class="comercioSel">
  		  				<option value="9999">Unidad medida</option>
  		  		</select>
  		  </div>  		  
  		  <div  class="itemFUM3">
  		  	<button class="agregarBoton" id="EliminarUM" />-
  		  </div>  		   
  		  <div class="itemFUM4">Unidad</div>
  		  <div class="itemFUM5">
  		  		<input type="text" class="FormNombres" id="umednombre" />
  		  </div>
  		  <div  class="itemFUM6">
  		  	<button class="agregarBoton" id="AgregaUM" />+
  		  </div>
  		  <div class="itemFUM7">Abrev Unidad</div>
  		  <div class="itemFUM8">
  		  		<input type="text" class="FormNombres" id="umednombreabrev" />
  		  </div>
  		  <div class="itemFUM9"></div>
  		</div>	
</div>  

<div class="itemAcceso7" id="AdmTipos">
  		<div class="FormTipos">
  		  <div class="itemFTT1">Tipos tabla</div>
  		  <div class="itemFTT2">
  		  		<select id="igtipos" class="comercioSel">
  		  				<option value="9999">Seleccione tipos</option>
  		  		</select>
  		  </div>  		  
  		  <div  class="itemFTT3">
  		  	<button class="agregarBoton" id="EliminarTipo" />-
  		  </div>  		   


  		  <div class="itemFTT4"><span>Tipo</span>
  		  	<input type="text" class="FormNombres" id="descripciontipo" />
		 </div>
  		  <div class="itemFCTT5"><span>Tabla</span>
  		  		<select id="tablaPertenece" class="comercioSel">
  		  				<option value="COMERCIO">COMERCIO</option>
  		  				<option value="TIPOS">TIPOS</option>
  		  				<option value="MONEDA">MONEDA</option>
  		  				<option value="UNIDADES">UNIDADES</option>
  		  		</select>  		  
  		  </div>
  		  <div  class="itemFTT6">
  		  	<button class="agregarBoton" id="AgregaTipoTabla" />+
  		  </div>  		   
  		</div>	
</div>		

<div class="itemAcceso8" id="AdmProcesos">
  		<div class="FormTipos">
  		  <div class="itemFTT1">Crear Tabla Producto</div>
  		  <div class="itemFTT2">
  		  	<button class="agregarBoton" id="correrstoreprocedure01" />RUNP01
  		  </div>  		  
  		  <div  class="itemFTT3">
	  		  <button class="agregarBoton" value="Ver productos/obj consumo" id="irObjConsumoLista">-></button>
  		  </div>  		   
  		  <div class="itemFTT4">
		 </div>
  		  <div class="itemFCTT5">
  		  </div>
  		  <div  class="itemFTT6">
  		  </div>  		   
  		</div>	
</div>		
	
</div> <!-- lisgta accesos -->
  <!-- grilla de novedades, ultimos cargados -->
	<div class="grillaGastos" id="filtrosGrillaGastos">
			<div class="TabsGeneral">
				<ul class="ul">
					<li class="li" id="verFiltros" >Filtros</li>
					<li class="li" id="verResumen" >Resumen</li>
					<li class="li" id="verExtras" >Extras</li>
				</ul>
			<div class="SubTab">	
				<div class="BloqueSubTab">
		           <!-- grillaFiltros-->
		           <div class="grillaFiltros" id="grillaFiltros">
		           	<div class="grillaFiltrositem1">FILTROS</div>
		           	<div class="grillaFiltrositem10">
			           	<div class="grillaFiltrositem10A">Fecha Dde</div>           	
			           	<div class="grillaFiltrositem10B">
			           		<input  type="date" id="FechaBuscarDde" name="FechaBuscar"/>
			           	</div>           	
			           	<div class="grillaFiltrositem10C">Fecha Hta</div>           	
			           	<div class="grillaFiltrositem10D">
			           		<input  type="date" id="FechaBuscarHta" name="FechaBuscar"/>
			           	</div>           	
		           	</div>
		           	<div class="grillaFiltrositem12">
	           		<div>Son cuotas</div>
	           		<div>
	           			<input  type="checkbox" id="SonCuotas" name="SonCuotas"/>
					</div>
	           	</div>           	
		        <div class="grillaFiltrositem2">
	           		<select id="filtroFechaGastos">
		           		<option value="0">Seleccione intervalo fechas...</option>
	           			<option value="ESTASEMANA">esta semana</option>
	           			<option value="ESTAQUINCENA">última quincena</option>
	           			<option value="ESTAMES">ultimo mes</option>
	           			<option value="ESTATRESM">ultimos tres meses</option>
	           			<option value="ESTASEISM">ultimo semestre</option>
	           			<option value="ESTAANIO">ultimo año</option>
	           		 </select>
	           	</div>
		        <div class="grillaFiltrositem3">
	           	<!-- lo transformo en grilla -->
						<div class="itemProductos1">
			  		  		<div class="itmPrd1A">Producto</div>
			  		  		<div  class="itmPrd1B">
			  		  		<input type="text" id="productobuscar" class="productobuscar" value="" placeholder="nombre producto a buscar"/> </div>
			  		  	</div>
			  		  	<div class="itemProductos2">
			  		  		<select id="gproductos" class="comercioSel">
			  		  			<option value="9999">Seleccione producto...</option>
			  		  		</select>
			  		  	</div>
	           	</div>
		        <div  class="grillaFiltrositem4">
	           	<!-- lo transformo en grilla -->
		           	<div class="itemComercios1">
		           		<div  class="itmCmm1A">Comercio:</div>
		           		<div  class="itmCmm1B">
		           		<input type="text" id="comerciobuscar" class="comerciobuscar" value="" placeholder="nombre comercio a buscar"/> 
		           		</div>
		           	</div>
		           	<div class="itemComercios2">           	
		  		  		<select id="fcomercios" class="comercioSel">
		  		  				<option value="9999">Seleccione comercios...</option>
		  		  		</select>
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
				</div> <!-- BloqueSubTab -->
				<div class="BloqueSubTab">
					<div id="grillaResumen" class="grillaResumen">
						<div  class="grillaResumenitem1">
								<div>
									Elegir Mes
								</div>	
								<div>
									<select id="selectMes">
										<option>Seleccione mes</option>
									</select>
								</div>
						</div>			
						<div  class="grillaResumenitem10">		
								<div>Medios de Pago </div>	
								<div class="itemFMP2" id="RESgMPa"></div>
						</div>									
						</div>
						<div  class="grillaResumenitem2">
							<div class="grillaTotales">
								<div class="grillaTotales1">
									<div class="gIngreso"></div>
								</div>	
								<div class="grillaTotales2">							
									<div class="gEgreso"></div>
								</div>
							</div> <!--grillaIngresos-->
						</div>
						<div  class="grillaResumenitem3">
							<!-- MES COMERCIO MONTO DESCUENTOS -->
							<!-- <div class="grillaGastos"></div> -->
						</div>
						<div  class="grillaResumenitem4">
						</div><!-- 	fin resumen item 4 -->
						<div  class="grillaResumenitem5"></div>
						<div  class="grillaResumenitem6"></div>
					</div>
				</div> <!-- BloqueSubTab -->		
				<div class="BloqueSubTab">
				<div id="grillaExtras" class="GrillaExtras">
					<!-- CAMBIOS ACA ALIMENTAN AL RESUMEN -->
						<!-- GRILLA 3 TEXTO ESPECIFICO -->
						<div class="grillaExtrasDTXT">
							<div class="itemgDTXT1">
								<!-- ELEGIR PRODUCTO -->	
								<div class="itmDTXT1A">Buscar</div>
								<div class="itmDTXT1A1">
								<button id="BuscarExtras">(?)</button>
								</div>
								<!-- FILTRO PRODUCTO -->
								<div  class="itmDTXT1B">
									<input type="text" id="GEXproductoNomTxt" class="productobuscar" value="" placeholder="TEXTO/PRODUCTO"/> 
								</div>
								<div  class="itmDTXT1C">
									<input type="date" id="GEXFDesde" class="productobuscar" value="" placeholder="FDesde"/>
									<input type="date" id="GEXFHasta" class="productobuscar" value="" placeholder="FHasta"/> 		
								</div>
			  		  		</div>
							<div class="itemgDTXT2">
								<!-- LISTADO -->
							</div>
						</div>  	
						<!-- FIN GRILLA 3 TEXTO ESPECIFICO -->
						<div class="Raya"></div>
						<!-- GRILLA 1 COMERCIOS -->
						<div class="grillaExtrasCOM">
							<div  class="itemgexcom1">
									<!-- ELEGIR COMERCIO -->
								    <!-- FILTRO COMERCIO -->
								<div  class="itmGEXCmm1A">Comercio:</div>
								<div  class="itmGEXCmm1B">
								<input type="text" id="GEXcomerciobuscar" class="comerciobuscar" value=" " placeholder="nombre comercio a buscar"/> 
								</div>
							</div>
							<div  class="itemgexcom2">
								<!-- SELECT COMERCIO -->
								 <select id="GEXcomercios" class="comercioSel">
										 <option value="9999">Seleccione comercios...</option>
								 </select>
								 <button>+</button>
								 <button>-</button>
							 </div>	
							<div class="itemgexcom3">
									<!-- LISTA DE COMERCIOS ELEGIDOS -->
							</div>								
						</div>  	
						<!-- GRILLA 2 PRODUCTOS -->
						<div class="grillaExtrasPROD">
							<div class="itemgexprod1">
								<!-- ELEGIR PRODUCTO -->	
								<div class="itmGEXPrd1A">Producto</div>
								<!-- FILTRO PRODUCTO -->
								<div  class="itmGEXPrd1B">
									<input type="text" id="GEXproductobuscar" class="productobuscar" value="" placeholder="nombre producto a buscar"/> 
								</div>
			  		  		</div>
							<div class="itemgexprod2">
								<!-- SELECT PRODUCTO -->
								<select id="GEXproductos" class="comercioSel">
									<option value="9999">Seleccione producto...</option>
								</select>
								<button>+</button>
								<button>-</button>
							</div>
							<div class="itemgexprod3">
									<!-- LISTA DE PRODUCTOS ELEGIDOS -->
							</div>								
						</div>  	
						<!-- FIN GRILLA 2 PRODUCTOS -->
						<div  class="grillaExtraResultado">
							<div class="iGexRes1">TOTAL</div>
							<div class="iGexRes2">
								<input id="totalConsulta" name="totalConsulta" type="text" value="" placeholder="Monto total de la consulta" disabled="true" />
							</div>
							<div class="iGexRes3" id="iGexRes3">
								<div class="grillaObjetivos" id="grillaResultadosExtra"></div>
							</div> 
					    </div>
				</div>
				</div> <!-- BloqueSubTab -->
			</div> <!-- SubTabs -->
		    </div> <!-- tabs general -->

	</div>
	<div class="grillaGastos" id="grillaGastos">
	</div>
  <!-- grilla de novedades, ultimos cargados -->
</div> <!-- andamioHeader -->
</BODY>
</HTML>
