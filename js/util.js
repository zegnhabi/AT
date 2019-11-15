/*Funciones ocupadas en el sistema.
*/
	//añade una funcion a la clase String.
	String.prototype.endsWith = function(str){
			return (this.match(str+"$")==str)
		}
	String.prototype.startsWith = function(str){
			return (this.match("$"+str)==str)
		}
//Manejadora de eventos.
var Eventos={
	addEvent:function( obj, type, fn ) {
		if ( obj.attachEvent ) {
			obj['e'+type+fn] = fn;
		obj[type+fn] = function(){obj['e'+type+fn]( window.event );}
			obj.attachEvent( 'on'+type, obj[type+fn] );
		} else
			obj.addEventListener( type, fn, false );
	},
	removeEvent:function( obj, type, fn ) {
		if ( obj.detachEvent ) {
			obj.detachEvent( 'on'+type, obj[type+fn] );
		obj[type+fn] = null;
		} else
			obj.removeEventListener( type, fn, false );
	}
}
//Para proposito general
var Util={
		imprimirBoleto:function()
		{
			if (window.print)
			{
				if(confirm("Desea imprimir los boletos?"))
				{	 var ficha = document.getElementById('boleto');
					var ventimp = window.open(' ', 'popimpr');
					ventimp.document.write( ficha.innerHTML );
					ventimp.document.close();
					ventimp.print( );
					ventimp.close();
				}
			}
			else
				alert("Para imprimir presione Crtl+P.");
		},
		realizarCompra:function()
		{
			var valor="Debes de ingresar el nombre del pasajero.";
			var len=document.forms[0].length;
			var elementos=document.forms[0].elements;
			var formu=document.forms[0];
			//validamos los text
			for(var i=0;i<len;i++)
			{
				if(elementos[i].value=="" && elementos[i].type=="text"){
					elementos[i].focus();
					return false;
				}
			}
			var datos="";
			var asi="";
			var nombres="";
			//Obtenemos los datos de los asientos
			for(var i=0;i<len;i++)
			{
					if(elementos[i].type=="text")
						nombres=nombres+elementos[i].value+",";
			}
			for(var i=0;i<len;i++)
			{
				if(elementos[i].type=="hidden" && elementos[i].id!="id_boleto")
					asi=asi+elementos[i].value+",";
			}
			nombres=nombres.substring(0,nombres.length-1);
			asi=asi.substring(0,asi.length-1);
			//obtenemos el id de boleto
			var id_boleto=document.forms[0].id_boleto.value;
			var encoded="id="+Base64.encode(id_boleto)+"&as="+Base64.encode(asi)+"&no="+Base64.encode(nombres);
				formu.action="imprimirBoletos.php?"+encoded;
			if(confirm("Desea realizar la compra de los boletos!?"))
			{
				alert("Compra realizada");
				formu.submit();
			}else
				return false;
		},
		focusCampo:function(campo)
		{
				campo.style.backgroundColor="#FBF5EF";
		},
		blurCampo:function(campo)
		{
				campo.style.backgroundColor="white";
		},
		//avanzar a la compra del boleto.
		AvanzarCompra:function()
		{
			//vemos que boletos estan seleccionados y sus respectivos numeros.
			var seleccionado="images/seleccionado.gif";
			var imagenes=document.images;
			var largo=imagenes.length;
			var query="";
			for(var i=0;i<largo;i++)
			{
				if(imagenes[i].src.endsWith(seleccionado) && imagenes[i].id != "")
				{
					query+=imagenes[i].id+",";
				}
			}
			query=query.substring(0,query.length-1);
			//Damos el action al formulario.
				var formu=document.forms[0];
				var id_corrida=formu.id_corrida.value;
				//Enviamos los datos
				var encoded="id="+Base64.encode(id_corrida)+"&as="+Base64.encode(query);
				formu.action="comprar.php?"+encoded;
				formu.submit();
		},
		avanzar:function()
		{
			var bolSel=document.forms[0].num_bol_selec.value;
			var bolMax=document.forms[0].bolsMax.value;
			if(bolSel==0)
			{
					alert("Tienes que  seleccionar más boletos");
					return false;
			}
			if(bolSel>bolMax )
			{
				if(confirm("Tienes Seleccionados más boletos, deseas volver a seleccionarlos!?"))
				{
					location.reload(true);
				}else
				{
					alert("Puedes seleccionar más boletos, cambiando el numero de boletos.");
					document.forms[0].num_boletos.focus();
				}
			}else
			{
				Util.AvanzarCompra();
			}
		},
		//Inicializa los contadores
		cargar:function()
		{
			var bMax=document.forms[0].bolsMax;
			var indice=document.forms[0].num_boletos.selectedIndex;
			bMax.value=indice+1;
			Util.scrlsts();
		},
		//Funcion para seleccionar el numero de boleticos.
		bolsMax:function(indice)
		{
			var bMax=document.forms[0].bolsMax;
			bMax.value=indice+1;
		},
		//Cambia la imagen del asiento al darle click.
		swapImage:function(imagenSeleccionada)
		{
			var id=imagenSeleccionada.id;
			var imagen=document.images[id];
			var img="images/seleccionado.gif";
			var path="images/";
			var bolSel=document.forms[0].num_bol_selec.value;
			var bolMax=document.forms[0].bolsMax.value;
			if( bolSel < bolMax )
			{
				if(imagen.src.endsWith(img))
				{
					imagen.src=path+id+".jpg";
					document.forms[0].num_bol_selec.value--;
				}else
					imagen.src=img;
					document.forms[0].num_bol_selec.value++;
			}else
				alert("Numero Maximo de Boletos");
		},
		//Muestra mensajito en el title del browser
		scrlsts:function () {
		var scrl=document.title;
		scrl = scrl.substring(1, scrl.length) + scrl.substring(0, 1);
		document.title = scrl;
		setTimeout("Util.scrlsts()", 300);
		},
		//Seleciciona las corridas.
		seleccionar:function()
		{
			var valor="Selecciona una corrida.";
			var len=document.forms[0].length;
			var elementos=document.forms[0].elements;
			for(var i=0;i<len;i++)
			{
				if(elementos[i].checked){
					valor=elementos[i].value;
				}
			}
			if(valor!="Selecciona una corrida.")
			{
				//Continuo con los datos.
				//Damos el action al formulario.
				var id_corrida=valor;
				var formu=document.forms[0];
				//Enviamos los datos
				var encoded="id="+Base64.encode(id_corrida);
				formu.action="elegir.php?"+encoded;
				formu.submit();
			}else
			{
				//Mando error.
				alert("Selecciona una corrida.");
			}
		},
		//Igual si le dieramos click al boton back del browser.
		Regresar:function()
		{
			if(confirm("Deseas ir  a la pagina anterior!?"))
			{
				history.back(1);
			}
		},
		//Establece la fecha de hoy en el form.
		fechaHoy:function ()
		{
			Util.scrlsts();
			var fecha=new Date();
			var fechaHoy=fecha.getDate()+"-"+(fecha.getMonth()+1)+"-"+fecha.getFullYear();
			document.getElementById('fecha').value=fechaHoy;
			document.getElementById('fechahoy').value=fechaHoy;
		},
		//Funcion que busca las corridas y valida el form.
		Buscar: function ()
		{
			//Obtenemos el valor del origen.
			var origen=document.forms[0].origen.value;
			//Obtenemos el valor del destino.
			var destino=document.forms[0].destino.value;
			//validamos que este seleccionado un origen.
			if(origen==-1 && destino==-1)
			{
				alert("Seleccione Origen y Destino");
				return false;
			}
			if(origen==-1)
			{
				alert("Debe seleccionar un  origen");
				return false;
			}
			//validamos que este seleccionado un destino.
			if(destino==-1)
			{
				alert("Debe seleccionar un destino");
				return false;
			}
			//validamos que origen y destino no sean iguales.
			if(origen==destino)
			{
				alert("Origen y Destino no pueden ser iguales");
				return false;
			}
			//Obtenemos la fecha de la busqueda.
			var fecha=document.getElementById('fecha').value;
			//Obtenemos la fecha de hoy.
			var fechah=document.getElementById('fechahoy').value;
			//Comparando fechas
			var myDate=new Date();
			var aux=fecha.split("-");
			myDate.setFullYear(aux[2],aux[1]-1,aux[0]);
			var today = new Date();
			/*if (today>myDate)
			{
				alert("La fecha de salida no puede ser menor que hoy.");
				return false;
			}*/
			//Damos el action al formulario.
			var formu=document.forms[0];
			//Enviamos los datos
			var encoded="or="+Base64.encode(origen)+
							"&de="+Base64.encode(destino)+
							"&fe="+Base64.encode(fecha)+
							"&fh="+Base64.encode(fechah);
			formu.action="buscar.php?"+encoded;
			formu.submit();
			return true;
		}
	}
 //Para mandar los datos pero cifrados.
