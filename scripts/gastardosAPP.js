


function elijeFondo(porcentaje){

console.log('analizando porcentaje que llego : '+porcentaje);

seleccionColor='#07a3c9';//azul pseudo neutro
	
if(porcentaje < 49)
  seleccionColor='#78D053';//verde manzanita	
 
if(porcentaje >= 49 && porcentaje <= 75 ) 
		seleccionColor='#e49e3f';	//naranja opaco

if(porcentaje >= 100) 
		seleccionColor='#fe2525';	//rojo encendido

console.log('color: : '+seleccionColor);

return seleccionColor;	
} 


function trunc (x, posiciones = 0) {
  var s = x.toString()
  var l = s.length
  var decimalLength = s.indexOf('.') + 1
  var numStr = s.substr(0, decimalLength + posiciones)
  return Number(numStr)
}

function totalCalcular(){
	var calcular=calculaLinea=0;
		var TotalItems = $("#contadorItemsVer").text();
		var DescuentoGeneral = $("#descuentogenmonto").val(); 
		//alert(DescuentoGeneral);
	if(TotalItems != '' && TotalItems != '0'){
		for(var i=1;i<=TotalItems;i++){
			var recargo = (-1)*($("#dis_"+i).val());
			if( $("#EsRecargo_"+i).is(':checked') ) recargo = $("#dis_"+i).val();
			
			var Cantidad = $("#cantidad_"+i).val();
            var precioUnitario = $("#pun_"+i).val();
            var calculaLinea = parseFloat(Cantidad) * parseFloat(precioUnitario) + 
            					parseFloat(recargo);
//            console.log(calculaLinea);
//			calculaLinea = trunc( ($("#cantidad_"+i).val() * $("#pun_"+i).val()),3);
//			calculaLinea += Number(recargo);
//				$("#montoparcial_"+i).empty();
//				console.log("monto parcial cargado: " + $("#montoparcial_"+i).val() ) ;
			  	$("#montoparcial_"+i).text( parseFloat(calculaLinea) );
			  	$("#montoparcial_"+i).val( parseFloat(calculaLinea) );
//            console.log(calculaLinea);

			calcular = parseFloat(calcular) + parseFloat(calculaLinea); 
		}
	}
	$("#totalCalculado").empty();
			calcular = calcular - DescuentoGeneral;//junio 2022
	$("#totalCalculado").val(calcular);
}

//cargamos los subobjetivos 
function cargarSubObjetivis(){
	var TotalSubObje = $("#contadorSubObjetivos").text(); //es un span, por eso el text()
	var itemSubObjetivo = new Array(TotalSubObje);

	if(TotalSubObje != '' && TotalSubObje != '0')
	{
		for(var i=1;i<=TotalSubObje;i++)
		{
			itemSubObjetivo.push( {
								"idsubobjetivo":$("#idsuboj_"+i).val(),
								"monedasubobj":$("#subimonedas_"+i).val(),
								"mediopagosubobj":$("#subimediospago_"+i).val(),
								"fraccionsubobj":$("#subFraccion_"+i).val(),
								"fraccTotsubobj":$("#subFraccionTot_"+i).val()
								});
		}
	}	
	
return 	itemSubObjetivo;		
}


function cargarItems(){
	var TotalItems = $("#contadorItemsVer").text();
	var itemsLista= new Array(TotalItems);
	
	if(TotalItems != '' && TotalItems != '0'){
		for(var i=1;i<=TotalItems;i++){
			var recargo=0;
			if( $("#EsRecargo_"+i).is(':checked') ) recargo=1;
			
			itemsLista.push( {
								"descripcion":$("#descripcion_"+i).val(),
								"cantidad":$("#cantidad_"+i).val(),
								"punitario":$("#pun_"+i).val(),
								"discount":$("#dis_"+i).val(),
								"recargo":recargo,
								"unidad": $("#iumedidas_"+i).val(),
								"gasid" : $("#idregistro_"+i).val()								
								});
		}
	}
return 	itemsLista;
};

function  sugerir(idDescriptor,identificadorRegistro)
{
	
var key = $("#"+idDescriptor).val();		
//	console.log(key);
	var parametros=
	{
			"llama":"sugerir",
			"funcion":"XGET",
			"filtro":key
	};

if(key != ''){
	
	 	$.ajax({ 
	    url:   './apis/iobjconsumo.php',
	    type:  'GET',
	    data: parametros ,
	    datatype:   'text json',
		// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
	    beforeSend: function (){$("#suggestions_"+identificadorRegistro).empty();},
	    done: function(data){},
	    success:  function (data){
                //Escribimos las sugerencias que nos manda la consulta
               if(data != ''){
			   	
                $('#suggestions_'+identificadorRegistro).fadeIn(1000).html(data);
                //Al hacer click en alguna de las sugerencias
                $('.suggest-element').on('click', function(){
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $("#"+idDescriptor).val(id);
                        //Hacemos desaparecer el resto de sugerencias
                        $('#suggestions_'+identificadorRegistro).fadeOut(1000);
                        	//alert('Has seleccionado el '+id+' '+$('#'+id).attr('data'));
                        return false;
                });
               }
             }
        });// fin del AJAX
}
}

/**

* @param {object} destinoid : el objeto Combo a donde se cargaran los resultados
* @param {object} idDescriptor : el objeto en donde se esta escribiendo el dato a filtrar
* @return SELECT DE COMERCIOS, FILTRADOS POR EL TEXTO QUE ESTA EN '#'+idDescriptor
*/
function  filtrarComercio(destinoid,idDescriptor)
{
var key = $("#"+idDescriptor).val();		
	var parametros=
	{
			"llama":"sugerir",
			"funcion":"XGET",
			"filtro":key
	};

	 	$.ajax({ 
	    url:   './apis/icomercios.php',
	    type:  'GET',
	    data: parametros ,
	    datatype:   'text json',
		// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
	    beforeSend: function (){
    	$(destinoid).empty();
    	$(destinoid).append('<option value="9999">Seleccione comercio...</option>');
    	},
    	done: function(data){},
	    success:  function (data){
                //Escribimos las sugerencias que nos manda la consulta
               if(data != ''){

			   if(data.indexOf("<br />") > -1)
							$(".errores").append(re);
				else
				{
					var r = JSON.parse(data);
			        if(r['estado'] == 1) {
			         $(r['comercios']).each(function(i, v)
					        { // indice, valor
								//TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
					            // TRIPLICANDO UN EVENTO QUE NO PUDE ENCONTRAR Y CARGABA TODOS LOS DATOS TRES VECESSS
					        	if (! $(destinoid).find("option[value='" + v.ComercioId + "']").length)
					        	{						
									$(destinoid).append('<option value="' + v.ComercioId + '">' +v.descripcionComercio+' - ' + v.tipo + '</option>');
								}	//if que no haya copias	
					        }); // if coleccion comercios trajo datos..
					} //if estado == 1
					else {			
							$(".errores").append(re);
						 };
		        } //else hay data	
      			 $(destinoid).prop('disabled', false);
                } //if hay Data no vacia
               },//success
		    error: function (xhr, ajaxOptions, thrownError)
	    	{
				// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
					$(".errores").append(xhr);
			}
        });// fin del AJAX
} //fin de la funcion

function seleccionmoneda(xidmoneda){
	//$("#"+xidmoneda).removeClass('moneda');
	if($("#"+xidmoneda).hasClass( 'selectedMon' ))
	{
	 		 $("#"+xidmoneda).removeClass('selectedMon');
	 		 $("#"+xidmoneda).addClass('moneda');
	}
	else
	{
	 		 $("#"+xidmoneda).addClass('selectedMon');
	 		 $("#"+xidmoneda).removeClass('moneda');
		
	}
}

