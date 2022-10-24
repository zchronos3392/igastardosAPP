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

			$("#FechaTicket").val(FechaDia);
			$("#FechaDesdeVigencia").val(FechaDia);
			$("#FechaHastaVigencia").val(FechaDia);
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++

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

		pedirmonedas('#imonedas',99);
			pedirmonedas2('#itemgmon2',99);
			//pedirmonedas2('#itemFmon2',99);//FILTROS DE BUSQUEDA
			pedirmonedas3('#itemFmon2','monedaFiltro_',99);//FILTROS DE BUSQUEDA
		pedirObjetivos('#iobjetivos',"select",99);
			
		pedirmediospago('#imediospago',99);
			pedirmediospago2('#itemgmpa2',99);
			//pedirmediospago2('#itemFMP2',99); //para FILTROS DE BUSQUEDA
			pedirmediospago3('#itemFMP2','mpagoFiltro_',99); //para FILTROS DE BUSQUEDA
		pedirumedidas('#iumed',99);
			//pedirumedidas('#iumedidas_',99);
		pedirtipos('#igtipos','');
		pedirtipos('#comerciotipo','COMERCIO');
		
		
		pedirTickets("#grillaGastos",99);
			pedirProductos("#gproductos",'');
		
		$("#FechaBuscar").on("change",function(){
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
		
		$("#AgregaComercio").on("click",function(){
			agregacomercio('#comercios');
		});

		$("#EliminarComercio").on("click",function(){
			eliminacomercio('#comercios');
					pedircomercio('#gcomercio',99);
					pedircomercio('#fcomercios',99);

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

			$("#itemsTicket").append(
				'<div id="DSCCONTENEDOR_'+contadorDescripcionItems+'" >'+
					'<div class="descripcion">'+
					'<input type="hidden" id="idregistro_0" value="0"></input> '+
					'<div class="descitem1">'+contadorDescripcionItems+'</div>'+
					'<div class="descitem2">Descripcion</div>'+
					'<div class="descitem22"><input type="text" id="montoparcial_'+contadorDescripcionItems+'" disabled="true"></input></div>'+
					'<div class="descitem3">'+
						'<input type="text" value="" id="descripcion_'+contadorDescripcionItems+'" onclick="sugerir(this.id,'+contadorDescripcionItems+');" onkeyup="sugerir(this.id,'+contadorDescripcionItems+');" /><div id="suggestions_'+contadorDescripcionItems+'" class="suggestions" ></div>'+
					'</div>'+
					'<div class="descitem4" onclick="elimnaritem(\'DSCCONTENEDOR_'+contadorDescripcionItems+'\');">(X)</div>'+
				'</div>'+
				'<div class="CantPunit">'+
					'<div class="umedidas CantPunit1">'+
						 '<div class="itemumed1"></div>'+	
						  '<div class="itemumed2">'+
						  '<select id="iumedidas_'+contadorDescripcionItems+'" class="comercioSel">'+
  		  					'<option value="9999">Unidad medida</option>'+
  		  				  '</select>'+
  		  				  '</div>'+
					'</div>'+
					'<div class="cantidad CantPunit2">'+
						'<div class="itemcant1">Cant.</div>'+
						'<div class="itemcant2">'+
						'</div>'+
						'<div class="itemcant3">'+
							'<input type="number" value="" id="cantidad_'+contadorDescripcionItems+'"  onkeyup="totalCalcular();"  />'+
						'</div>'+
						'<div class="itemcant4">'+
						'</div>'+
					'</div>'+
					'<div class="preciounit CantPunit3">'+
						'<div class="itempun1">Precio Unitario</div>'+
						'<div class="itempun2">'+
						'</div>'+
						'<div class="itempun3">'+
							'<input type="number" value="" id="pun_'+contadorDescripcionItems+'" onkeyup="totalCalcular();" />'+
						'</div>'+
						'<div class="itempun4">'+
						'</div>'+
					'</div>'+

				'<div class="descuento CantPunit11">'+
					'<div class="itemdis1">Descuento</div>'+
					'<div class="itemdis2">'+
					'</div>'+
					'<div class="itemdis3">'+
						'<input type="number" value="" id="dis_'+contadorDescripcionItems+'" onkeyup="totalCalcular();" ></input>'+
					'</div>'+
					'<div class="itemdis4">'+
						'<input type="checkbox" id="EsRecargo_'+contadorDescripcionItems+'" value="0"  onclick="totalCalcular();" ></input>'+
					'</div>'+
				   '</div>'+
				 '</div>'+
				'</div>');		
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
			<div class="itemaccioneg44">
					<span id="contadorItemsVer"></span>
			</div>
			<div class="itemaccioneg4">
					Total
					<input type="text" id="totalCalculado" disabled="true"/>
			</div>					
			<div class="itemaccioneg45">
				<div class="itac45a">DESC.GEN.CONCPT</div>
				<div class="itac45b">
				  <input type="text" id="descgenDesc" placeholder="Descuento general ticket razón" value="No"/>				</div>
			<div class="itac45c">
				<input  type="number" id="descuentogenmonto" placeholder="0.000" value="0.000"/>
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
			<div class="itemaccioneg51">
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
			<div class="itemaccioneg52">
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
           <div class="grillaFiltros">
           	<div class="grillaFiltrositem1">FILTROS</div>
           	<div class="grillaFiltrositem10">Fecha Específica</div>           	
           	<div class="grillaFiltrositem11">
           		<input  type="date" id="FechaBuscar" name="FechaBuscar"/>
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
					<select id="gproductos" class="comercioSel">
		  		  		<option value="9999">Seleccione producto...</option>
		  		  	</select>
           	</div>
           	<div  class="grillaFiltrositem4">
  		  		<select id="fcomercios" class="comercioSel">
  		  				<option value="9999">Seleccione comercios...</option>
  		  		</select>
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
	<div class="grillaGastos" id="grillaGastos">
	</div>
  <!-- grilla de novedades, ultimos cargados -->
</div> <!-- andamioHeader -->
</BODY>
</HTML>
