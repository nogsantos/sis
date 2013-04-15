<!--
/**
 * Descrição: diferença entre datas em dias
 * @param: objeto date
 * @return: int dia
 * Uso: 
 *		var hoje = new Date();
 *  	var amanha = hoje.add(1);
 *		var diferenca = hoje.dateDiff(amanha);
 */
Date.prototype.dateDiff = function(d,tipo){
    switch(tipo){
        case "s":
            return Math.round((d.valueOf() - this.valueOf()) / 60000);
            break;
        default://dia
            return Math.round((d.valueOf() - this.valueOf()) / 86400000);

    }
}
/**
 * Descrição: adiciona data a um data
 * @param: objeto date
 * @return: date dataModificada
 * Uso: 
 *		var hoje = new Date();
 *  	var amanha = hoje.add(1);
 */
Date.prototype.add = function(n){
     var d = new Date(this);
     d.setDate(d.getDate() + n);
     return d;
}
/**
 * Descrição: adiciona mês a um data
 * @param: objeto date
 * @return: date dataModificada
 * Uso: 
 *		var hoje = new Date();
 *  	var mesQueVem = hoje.addMonth(1);
 */
Date.prototype.addMonth = function(n){
    var d = new Date(this);
    d.setMonth(d.getMonth() + n);
    return d;
}
/**
 * Descrição: adiciona ano a um data
 * @param: objeto date
 * @return: date dataModificada
 * Uso: 
 *		var hoje = new Date();
 *  	var anoQueVem = hoje.addYear(1);
 */
Date.prototype.addYear = function(n){
     var d = new Date(this);
     d.setFullYear(d.getFullYear() + n);
     return d;
}
/**
 * Descrição: verifica qual é o browser que está sendo utilizado
 */
var browserName;
var browserVersion;
var browserVersionDecimal = 0;
var browserPlatform;
var tempVersion;
if (navigator.appName.toLowerCase().indexOf("netscape") != -1) {
    browserName = "NS";
    browserVersion = parseInt(navigator.appVersion.charAt(0));
} else if (navigator.appName.toLowerCase().indexOf("microsoft") != -1) {
    browserName = "MSIE";
    tempVersion = parseInt(navigator.appVersion.charAt(0));
    if (tempVersion < 4) {
		browserVersion = tempVersion;
	} else {
      browserVersion = parseInt(navigator.appVersion.substr((navigator.appVersion.indexOf("MSIE ") + 5),1));
      browserVersionDecimal = parseInt(navigator.appVersion.substr((navigator.appVersion.indexOf("MSIE ") + 7),1));
    }

} else {
    browserName = "?";
    browserVersion = parseInt(navigator.appVersion.charAt(0));
}

if ((browserName == "NS") && (browserVersion < 4)) {
  browserPlatform = "WINDOWS"
} else {
  if (navigator.platform.toLowerCase().indexOf("win") != -1) {
      browserPlatform = "WINDOWS";
  } else if (navigator.platform.toLowerCase().indexOf("mac") != -1) {
      browserPlatform = "MAC";
  } else {
      browserPlatform = "?";
  }
}
/**
 * Descrição: limita um TextArea
 * @param: objeto campo, int tamanho
 * @return: boolean
 * Uso: onkeyup="limitaCampo(this,10)"
 */
function limitaCampo(campo,tamanho){
    var tamanhoAtual = campo.value.length;
    var texto = campo.value;
    if (tamanhoAtual >= tamanho) {
            campo.value = texto.substring(0,tamanho);
    }
    return true;
}
/**
 * Descrição: verifica se teclou Enter para chamar alguma operação no formulário
 * Data: 28/03/2008
 * @param: objeto evento
 * @return: boolean
 * Uso: onkeydown="isEnter(evento)"
 */
function isEnter(evento){	
    var keyCode;
    if (window.event){
        keyCode = window.event.keyCode;
    }else{
        keyCode = evento.which;
    }
    if(keyCode == 13){
        return true;
    } else {
        return false;
    }
}
/**
 * Descrição: Enter funciona como tab "vai para o próximo campo
 * @param: objeto campo, string form, objeto evento, boolean maximo
 * @return: boolean
 * Uso: onkeydown="setarFocus(this,'form',event)"
 */
function setarFocus(campo,form,evento){
	form = eval(document.getElementById(form));	
	var i;
	var keyCode;
	var typeElement;
	var proximo;
	var proximoCampo;
	
	if (window.event){
		keyCode = window.event.keyCode;
		typeElement = window.event.srcElement.type;
	} else {
		keyCode = evento.which;
		typeElement = evento.target.type;
	}
	
	if(typeElement == 'text' || typeElement == 'password'){ 		
		
		
		if(keyCode == 13){
			
			proximo = campo.tabIndex+1;				
			if (proximo < form.length) {
				try{
					for(i=0; i<form.length; i++){
						if (form.elements[i].tabIndex == proximo){
							proximo = i;						
							break;
						}					
					}	
					proximoCampo = eval(form.elements[proximo]);
				} catch (e){
					alert("Erro: " + e);
				}					 
			}
			
			if (proximoCampo.disabled == false){
				try{
					if (proximoCampo.type != 'select-one'){
						try{
							proximoCampo.select();
						} catch(e){
							alert(e);
						}		
					} else {
						proximoCampo.focus();
					}
				} catch(e){
					alert(e);
				}
			}
			
			if (window.event){				
				window.event.returnValue = false;				
			} else {
				evento.preventDefault();				
			}
		}
	}	
}
/**
 * Descrição: se atingiu o maxlength vai para o próximo campo
 * @param: objeto campo
 * @return: boolean
 * Uso: onkeyup="isMaxlength(this,'form',event)"
 */
