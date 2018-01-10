function OnLoad(){
	ShowWait('InfoGenList');
	var Bln = document.getElementById('Month').value;
	var Thn = document.getElementById('Year').value;
	sendRequestText('pengumuman.ajax.list.php',ShowInfoGenList,'op=GetInfoGenList&Bln='+Bln+'&Thn='+Thn);
}
function ShowInfoGenList(x){
	document.getElementById('InfoGenList').innerHTML = x;
	Tables('Table1', 1, 0);
}
//DetailInfoGenList
function SelectInfoGenList(replid){
	ShowWait('DetailInfoGenList');
	sendRequestText('pengumuman.ajax.list.php',ShowDetailInfoGenList,'op=GetDetailInfoGenList&replid='+replid);
}
function ShowDetailInfoGenList(x){
	document.getElementById('DetailInfoGenList').innerHTML = x;
	Tables('Table2', 1, 0);
}
function ChgCmb(){
	ShowWait('InfoGenList');
	var Bln = document.getElementById('Month').value;
	var Thn = document.getElementById('Year').value;
	sendRequestText('pengumuman.ajax.list.php',ShowInfoGenList,'op=GetInfoGenList&Bln='+Bln+'&Thn='+Thn);
	document.getElementById('DetailInfoGenList').innerHTML = '';
}
function DeleteInfoGenList(ID){
	if (confirm('Are you sure want to delete all SMS in this info?')){
		var Bln = document.getElementById('Month').value;
		var Thn = document.getElementById('Year').value;
		ShowWait('InfoGenList');
		sendRequestText('pengumuman.ajax.list.php',ShowInfoGenList,'op=DeleteInfoGenList&Bln='+Bln+'&Thn='+Thn+'&replid='+ID);
		document.getElementById('DetailInfoGenList').innerHTML = '';
	}
}

function EditDetailInfoGenList(ID, state){
	if (state=='1')
	{
	document.getElementById('Utility1'+ID).style.display='none';
	document.getElementById('Utility2'+ID).style.display='block';
	document.getElementById('SpanNumber'+ID).style.display='none';
	document.getElementById('Input'+ID).style.display='block';
	document.getElementById('SpanTxt'+ID).style.display='none';
	document.getElementById('TxtArea'+ID).style.display='block';
	} else {
	document.getElementById('Utility2'+ID).style.display='none';
	document.getElementById('Utility1'+ID).style.display='block';
	document.getElementById('SpanNumber'+ID).style.display='block';
	document.getElementById('Input'+ID).style.display='none';
	document.getElementById('SpanTxt'+ID).style.display='block';
	document.getElementById('TxtArea'+ID).style.display='none';
	}
}
function ResendDetailInfoGenList(ID){
	if (confirm('Are you sure want to resend this message?')){
		ShowWait('DetailInfoGenList');
		sendRequestText('pengumuman.ajax.list.php',ShowDetailInfoGenList,'op=ResendDetailInfoGenList&OutboxID='+ID);
	}
}
function ResendDetailInfoGenList2(ID){
	var DestNumb = document.getElementById('Input'+ID).value;
	var Txt = document.getElementById('TxtArea'+ID).value;
	if (confirm('Are you sure want to send this message now?')){
		ShowWait('DetailInfoGenList');
		sendRequestText('pengumuman.ajax.list.php',ShowDetailInfoGenList,'op=ResendDetailInfoGenList2&OutboxID='+ID+'&DestNumb='+DestNumb+'&Txt='+Txt);
	}
}
function DeleteDetailInfoGenList(ID){
	if (confirm('Are you sure want to delete this message?')){
		ShowWait('DetailInfoGenList');
		sendRequestText('pengumuman.ajax.list.php',ShowDetailInfoGenList,'op=DeleteDetailInfoGenList&OutboxID='+ID);
		//document.getElementById('DetailInfoGenList').innerHTML = '';
	}
}