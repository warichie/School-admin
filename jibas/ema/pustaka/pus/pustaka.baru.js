function validate(count){
	
	var judul = document.getElementById('judul').value;
	//alert ('Masuk judul='+judul);
	var harga = document.getElementById('hargaasli').value;
	//alert ('Masuk harga='+harga);
	var katalog = document.getElementById('katalog').value;
	//alert ('Masuk katalog='+katalog);
	var penerbit = document.getElementById('penerbit').value;
	//alert ('Masuk penerbit='+penerbit);
	var penulis = document.getElementById('penulis').value;
	//alert ('Masuk penulis='+penulis);
	var tahun = document.getElementById('tahun').value;
	//alert ('Masuk tahun='+tahun);
	var format = document.getElementById('format').value;
	var keyword = document.getElementById('keyword').value;
	var ketfisik = document.getElementById('keteranganfisik').value;
	//alert ('MAsuk jum perpus='+count);

	if (judul.length==0)
	{
		alert ('You must enter a value for Library Title');
		document.getElementById('judul').focus();
		return false;
	}
	if (harga.length==0)
	{
		alert ('You must enter a value for Library Price');
		document.getElementById('harga').focus();
		return false;
	}
	if (isNaN(harga))
	{
		alert ('Library Price must be numeric');
		document.getElementById('harga').value = "";
		document.getElementById('harga').focus();
		return false;
	}
	if (katalog.length==0)
	{
		alert ('You must specify Library Catalogue');
		document.getElementById('katalog').focus();
		return false;
	}
	if (penerbit.length==0)
	{
		alert ('You must specify Library Publisher');
		document.getElementById('penerbit').focus();
		return false;
	}
	if (penulis.length==0)
	{
		alert ('You must specify Library Author');
		document.getElementById('penulis').focus();
		return false;
	}
	if (tahun.length==0)
	{
		alert ('You must enter a value for Date Published');
		document.getElementById('tahun').focus();
		return false;
	}
	if (isNaN(tahun))
	{
		alert ('Date Published must be numeric');
		document.getElementById('tahun').value = "";
		document.getElementById('tahun').focus();
		return false;
	}
	
	if (format.length==0)
	{
		alert ('You must specify Library Format');
		document.getElementById('format').focus();
		return false;
	}
	if (keyword.length==0)
	{
		alert ('You must enter a value for Keyword');
		document.getElementById('keyword').focus();
		return false;
	}
	var acc=0;
	var i=0;
	while (i<count)
	{
		var y = document.getElementById('jumlah'+i).value;
		if (isNaN(y))
		{
			alert ('Allocation must be numeric');
			document.getElementById('jumlah'+i).focus();
			return false;
		}
		if (parseInt(y)>0){
			acc=1;
		} 
	i++;
	}
	return advance_val(acc);
}
function advance_val(x){
	if (x==0)
	{
		alert ('You should have at least one library in one of libraries');
		document.getElementById('jumlah0').focus();
		return false;
	}
	else
	{
		return true;
	}
}
function tempel(sourceid,destid){
	var x = document.getElementById(sourceid).value;
	document.getElementById(destid).value=x;
}
function ManagePenulis(){
	newWindow('../ref/penulis.add.php?flag=1', 'TambahPenulis','355','448','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function ManagePenerbit(){
	newWindow('../ref/penerbit.add.php?flag=1', 'TambahPenerbit','355','448','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function getfresh(id,lastid){
	if (id=='penulis'){
		show_wait("PenulisInfo");
		sendRequestText("GetPenulis.php", showPenulis, "penulis="+lastid);
	} else {
		show_wait("PenerbitInfo");
		sendRequestText("GetPenerbit.php", showPenerbit, "penerbit="+lastid);
	}
}
function show_wait(areaId) {
	var x = document.getElementById("waitBox").innerHTML;
	document.getElementById(areaId).innerHTML = x;
}
function showPenulis(x) {
	document.getElementById("PenulisInfo").innerHTML = x;
}
function showPenerbit(x) {
	document.getElementById("PenerbitInfo").innerHTML = x;
}