function isMaxlength(campo,form,evento) {
	form = eval(document.getElementById(form));
	var tamanho = campo.value.length;
	var maxTamanho = campo.maxLength;
	var i;
	var keyCode;
	var typeElement;
	var proximo;
	var proximoCampo;
	
	if (window.event){
		keyCode = window.event.keyCode;
		typeElement = window.event.srcElement.type;
	} else {
		keyCode = evento.which;
		typeElement = evento.target.type;
	}
	
	if(typeElement == 'text' || typeElement == 'password'){ 		
		
		if (tamanho == maxTamanho) {
			
			proximo = campo.tabIndex+1;				
			if (proximo < form.length) {
				try{
					for(i=0; i<form.length; i++){
						if (form.elements[i].tabIndex == proximo){
							proximo = i;						
							break;
						}					
					}	
					proximoCampo = eval(form.elements[proximo]);
				} catch (e){
					alert("Erro: " + e);
				}					 
			}
	
			if (browserName != "MSIE" && keyCode == 0){
				keyCode = 8;
			}
			if(keyCode != 8){
				if (proximoCampo.disabled == false){
					if (proximoCampo.type != 'select-one'){
						try{
							proximoCampo.select();
						} catch(e){
							alert(e);
						}	
					} else {
						proximoCampo.focus();
					}
				}
			}
		}
	}
}
/**
 * Descrição: deixa somente números na string digitada
 * @param: objeto campo
 * @return: boolean
 * Uso: onkeyup="isNumero(this)"
 */
function isNumero(campo) {	
	var numeros = "";
	var keyCode;
	if(window.event){
		keyCode = window.event.keyCode;
		
		switch(keyCode) {
			case 8://backspace
				isTeclaUtil = true;
				break;
			case 46://delete
				isTeclaUtil = true;
				break;
			case 37://seta para esquerda
				isTeclaUtil = true;
				break;
			case 39://seta para direita
				isTeclaUtil = true;
				break;
			case 16://shift
				isTeclaUtil = true;
				break;
			case 36://home
				isTeclaUtil = true;
				break;
			case 35://end
				isTeclaUtil = true;
				break;		
			default:
				isTeclaUtil = false;
				break;
		}
		
		if ( ((keyCode >= 48) && (keyCode <= 57)) || ((keyCode >= 96) && (keyCode <= 105)) || isTeclaUtil ) {
			void(0);
		} else {
			for(var i  = 0; i <= campo.value.length ; i++){
		
				if(campo.value.charAt(i) >= "0" && campo.value.charAt(i) <= "9" ){
					numeros += campo.value.charAt(i);			
				}	
				
			}			
			campo.value = numeros;			
		}
	} else {
		for(var i  = 0; i <= campo.value.length ; i++){
	
			if(campo.value.charAt(i) >= "0" && campo.value.charAt(i) <= "9" ){
				numeros += campo.value.charAt(i);			
			}	
			
		}
		campo.value = numeros;	
	}
}
/**
 * Descrição: retira a "-" do telefone deixando somente os números para alteração
 * @param: objeto campo
 * @return: boolean
 * Uso: onfocus="onFocusFormataTelefone(this)"
 */
function onFocusFormataTelefone(campo){
	campo.value = campo.value.replace(/[-]/g,"");	
}
/**
 * Descrição: retira as "/" da data deixando somente os números para alteração
 * @param: objeto campo
 * @return: boolean
 * Uso: onfocus="onFocusFormataData(this)"
 */
function onFocusFormataData(campo){
	campo.value = campo.value.replace(/[/]/g,"");
	//campo.value = campo.value.replace("/","");
}
/**
 * Descrição: coloca um telefone no formato 30917694 em 3091-7694
 * @param: objeto campo
 * @return: boolean
 * Uso: onblur="onBlurFormataTelefone(this)"
 */
function onBlurFormataTelefone(campo){
	var tamanho = campo.value.length;
	
	if(tamanho > 0){
		if (tamanho != 7 && tamanho != 8){
			alert("Telefone inválido!\nO telefone tem que ter no mínimo 7 e no máximo 8 dígitos.");
			campo.focus();
		} else {		
			if(tamanho == 7)			
				campo.value = campo.value.substr(0,3) + '-' + campo.value.substr(3);
			else 
				campo.value = campo.value.substr(0,4) + '-' + campo.value.substr(4);
		}
	}
}
/**
 * Descrição: coloca uma data no formato 01012000 em 01/01/2000
 * @param: objeto campo
 * @return: boolean
 * Uso: onblur="onBlurFormataData(this)"
 */
function onBlurFormataData(campo){
	var tamanho = campo.value.length;
	
	if(tamanho > 0){
		if (tamanho < 8){			
			alert("Data inválida!\nExemplo de data: 01/01/2000\nDigite: 01012000");
			campo.focus();
			return false;
		} else {		
			campo.value = campo.value.substr( 0, 2 ) + '/' + campo.value.substr( 2, 2 ) + '/' + campo.value.substr( 4, 4 );
			return true;
		}
	}
	return false;
}
function FormataData(campo,e) {
	if(browserName == "MSIE"){
		keycode = e.keyCode;	
	} else {
		keycode = e.which;
	}
	
	vr = campo.value;
	vr = vr.replace( ".", "" );
	vr = vr.replace( "/", "" );
	vr = vr.replace( "/", "" );
	tam = vr.length + 1;

	if ( keycode != 9 && keycode != 8 ){
		if ( tam > 2 && tam < 5 )
			campo.value = vr.substr( 0, tam - 2  ) + '/' + vr.substr( tam - 2, tam );
		if ( tam >= 5 )
			campo.value = vr.substr( 0, 2 ) + '/' + vr.substr( 2, 2 ) + '/' + vr.substr( 4, 4 ); 
	}

}
/**
 * Descrição: formata valores
 * @param: objeto campo
 * Uso: onKeyUp="FormataValor('valrCusto',3,event)"
 */
