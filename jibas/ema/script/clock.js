// JavaScript Document
var timerID = null;
var timerRunning = false;
var timerElementId = null;

var months=new Array(13);
months[1]="January";
months[2]="February";
months[3]="March";
months[4]="April";
months[5]="May";
months[6]="June";
months[7]="July";
months[8]="August";
months[9]="September";
months[10]="October";
months[11]="November";
months[12]="December";

var days = new Array(7);
days[0]="Sunday";
days[1]="Monday";
days[2]="Tuesday";
days[3]="Wednesday";
days[4]="Thursday";
days[5]="Friday";
days[6]="Saturday";



function stopclock (){
	if(timerRunning)
		clearTimeout(timerID);
	timerRunning = false;
}

function getCurrentDate() {
	var time = new Date();
	var lmonth = months[time.getMonth() + 1];
	var date = time.getDate();
	var year = time.getYear();
	var lday = days[time.getDay()];
	//var lday = time.getDay();
	if (year < 2000)    // Y2K Fix, Isaac Powell
		year = year + 1900; // http://onyx.idbsu.edu/~ipowell

	return lday + ", " + date + " " + lmonth + " " + year;
}

function showtime() {
	var now = new Date();
	var hours = now.getHours();
	var minutes = now.getMinutes();
	var seconds = now.getSeconds()
	var timeValue = ((hours < 10) ? "0" : "") + hours
	timeValue += ((minutes < 10) ? ":0" : ":") + minutes
	timeValue += ((seconds < 10) ? ":0" : ":") + seconds
	//timeValue = getCurrentDate() + "   " + timeValue;
	document.getElementById(timerElementId).innerHTML = timeValue;
	timerID = setTimeout("showtime()", 1000);
	timerRunning = true;
}

function startclock(elementId) {
	timerElementId = elementId;
	stopclock();
	showtime();
}
