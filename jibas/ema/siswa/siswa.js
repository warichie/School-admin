function show_wait(areaId) {
	var x = document.getElementById("waitBox").innerHTML;
	document.getElementById(areaId).innerHTML = x;
}
function getTabContent(){
	show_wait('pilihsiswa');
	sendRequestText('pilihsiswa.php',showTabPilih,'');
	show_wait('carisiswa');
	sendRequestText('carisiswa.php',showTabCari,'');
}
function showTabPilih(x){
	document.getElementById('pilihsiswa').innerHTML = x;
}
function showTabCari(x){
	document.getElementById('carisiswa').innerHTML = x;
}
function chg_dep(){
	//alert ('asup kehed');
	var dep = document.frmPilih.dep.value;
	show_wait('tktInfo');
	sendRequestText('gettkt.php',showtktInfo,'dep='+dep); 
}
function showtktInfo(x){
	document.getElementById('tktInfo').innerHTML = x;
	chg_tkt();
}
function chg_tkt(){
	var tkt = document.frmPilih.tkt.value;
	var ta = document.frmPilih.ta.value;
	//alert (ta+' '+tkt);
	show_wait('klsInfo');
	sendRequestText('getkls.php',showklsInfo,'tkt='+tkt+'&ta='+ta); 
}
function showklsInfo(x){
	document.getElementById('klsInfo').innerHTML = x;
	chg_kls();
}
function chg_kls(){
	var kls = document.frmPilih.kls.value;
	show_wait('sisInfo');
	sendRequestText('getsis.php',showsisInfo,'kls='+kls); 
}
function showsisInfo(x){
	document.getElementById('sisInfo').innerHTML = x;
}
function load_first_dep(){
	//alert ('Asup');
	//setTimeout(chg_dep(),3000);
}
function pilihsiswa(nis){
	//alert ('Masuk NISnya = '+nis);
	show_wait('content');
	setTimeout(
	function (){
		sendRequestText('getinfo.php',showInfo,'nis='+nis);
		getInfoTabContent(nis);
	},500
	);

}

function showInfo(x){
	document.getElementById('content').innerHTML = x;
    var TabbedPanels2 = new Spry.Widget.TabbedPanels("TabbedPanels2");
}
function CariSiswa(){
	var nis = document.frmCari.nis.value;
	var nisn = document.frmCari.nisn.value;
	var nama = document.frmCari.nama.value;
	var next = false;
	if (nis.length>=3 || nisn.length>=3 || nama.length>=3){
		next = true;
		
	}
	if (!next){
		alert ('Student ID, National Student ID, or Name is required and should not less than 3 characters.');
		document.frmCari.nis.focus();
		return false;
	}
	var addr2 = "";
	if (nis.length>=3)
		addr2 += 'nis='+nis;
	if (nama.length>=3)
		addr2 += (addr2!="")?'&nama='+nama:'nama='+nama;
	if (nisn.length>=3)
		addr2 += (addr2!="")?'&nisn='+nisn:'nisn='+nisn;
	
	show_wait('sisInfoCari');
	sendRequestText('getsiscari.php',showsisInfoCari,addr2);
	
}
function showsisInfoCari(x){
	document.getElementById('sisInfoCari').innerHTML = x;
}