function FormataValor(campo,tammax,teclapres) {
	var tecla = teclapres.keyCode;
	vr = document.form[campo].value;
	vr = vr.replace( "/", "" );
	vr = vr.replace( "/", "" );
	vr = vr.replace( ",", "" );
	vr = vr.replace( ".", "" );
	vr = vr.replace( ".", "" );
	vr = vr.replace( ".", "" );
	vr = vr.replace( ".", "" );
	tam = vr.length;

	if (tam < tammax && tecla != 8){tam = vr.length + 1 ;}

	if (tecla == 8 ){tam = tam - 1 ;}
		
	if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ){
		if ( tam <= 2 ){ 
	 		document.form[campo].value = vr ;}
	 	if ( (tam > 2) && (tam <= 5) ){
	 		document.form[campo].value = vr.substr( 0, tam - 2 ) + ',' + vr.substr( tam - 2, tam ) ;}
	 	if ( (tam >= 6) && (tam <= 8) ){
	 		document.form[campo].value = vr.substr( 0, tam - 5 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ) ;}
	 	if ( (tam >= 9) && (tam <= 11) ){
	 		document.form[campo].value = vr.substr( 0, tam - 8 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ) ;}
	 	if ( (tam >= 12) && (tam <= 14) ){
	 		document.form[campo].value = vr.substr( 0, tam - 11 ) + '.' + vr.substr( tam - 11, 3 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ) ;}
	 	if ( (tam >= 15) && (tam <= 17) ){
	 		document.form[campo].value = vr.substr( 0, tam - 14 ) + '.' + vr.substr( tam - 14, 3 ) + '.' + vr.substr( tam - 11, 3 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ) ;}
	}		
	
}
/**
 * Descrição: coloca um valor no formato 9,9999 (4 casas decimais)
 * @param: objeto campo
 * Uso: onKeyUp="FormataValor4('valrCusto',3,event)"
 */
function FormataValor4(campo,tammax,teclapres) {
	
	var tecla = teclapres.keyCode;
	vr = document.form[campo].value;
	vr = vr.replace( "/", "" );
	vr = vr.replace( "/", "" );
	vr = vr.replace( ",", "" );
	vr = vr.replace( ".", "" );
	vr = vr.replace( ".", "" );
	vr = vr.replace( ".", "" );
	vr = vr.replace( ".", "" );
	tam = vr.length;

	if (tam < tammax && tecla != 8){tam = vr.length + 1 ;}

	if (tecla == 8 ){tam = tam - 1 ;}
		
	if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ){
		if ( tam <= 4 ){ 
	 		document.form[campo].value = vr ;}
	 	if ( (tam > 4) && (tam <= 7) ){
	 		document.form[campo].value = vr.substr( 0, tam - 4 ) + ',' + vr.substr( tam - 4, tam ) ;}
	 	if ( (tam >= 8) && (tam <= 10) ){
	 		document.form[campo].value = vr.substr( 0, tam - 7 ) + '.' + vr.substr( tam - 7, 3 ) + ',' + vr.substr( tam - 4, tam ) ;}
	 	if ( (tam >= 11) && (tam <= 13) ){
	 		document.form[campo].value = vr.substr( 0, tam - 10 ) + '.' + vr.substr( tam - 10, 3 ) + '.' + vr.substr( tam - 7, 3 ) + ',' + vr.substr( tam - 4, tam ) ;}
	 	if ( (tam >= 14) && (tam <= 16) ){
	 		document.form[campo].value = vr.substr( 0, tam - 13 ) + '.' + vr.substr( tam - 13, 3 ) + '.' + vr.substr( tam - 10, 3 ) + '.' + vr.substr( tam - 7, 3 ) + ',' + vr.substr( tam - 4, tam ) ;}
	 	if ( (tam >= 17) && (tam <= 19) ){
	 		document.form[campo].value = vr.substr( 0, tam - 16 ) + '.' + vr.substr( tam - 16, 3 ) + '.' + vr.substr( tam - 13, 3 ) + '.' + vr.substr( tam - 10, 3 ) + '.' + vr.substr( tam - 7, 3 ) + ',' + vr.substr( tam - 4, tam ) ;}
	}		
	
}

/**
 * Descrição: retira os ":" da hora deixando somente os números para alteração
 * @param: objeto campo
 * @return: boolean
 * Uso: onfocus="onFocusFormataHora(this)"
 */
function onFocusFormataHora(campo){
	campo.value = campo.value.replace(":","");
}
/**
 * Descrição: coloca uma hora no formato 1200 em 12:00
 * @param: objeto campo
 * @return: boolean
 * Uso: onblur="onBlurFormataHora(this)"
 */
function onBlurFormataHora(campo){
	var tamanho = campo.value.length;
	
	if(tamanho > 0){
		if (tamanho < 4){
			if(tamanho < 3){
				alert("Hora inválida! Exemplo de hora: \n08:00 - Digite: 0800 ou 800 \n00:50 - Digite: 050 ou 0050");
				campo.focus();
			}else{
				campo.value = campo.value.substr( 0, 1 ) + ':' + campo.value.substr( 1, 2 );
			}
		} else {		
			campo.value = campo.value.substr( 0, 2 ) + ':' + campo.value.substr( 2, 2 );
		}
	}
}
/**
 * Descrição: função utilizada para validação de CPF E CNPJ
 * @param: objeto campo
 * @return: boolean 
 */
function modulo(str) {

   	soma=0;
   	ind=2;
   	for(pos=str.length-1;pos>-1;pos=pos-1) {
   		soma = soma + (parseInt(str.charAt(pos)) * ind);
   		ind++;
   		if(str.length>11) {
   			if(ind>9) ind=2;
   		}
	}
   	resto = soma - (Math.floor(soma / 11) * 11);
   	if(resto < 2) {
    	return 0
   	}
   	else {
   		return 11 - resto
   	}
}
/**
 * Descrição: valida um CPF
 * @param: string cpf (somente numeros)
 * @return: boolean
 * Uso: if(!isCpf(form.campoCpf.value)){}
 * Obs: precisa do função modulo para funcionar
 */
function isCpf(valor) {

	var primeiro=valor.substr(1,1);
	var falso=true;
	var size=valor.length;
	var proximo;
	if (size!=11){
		return false;
	}
	size--;
	for (i=2; i<size-1; ++i){
		proximo=(valor.substr(i,1));
		if (primeiro!=proximo) {
			falso=false;
		}
	}
	if (falso){
		return false;
	}
   	if(modulo(valor.substring(0,valor.length - 2)) + "" + modulo(valor.substring(0,valor.length - 1)) != valor.substring(valor.length - 2,valor.length)) {
   		return false;
   	}
   	return true;
}
/**
 * Descrição: valida um CNPJ
 * @param: string cpf (somente numeros)
 * @return: boolean
 * Uso: if(!isCnpj(form.campoCnpj.value)){}
 * Obs: precisa do função modulo para funcionar
 */
