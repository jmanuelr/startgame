//----------------------
function validaEmail(campo,email,ididm){
	var reEmail1 = /^[\w!#$%&'*+\/=?^`{|}~-]+(\.[\w!#$%&'*+\/=?^`{|}~-]+)*@(([\w-]+\.)+[A-Za-z]{2,6}|\[\d{1,3}(\.\d{1,3}){3}\])$/;
	var msg = [];
	if(email != ""){
	    if (!reEmail1.test(email)) {
            msg[1] = " não é um endereço válido de e-mail!";
            msg[2] = " no es una dirección válida de e-mail!";
            msg[3] = " is not a valid e-mail!";
            if(ididm > 0)alert('"' + email + '"' + msg[ididm]);
		    //campo.value = "";
		    campo.focus();
		    return false;
	    }else{
	        return true;
	    }
    }else{
		msg[1] = "Informe um endereço válido de e-mail!";
		msg[2] = "Informe una dirección válida de e-mail!";
		msg[3] = "Type a valid e-mail!";
		if(ididm > 0)alert(msg[ididm]);
		//campo.value = "";
		campo.focus();
		return false;
	}
    return false;
}

function PopupCentralizado(pagina,nome,width,height,parametros) {
	largura = screen.width;
	altura = screen.height;
	posX = (largura - width) / 2;
	posY = (altura - height) / 2;
	var janela = null;
	if (parametros=='') {
		janela = window.open(pagina, nome,'left='+posX+',top='+posY+',height='+height+',width='+width);
	} else {
		janela = window.open(pagina, nome,parametros+',left='+posX+',top='+posY+',height='+height+',width='+width);
	}
	janela.focus();
	return false;
}

function TeclaInteiro(e){
	var key;
	var keychar;
	var reg;
	if(window.event){
		key = e.keyCode;
	}else if(e.which){
		key = e.which;
	}else{
		return true;
	}//if

	if((key > 47 && key < 58) || (key == 8)){ // numeros de 0 a 9 OU BACKSPACE
		return true;
	}else{
		return false;
	}//if
}

function TeclaDecimal(e){
	var key;
	var keychar;
	var reg;

	if(window.event) {
		// for IE, e.keyCode or window.event.keyCode can be used
		key = e.keyCode;
	}
	else if(e.which) {
		// netscape or firefox
		key = e.which;
	}
	else {
		// no event, so pass through
		return true;
	}
	if(key > 47 && key < 58) // numeros de 0 a 9
		return true;
	else {
		if (key == 8 || key == 44 || key == 46) // backspace / , / .
			return true;
		else
			return false;
	}
}
//**************************************************
function TeclaDecimal2(objeto){
	var valor = objeto.value;
	var key = "";
	var palavra = "";
	var ValidChars = "0123456789.,";

	for (i = 0; i < valor.length; i++){
	  key = valor.charAt(i);
	  if (ValidChars.indexOf(key) >= 0){
		   palavra += "" + key;
	  }
	}

	objeto.value = palavra;
}

function TeclaInteiro2(objeto){
	var valor = objeto.value;
	var key = "";
	var palavra = "";
	var ValidChars = "0123456789";

	for (i = 0; i < valor.length; i++){
	  key = valor.charAt(i);
	  if (ValidChars.indexOf(key) >= 0){
		   palavra += "" + key;
	  }
	}

	objeto.value = palavra;
}
function TeclaEnter(e){
	var key;
	var keychar;
	var reg;

	if(window.event){
		key = e.keyCode;
	}else if(e.which){
		key = e.which;
	}else{
		return false;
	}

	if((key == 13)){
		return true;
	}else{
		return false;
	}
}
//**************************************************
function countChars(num_chars, obj_mostrador, obj_texto, msg) {
	campo=obj_texto.value;
	obj_mostrador.value=campo.length;
	if (campo.length>parseInt(num_chars)) {
		alert(msg+" "+num_chars+" caracteres.");
		obj_texto.value=campo.substring(0,parseInt(num_chars));
		obj_mostrador.value=num_chars;
		return false;
	}
	return true;
}

function getElementsByClass(searchClass,node,tag) {

	var classElements = new Array();
	if (node == null)
		node = document;
	if (tag == null)
		tag = '*';
	var els = node.getElementsByTagName(tag);
	var elsLen = els.length;
	var pattern = new RegExp("(^|\\s)"+searchClass+"(\\s|$)");
	var j = 0;
	for (i = 0; i < elsLen; i++) {
		if (pattern.test(els[i].className) ) {
			classElements[j] = els[i];
			j++;
		}
	}
	return classElements;
}

function getNowString(){
		var now = new Date();
		var ano = now.getFullYear();
		var mes = now.getMonth() + 1;
		if(mes<10) mes = "0" + mes;
		var dia = now.getDate();
		if(dia<10) dia = "0" + dia;
		var hora = now.getHours();
		if(hora<10) hora = "0" + hora;
		var minuto = now.getMinutes();
		if(minuto<10) minuto = "0" + minuto;
		var segundo = now.getSeconds();
		if(segundo<10) segundo = "0" + segundo;
		var agora = ano + "" + mes + "" + dia + "" + hora + "" + minuto + "" + segundo;
		return agora;
}

function FormatNumber(num,decimalNum,bolLeadingZero,bolParens,bolCommas,bolPadZeroDec)
/**********************************************************************
	IN:
		NUM - the number to format
		decimalNum - the number of decimal places to format the number to
		bolLeadingZero - true / false - display a leading zero for
										numbers between -1 and 1
		bolParens - true / false - use parenthesis around negative numbers
		bolCommas - put commas as number separators.

	RETVAL:
		The formatted number!
 **********************************************************************/
{
        if (isNaN(parseInt(num))) return "NaN";

	var tmpNum = num;
	var iSign = num < 0 ? -1 : 1;		// Get sign of number

	// Adjust number so only the specified number of numbers after
	// the decimal point are shown.
	tmpNum *= Math.pow(10,decimalNum);
	tmpNum = Math.round(Math.abs(tmpNum))
	tmpNum /= Math.pow(10,decimalNum);
	tmpNum *= iSign;					// Readjust for sign


	// Create a string object to do our formatting on
	var tmpNumStr = new String(tmpNum);

	//-------------------------------- bypapu -->>
	if (bolPadZeroDec && (decimalNum > 0)) {
		var iStart = tmpNumStr.indexOf(".");
		var zeros = "";
		if (iStart < 0){
			for(i=0;i<decimalNum;i++){
				zeros += "0";
			}
			tmpNumStr += "." + zeros;
		}else{
			var qtsVezes = 0;
			var auxStr = tmpNumStr.substring(iStart+1,tmpNumStr.length);
			//alert(auxStr);
			if(decimalNum > auxStr.length){
				qtsVezes = decimalNum - auxStr.length;
				for(i=0;i<qtsVezes;i++){
					zeros += "0";
				}
				tmpNumStr += zeros;
			}
		}
	}
	//-------------------------------- bypapu --<<

	// See if we need to strip out the leading zero or not.
	if (!bolLeadingZero && num < 1 && num > -1 && num != 0)
		if (num > 0)
			tmpNumStr = tmpNumStr.substring(1,tmpNumStr.length);
		else
			tmpNumStr = "-" + tmpNumStr.substring(2,tmpNumStr.length);

	// See if we need to put in the commas
	if (bolCommas && (num >= 1000 || num <= -1000)) {
		var iStart = tmpNumStr.indexOf(".");
		if (iStart < 0)
			iStart = tmpNumStr.length;

		iStart -= 3;
		while (iStart >= 1) {
			tmpNumStr = tmpNumStr.substring(0,iStart) + "," + tmpNumStr.substring(iStart,tmpNumStr.length)
			iStart -= 3;
		}
	}

	// See if we need to use parenthesis
	if (bolParens && num < 0)
		tmpNumStr = "(" + tmpNumStr.substring(1,tmpNumStr.length) + ")";

	return tmpNumStr;		// Return our formatted string!
}

function FormatDate(fecha_in){
	if(fecha_in.length==10){
		fecha_out = fecha_in.substring(6,10) + "" + fecha_in.substring(3,5) + "" + fecha_in.substring(0,2);
	}else{
		fecha_out =  fecha_in.substring(6,8)+ "/" + fecha_in.substring(4,6) + "/" + fecha_in.substring(0,4);
	}
	return fecha_out;
}

//---------------------------------------------------------------
/*
Array.prototype.in_array = function(p_val) {
	for(var i = 0, l = this.length; i < l; i++) {
		if(this[i] == p_val) {
			return true;
		}
	}
	return false;
}
*/
//---------------------------------------------------------------
function IsNumeric(strString){
   var strValidChars = "0123456789.-";
   var strChar;
   var blnResult = true;
   if (strString.length == 0) return false;
   for (count_i = 0; count_i < strString.length; count_i++){
	   if(blnResult){
	      strChar = strString.charAt(count_i);
    	  if(strValidChars.indexOf(strChar) < 0){
			  blnResult = false;
			  break;
		  }
	   }
   }//for
   return blnResult;
}
//---------------------------------------------------------------
/**
*
*  UTF-8 data encode / decode
*  http://www.webtoolkit.info/
*
**/

var Utf8 = {

	// public method for url encoding
	encode : function (string) {
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

	// public method for url decoding
	decode : function (utftext) {
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
function getMyObj(nome){
	var objeto = "";
	var IE = (document.all) ? 1 : 0;
    var DOM = 0;
    if(parseInt(navigator.appVersion) >=5) DOM=1;
    if(DOM)objeto = document.getElementById(nome);
    else if(IE) objeto = document.all[nome];
	return objeto;
}

function MyRound(number,X) {
	// rounds number to X decimal places, defaults to 2
	X = (!X ? 2 : X);
	return Math.round(number*Math.pow(10,X))/Math.pow(10,X);
}

function formataMoney(objeto){
	var numeros = "0123456789";
	var texto = objeto.value;
	var novo = "";
	var position = 0;
	for(var i=texto.length-1;i>=0;i--){
		if(numeros.indexOf(texto[i])>=0){
			if(position==2){
				novo = "," + novo;
			}else if(position > 2){
				if( ((position-2) % 3) ==0 ){
					novo = "." + novo;
				}
			}
			novo = texto[i] + novo;
			position++;
		}
	}
	objeto.value = novo;
}
function formataMoney2(texto){
	var numeros = "0123456789";
	//var texto = objeto.value;
	var novo = "";
	var position = 0;
	for(var i=texto.length-1;i>=0;i--){
		if(numeros.indexOf(texto[i])>=0){
			if(position==2){
				novo = "," + novo;
			}else if(position > 2){
				if( ((position-2) % 3) ==0 ){
					novo = "." + novo;
				}
			}
			novo = texto[i] + novo;
			position++;
		}
	}
	return novo;
}
/**************************************************************************************************/
// This code was written by Tyler Akins and has been placed in the
// public domain.  It would be nice if you left this header intact.
// Base64 code from Tyler Akins -- http://rumkin.com

var keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";

function encode64(input) {
	var output = new StringMaker();
	var chr1, chr2, chr3;
	var enc1, enc2, enc3, enc4;
	var i = 0;

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

		output.append(keyStr.charAt(enc1) + keyStr.charAt(enc2) + keyStr.charAt(enc3) + keyStr.charAt(enc4));
   }

   return output.toString();
}

function decode64(input) {
	var output = new StringMaker();
	var chr1, chr2, chr3;
	var enc1, enc2, enc3, enc4;
	var i = 0;

	// remove all characters that are not A-Z, a-z, 0-9, +, /, or =
	input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

	while (i < input.length) {
		enc1 = keyStr.indexOf(input.charAt(i++));
		enc2 = keyStr.indexOf(input.charAt(i++));
		enc3 = keyStr.indexOf(input.charAt(i++));
		enc4 = keyStr.indexOf(input.charAt(i++));

		chr1 = (enc1 << 2) | (enc2 >> 4);
		chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
		chr3 = ((enc3 & 3) << 6) | enc4;

		output.append(String.fromCharCode(chr1));

		if (enc3 != 64) {
			output.append(String.fromCharCode(chr2));
		}
		if (enc4 != 64) {
			output.append(String.fromCharCode(chr3));
		}
	}

	return output.toString();
}
/**************************************************************************************************/

function replaceAll(find, replace, str) {
  while( str.indexOf(find) > -1){
    str = str.replace(find, replace);
  }
  return str;
}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}