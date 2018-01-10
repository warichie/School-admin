function getfresh(){
	document.location.href = "pustaka.php";
}
function hapus(id){
	if (confirm('Are you sure want to delete this library?'))
		document.location.href = "pustaka.php?op=del&id="+id;
}
function cetak(){
	newWindow('pustaka.cetak.php', 'CetakPerpustakaan','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function tambah(){
	newWindow('pustaka.add.php', 'TambahPerpustakaan','360','230','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function ubah(id){
	newWindow('pustaka.edit.php?id='+id, 'UbahPerpustakaan','360','230','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function validate(){
	var nama = document.getElementById('nama').value;
	if (rak.length==0){
		alert ('You should enter a value for name');
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
	var addr = "../lib/ViewByTitle.php?id="+id+"&state=1";
	newWindow(addr, 'LihatJudul','687','578','resizable=1,scrollbars=1,status=0,toolbar=0')
}