function isCnpj(valor) {

	var primeiro=valor.substr(1,1);
	var falso=true;
	var size=valor.length;
	var proximo;
	if (size!=14){
		return false;
	}
	size--;
	for (i=2; i<size-1; ++i){
		proximo=(valor.substr(i,1));
		if (primeiro!=proximo) {
			falso=false;
		}
	}
	
	if (falso){
		return false;
	}
	
   	if(modulo(valor.substring(0,valor.length - 2)) + "" + modulo(valor.substring(0,valor.length - 1)) !=valor.substring(valor.length - 2,valor.length)) {
   		return false;
   	}
   	return true;
}
/**
 * Descrição: verifica se numa string só tem números
 * @param: string numero
 * @return: boolean
 * Uso: if (!isNumeric(ano)){}
 * Obs: função usada na validação de data e hora
 */
function isNumeric(sNumeros){
	var ch;
	
	if (sNumeros == ""){
		return false;
	}
	for (var i = 0; i < sNumeros.length; i++){
		ch = sNumeros.charAt(i);		
		if (ch < '0' || '9' < ch){
			return false;
		}
	}
	return true;
}
/**
 * Descrição: valida uma data
 * @param: string data (01/01/2000)
 * @return: boolean
 * Uso: if(!isDate(form.campoData.value)){}
 * Obs: precisa do função isNumeric para funcionar
 */
function isDate(pData){

	if(pData.length<10 || pData.length>10){

		return false;
	}
	
	var dia = '' + pData.substring(0,2);	
	var mes = '' + pData.substring(3,5);
	var ano = '' + pData.substring(6,10);
	
	if (!isNumeric(dia) || !isNumeric(mes) || !isNumeric(ano)){
		return false;
	}
			
	if(dia>'31'){
		return false;
	}
				
	if(mes>'12'){
		return false;
	}

	if(ano<='1900'){
		return false;
	}

	if(mes=='02'){
		if(ano%4!=0 && dia>'28'){
			return false;
		}
		else{
			if(dia>'29'){
				return false;
			}
		}
	}
	
	if(mes<='07'){
		if(mes%2==0 && dia>'30'){
			return false;
		}
	}
	else{
		if(mes>'09'){
			if(mes%2!=0 && dia>'30'){
				return false;
			}
		}
	}
					
	return true;
}
/**
 * Descrição: valida uma hora
 * @param: string hora (09:00)
 * @return: boolean
 * Uso: if(!isHour(form.campoHora.value)){}
 * Obs: precisa do função isNumeric para funcionar
 */
function isHour(pHora){

	if (pHora == ""){
		return false;
	} else {
	
		if(pHora.length < 4 || pHora.length > 5){
			return false;
		}
		
		var aux = pHora.indexOf(":");
		var hora = "" + pHora.substring(0,aux);
		var minuto = "" + pHora.substring(aux+1,pHora.length);
		
		if (!isNumeric(hora) || !isNumeric(minuto)){
			return false;
		}
		
		if(hora > "23" || hora < "0"){
			return false;
		}
					
		if(minuto > "59" || minuto < "0"){
			return false;
		}
	}
	
	return true;
}
/**
 * Descrição: valida um email
 * @param: string email
 * @return: boolean
 * Uso: if(!isEmail(form.campoEmail.value)){}
 */
function isEmail(email){    
	var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
    if(filter.test(email)){
      return true;
	} else {
      return false;
    }
}
/**
 * Descrição: retira os espaços do inicio e final de uma string
 * @param: string valor
 * @return: string valor (sem espaços no começo e final)
 * Uso: trim("   string    ")
 */
function trim(valor){
	return valor.replace(/^\s*/, "").replace(/\s*$/, "");
}
/**
 * Descrição: monta as tabs de um formulário
 * @param: array vLabel(Rótulos das abas)
 * @return: string Código html
 * Uso: 
 * sem tabs internas e sem alterar a barra de funções: montaTabs(Array("nome1","nome2","nome3"));
 * com tabs internas e sem alterar a barra de funções: montaTabs(Array("nome1","nome2","nome3"),"nomeTabInternaSemSequencia");
 * com tabs internas e alterando a barra de funções:   montaTabs(Array("nome1","nome2","nome3"),"nomeTabInternaSemSequencia",Array(Array("codgFormulario","novoRegistroUsaNumg","iFrameInterno")));
 * sem tabs internas e alterando a barra de funções:   montaTabs(Array("nome1","nome2","nome3"),null,Array(Array("codgFormulario","novoRegistroUsaNumg","iFrameInterno")));
 */
function montaTabs(vRotulos,nTabs) {
	if (vRotulos.length > 0) {
		nRotulos = vRotulos.length
		sAux=""
		for (i=0;i<vRotulos.length;i++) {
			sAux += "<div id='imgtab" + (i+1) + "' style='display:none'>" + '\n'

			sAux += "<table border=0 width=100% height=20 cellspacing=0 cellpadding=0 align=left background='imagens/tab_" + (i+1) + "_" + nTabs + ".gif'>" + '\n'
			sAux += "<tr class=normal11b align=center>" + '\n'
			for (j=0;j<vRotulos.length;j++) {
				//TAB EM DESTAQUE
				if (i==j) {
					sAux += "<td width='" + parseInt(100/nRotulos) + "%'><a href='javascript:alteraTab(" + (j+1) + "," + nTabs + ")' class=link-tab><b>" + vRotulos[j] + "</b></a></td>" + '\n'
				} else {
					sAux += "<td width='" + parseInt(100/nRotulos) + "%'><a href='javascript:alteraTab(" + (j+1) + "," + nTabs + ")' class=link-tab>" + vRotulos[j] + "</a></td>" + '\n'
				}
			}
			sAux += "</tr>" + '\n'
			sAux += "</table>" + '\n'
			sAux += "</div>" + '\n' + '\n'
		}
		document.write(sAux)
	}
	
}
/**
 * Descrição: 
 * @param: int tabOn, int qtdTabs
 * @return: void 
 * Obs: precisa do prototype 1.5.1 para funcionar
 * Uso: 
 * sem alteraTab(1,3)
 * sem tabs internas e sem alterar a barra de funções: alteraTab(1,3);
 * com tabs internas e sem alterar a barra de funções: alteraTab(1,3,"nomeTabInternaSemSequencia");
 * com tabs internas e alterando a barra de funções:   alteraTab(1,3,"nomeTabInternaSemSequencia,Array("codgFormulario","novoRegistroUsaNumg","iFrameInterno"));
 * sem tabs internas e alterando a barra de funções:   alteraTab(1,3,null,Array("codgFormulario","novoRegistroUsaNumg","iFrameInterno"));
 */
