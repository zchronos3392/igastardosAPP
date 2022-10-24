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


function  eliminaritemDB(idregistro){

	var	idticket = parametroURL('idticket');

//	console.log("renglon : "+idregistro);
	var parametros=
	{
			"idrenglon":idregistro,
			"idticket":idticket,
		    "gasFecha": $("#FechaTicket").val(),
			"llama":"update",
			"funcion":"iDEL"
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
}
	 
function elimnaritem(itemID){
//	console.log("numero del item: " + itemID);
	var stringclaveRenglon = itemID.split("_");
	var claveRenglon = stringclaveRenglon[1];
//	console.log("numero del renglon: " + claveRenglon);

	var idregistro = $("#idregistro_"+claveRenglon).val();
	if(idregistro != 0)
			eliminaritemDB(idregistro);
			
	$("#"+itemID).remove();
	var numeroItem = $("#contadorItemsVer").text();
	numeroItem--;
	if(numeroItem==0)
		$("#contadorItemsVer").text('');
	else
		$("#contadorItemsVer").text(numeroItem);
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

// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		 var fecHoy=new Date();
		 var dias = new Array ("01","02","03","04","05","06","07","08","09","10","11","12"
		 				,"13","14","15","16","17","18","19","20","21","22","23","24","25","26"
		 				,"27","28","29","30","31");
		 var meses = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
		 var FechaDia = fecHoy.getFullYear() + "-" + meses[fecHoy.getMonth()] + "-" +dias[(fecHoy.getDate()-1)] ;

			$("#FechaTicket").val(FechaDia);
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			var	idticket = parametroURL('idticket');
			var FechaTicket = parametroURL('fechaticket');
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
					
//+++++++++++++++++++++++++++++++LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++
		pedircomercio('#gcomercio',99);
		pedirmonedas2('#itemgmon2',99);
		pedirmediospago2('#itemgmpa2',99);		
		pedirTicketsMod("#FormEgresos",idticket,FechaTicket);
		

		// Copia estructura descripcion
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
					'<input type="hidden" id="idregistro_'+contadorDescripcionItems+'" value="0" ></input>'+
					'<div class="descripcion">'+
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
						'<input type="number" value="" id="dis_'+contadorDescripcionItems+'" onkeyup="totalCalcular();" />'+
					'</div>'+
					'<div class="itemdis4">'+
						'<input type="checkbox" id="EsRecargo_'+contadorDescripcionItems+'" value="0"  onclick="totalCalcular();" ></input>'+
					'</div>'+
				   '</div>'+
				 '</div>'+
				'</div>');		
				pedirumedidas('#iumedidas_'+contadorDescripcionItems,99);	
				//contadorDescripcionItems++;	
		});

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$("#botonvolverMain").on("click",function(){
		window.location="index.php";
	});
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

//++++++++++++++++++++++FIN DE LA LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++			
	$("#ModificaGasto").on("click",function(){

	//necesito cargar las descripciones:
	var items= new Array();	
	var	idticket = parametroURL('idticket');
	items = cargarItems(); //VECTOR CON INDICE A PARTIR DE 1
	//console.log(	items.toString() );

	var stringmoneda = $( ".itemgmon BUTTON.selectedMon" ).attr("id").split("_");
	monedaSeleccionada = stringmoneda[1];
	//alert( " id ("+monedaSeleccionada+") de la MONEDA SELECCIONADA, abrev: " + $( ".itemgmon BUTTON.selectedMon" ).html());	
	var stringmepago = $( ".itemgMPa BUTTON.selectedMPago" ).attr("id").split("_");
	mformapago = stringmepago[1];
	//alert( " id ("+mformapago+" ) de la MEDIO DE PAGO SELECC., Descripcion abreviada:" + $( ".itemgMPa BUTTON.selectedMPago" ).html());

	var stringtipomov1 = $( ".inputI.selectedINPUT" ).attr("id");
		console.log("id TipoMovParm1 "+stringtipomov1);

	var stringtipomov2 = $( ".inputE.selectedINPUT" ).attr("id");
		console.log("id TipoMovParm2 "+stringtipomov2);
	var TipoMovParm = '';
	
	if(stringtipomov1 != undefined) 
		TipoMovParm= $( "#"+stringtipomov1 ).html();
	
	//alert($( "#"+stringtipomov1 ).html() );
	if(stringtipomov2 != undefined) 
			TipoMovParm= $( "#"+stringtipomov2 ).html();
	//alert($( "#"+stringtipomov2 ).html() );
	
//	console.log("TipoMovParm "+TipoMovParm);


	var parametros=
	{
			"idticket":idticket,
		    "gasFecha": $("#FechaTicket").val(),
		    "ComercioId": $("#gcomercio").val(),
		    "items"		: items,
		    "moneda": monedaSeleccionada,
		    "descgenDesc":$("#descgenDesc").val(),
		    "descuentogenmonto":$("#descuentogenmonto").val(),
		    "mformapago": mformapago,
			"tipoMovimiento":TipoMovParm,		    
			"llama":"update",
			"funcion":"UPD"
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
    	 location.href='index.php';
     },
    	error: function (xhr, ajaxOptions, thrownError)
    	{
				$(".errores").append(xhr);
		}
    	});

	}); // fin funcion ModificaGasto
		
		$(".icono1").on("click",function(){

		});
		
		$(".icono2").on("click",function(){

		});


		
		
	}); // parentesis del READY
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
</script>

<BODY>
<?php
	include('header.html');
?>	
  <div class="errores"></div>
  <div class="listaAccesos">

  <div class="grillaCambioAnio">
 	<div class="itemcambioanio1">
	   <A>\Gastos i0: Modificar Ticket seleccionado</A>
 	</div>
 	<div class="itemcambioanio2">
		<select id="ianio" name="ianio" class="ianio">
				<option value="9999">Seleccionar año...</option>
		</select>	
 	</div>
 	<div class="itemcambioanio3">
		<input type="checkbox" value="" id="cargarotroanio" ><A style="color:#fff;">Cargar años anteriores</A></input>
 	</div>
  </div>

<div class="iconosFunciones">
	<div class="icono1"><span class="icon-upload" title="GASTOS"></span></div>	
	<div class="icono2"></div>
	<div class="icono3"></div>
</div>
  	<div class="itemAcceso1" id="AdmGastos">
		<div class="FormEgresos">
		<div class="AccionesEgresos">
			<div class="itemaccioneg1">
				<input type="date" id="FechaTicket"/>
			</div>
			<div class="itemaccioneg2">
				<button class="botonMas" id="ModificaGasto" title="Grabar evento en base">+</button>
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
				  <input type="text" id="descgenDesc" placeholder="Descuento general ticket razón"/>				</div>
			<div class="itac45c">
				<input  type="number" id="descuentogenmonto" placeholder="0.000"/>
			</div>
		  	</div>	
			<div class="itemaccioneg5">
				<div class="gCom">
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
						  <input type="number" id="montoCuota"  name="montoCuota" placeholder="Cantidad de cuotas a dividir el monto" value="0" disabled="true"/>
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
		
  </div> <!-- lisgta accesos -->
  <!-- grilla de novedades, ultimos cargados -->
<!--	<div class="grillaGastos" id="grillaGastos"></div> -->
  <!-- grilla de novedades, ultimos cargados -->
</BODY>
</HTML>
