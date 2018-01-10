function getfresh(){
	document.location.href = "format.php";
}
function hapus(id){
	if (confirm('Are you sure want to delete this format?'))
		document.location.href = "format.php?op=del&id="+id;
}
function tambah(){
	newWindow('format.add.php', 'TambahFormat','360','230','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function cetak(){
	newWindow('format.cetak.php', 'CetakFormat','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function ubah(id){
	newWindow('format.edit.php?id='+id, 'UbahFormat','360','230','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function validate(){
	var kode = document.getElementById('kode').value;
	var nama = document.getElementById('nama').value;
	if (kode.length==0){
		alert ('You must enter a value for code');
		document.getElementById('kode').focus();
		return false;
	}
	if (nama.length==0){
		alert ('You must enter a value for name');
		document.getElementById('nama').focus();
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
	var addr = "../lib/ViewByTitle.php?id="+id+"&state=2";
	newWindow(addr, 'LihatJudul','687','578','resizable=1,scrollbars=1,status=0,toolbar=0')
}