function alteraTab(tab,ntabs){

	for (i=1;i<=ntabs;i++){		
		document.getElementById('tab' + i).style.display = "none"
		document.getElementById('imgtab' + i).style.display = "none"				
	}
	document.getElementById('tab' + tab).style.display = "block"
	document.getElementById('imgtab' + tab).style.display = "block"
			
	
}
/**
 * Descrição: 
 * @param: String idDivPrel, String css
 * @return: void
 * Uso: imprimirRelatorio("prelcolaboradores","estilosFormularios")
 * Obs: precisa do prototype 1.5.1 para funcionar
 */
function imprimirRelatorio(idDivPrel,css){	
	var oPrint, oJan;
	if($("divBotaoImprimirPrel"))
		$("divBotaoImprimirPrel").style.display = "none";
	oPrint = $(idDivPrel).innerHTML;
	if($("divBotaoImprimirPrel"))
		$("divBotaoImprimirPrel").style.display = "";
	oJan = window.open("impressao");	
	oJan.document.write('<link href="../../css/'+css+'.css" rel="stylesheet" type="text/css" media="all" />');
	oJan.document.write(oPrint);
	if(browserName == "MSIE"){
		oJan.history.go();	
	}
	oJan.window.print();
}
/**
 * Descrição: converte de horas para minuto
 * @param: String sHora
 * @return: int minutos
 * Uso: var minutos = horaToMin("08:00");
 * Obs: precisa do prototype 1.5.1 para funcionar
 */
function horaToMin(sHora){
	if(trim(sHora) != ""){
		var vHora = sHora.split(":");
		return (parseInt(vHora[0]) * 60) + parseInt(vHora[1]);
	}else{
		return 0;
	}
	
}
/**
 * Descrição: calcula a diferença entre duas datas
 * @param: String sHora
 * @return: int dia
 * Uso: if(datediff("01/01/2008","10/01/2008") > 0)
 * Obs: 
 *		precisa do prototype 1.5.1 para funcionar
 *		precisa passar a data assim: 01/01/2008 ou 01/01/2008 09:00
 */
 function dateDiff(data1, data2){
 	var tipo = "s";
 	
	 if(data1.length == 10){
		 data1 += " 00:00";
		 tipo = "d";
	 }
	 
	 if(data2.length == 10){
		 data2 += " 00:00";
		 tipo = "d";
	 }
	 
	 var validaData = data1.search(/(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[012])\/[12][0-9]{3}/);
	 var validaHora = data1.search(/(0[0-9]|1[0-9]|2[0-3])[:]([0-5][0-9])/);
	 var data1ok = false;
	 var data1Erro = "";
	 var data2ok = false;
	 var data2Erro = "";
	 
	 if(validaData == 0 && validaHora == 11){		
		 data1ok = true;
	 } else {
		 data1Erro = "- Data " + data1 + " errada.";
	 }
	 
	 validaData = data2.search(/(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[012])\/[12][0-9]{3}/);
	 validaHora = data2.search(/(0[0-9]|1[0-9]|2[0-3])[:]([0-5][0-9])/);
	 
	 if(validaData == 0 && validaHora == 11){
		 data2ok = true;
	 } else {
		 data2Erro = "- Data " + data2 + " errada.";
	 }
	 
	 if(data1ok && data2ok){	 
		 var vDataCompleta = data1.split(" ");
		 var vData = vDataCompleta[0].split("/");
		 var vHora = vDataCompleta[1].split(":");
		 
		 data1 = new Date(vData[2], vData[1] - 1, vData[0], vHora[0], vHora[1]);
		 
		 vDataCompleta = data2.split(" ");
		 vData = vDataCompleta[0].split("/");
		 vHora = vDataCompleta[1].split(":");
		 
		 data2 = new Date(vData[2], vData[1] - 1, vData[0], vHora[0], vHora[1]);
		 
		
		return data1.dateDiff(data2,tipo);
		
	 } else {
		 alert(data1Erro + "\n" + data2Erro);
		 return -1;
	 }
	 
 }
/**
 * Descrição: coloca o curso no campo informado
 * @param: String idCampo
 * @return: void
 * Uso: var t = setTimeout("focoPrimeiroCampo('descLogin')",1000);
 * Obs: 
 *		precisa do prototype 1.5.1 para funcionar
 *		precisa usar com setTimeout para funcionar no ie, porque a janela tem um delay para montar.
 */ 
function focoPrimeiroCampo(idCampo){
	$(idCampo).focus();
}
/**
 * Descrição: Monta a barra de funções.
 */
function montaFuncoes(codg_formulario,nome_formulario,flag_novoRegistro){
    window.open('../barra_funcoes.php?codg_formulario=' + codg_formulario + '&nome_formulario=' + nome_formulario + '&flag_novoRegistro=' + flag_novoRegistro,'barra_funcoes');
}
/**
 * Descrição: chama a página dos Correios para a busca do endereço através do cep
 * @param: void
 * @return: void
 * Uso: onClick="pesquisarCEP();return false"
 */ 
function pesquisarCEP(){
	var URL = "busca_CEP.htm";
	window.open(URL,'busca_CEP','scrollbars=no,screenX=150,screenY=150,width=338,height=333');
}
/**
 * Daqui pra baixo é para funcionar mascara para money
 */
documentall = document.all;  
/* 
* função para formatação de valores monetários retirada de 
* [url]http://jonasgalvez.com/br/blog/2003-08/egocentrismo[/url] 
*/  
function formatamoney(c) {  
	var t = this; 
	if(c == undefined) c = 2;        
	var p, d = (t=t.split("."))[1].substr(0, c);  
	for(p = (t=t[0]).length; (p-=3) >= 1;) {  
		t = t.substr(0,p) + "." + t.substr(p);  
	}  
	return t+","+d+Array(c+1-d.length).join(0);  
}  

String.prototype.formatCurrency=formatamoney  

