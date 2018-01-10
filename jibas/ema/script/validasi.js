// JavaScript Document
function vdtrim(inputString) {
	var returnString = inputString;
	var removeChar = ' ';

	if (removeChar.length) {
	   while('' + returnString.charAt(0) == removeChar) {
		   returnString = returnString.substring(1, returnString.length);
   	   }
   	   while('' + returnString.charAt(returnString.length - 1) == removeChar) {
  	       returnString = returnString.substring(0, returnString.length - 1);
       }
	}
	return returnString;
}

function vdIsNumber(input) {
  return (!isNaN(parseInt(input))) ? true : false;
}

function validateEmptyText(elementId, elementName) {
	var val = document.getElementById(elementId).value;
	val = vdtrim(val);
		if (val.length == 0) {
			//alert ("woi");
		alert("You must enter a value for "+elementName);
		document.getElementById(elementId).focus();
		return false;
	}
	return true;
}

function validateMaxText(elementId, maxLen, elementName) {
	var val = document.getElementById(elementId).value;
	val = vdtrim(val);
	
	if (val.length > maxLen) {
		alert("Max character for " + elementName + " should not exceed " + maxLen + " characters");
		document.getElementById(elementId).focus();
		return false;
	}
	return true;
}

function validateNumber(elementId, elementName) {
	var val = document.getElementById(elementId).value;
	val = vdtrim(val);
	
	if (!vdIsNumber(val)) {
		alert(elementName + " should be numeric");
		document.getElementById(elementId).focus();
		return false;
	}
	return true;
}

function validateTgl(tgl,bln,th,tgl1,bln1,th1) {
	if (th > th1) {
		alert ('End Year should not less than Start Year');
		return false;
	} 
	
	if (th == th1 && bln > bln1 ) {
		alert ('End Month should not less than Start Month');
		return false; 
	}	
	
	if (th == th1 && bln == bln1 && tgl > tgl1 ) { 
		alert ('End Date should not less than Start Date');
		return false;
	}	
	return true;
}