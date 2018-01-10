function getfresh(){
	document.location.href = "rak.php";
}
function hapus(id){
	if (confirm('Are you sure want to delete rak ini?'))
		document.location.href = "rak.php?op=del&id="+id;
}
function tambah(){
	newWindow('rak.add.php', 'TambahRak','360','230','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function cetak(){
	newWindow('rak.cetak.php', 'CetakRak','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function ubah(id){
	newWindow('rak.edit.php?id='+id, 'UbahRak','360','230','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function validate(){
	var rak = document.getElementById('rak').value;
	if (rak.length==0){
		alert ('You must enter a value for rak');
		document.getElementById('rak').focus();
		return false;
	}
}
function success(){
	parent.opener.getfresh();
	window.close();
}
function ViewByTitle(id){
	//State:
	//1.Library
	//2.Format
	//3.Shelf
	//4.Catalogue
	//5.Publisher
	//6.Author
	var addr = "../lib/ViewByTitle.php?id="+id+"&state=3";
	newWindow(addr, 'LihatJudul','687','578','resizable=1,scrollbars=1,status=0,toolbar=0')
}
