function getfresh(){
	document.location.href = "anggota.php";
}
function hapus(id){
	if (confirm('Are you sure want to delete this member?'))
		document.location.href = "anggota.php?op=del&id="+id;
}
function tambah(){
	newWindow('anggota.add.php', 'TambahAnggota','390','493','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function cetak(){
	newWindow('anggota.cetak.php', 'CetakAnggota','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function ubah(id){
	newWindow('anggota.edit.php?replid='+id, 'UbahAnggota','433','459','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function validate(){
	var nama = document.getElementById('nama').value;
	var alamat = document.getElementById('alamat').value;
	if (nama.length==0){
		alert ('You must enter a value for name');
		document.getElementById('nama').focus();
		return false;
	}
	if (alamat.length==0){
		alert ('You must enter a value for address');
		document.getElementById('alamat').focus();
		return false;
	}
}
function success(){
	parent.opener.getfresh();
	window.close();
}
function setaktif(id,newaktif){
	var msg;
	if (newaktif==1)
	{
		msg='Are you sure want to activate this member?';
	} else {
		msg='Are you sure want to inactivated this member?';
	}
	if (confirm(msg))
	{
		document.location.href = "anggota.php?op=nyd6j287sy388s3h8s8&replid="+id+"&newaktif="+newaktif;
	}
}