function demaskvalue(valor, currency, casasDecimais){  
	/* 
	* Se currency é false, retorna o valor sem apenas com os números. Se é true, os dois últimos caracteres são considerados as  
	* casas decimais 
	*/  
	var val2 = '';  
	var strCheck = '0123456789';  
	var len = valor.length;  
	if (len== 0){  
		var valorRetorno = new Number(0);
		return valorRetorno.toFixed(casasDecimais);
	}  

	if (currency ==true){     
		/* Elimina os zeros à esquerda  
		* a variável  <i> passa a ser a localização do primeiro caractere após os zeros e  
		* val2 contém os caracteres (descontando os zeros à esquerda) 
		*/  
		
		for(var i = 0; i < len; i++)  
			if ((valor.charAt(i) != '0') && (valor.charAt(i) != ',')) break;  
		
		for(; i < len; i++){  
			if (strCheck.indexOf(valor.charAt(i))!=-1) val2+= valor.charAt(i);  
		}  
		
		if(val2.length <= casasDecimais){
			if(val2.length == 0){
				return "0." + escreveZeros(casasDecimais - val2.length);
			} else {
				return "0." + escreveZeros(casasDecimais - val2.length) + val2;
			}
		}
		
		var parte1 = val2.substring(0,val2.length-casasDecimais);  
		var parte2 = val2.substring(val2.length-casasDecimais);  
		
		var returnvalue = parte1 + "." + parte2;  
		return returnvalue;  
	
	}  
	else{  
		/* currency é false: retornamos os valores COM os zeros à esquerda,  
		* sem considerar os últimos 2 algarismos como casas decimais  
		*/  
		val3 ="";  
		for(var k=0; k < len; k++){  
			if (strCheck.indexOf(valor.charAt(k))!=-1) val3+= valor.charAt(k);  
		}           
		return val3;  
	}  
}  

/**
 * Obs.: só aceita 2 ou 4 nas casas decimais
 */
function reais(obj,event,casasDecimais){ 

	var whichCode = (window.event) ?  window.event.keyCode : event.which; 
	/* 
	Executa a formatação após o backspace nos navegadores !document.all 
	*/  
	if (whichCode == 8 && !documentall) {     
		try{
			/* 
			Previne a ação padrão nos navegadores 
			*/  
			if (event.preventDefault){ //standart browsers  
				event.preventDefault();  
			}else{ // internet explorer  
				event.returnValue = false;  
			}  
			var valor = obj.value;  
			var x = valor.substring(0,valor.length-1);  
			obj.value= demaskvalue(x,true,casasDecimais).formatCurrency(casasDecimais);  
			return false;  
		} catch(e){
			if (event.preventDefault){ //standart browsers  
				event.preventDefault();  
			}else{ // internet explorer  
				event.returnValue = false;  
			}
		}
	}  
	/* 
	Executa o Formata Reais e faz o format currency novamente após o backspace 
	*/  
	FormataReais(obj,'.',',',event,casasDecimais);  
} // end reais  

/**
 * obs.: só aceita 2 ou 4 nas casasDecimais
 */
function backspace(obj,event,casasDecimais){  
	/* 
	Essa função basicamente altera o backspace nos input com máscara reais para os navegadores IE e opera. 
	O IE não detecta o keycode 8 no evento keypress, por isso, tratamos no keydown. 
	Como o opera suporta o infame document.all, tratamos dele na mesma parte do código. 
	*/  
	var whichCode = (window.event) ?  window.event.keyCode : event.which;

	if (whichCode == 8 && documentall) {     
		try {
			var valor = obj.value;  
			var x = valor.substring(0,valor.length-1);  
			var y = demaskvalue(x,true,casasDecimais).formatCurrency(casasDecimais);  
			
			obj.value =""; //necessário para o opera  
			obj.value += y;  
			
			if (event.preventDefault){ //standart browsers  
				event.preventDefault();  
			}else{ // internet explorer  
				event.returnValue = false;  
			}  
			return false;  
		} catch(e){
			if (event.preventDefault){ //standart browsers  
				event.preventDefault();  
			}else{ // internet explorer  
				event.returnValue = false;  
			}
		}
		
	}// end if
}// end backspace  

function FormataReais(fld, milSep, decSep, e, casasDecimais) {  
	var sep = 0;  
	var key = '';  
	var i = j = 0;  
	var len = len2 = 0;  
	var strCheck = '0123456789';  
	var aux = aux2 = '';  
	var whichCode = (window.event) ?  window.event.keyCode : e.which; 
	
	//if (whichCode == 8 ) return true; //backspace - estamos tratando disso em outra função no keydown  
	if (whichCode == 0 ) return true;  
	if (whichCode == 9 ) return true; //tecla tab  
	if (whichCode == 13) return true; //tecla enter  
	if (whichCode == 16) return true; //shift internet explorer  
	if (whichCode == 17) return true; //control no internet explorer  
	if (whichCode == 27 ) return true; //tecla esc  
	if (whichCode == 34 ) return true; //tecla end  
	if (whichCode == 35 ) return true;//tecla end  
	if (whichCode == 36 ) return true; //tecla home  
	
	/* 
	O trecho abaixo previne a ação padrão nos navegadores. Não estamos inserindo o caractere normalmente, mas via script 
	*/  
	
	if (e.preventDefault){ //standart browsers  
		e.preventDefault()  
	}else{ // internet explorer  
		e.returnValue = false  
	}  
	
	var key = String.fromCharCode(whichCode);  // Valor para o código da Chave  
	if (strCheck.indexOf(key) == -1) return false;  // Chave inválida  
	
	/* 
	Concatenamos ao value o keycode de key, se esse for um número 
	*/  
	fld.value += key;  
	
	var len = fld.value.length;  
	var bodeaux = demaskvalue(fld.value,true,casasDecimais).formatCurrency(casasDecimais);  
	fld.value=bodeaux;  
	
	/* 
	Essa parte da função tão somente move o cursor para o final no opera. Atualmente não existe como movê-lo no konqueror. 
	*/  
	if (fld.createTextRange) {  
		var range = fld.createTextRange();  
		range.collapse(false);  
		range.select();  
	}
	else if (fld.setSelectionRange) {  
		fld.focus();  
		var length = fld.value.length;  
		fld.setSelectionRange(length, length);  
	}  
	return false; 
}  
function escreveZeros(qtos){
	var zeros = "";
	for(var i=0; i<qtos; i++){
		zeros += "0";
	}
	return zeros
}
/**
 * fim da mascara para money
 */