function seleccionmpago(xidmpago){
	//$("#"+xidmoneda).removeClass('moneda');
	if($("#"+xidmpago).hasClass( 'selectedMPago' ))
	{
	 		 $("#"+xidmpago).removeClass('selectedMPago');
	 		 $("#"+xidmpago).addClass('moneda');
	}
	else
	{
	 		 $("#"+xidmpago).addClass('selectedMPago');
	 		 $("#"+xidmpago).removeClass('moneda');
		
	}
}

function seleccionIE(identificarMov){
	//$("#"+xidmoneda).removeClass('moneda');
	if($("#"+identificarMov).hasClass( 'selectedINPUT' ))
	{
	 		 $("#"+identificarMov).removeClass('selectedINPUT');
	 		 //$("#"+identificarMov).addClass('moneda');
	}
	else
	{
	 		 $("#"+identificarMov).addClass('selectedINPUT');
	 		 //$("#"+identificarMov).removeClass('moneda');
		
	}
}

function parametroURL(_par) {
  var _p = null;
  if (location.search) location.search.substr(1).split("&").forEach(function(pllv) {
    var s = pllv.split("="), //separamos llave/valor
      ll = s[0],
      v = s[1] && decodeURIComponent(s[1]); //valor hacemos encode para prevenir url encode
    if (ll == _par) { //solo nos interesa si es el nombre del parametro a buscar
      if(_p==null){
      _p=v; //si es nula, quiere decir que no tiene valor, solo textual
      }else if(Array.isArray(_p)){
      _p.push(v); //si ya es arreglo, agregamos este valor
      }else{
      _p=[_p,v]; //si no es arreglo, lo convertimos y agregamos este valor
      }
    }
  });
  return _p;
}
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