var Base64 = {
 
	// private property
	_keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
 
	// encoding de los datos
	encode : function (input) {
		var output = "";
		var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
		var i = 0;
 
		input = Base64._utf8_encode(input);
 
		while (i < input.length) {
 
			chr1 = input.charCodeAt(i++);
			chr2 = input.charCodeAt(i++);
			chr3 = input.charCodeAt(i++);
 
			enc1 = chr1 >> 2;
			enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
			enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
			enc4 = chr3 & 63;
 
			if (isNaN(chr2)) {
				enc3 = enc4 = 64;
			} else if (isNaN(chr3)) {
				enc4 = 64;
			}
 
			output = output +
			this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
			this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);
 
		}
 
		return output;
	},
 
	// decoding de los datos
	decode : function (input) {
		var output = "";
		var chr1, chr2, chr3;
		var enc1, enc2, enc3, enc4;
		var i = 0;
 
		input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
 
		while (i < input.length) {
 
			enc1 = this._keyStr.indexOf(input.charAt(i++));
			enc2 = this._keyStr.indexOf(input.charAt(i++));
			enc3 = this._keyStr.indexOf(input.charAt(i++));
			enc4 = this._keyStr.indexOf(input.charAt(i++));
 
			chr1 = (enc1 << 2) | (enc2 >> 4);
			chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
			chr3 = ((enc3 & 3) << 6) | enc4;
 
			output = output + String.fromCharCode(chr1);
 
			if (enc3 != 64) {
				output = output + String.fromCharCode(chr2);
			}
			if (enc4 != 64) {
				output = output + String.fromCharCode(chr3);
			}
 
		}
 
		output = Base64._utf8_decode(output);
 
		return output;
 
	},
 
	//encoding interno a UTF
	_utf8_encode : function (string) {
		string = string.replace(/\r\n/g,"\n");
		var utftext = "";
 
		for (var n = 0; n < string.length; n++) {
 
			var c = string.charCodeAt(n);
 
			if (c < 128) {
				utftext += String.fromCharCode(c);
			}
			else if((c > 127) && (c < 2048)) {
				utftext += String.fromCharCode((c >> 6) | 192);
				utftext += String.fromCharCode((c & 63) | 128);
			}
			else {
				utftext += String.fromCharCode((c >> 12) | 224);
				utftext += String.fromCharCode(((c >> 6) & 63) | 128);
				utftext += String.fromCharCode((c & 63) | 128);
			}
 
		}
 
		return utftext;
	},
 
	//decoding interno a UTF
	_utf8_decode : function (utftext) {
		var string = "";
		var i = 0;
		var c = c1 = c2 = 0;
 
		while ( i < utftext.length ) {
 
			c = utftext.charCodeAt(i);
 
			if (c < 128) {
				string += String.fromCharCode(c);
				i++;
			}
			else if((c > 191) && (c < 224)) {
				c2 = utftext.charCodeAt(i+1);
				string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
				i += 2;
			}
			else {
				c2 = utftext.charCodeAt(i+1);
				c3 = utftext.charCodeAt(i+2);
				string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
				i += 3;
			}
 
		}
 
		return string;
	}
 
}