//-->
/**
 * Descrição: retorna só númereos
 */
function soNumeros(valor) {	
	var validos = "0123456789";
	var result = "";
	var aux;
	for (var i=0; i < valor.length; i++) {
		aux = validos.indexOf(valor.substring(i, i+1));
		if (aux>=0) {
			result += aux;
		}
	}
	return result;
}
/**
 * Descrição: mostra o valor no formato 
 */
function formataValorView(valor,decimais){
	var numeros = soNumeros(valor);
	var isSeparador = true;	
	var cont = 0;
	var resultado = "";
	if(numeros.length == 0){
		resultado = "0,";
		for(var i=0; i < decimais; i++){
			resultado += "0";
		}
	
	} else {
		for(var i=0; i < numeros.length; i++){
			cont++;
			resultado = numeros.substr((numeros.length-1) - i, 1) + resultado;
			if(isSeparador){
				if (cont == decimais){
					resultado = "," + resultado;
					isSeparador = false;
					cont = 0;
				}			
			} else {				
				if (cont == 3){
					resultado = "." + resultado;
					cont = 0;
				}
			}
		}	
	}
	return resultado;
}
/**
 * Descrição: verifica se o valor tem num array
 */
function in_array(needle,haystack) {
	return new RegExp('(^|\,)'+needle+'(\,|$)','gi').test(haystack);
}

