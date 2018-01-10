// JavaScript Document
function vdtrim(inputString) {
	var returnString = '' + inputString + '';
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
		alert("You must enter a value for " + elementName);
		document.getElementById(elementId).focus();
		return false;
	}
	return true;
}

function validateEmptyTextMCE(elementId, elementName) {
	var val = tinyMCE.get(elementId).getContent()
	val = vdtrim(val);
	
	if (val.length == 0) {
		alert("You must enter a text for " + elementName);
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

function vdIsInteger(input) {
	var digit = ['-','0','1','2','3','4','5','6','7','8','9'];
	
	var i = 0;
	var isInt = true;	
	while ((i < input.length) && isInt) {
		var ch = input.charAt(i);
		
		var j = 0;
		var found = false;
		while ((j < digit.length) && !found) {
			found = (digit[j] == ch);
			j++;
		}
		
		isInt = found;
		i++;
	}
	
	return isInt;
}


function vdIsFloat(input) {
	var digit = ['-','.','0','1','2','3','4','5','6','7','8','9'];
	
	var i = 0;
	var isInt = true;	
	while ((i < input.length) && isInt) {
		var ch = input.charAt(i);
		
		var j = 0;
		var found = false;
		while ((j < digit.length) && !found) {
			found = (digit[j] == ch);
			j++;
		}
		
		isInt = found;
		i++;
	}
	
	return isInt;
}


function validateInteger(elementId, elementName) {
	var val = document.getElementById(elementId).value;
	val = vdtrim(val);
	
	if (!vdIsInteger(val)) {
		alert(elementName + " should be an integer");
		document.getElementById(elementId).focus();
		return false;
	}
	return true;
}

function validateDecimal(elementId, elementName) {
	var val = document.getElementById(elementId).value;
	val = vdtrim(val);
	
	if (!vdIsFloat(val)) {
		alert(elementName + " should be numeric");
		document.getElementById(elementId).focus();
		return false;
	}
	return true;
}


function validateChoice(elementId, elementName, choiceArr) {
	var input = document.getElementById(elementId).value;
	var inputlow = input.toLowerCase();
	
	var i = 0;
	var found = false;
	while ((i < choiceArr.length) && !found) {
		var choice = choiceArr[i];
		choice = choice.toLowerCase();
		
		found = (choice == inputlow);
		i++;
	}
	
	if (!found) {
		var choicestr = "";
		for (i = 0; i < choiceArr.length; i++) {
			if (choicestr.length > 0) choicestr = choicestr + ", ";
			choicestr = choicestr + "" + choiceArr[i];
		}
		alert("The value for " + elementName + " should have at least ( " + choicestr + " )");
		document.getElementById(elementId).focus();
		return false;
	} else {
		return true;
	}
}

function validateRange(elementId, elementName, minRange, maxRange) {
	var input = document.getElementById(elementId).value;
	
	if (vdIsInteger(input)) {
		input = parseInt(input);
		minRange = parseInt(minRange);
		maxRange = parseInt(maxRange);
	} else if (vdIsFloat(input)) {
		input = parseFloat(input);
		minRange = parseFloat(minRange);
		maxRange = parseFloat(maxRange);
	} else {
		return false;
	}
			
	if ((input >= minRange) && (input <= maxRange)) {
		return true;
	} else {
		alert('The value range for ' + elementName + ' must be between ' + minRange + ' to ' + maxRange);
		document.getElementById(elementId).focus();		
		return false;
	}
}

function validateLength(elementId, elementName, len) {
	var input = document.getElementById(elementId).value;
	
	if (input.length != len) {
		alert('Maximum for ' + elementName + ' should be ' + len + ' digit');
		document.getElementById(elementId).focus();		
		return false;
	} else {
		return true;
	}
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

function validateEmptyTextMCE(elementId, elementName) {
	var val = tinyMCE.get(elementId).getContent()
	val = vdtrim(val);
	
	if (val.length == 0) {
		alert("You must enter a text for " + elementName);
		document.getElementById(elementId).focus();
		return false;
	}
	return true;
}