function pedirProductos(destinoid,producto){	 
	var parametros={"filtro":producto,"llama":"pedirproductos","funcion":"XGETX"};
 	$.ajax({ 
	url:   './apis/iobjconsumo.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){
    	$(destinoid).empty();
    	$(destinoid).append('<option value="9999">Seleccione productos...</option>');
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
         $(r['ObjCons']).each(function(i, v)
		        { // indice, valor
		                		//TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
		                		// TRIPLICANDO UN EVENTO QUE NO PUDE ENCONTRAR Y CARGABA TODOS LOS DATOS TRES VECESSS
		        	if (! $(destinoid).find("option[value='" + v.descripcionObjetoCons + "']").length)
		        	{						
						  $(destinoid).append('<option value="' + v.descripcionObjetoCons + '">' +v.descripcionObjetoCons+ '</option>');
					}		
		        });
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
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx	


//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
function pedirObjetivos(destinoid,tipoControl,idObjetivo){	 
						//('#iobjetivos',"select");
	var parametros={"filtro":idObjetivo,"llama":"pedirObjetivos","funcion":"GET"};
 	$.ajax({ 
	url:   './apis/iobjetivos.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){
    	if(tipoControl =='select')
    	{
	    	$(destinoid).empty();
    		$(destinoid).append('<option value="0">Seleccionar objetivos...</option>');
		}
    	if(tipoControl =='verDIV') //lleno una grilla del objetivo seleccionado
    	{
	    	$(destinoid).empty();
		}		
	
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
         $(r['Objetivos']).each(function(i, v)
		        { // indice, valor
//					"idobjetivo":"1",
//					"FechaDesdeVig":"2022-05-18","FechaHastaVig":"2022-05-31",
//					"fraccion":"10000","fraccionTiempo":"1",FraccionTipo":"SEMANA",
//					"montoObjetivo":"45000","montoAviso":"60000",
//					"objobservaciones1":"controlando lo que queda por mes",
//					"objetivoTipo":"E"
		    	if(tipoControl =='select')
		    	{
		        	if (! $(destinoid).find("option[value='" + v.idobjetivo + "']").length)
		        	{						
					  $(destinoid).append('<option value="' + v.idobjetivo + '">' +v.FechaDesdeVig+'/'+v.FechaHastaVig+ '</option>');
					}
				 }			
	 if(tipoControl =='verDIV2')
	  {
	  	$("#FechaDesdeVigencia").val(v.FechaDesdeVig);
	  	$("#FechaHastaVigencia").val(v.FechaHastaVig);
	 	
	 	$("#fraccion").val(v.fraccion);
	 	$("#FraccionTipo").val(v.FraccionTipo);//andara??
		$("#fraccionTiempo").val(v.fraccionTiempo);

		$("#montoobjetivo").val(v.montoObjetivo);
		$("#montocontrol").val(v.montoAviso);
		$("#objobservaciones1").val(v.objobservaciones1);
		$("#idobjetivo").val(v.idobjetivo);

	  	var itemsSubObjetivos='';
	    $(v.SubObjetivos).each(function(t, u)
	    {
			$("#contadorSubObjetivos").text(v.SubObjetivos.length );
		itemsSubObjetivos +='<div class="grillaSubFraccion" id="subobje_'+u.iddetobjetivo+
	'">'+
			'<div class="itemSUFraccion1">'+'<span class="subid"> * '+u.iddetobjetivo+'</span>'+
				'<input type="hidden" value="'+u.iddetobjetivo+'" id="idsuboj_'+u.iddetobjetivo+'" name="idsuboj_'+u.iddetobjetivo+'">'+
			'</div>'+			
			'<div class="itemSUFraccion2">'+
			'<input type="hidden" id="isubimonedas_'+u.iddetobjetivo+'" value="'+u.monedaid+'" />'+
  		  		'<select id="subimonedas_'+u.iddetobjetivo+'" class="comercioSel">'+
  		  				'<option value="9999">Seleccione moneda</option>'+
  		  		'</select>'+
			'</div>'+			
			'<div class="itemSUFraccion3">'+
			'<input type="hidden" id="isubimediospago_'+u.iddetobjetivo+'" value="'+u.mediopagoid+'" />'+
  		  		'<select id="subimediospago_'+u.iddetobjetivo+'" class="comercioSel">'+
  		  				'<option value="9999">Seleccione Forma de pago</option>'+
  		  		'</select>'+
			'</div>'+			
			'<div class="itemSUFraccion4">'+
				'<input id="subFraccion_'+u.iddetobjetivo+'" name="subFraccion_'+u.iddetobjetivo+'" type="number" placeholder="Fraccion poor moneda y medio de pago.." value="'+u.fraccionMonto+'"/>'+	
			'</div>'+			
			'<div class="itemSUFraccion5">'+
			'<input id="subFraccionTot_'+u.iddetobjetivo+'" name="subFraccionTot_'+u.iddetobjetivo+'" placeholder="Monto total de la fracción" value="'+u.MontoTotalSubObj+'"/></div>'+
			'<div class="itemSUFraccion6">'+
			'<button class="accionBotonCancel" value="eliminar sub objetivo" id="EliminarSubObjetivo" onclick="eliminaSubobjetivo(\'subobje_'+u.iddetobjetivo+'\');">-</button>'+
			'</div>'+
		'</div>';
		});
		
		$("#grillaSubObjs").empty();
		$("#grillaSubObjs").append(itemsSubObjetivos);
		//luego de agregarlo , los puedo "cargar"

	    $(v.SubObjetivos).each(function(t, u)
	    {
			pedirmonedasabm('#subimonedas_'+u.iddetobjetivo,u.monedaid);
			pedirmediospagoabm('#subimediospago_'+u.iddetobjetivo,u.mediopagoid);
		});
		
//		$(v.SubObjetivos).each(function(t, u)
//	    {
	    	//alert($('#isubimonedas_'+u.iddetobjetivo).val() );
	    	//$('#subimonedas_'+u.iddetobjetivo).val(2);
	    	//alert( $('#isubimediospago_'+u.iddetobjetivo).val() );
	    	//$('#subimediospago_'+u.iddetobjetivo).val($('#isubimediospago_'+u.iddetobjetivo).val() );
//		});		

	  }
	  					 
	 if(tipoControl =='verDIV')
	  {
	  	var graficos = ''; //para que exista sino lo usamos...
		 graficos = '<div class="GobGraficos">';
		 var indiceGrid = 3;
	    $(r['xCompleto']).each(function(i, v)
	    {
	    	var xMontos =xgraficos ='';	
			$(v.OBJETIVODETALLE).each(function(j, w){
		    	xMontos +=	'<span>'+w.medionombre+' Monto '+w.monedanombre+' '+w.montoTotal+'</span><br>';	

		        var porcentaje = excente= 0;	
		        //console.log("XTRM piorcentaje obtenido: " + v.porcentajeTotal);		        
		        if(w.porcentajeTotal != 0)
		          	porcentaje=Math.floor((w.porcentajeTotal * 100));	
				
		        if(porcentaje > 100)
		        	{ 
		        		excente = porcentaje -100;
						porcentaje = 100;
					}
		        //if(excente > 100) excente = 100;		

				xgraficos +=	'<div  class="contieneRenglones'+indiceGrid+'"><input type="text" value="'+porcentaje+'" class="ObjetivoFraccion_'+(j+99)+'"></div>';
				indiceGrid++;
				xgraficos +=	'<div  class="contieneRenglones'+indiceGrid+'"><input type="text" value="'+excente+'" class="ObjetivoFraccionPasado_'+(j+99)+'"></div>';	
				indiceGrid++;			
			});		
				//console.log("excedente: " + excente + " porcentaje: " + porcentaje);
				graficos += '<div class="contieneGraficoRenglones">';
			graficos +='<div class="contieneRenglones1">Extremo Inicial '+v.FechaTotalIni+'</div>';
			graficos +='<div class="contieneRenglones11"><button id="stats" name="stats" onclick="location.href=\'estadisticas.php?finicio='+v.FechaTotalIni+'&ffin='+v.FechaTotalFin+'\';">Stats</button></div>';

				graficos +=	'<div  class="contieneRenglones2">Extremo Final '+v.FechaTotalFin+'</div>';
				graficos +=	'<div  class="contieneRenglones20">'+xMontos+'</div>';								graficos += xgraficos;
				graficos +='</div>';
		});		
		  	  
//		 var xgraf='';		 
	    $(r['xFracciones']).each(function(i, v)
		{
		    	xMontos =xgraficos ='';	
 				var indiceGrid = 3;
				//solo cargo los montos para pegarlos arriba..
				$(v.OBJETIVODETALLE).each(function(j, w)
				{
			    	xMontos +=	'<span>'+w.medionombre+' Monto '+w.monedanombre+' '+w.montoTotal+'</span><br>';	

			        var porcentaje = excente= 0;	
			        //console.log("XTRM piorcentaje obtenido: " + v.porcentajeTotal);		        
			        if(w.porcentaje != 0)
			          	porcentaje=Math.floor((w.porcentaje * 100));	
					
			        if(porcentaje > 100)
			        	{ 
			        		excente = porcentaje -100;
							porcentaje = 100;
						}
			        //if(excente > 100) excente = 100;		

					xgraficos +=	'<div  class="contieneRenglones'+indiceGrid+'"><input type="text" value="'+porcentaje+'" class="ObjetivoFraccion_'+(j+99)+'"></div>';
					indiceGrid++;
					xgraficos +=	'<div  class="contieneRenglones'+indiceGrid+'"><input type="text" value="'+excente+'" class="ObjetivoFraccionPasado_'+(j+99)+'"></div>';	
					indiceGrid++;			
				});		
					//console.log("excedente: " + excente + " porcentaje: " + porcentaje);
				graficos += '<div class="contieneGraficoRenglones">';
				graficos +='<div class="contieneRenglones1">F. Inicial '+v.FechaInicio+'</div>';
				graficos +='<div class="contieneRenglones11"><button id="stats" name="stats" onclick="location.href=\'estadisticas.php?finicio='+v.FechaInicio+'&ffin='+v.FechaFin+'\';">Stats</button></div>';

				graficos +=	'<div  class="contieneRenglones2">F. Final '+v.FechaFin+'</div>';
				graficos +=	'<div  class="contieneRenglones20">'+xMontos+'</div>';								graficos += xgraficos;
				graficos +='</div>';
		}); 	//xFracciones...
	  graficos += '</div>';//cierro grilla de graficos...?
			
	//console.log(graficos);								
	var estructura= '<div class="gObjetivosVerUna" id="gObjetivosVerUna">'+
		'<div class="Gobjitem1V">'+
		'<textarea id="objobservaciones1" class="objobservaciones1" rows="5" cols="50" placeholder="Descripcion del objetivo" disabled>'+v.objobservaciones1+'</textarea>'+
		'</div>'+
		'<div class="Gobjitem2V">'+
		'<div class="grillaFechaObjs">'+
		'<div class="gobjFecha1">'+
		'Fecha Desde'+
		'</div>'+
		'<div class="gobjFecha2">'+	
		'<input type="date" value="'+v.FechaDesdeVig+'" id="FechaDesdeVigencia" placeholder="Vigencia, inicio"  disabled/>'+
		'</div>'+
		'<div class="gobjFecha3">'+
		'Fecha Hasta'+
		'</div>'+	
		'<div class="gobjFecha4">'+
		'<input type="date" value="'+v.FechaHastaVig+'" id="FechaHastaVigencia" placeholder="Vigencia, fin" disabled/>'+
		'</div>'+	
		'</div>'+
		'</div>'+
		'<div class="Gobjitem3V">'+
		'<div class="gFraccionObjVer">'+
		'<div class="gfracit1">'+
		'<select id="fraccionTipo">'+
		'<option value="'+v.FraccionTipo+'">'+v.FraccionTipo+'</option>'+
		'</select>'+
		'</div>'+
		'<div class="gfracit2">'+
		'<input type="text"  id="fraccionTiempo" placeholder="Tiempo en DIAS" disabled value="'+
		v.fraccionTiempo+'"/>'+
		'</div>'+
		'<div class="gfracit3">'+
		'<input type="text" value="'+v.fraccion+'" id="fraccion" disabled  placeholder="Monto de la fraccion" />'+
		'</div>'+
		'<div class="gfracit4"></div>'+
		'</div>'+
		'</div>'+
	'<div class="Gobjitem30V">'+
	'</div>'+	
		'<div class="Gobjitem4V">'+
		'<div class="grillaMontos">'+
		'<div class="itemMont1">Monto Objetivo</div>'+
		'<div class="itemMont2">'+
		'<input type="number" id="montoobjetivo" value="'+v.montoObjetivo+'" placeholder="Monto de Control"  disabled />'+
		'</div>'+
		'<div class="itemMont3">Avisar En Monto</div>'+			
		'<div class="itemMont4">'+
		'<input type="number" id="montocontrol" value="'+v.montoAviso+'" placeholder="Monto de Alarma" disabled />'+
		'</div>'+									
		'</div>'+
		'</div>'+
		'<div class="Gobjitem5V">'+
		'</div>'+
		'<div class="Gobjitem6V">'+
		'</div>'+
		'<div class="Gobjitem7V">'+
		graficos+
		'</div>';
		//console.log(estructura);
	    $(destinoid).append(estructura);

/*
	    $(v.SubObjetivos).each(function(t, u)
	    {
			pedirmonedas('#subimonedas_'+u.iddetobjetivo,99);
			pedirmediospago('#subimediospago_'+u.iddetobjetivo,99);
		
			$('#subimonedas_'+u.iddetobjetivo).val(u.monedaid);
			$('#subimediospago_'+u.iddetobjetivo).val(u.mediopagoid);
		});
*/
	    $(r['xCompleto']).each(function(i, v)
	    {
			$(v.OBJETIVODETALLE).each(function(j, w){

		        var porcentaje = excente= 0;	
		        //console.log("XTRM porcentaje obtenido: " + v.porcentajeTotal);		        
		        if(w.porcentajeTotal != 0)
		          	porcentaje=Math.floor((w.porcentajeTotal * 100));	
				
		        if(porcentaje > 100)
		        	{ 
		        		excente = porcentaje -100;
						porcentaje = 100;
					}
		        //if(excente > 100) excente = 100;	
//		        console.log("XTRM excedente obtenido: " + excente);					
		         var seleccionColor=seleccionColorExcedente='';
		         seleccionColor = elijeFondo(porcentaje);
				 seleccionColorExcedente = elijeFondo(excente);
				 //console.log(seleccionColor);
				 //console.log(i);				 
			      $('.ObjetivoFraccion_'+(j+99)).knob({
			        'min':0,'max':100,
			        'width':120,'height':120,
			        'displayInput':true,
			        'fgColor':seleccionColor,
			        'release':function(v) {$("p").text(porcentaje);},'readOnly':true
			      });
			      
			      $('.ObjetivoFraccionPasado_'+(j+99)).knob({
			        'min':0,'max':500,
			        'width':120,'height':120,
			        'displayInput':true,
			        'fgColor':seleccionColorExcedente,
			        'release':function(v) {$("p").text(excente);},'readOnly':true
			      });
			 });
		});	 
		
	    $(r['xFracciones']).each(function(i, v)
		{
				$(v.OBJETIVODETALLE).each(function(j, w){

			    var porcentaje = excente= 0;	
			    //console.log("COMUN, Fecha Ini: " + v.FechaInicio + ' Hasta ' + v.FechaFin);
			    //console.log("COMUN, porcentaje obtenido: " + w.porcentaje +  ' '+ w.medionombre);
			    if(w.porcentaje != 0)
			          	porcentaje=Math.floor((w.porcentaje * 100));	
					
			        if(porcentaje > 100)
			        	{ 
			        		excente = porcentaje -100;
							porcentaje = 100;
						}
			    //if(excente > 100) excente = 100;	
				//console.log("COMUN, porcentaje EXCEDENTE obtenido: " + excente);	
						        
			         var seleccionColor=seleccionColorExcedente='';
			         seleccionColor = elijeFondo(porcentaje);
					 seleccionColorExcedente = elijeFondo(excente);
					 //console.log(seleccionColor);
					 //console.log(i);				 
				      $('.ObjetivoFraccion_'+(j+99)).knob({
				        'min':0,'max':100,
				        'width':120,'height':120,
				        'displayInput':true,
				        'fgColor':seleccionColor,
				        'release':function(v) {$("p").text(porcentaje);},'readOnly':true
				      });
				      
				      $('.ObjetivoFraccionPasado_'+(j+99)).knob({
				        'min':0,'max':500,
				        'width':120,'height':120,
				        'displayInput':true,
				        'fgColor':seleccionColorExcedente,
				        'release':function(v) {$("p").text(excente);},'readOnly':true
				      });
				 });
			 });
			  
		  }	//el control es LA GRILLA DE VISUALIZAR		
		  
	    $(v.SubObjetivos).each(function(t, u)
	    {
			$('#subimonedas_'+u.iddetobjetivo).val(u.monedaid);
			$('#subimediospago_'+u.iddetobjetivo).val(u.mediopagoid);
		});		
		  	 
		   }); //COLECCION OBJETIVOS
		}
		else {		
				if(r['estado'] != 0)
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
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx	
function pedirSubObjetivos(idObjetivo){	 
						//('#iobjetivos',"select");
	var parametros={"filtro":idObjetivo,"llama":"pedirObjetivos","funcion":"GETDET"};
 	$.ajax({ 
	url:   './apis/iobjetivos.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){
	
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
         $(r['Objetivos']).each(function(i, v)
		        { // indice, valor
				    $(v.SubObjetivos).each(function(t, u)
				    {
				    	//necesito tener otoa nombre para esto?....
				    	// o insertarlo en otra pagina...COMO EN MODIFICARGASTOS..
						$('#subimonedas_'+u.iddetobjetivo).val(u.monedaid);
						$('#subimediospago_'+u.iddetobjetivo).val(u.mediopagoid);
					});		
		   }); //COLECCION OBJETIVOS
		}
		else {			
				$(".errores").append(re);
			};
		}	
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
				$(".errores").append(xhr);
		}
    });
}
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
function pedirObjeCns(destinoid,tipoControl,idObjCons){	 
						//('#iobjetivos',"select");
	var parametros={"filtro":idObjCons,"llama":"pedirObjeCns","funcion":"GET"};
 	$.ajax({ 
	url:   './apis/iobjconsumo.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){},
    done: function(data){},
    success:  function (re){
      var r = JSON.parse(re);
      var inputCheckObjCns=listadoProductos='';
      //console.log(re);	
      $(r['ObjCons']).each(function(i, v)
		{
		  //console.log(' indice '+i +' valor: '+v);	
		  inputCheckObjCns='<input type="checkbox" id="idcnsobjeto_'+v.idcnsobjeto+'" name="idcnsobjeto_'+v.idcnsobjeto+'" value="" onclick="alert(this.id);"></input>';	
	      listadoProductos += '<div class="grillaproductoitem">'+
		    		  			  '<div class="objconsitem1">'+inputCheckObjCns+'</div>'+
		    					  '<div class="objconsitem2">ID '+v.idcnsobjeto+'</div>'+ 
		    					  '<div class="objconsitem3">'+v.descripcionObjetoCons+'</div>'+ 
		    					  '<div class="objconsitem4">'+v.objcnsTipo+'</div>'+
	    					  '</div>';
		});
		$(destinoid).append(listadoProductos);
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
				$(".errores").append(xhr);
		}
    });	
}


// ****************************************************************
// ****************************************************************
function agregaobjetosconsumo(){
	
						//('#iobjetivos',"select");
	var parametros={"filtro":"","llama":"storeproce01","funcion":"PUTX"};
 	$.ajax({ 
	url:   './apis/iobjconsumo.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){},
    done: function(data){},
    success:  function (re){
    	location.href='objetosconsumo.php'; 
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
				$(".errores").append(xhr);
		}
    });		
	
	
	
}
// ****************************************************************
// ****************************************************************


function pedircomercio(destinoid,comercio){	 
	var parametros={"filtro":comercio,"llama":"pedircomercio","funcion":"GET"};
 	$.ajax({ 
    url:   './apis/icomercios.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){
    	$(destinoid).empty();
    	$(destinoid).append('<option value="9999">Seleccione comercio...</option>');
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
         $(r['comercios']).each(function(i, v)
		        { // indice, valor
		                		//TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
		                		// TRIPLICANDO UN EVENTO QUE NO PUDE ENCONTRAR Y CARGABA TODOS LOS DATOS TRES VECESSS
		        	if (! $(destinoid).find("option[value='" + v.ComercioId + "']").length)
		        	{						
						  $(destinoid).append('<option value="' + v.ComercioId + '">' +v.descripcionComercio+' - ' + v.tipo + '</option>');
					}		
		        });
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

// ****************************************************************

// ****************************************************************
function agregacomercio(destinoid){	 

	var parametros = {
			"comnombre":$("#comercioNombre").val(),
			"ctipo":$("#comerciotipo").val(),
			"filtro":'',
			"llama":"agregacomercio",
			"funcion":"PUT"			
			};	
 	$.ajax({ 
    url:   './apis/icomercios.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoid).empty();},
    done: function(data){},
    success:  function (re){
			pedircomercio(destinoid,99);	
				pedircomercio('#gcomercio',99);
				pedircomercio('#fcomercios',99);

    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);
		}
    });
}
// ****************************************************************
// ****************************************************************
function eliminacomercio(destinoid){
	
	var parametros = {
			"filtro":$(destinoid).val(),
			"llama":"eliminacomercio",
			"funcion":"DEL"			
			};	
 	$.ajax({ 
    url:   './apis/icomercios.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoid).empty();},
    done: function(data){},
    success:  function (re){
			pedircomercio(destinoid,99);	
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);
		}
    });
	
}
// ****************************************************************
// ****************************************************************
function pedirmonedas(destinoid,monedaid){
	//console.log('destinoid '+destinoid);
	//console.log('moneda id'+ monedaid);	 
	var parametros={"filtro":monedaid,"llama":"pedirmonedas","funcion":"GET"};
 	$.ajax({ 
    url:   './apis/imonedas.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoid).empty();},
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
         $(r['monedas']).each(function(i, v)
		        { // indice, valor
		    //TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
			// monedaId, descripcionmoneda, abrmoneda
		        	if (! $(destinoid).find("option[value='" + v.monedaId + "']").length)
		        	{						
						  $(destinoid).append('<option value="' + v.monedaId + '">' +v.abrmoneda+' - ' + v.descripcionmoneda + '</option>');
					}		
		        });
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

// ****************************************************************
function pedirmonedas2(destinoid,monedaid){	 
	var parametros={"filtro":monedaid,"llama":"pedirmonedas","funcion":"GET"};
 	$.ajax({ 
    url:   './apis/imonedas.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoid).empty();},
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
         $(r['monedas']).each(function(i, v)
		{ // indice, valor
		    //TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
			// monedaId, descripcionmoneda, abrmoneda
		if (! $(destinoid).find("id[value='" + v.monedaId + "']").length)
		{						
		  $(destinoid).append('<div class="itemgmon">'+
					'<button class="moneda" id="xMONEDA_'+v.monedaId+'" onclick="seleccionmoneda(this.id);">'+v.abrmoneda+'</button>'+
					'</div>');
		}		
		});
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

// ****************************************************************

// ****************************************************************
function pedirmonedas3(destinoid,preidobjetomoneda,monedaid){	 
	// llega 'monedaFiltro_' en preidobjetomoneda
	var parametros={"filtro":monedaid,"llama":"pedirmonedas","funcion":"GET"};
 	$.ajax({ 
    url:   './apis/imonedas.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoid).empty();},
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
         $(r['monedas']).each(function(i, v)
		{ // indice, valor
		    //TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
			// monedaId, descripcionmoneda, abrmoneda
		if (! $(destinoid).find("id[value='" + v.monedaId + "']").length)
		{						
		  $(destinoid).append('<div class="itemgmon">'+
					'<button class="moneda" id="'+preidobjetomoneda+v.monedaId+'" onclick="seleccionmoneda(this.id);pedirTickets(\'#grillaGastos\',99);">'+v.abrmoneda+'</button>'+
					'</div>');
		}		
		});
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

// ****************************************************************

// ****************************************************************
function pedirmonedasabm(destinoid,monedaid){
	//console.log('destinoid '+destinoid);
	//console.log('moneda id'+ monedaid);	 
	var parametros={"filtro":99,"llama":"pedirmonedas","funcion":"GET"};
 	$.ajax({ 
    url:   './apis/imonedas.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoid).empty();},
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
         $(r['monedas']).each(function(i, v)
		        { // indice, valor
		    //TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
			// monedaId, descripcionmoneda, abrmoneda
		        	if (! $(destinoid).find("option[value='" + v.monedaId + "']").length)
		        	{						
						  $(destinoid).append('<option value="' + v.monedaId + '">' +v.abrmoneda+' - ' + v.descripcionmoneda + '</option>');
					}		
		        });
		}
		else {			
				$(".errores").append(re);
			};
		}	
       $(destinoid).prop('disabled', false);
       $(destinoid).val(monedaid);
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
				$(".errores").append(xhr);
		}
    });
}
// ****************************************************************

function agregamoneda(destinoid){

	var parametros = {
			"monnombre":$("#monnombre").val(),
			"abreviatura": $("#abreviatura").val(),
			"filtro":'',
			"llama":"agregamoneda",
			"funcion":"PUT"			
			};	
 	$.ajax({ 
    url:   './apis/imonedas.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoid).empty();},
    done: function(data){},
    success:  function (re){
			pedirmonedas(destinoid,99);	
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);
		}
    });	

}

function eliminamoneda(destinoid){
	var parametros = {
			"filtro":$(destinoid).val(),
			"llama":"eliminamoneda",
			"funcion":"DEL"			
			};	
 	$.ajax({ 
    url:   './apis/imonedas.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoid).empty();},
    done: function(data){},
    success:  function (re){
			pedirmonedas(destinoid,99);	
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);
		}
    });		
	
}



// ****************************************************************
function pedirmediospago(destinoid,mediopago){	 
	var parametros={"filtro":mediopago,"llama":"pedirmediospago","funcion":"GET"};
 	$.ajax({ 
    url:   './apis/imediopago.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoid).empty();},
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
         $(r['MediosPago']).each(function(i, v)
		        { // indice, valor
		    //TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
			// mediopagoid, descripcionmediopago
		        	if (! $(destinoid).find("option[value='" + v.mediopagoid + "']").length)
		        	{						
						  $(destinoid).append('<option value="' + v.mediopagoid + '">' +
						   v.descripcionmediopago +'/'+v.nombreabrev+
						  '</option>');
					}		
		        });
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

// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function pedirmediospago2(destinoid,mediopago){	 
	var parametros={"filtro":mediopago,"llama":"pedirmediospago","funcion":"GET"};
 	$.ajax({ 
    url:   './apis/imediopago.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoid).empty();},
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
         $(r['MediosPago']).each(function(i, v)
		{ // indice, valor
		    //TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
			// monedaId, descripcionmoneda, abrmoneda
		if (! $(destinoid).find("id[value='" + v.mediopagoid + "']").length)
		{						
		  $(destinoid).append('<div class="itemgMPa">'+
					'<button class="moneda" id="xMPAGO_'+v.mediopagoid+'" onclick="seleccionmpago(this.id);" >'+v.nombreabrev+'</button>'+
					'</div>');
		}		
		});
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
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function pedirmediospago3(destinoid,mediopagoidFiltro, mediopago){	 
//mediopagoidFiltro viene 'mpagoFiltro_'
	var parametros={"filtro":mediopago,"llama":"pedirmediospago","funcion":"GET"};
 	$.ajax({ 
    url:   './apis/imediopago.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoid).empty();},
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
         $(r['MediosPago']).each(function(i, v)
		{ // indice, valor
		    //TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
			// monedaId, descripcionmoneda, abrmoneda
		if (! $(destinoid).find("id[value='" + v.mediopagoid + "']").length)
		{						
		  $(destinoid).append('<div class="itemgMPa">'+
					'<button class="moneda" id="'+mediopagoidFiltro+v.mediopagoid+'" onclick="seleccionmpago(this.id);pedirTickets(\'#grillaGastos\',99);" >'+v.nombreabrev+'</button>'+
					'</div>');
		}		
		});
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
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// ****************************************************************
function pedirmediospagoabm(destinoid,mediopago){	 
	var parametros={"filtro":99,"llama":"pedirmediospago","funcion":"GET"};
 	$.ajax({ 
    url:   './apis/imediopago.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoid).empty();},
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
         $(r['MediosPago']).each(function(i, v)
		        { // indice, valor
		    //TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
			// mediopagoid, descripcionmediopago
		        	if (! $(destinoid).find("option[value='" + v.mediopagoid + "']").length)
		        	{						
						  $(destinoid).append('<option value="' + v.mediopagoid + '">' +
						   v.descripcionmediopago +'/'+v.nombreabrev+
						  '</option>');
					}		
		        });
		}
		else {			
				$(".errores").append(re);
			};
		}	
       $(destinoid).prop('disabled', false);
       $(destinoid).val(mediopago);
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
				$(".errores").append(xhr);
		}
    });
}

// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// ****************************************************************
function agregampago(destinoid){
	var parametros = {
			"mpagonombre":$("#mediopagonombre").val(),
			"mediopagoabrev":$("#mediopagoabrev").val(),
			"filtro":'',
			"llama":"agregampago",
			"funcion":"PUT"			
			};	
 	$.ajax({ 
    url:   './apis/imediopago.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoid).empty();},
    done: function(data){},
    success:  function (re){
			pedirmediospago(destinoid,99);	
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);
		}
    });	
	
}

function eliminampago(destinoid){
	var parametros = {
			"filtro":$(destinoid).val(),
			"llama":"eliminampago",
			"funcion":"DEL"			
			};	
 	$.ajax({ 
    url:   './apis/imediopago.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoid).empty();},
    done: function(data){},
    success:  function (re){
			pedirmediospago(destinoid,99);	
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);
		}
    });		
}

// ****************************************************************
function pedirumedidas(destinoid,umed){	 
	var parametros={"filtro":umed,"llama":"pedirumedidas","funcion":"GET"};
 	$.ajax({ 
    url:   './apis/iumed.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoid).empty();},
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
         $(r['UMedidas']).each(function(i, v)
		        { // indice, valor
		    //TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
			// unidadmedidaid, descripcionumedida
		        	if (! $(destinoid).find("option[value='" + v.unidadmedidaid+ "']").length)
		        	{						
						  $(destinoid).append('<option value="' + v.unidadmedidaid + '">' +
						   v.descripcionumedida +'('+v.nombreAbr+')'+
						  '</option>');
					}		
		        });
		}
		else {			
				$(".errores").append(re);
			};
		}	
       $(destinoid).prop('disabled', false);
       $(destinoid).val(umed);
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
				$(".errores").append(xhr);
		}
    });
}

// ***************************************************************************
function agregaunimedidas(destinoid){
	//
	var parametros = {
			"umednombre":$("#umednombre").val(),
			"umednombreabrev":$("#umednombreabrev").val(),
			"filtro":'',
			"llama":"agregaumedida",
			"funcion":"PUT"			
			};	
 	$.ajax({ 
    url:   './apis/iumed.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoid).empty();},
    done: function(data){},
    success:  function (re){
			pedirumedidas(destinoid,99);	
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);
		}
    });		
}

function eliminaunimedidas(destinoid){
	var parametros = {
			"filtro":$(destinoid).val(),
			"llama":"eliminaumed",
			"funcion":"DEL"			
			};	
 	$.ajax({ 
    url:   './apis/iumed.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoid).empty();},
    done: function(data){},
    success:  function (re){
			pedirumedidas(destinoid,99);	
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);
		}
    });		
	
}

// ***************************************************************************

// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ****************************************************************

function pedirtipos(destinoid,iTabla){	 
	var parametros={"filtro":iTabla,"llama":"pedirtipos","funcion":"GET"};
 	$.ajax({ 
    url:   './apis/igtipos.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoid).empty();},
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
         $(r['GTipos']).each(function(i, v)
		        { // indice, valor
		    //TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
			// 
		        	if (! $(destinoid).find("option[value='" + v.descripciontipo+ "']").length)
		        	{		
		        			if(iTabla != '')
							  $(destinoid).append('<option value="' + v.descripciontipo + '">' +
							   v.descripciontipo +
							  '</option>');

		        			else
							  $(destinoid).append('<option value="' + v.descripciontipo + '">' +
							   v.descripciontipo+' '+v.tablaPertenece +
							  '</option>');
					}		
		        });
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

// ***************************************************************************
function agregatipos(destinoid){
	//
	var parametros = {
			"tablaPertenece":$("#tablaPertenece").val(),
			"descripciontipo":$("#descripciontipo").val(),			
			"filtro":'',
			"llama":"agregatipo",
			"funcion":"PUT"			
			};	
 	$.ajax({ 
    url:   './apis/igtipos.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoid).empty();},
    done: function(data){},
    success:  function (re){
			pedirtipos(destinoid,'');	
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);
		}
    });		
}

function eliminatipos(destinoid){
	var parametros = {
			"filtro":$(destinoid).val(),
			"llama":"eliminatipo",
			"funcion":"DEL"			
			};	
 	$.ajax({ 
    url:   './apis/igtipos.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoid).empty();},
    done: function(data){},
    success:  function (re){
			pedirtipos(destinoid,'');	
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);
		}
    });		
	
}

// ***************************************************************************
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function eliminaTicket(vticketID,fechaTicket){

	var parametros=
	{
		    "gasFecha": fechaTicket,
		    "filtro": vticketID,
			"llama":"eliminar",
			"funcion":"DEL"
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
    });//fin del AJAX

	
}
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function modificaTicket(vticketID,fechaTicket)
{
	location.href='ticket.php?idticket='+vticketID+'&fechaticket='+fechaTicket; 
	
}
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function pedirTickets(grillaGastosID,idticket){
	stringmoneda = '';
	monedaSeleccionada='';
	$(".selectedMon").each(function(index) {
	 //     console.log(index + ": " + $(this).text());
	 	  stringmoneda = $(this).attr('id').split("_");
	  });	
	monedaSeleccionada = stringmoneda[1];

	stringmepago = '';		
	mformapago = '';
	$(".selectedMPago").each(function(index) {
	 //     console.log(index + ": " + $(this).text());
	 	  stringmepago = $(this).attr('id').split("_");
	  });	
	mformapago = stringmepago[1];
//	alert(mformapago);
	//alert( " id ("+monedaSeleccionada+") de la MONEDA SELECCIONADA, abrev: " + $( ".itemgmon BUTTON.selectedMon" ).html());	

var sonCuotasVal = 0;
 if( $("#SonCuotas").is(':checked') )
	    sonCuotasVal=1;
	
	var parametros=
	{
			"llama":"pedir",
			"funcion":"GET",
			"filtroTicket":idticket,
			"FechaBuscar":$("#FechaBuscar").val(),
			"SonCuotas":sonCuotasVal,
			"filtroFechaGeneral": $("#filtroFechaGastos").val(),
			"productos": $("#gproductos").val(),
			"comercios" : $("#fcomercios").val(),
		    "moneda": monedaSeleccionada,
		    "mformapago": mformapago,
			
	};

 	$.ajax({ 
    url:   './apis/ioegresos.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(grillaGastosID).empty();},
    done: function(data){},
    success:  function (re){
			//idpersona, usuariopersona, nombrepersona, tipopersona         	  
			
	   var listaGastos="";
	   if(re.indexOf("<br />") > -1)
					$(".errores").append(re);
		else
		{
		var r = JSON.parse(re);
        if(r['estado'] == 1) {

		$(r['gastos']).each(function(i, v)
		{ // indice, valor
		listaGastos="";    
		totalTicket =0.0;
		totalLinea =0.0;
				//console.log(i);
		        $(v.items).each(function(j, x)
		        { // indice, valor
						var recargo = (-1)*(x.descuento);
						var describeExtra='Dsc '+v.abrmoneda+' '+x.descuento; 											if(v.movTipo == 'I') describeExtra=' '+v.abrmoneda+' '+x.descuento;
						if( x.EsRecargo == 1 )
							{
							   recargo = x.descuento;
								describeExtra='Rec '+v.abrmoneda+' '+x.descuento; 
							}	 

				       var Cantidad = x.gasCant;
			           var precioUnitario = x.gasPUnit;
						//totalLinea =  (x.gasPUnit*x.gasCant) ;	
		            	totalLinea = parseFloat(Cantidad) * parseFloat(precioUnitario) + 
            					     parseFloat(recargo);
						//console.log("CALCULANDO LA LINEA con Recargo/Descuento: " + totalLinea);
						totalTicket = parseFloat(totalTicket) + parseFloat(totalLinea) ;								//console.log("CALCULANDO Total: " + totalTicket);
						
						
				listaGastos += '<div class="ga_grillaiTems">'+
									'<div class="gritems1">'+x.gasDescripcion+'</div>'+
									'<div class="gritems2">'+x.descripcionumedida+'</div>'+
									'<div class="gritems222">'+x.gasCant+'</div>'+
									'<div class="gritems3">PUnit:</div>'+
									'<div class="gritems4">'+v.abrmoneda+' '+x.gasPUnit+'</div>'+
									'<div class="gritems44">'+describeExtra+'</div>'+
									'<div class="gritems5">Total</div>'+
									'<div class="gritems6">'+
									v.abrmoneda+' '+totalLinea+'</div>'+
									'</div>';
				});
				
				totalTicket = parseFloat(totalTicket) - parseFloat(v.descuentoGeneral);
				
				var cabeceraGasto='<div class="gasto">';
				if(v.movTipo == 'I') cabeceraGasto = '<div class="gasto INGRESO">';
				 var SiEsCuotaNoUpdate='<div class="ga_item2">TICKET: <span class="botonUpdate" id="TICKET_'+v.ticketID+'" onclick="modificaTicket('+v.ticketID+',\''+v.gasFecha+'\');">'+v.ticketID+'</span>'+'<input type="hidden" id="idgasto" name="idgasto" value=""></input></div>';
				 if (v.montoCuota != 0){
				 	SiEsCuotaNoUpdate='<div class="ga_item2">TICKET: <span class="botonUpdateGris" id="TICKET_'+v.ticketID+'" onclick="alert(\'No se modifican las cuotas\');">'+v.ticketID+'</span>'+'<input type="hidden" id="idgasto" name="idgasto" value=""></input></div>';				 
				 
					 cabeceraGasto = '<div class="gasto CUOTA">';
				 }
				 
		         $(grillaGastosID).append(cabeceraGasto+
											'<div class="ga_item1">'+v.gasFecha+'</div>'+
											SiEsCuotaNoUpdate+
											'<div class="ga_item3"><button id="eliminarGasto" class=""  onclick="eliminaTicket('+v.ticketID+',\''+v.gasFecha+'\');" >-</button></div>'+
											'<div class="ga_item4">'+v.descripcionComercio+'</div>'+
											'<div class="ga_item5">'+v.nombreabrev+'</div>'+
											'<div class="ga_item6">'+v.abrmoneda+' '+v.descripcionmoneda+'</div>'+
							'<div class="ga_item66">Desc Gen por '+v.ConceptoDescGen+' '+v.abrmoneda+' '+v.descuentoGeneral+'</div>'+									
											'<div class="ga_item7">'+
											'<div >TOTAL '+v.abrmoneda+totalTicket +'</div>'+
											'<div >   CUOTA  '+v.abrmoneda+v.montoCuota +'</div>'+
											'</div>'+
											'<div class="ga_item8">'+listaGastos+
											'</div>'+
										'</div>');

		        });
		}
		else {			
				$(".errores").append(re);
			};
		}	
       $(grillaGastosID).prop('disabled', false);
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
				$(".errores").append(xhr);
		}
    });	
	
	
}
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function pedirTicketStats(grillaGastosID,idticket){
	stringmoneda = '';
	monedaSeleccionada='';
	$(".selectedMon").each(function(index) {
	 //     console.log(index + ": " + $(this).text());
	 	  stringmoneda = $(this).attr('id').split("_");
	  });	
	monedaSeleccionada = stringmoneda[1];

	stringmepago = '';		
	mformapago = '';
	$(".selectedMPago").each(function(index) {
	 //     console.log(index + ": " + $(this).text());
	 	  stringmepago = $(this).attr('id').split("_");
	  });	
	mformapago = stringmepago[1];
//	alert(mformapago);
	//alert( " id ("+monedaSeleccionada+") de la MONEDA SELECCIONADA, abrev: " + $( ".itemgmon BUTTON.selectedMon" ).html());	
	
	
	
	var parametros=
	{
			"llama":"pedir",
			"funcion":"GET",
			"filtroTicket":idticket,
			"FechaBuscar":$("#FechaBuscar").val(),
			"filtroFechaGeneral": $("#filtroFechaGastos").val(),
			"productos": $("#gproductos").val(),
			"comercios" : $("#fcomercios").val(),
		    "moneda": monedaSeleccionada,
		    "mformapago": mformapago,
			
	};

 	$.ajax({ 
    url:   './apis/ioegresos.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(grillaGastosID).empty();},
    done: function(data){},
    success:  function (re){
			//idpersona, usuariopersona, nombrepersona, tipopersona         	  
			
	   var listaGastos="";
	   if(re.indexOf("<br />") > -1)
					$(".errores").append(re);
		else
		{
		var r = JSON.parse(re);
        if(r['estado'] == 1) {

		$(r['gastos']).each(function(i, v)
		{ // indice, valor
		listaGastos="";    
		totalTicket =0.0;
		totalLinea =0.0;
				//console.log(i);
		        $(v.items).each(function(j, x)
		        { // indice, valor
						var recargo = (-1)*(x.descuento);
						var describeExtra='Dsc '+v.abrmoneda+' '+x.descuento; 											if(v.movTipo == 'I') describeExtra=' '+v.abrmoneda+' '+x.descuento;
						if( x.EsRecargo == 1 )
							{
							   recargo = x.descuento;
								describeExtra='Rec '+v.abrmoneda+' '+x.descuento; 
							}	 

				       var Cantidad = x.gasCant;
			           var precioUnitario = x.gasPUnit;
						//totalLinea =  (x.gasPUnit*x.gasCant) ;	
		            	totalLinea = parseFloat(Cantidad) * parseFloat(precioUnitario) + 
            					     parseFloat(recargo);
						//console.log("CALCULANDO LA LINEA con Recargo/Descuento: " + totalLinea);
						totalTicket = parseFloat(totalTicket) + parseFloat(totalLinea) ;								//console.log("CALCULANDO Total: " + totalTicket);
						
						
				listaGastos += '<div class="ga_grillaiTems">'+
									'<div class="gritems1">'+x.gasDescripcion+'</div>'+
									'<div class="gritems2">'+x.descripcionumedida+'</div>'+
									'<div class="gritems222">'+x.gasCant+'</div>'+
									'<div class="gritems3">PUnit:</div>'+
									'<div class="gritems4">'+v.abrmoneda+' '+x.gasPUnit+'</div>'+
									'<div class="gritems44">'+describeExtra+'</div>'+
									'<div class="gritems5">Total</div>'+
									'<div class="gritems6">'+
									v.abrmoneda+' '+totalLinea+'</div>'+
									'</div>';
				});
				var cabeceraGasto='<div class="gasto">';
				if(v.movTipo == 'I') cabeceraGasto = '<div class="gasto INGRESO">';
		         $(grillaGastosID).append(cabeceraGasto+
											'<div class="ga_item1">'+v.gasFecha+'</div>'+
											'<div class="ga_item2">TICKET: <span class="botonUpdate" id="TICKET_'+v.ticketID+'" onclick="modificaTicket('+v.ticketID+',\''+v.gasFecha+'\');">'+v.ticketID+'</span>'+
											'<input type="hidden" id="idgasto" name="idgasto" value=""></input></div>'+
											'<div class="ga_item3"><button id="eliminarGasto" class=""  onclick="eliminaTicket('+v.ticketID+',\''+v.gasFecha+'\');" >-</button></div>'+
											'<div class="ga_item4">'+v.descripcionComercio+'</div>'+
											'<div class="ga_item5">'+v.nombreabrev+'</div>'+
											'<div class="ga_item6">'+v.abrmoneda+' '+v.descripcionmoneda+'</div>'+
											'<div class="ga_item7">TOTAL '+v.abrmoneda+totalTicket +'</div>'+
											'<div class="ga_item8">'+listaGastos+
											'</div>'+
										'</div>');

		        });
		}
		else {			
				$(".errores").append(re);
			};
		}	
       $(grillaGastosID).prop('disabled', false);
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
				$(".errores").append(xhr);
		}
    });	
	
	
}
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function pedirTicketsMod(grillaGastosID,idticket,FechaTicket){
	
	var parametros=
	{
		    "gasFecha": FechaTicket,
			"llama":"pedirmod",
			"funcion":"GET",
			"filtroTicket":idticket
	};

 	$.ajax({ 
    url:   './apis/ioegresos.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(grillaGastosID).empty();},
    done: function(data){},
    success:  function (re){
			//idpersona, usuariopersona, nombrepersona, tipopersona         	  
			
	   var listaGastos="";
	   if(re.indexOf("<br />") > -1)
					$(".errores").append(re);
		else
		{
		var r = JSON.parse(re);
        if(r['estado'] == 1) {

		$(r['gastos']).each(function(i, v)
		{ // indice, valor
		listaGastos="";    
		var totalLinea =0.0;
		var totalTicket =0.0;
				//console.log(i);
		contadorDescripcionItems = v.items.length ;		
		$("#contadorItemsVer").text(contadorDescripcionItems);
		
	        $(v.items).each(function(j, x)
	        { // indice, valor
				//cargar los datos segun lo que viene en klos ITEMS
			var recargo= (-1)*(x.descuento);
			var TildeActivo = '';
			if( x.EsRecargo==1 ) 
				{
					recargo= x.descuento;
					TildeActivo = ' checked ';
				}
				
			var Cantidad = x.gasCant;
			var precioUnitario = x.gasPUnit;
			totalLinea = parseFloat(Cantidad) * parseFloat(precioUnitario) + 
			     		 parseFloat(recargo);
			totalTicket = parseFloat(totalTicket) + parseFloat(totalLinea) ;					
			
			$("#itemsTicket").append('<div id="DSCCONTENEDOR_'+(j+1)+'" >'+
				'<div class="descripcion">'+
				'<input type="hidden" id="idregistro_'+(j+1)+'" value="'+x.gasid+'"></input> '+
				'<div class="descitem1">'+(j+1)+'</div>'+
				'<div class="descitem2">Descripcion</div>'+
				'<div class="descitem22"><span id="montoparcial_'+(j+1)+'" >'+totalLinea+'</span></div>'+
				'<div class="descitem3">'+
					'<input type="text" value="'+x.gasDescripcion+'" id="descripcion_'+(j+1)+'" />'+
				'</div>'+
				'<div class="descitem4" onclick="elimnaritem(\'DSCCONTENEDOR_'+(j+1)+'\');">(X)</div>'+
			'</div>'+
			'<div class="CantPunit">'+
				'<div class="umedidas  CantPunit1">'+
					 '<div class="itemumed1"></div>'+	
					  '<div class="itemumed2">'+
					  '<select id="iumedidas_'+(j+1)+'" class="comercioSel">'+
	  					'<option value="9999">Unidad medida</option>'+
	  				  '</select>'+
	  				  '</div>'+
				'</div>'+
				'<div class="cantidad  CantPunit2">'+
					'<div class="itemcant1">Cant.</div>'+
					'<div class="itemcant2">'+
					'</div>'+
					'<div class="itemcant3">'+
						'<input type="number" value="'+x.gasCant+'" id="cantidad_'+(j+1)+'"  onkeyup="totalCalcular();"  />'+
					'</div>'+
					'<div class="itemcant4">'+
					'</div>'+
				'</div>'+
				'<div class="preciounit CantPunit3">'+
					'<div class="itempun1">Precio Unitario</div>'+
					'<div class="itempun2">'+
					'</div>'+
					'<div class="itempun3">'+
						'<input type="number" value="'+x.gasPUnit+'" id="pun_'+(j+1)+'" onkeyup="totalCalcular();" />'+
					'</div>'+
					'<div class="itempun4">'+
					'</div>'+
				'</div>'+

			'<div class="descuento CantPunit11">'+
				'<div class="itemdis1">Descuento</div>'+
				'<div class="itemdis2">'+
				'</div>'+
				'<div class="itemdis3">'+
					'<input type="number" value="'+x.descuento+'" id="dis_'+(j+1)+'" onkeyup="totalCalcular();" />'+
				'</div>'+
				'<div class="itemdis4">'+
					'<input type="checkbox" id="EsRecargo_'+(j+1)+'" value="'+ x.EsRecargo+'"  onclick="totalCalcular();" '+TildeActivo+' ></input>'+
				'</div>'+
			   '</div>'+				
			 '</div>'+
			'</div>');
			pedirumedidas('#iumedidas_'+(j+1),v.unidad);
				$('#iumedidas_'+(j+1)).val(v.unidad);	
				
			});
				
			$("#FechaTicket").val(v.gasFecha);
			//v.ticketID
			$("#gcomercio").val(v.ComercioId);
			//v.nombreabrev
			totalTicket = parseFloat(totalTicket) - parseFloat(v.descuentoGeneral) ;					
			//v.descripcionmoneda
			$("#totalCalculado").val(totalTicket); 
		    $("#descgenDesc").val(v.ConceptoDescGen);
		    $("#descuentogenmonto").val(v.descuentoGeneral);
			//solo traigo la info de la cuota, no la toco..
			$("#montoCuota").val(v.montoCuota);
			$("#observaciones1").val(v.gasobservaciones1);	
			
			seleccionmoneda('xMONEDA_'+v.monedaId);
			seleccionmpago('xMPAGO_'+v.tipoMedioPago);

			if(v.movTipo == 'I')
				seleccionIE('EsIngreso');
			else	
				if(v.movTipo == 'E')
						seleccionIE('EsEgreso');
				
		 });
		}
		else {			
				$(".errores").append(re);
			};
		}	
       $(grillaGastosID).prop('disabled', false);
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
				$(".errores").append(xhr);
		}
    });	
	
	
}
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

function grabarsesion(claveSesion,valorSesion){
	
//+++++++++++++++++++++++++++++++LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++				
	var parametros = {"llamador" :"grabarSesion","funcion":"grabarsesion","clave" : claveSesion,"valorSesion":valorSesion};	
 
 	$.ajax({ 
    url:   './apis/curFunciones.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){},
    done: function(data){},
    success:  function (re){},
     error: function (xhr, ajaxOptions, thrownError) 
     {
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);   
	}
    });
//++++++++++++++++++++++FIN DE LA LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++		
}
// ***********************************************************************************
// ***********************************************************************************
function leersesion(claveSesion){
//+++++++++++++++++++++++++++++++LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++
 	var respuesta = 0;
	var parametros = {"llamador" :"leerSesion","funcion":"leersesion","clave" : claveSesion};	
 	$.ajax({ 
    url:   './apis/curFunciones.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
    async: false,
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    success:  function (re){
    	//$(".errores").append(re);
    	respuesta = re;	
    },
     error: function (xhr, ajaxOptions, thrownError) 
     {
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);   
	}
    });
    
  return respuesta.trim(); 
//++++++++++++++++++++++FIN DE LA LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++		
}
// **************************************************************************************************
function devuelveSesionValores(datos){
	return datos;
}


// ****************************************************************