function getPageSize()
{
    
    var xScroll, yScroll;
    
    if (window.innerHeight && window.scrollMaxY) {    
        xScroll = document.body.scrollWidth;
        yScroll = window.innerHeight + window.scrollMaxY;
    } else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
        xScroll = document.body.scrollWidth;
        yScroll = document.body.scrollHeight;
    } else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
        xScroll = document.body.offsetWidth;
        yScroll = document.body.offsetHeight;
    }
    
    var windowWidth, windowHeight;
    if (self.innerHeight) {    // all except Explorer
        windowWidth = self.innerWidth;
        windowHeight = self.innerHeight;
    } else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
        windowWidth = document.documentElement.clientWidth;
        windowHeight = document.documentElement.clientHeight;
    } else if (document.body) { // other Explorers
        windowWidth = document.body.clientWidth;
        windowHeight = document.body.clientHeight;
    }    
    
    // for small pages with total height less then height of the viewport
    if(yScroll < windowHeight){
        pageHeight = windowHeight;
    } else {
        pageHeight = yScroll;
    }

    // for small pages with total width less then width of the viewport
    if(xScroll < windowWidth){    
        pageWidth = windowWidth;
    } else {
        pageWidth = xScroll;
    }

	arrayPageSize = new Array(pageWidth,pageHeight,windowWidth,windowHeight);
    return arrayPageSize;
}
//Div Flutuante ---------------------------------------------------------------------------------------------------------------
function transDiv(url, params)
{
	var size = getPageSize();
	//Div Alpha
	var Div  = document.createElement('div');
		Div.setAttribute('align', 'center');
		Div.setAttribute('id', 'divAlpha');
		Div.className 		= 'transDiv';
		Div.style.width 	= size[0] + 'px';
		Div.style.height 	= size[1] + 'px';

	//Div Central
	var divCentral  = document.createElement('div');
		divCentral.className = 'divCentralLoading';
		divCentral.setAttribute('align', 'center');
		divCentral.setAttribute('id', 'divTransparente');

	//Loading
		createElementLoading(divCentral)

	//Oculta Tags que Ultrapassam a Div Flutuante
	hiddenTags();

		document.body.insertBefore(divCentral, document.body.firstChild);
		document.body.insertBefore(Div, document.body.firstChild);

		//Object prototype Framework Post Params
		new Ajax.Request
		(url, 
			{ 
				method:'post',
				onSuccess: function(resp){returnTransDiv(resp.responseText)},
				parameters: params
			 }
		 );
//		postText(url, params, returnTransDiv);
}
function changeSizeTransDiv()
{
	if(document.getElementById('divAlpha')!=null)
	{
		var size = getPageSize();
		document.getElementById('divAlpha').style.width 	= size[0] + 'px';
		document.getElementById('divAlpha').style.height 	= size[1] + 'px';
	}
}
function returnTransDiv(Html)
{
	document.getElementById('divTransparente').className = 'divCentral';
	document.getElementById('divTransparente').innerHTML = Html;
	FocusInpDiv();
}
function FocusInpDiv()
{
	Length = document.getElementById('divTransparente').getElementsByTagName('input').length;
	for(i=0; i<Length; i++)
	{
		var inp = document.getElementById('divTransparente').getElementsByTagName('input').item(i);
		var dad = document.getElementById('divTransparente').getElementsByTagName('input').item(i).parentNode;
		if(inp.type == 'text' && !inp.readOnly && dad.style.display == '')
		{
			document.getElementById('divTransparente').getElementsByTagName('input').item(i).focus();
			break;
		}
	}
}
function closeTransDiv()
{
	//Div Dados
	TransDiv 	= document.getElementById('divTransparente');
	
	//Div Alpha
	Alpha 		= document.getElementById('divAlpha');
	
	//Body
	Body = document.getElementById('divAlpha').parentNode;
	Body.removeChild(TransDiv);
	Body.removeChild(Alpha);
	
	//Retorna Visivel as Tags Ocultas
	visibleTags();
}
function backTransDiv(url, params)
{
	//Div em Load
	divInLoad();
	
	new Ajax.Request
	(url, 
		{ 
			method:'post',
			onSuccess: function(resp){returnTransDiv(resp.responseText)},
			parameters: params
		 }
	 );
//	postText(url, params, returnTransDiv);
}
function divInLoad()
{
	//Cria o Loading
	document.getElementById('divTransparente').innerHTML = '';
	createElementLoading(document.getElementById('divTransparente'));
	document.getElementById('divTransparente').className = 'divCentralLoading';
}
function createElementLoading(Dad)
{
	//Loading
	var Img = document.createElement('img');
		Img.setAttribute('align', 'middle');
		Img.setAttribute('src', 'imagens/loading.gif');
		Img.setAttribute('id', 'imgDivTransparente');

		Dad.appendChild(Img);
}
//End Div Flutuante ---------------------------------------------------------------------------------------------------------------
function hiddenTags()
{
	var li = document.getElementsByTagName('li').length;
	var Select = document.getElementsByTagName('select').length;
	for(i=0; i<li; i++)
	{
		document.getElementsByTagName('li').item(i).style.visibility = 'hidden';
	}
	for(i=0; i<Select; i++)
	{
		document.getElementsByTagName('Select').item(i).style.visibility = 'hidden';
	}
}
function visibleTags()
{
	var li = document.getElementsByTagName('li').length;
	var Select = document.getElementsByTagName('select').length;
	for(i=0; i<li; i++)
	{
		document.getElementsByTagName('li').item(i).style.visibility = '';
	}
	for(i=0; i<Select; i++)
	{
		document.getElementsByTagName('Select').item(i).style.visibility = '';
	}
}
function formataHora(element)
{
	if(element.value.length == 2)
	{
		element.value += ':';
	}
	else if(element.value.length == 5)
	{
		element.value += ':';
	}
}
function isNumeric(Event)
{
	var cod = Event.keyCode;
	//Numeros---------------------------
	if(cod>95 && cod<106)
	{
		return true;
	}
	else if(cod>47 && cod<58)
	{
		return true;
	}
	//----------------------------------
	//Backspace, DELETE, TAB, CAPS LOCK, ESC
	else if(cod==8 || cod==46 || cod==9 || cod==20 || cod==27)
	{
		return true;
	}
	//F1 ao F12
	else if(cod>111 && cod<124)
	{
		return true;
	}
	//ALT SHIFT CTRL
	else if(cod>15 && cod<19)
	{
		return true;
	}
	//PAGE UP, PAGE DOWN, END, HOME, LEFT, UP, RIGTH, DOWN
	else if(cod>32 && cod<41)
	{
		return true;
	}
	//NUM LOCK, .NUMERICO ,NUMERICO .NORMAL ,NORMAL
	else if(cod==144 || cod==194 || cod==110 || cod==190 || cod==188)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function SetaImagem(){
    value = document.getElementById('cboImagens').value;
    document.getElementById('txtNomeImagem').value = value;
    if(document.getElementById('imagemView') != null){
            img = document.getElementById('imagemView');
            img.src = 'thumbnail.php?width=200&height=200&arquivo=' + value;
            if(img.parentNode.tagName.toLowerCase() != 'a'){
                    a = document.createElement('a');
                    a.setAttribute('rel', 'lytebox');
                    a.setAttribute('href', 'imagens/upload/' + value);

                    img.parentNode.appendChild(a);
                    a.appendChild(img);
            }else{
                    img.parentNode.href = 'imagens/upload/' + value;
            }
            initLytebox();
    }
    removeTransDiv();
}
function SetaImagem(){
    value = document.getElementById('cboImagens').value;
    document.getElementById('txtNomeImagem').value = value;
    if(document.getElementById('imagemView') != null){
        img = document.getElementById('imagemView');
        img.src = 'thumbnail.php?width=200&height=200&arquivo=' + value;
        if(img.parentNode.tagName.toLowerCase() != 'a'){
            a = document.createElement('a');
            a.setAttribute('rel', 'lytebox');
            a.setAttribute('href', 'arquivos/' + value);
            img.parentNode.appendChild(a);
            a.appendChild(img);
        }else{
            img.parentNode.href = 'arquivos/' + value;
        }
        initLytebox();
    }
    removeTransDiv();
}
function AlteraImagem(img){
    oImage = document.getElementById('imagemThumb');
    if (img != ""){
        oImage.src = "arquivos/" + img;
    }else{
        oImage.src = "imagens/space.gif"
    }
}
function removeTransDiv(){
    document.body.removeChild(document.getElementById('divTransparente'));
    document.body.removeChild(document.getElementById('divAlpha'));
    visibilityTags();
}
function hiddenTags(){
    var li = document.getElementsByTagName('li').length;
    var Select = document.getElementsByTagName('select').length;
    for(i=0; i<li; i++){
        document.getElementsByTagName('li').item(i).style.visibility = 'hidden';
    }
    for(i=0; i<Select; i++){
        document.getElementsByTagName('Select').item(i).style.visibility = 'hidden';
    }
}
function visibilityTags(){
    var li = document.getElementsByTagName('li').length;
    var Select = document.getElementsByTagName('select').length;
    for(i=0; i<li; i++){
        document.getElementsByTagName('li').item(i).style.visibility = '';
    }
    for(i=0; i<Select; i++){
        document.getElementsByTagName('Select').item(i).style.visibility = '';
    }
}
/**
 *  http://kevin.vanzonneveld.net
 *  original by: Webtoolkit.info (http://www.webtoolkit.info/)
 *  improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
 *  improved by: sowberry
 *  tweaked by: Jack
 *  bugfixed by: Onno Marsman
 *  improved by: Yves Sucaet
 *  bugfixed by: Onno Marsman
 *  bugfixed by: Ulrich
 *  example 1: utf8_encode('Kevin van Zonneveld');
 *  returns 1: 'Kevin van Zonneveld'
 *  
 *  Descrição: função php.js
 */
function utf8_encode ( argString ) {
    var string = (argString+''); // .replace(/\r\n/g, "\n").replace(/\r/g, "\n");
    var utftext = "";
    var start, end;
    var stringl = 0;

    start = end = 0;
    stringl = string.length;
    for (var n = 0; n < stringl; n++) {
        var c1 = string.charCodeAt(n);
        var enc = null;

        if (c1 < 128) {
            end++;
        } else if (c1 > 127 && c1 < 2048) {
            enc = String.fromCharCode((c1 >> 6) | 192) + String.fromCharCode((c1 & 63) | 128);
        } else {
            enc = String.fromCharCode((c1 >> 12) | 224) + String.fromCharCode(((c1 >> 6) & 63) | 128) + String.fromCharCode((c1 & 63) | 128);
        }
        if (enc !== null) {
            if (end > start) {
                utftext += string.substring(start, end);
            }
            utftext += enc;
            start = end = n+1;
        }
    }

    if (end > start) {
        utftext += string.substring(start, string.length);
    }
    return utftext;
}