function getfresh(){
	document.location.href = "pengguna.php";
}
function hapus(login){
	if (confirm('Are you sure want to delete this user from SIMTAKA?'))
		document.location.href = "pengguna.php?op=del&login="+login;
}
function tambah(){
	newWindow('pengguna.add.php', 'TambahPengguna','390','493','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function cetak(){
	newWindow('pengguna.cetak.php', 'CetakPengguna','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function cari(){
	newWindow('../lib/pegawai.php', 'CariPegawai','563','428','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function acceptPegawai(nip,nama,flag){
	document.location.href = "../atr/pengguna.add.php?nip="+nip+"&nama="+nama;
}
function ubah(login){
	newWindow('pengguna.edit.php?nip='+login, 'UbahAnggota','433','459','resizable=1,scrollbars=1,status=0,toolbar=0')
}
function validate(){
	var nip = document.getElementById('nip').value;
	var password1 = document.getElementById('password1').value;
	var password2 = document.getElementById('password2').value;
	if (nip.length==0){
		alert ('You should enter a value for Employee ID and Name!\nClick on the field to open the employee list');
		return false;
	}
	if (password1.length==0){
		alert ('You must enter a value for password');
		document.getElementById('password1').focus();
		return false;
	}
	if (password2.length==0){
		alert ('You must enter a value for password confirmation');
		document.getElementById('password2').focus();
		return false;
	}
	if (password1!=password2){
		alert ('Password and confirmation should match');
		document.getElementById('password2').value="";
		document.getElementById('password2').focus();
		return false;
	}
}
function success(){
	parent.opener.getfresh();
	window.close();
}
function setaktif(login,newaktif){
	var msg;
	if (newaktif==1)
	{
		msg='Are you sure want to activate this user in SIMTAKA?';
	} else {
		msg='Are you sure want to inactivated this user from SIMTAKA?';
	}
	if (confirm(msg))
	{
		document.location.href = "pengguna.php?op=nyd6j287sy388s3h8s8&login="+login+"&newaktif="+newaktif;
	}
}
function ChgTkt(id){
	var nip = document.getElementById('nip').value;
	var nama = document.getElementById('nama').value;
	var tingkat = document.getElementById('tingkat').value;
	if (id==1)
	{
		document.location.href = "pengguna.edit.php?nip="+nip+"&nama="+nama+"&tingkat="+tingkat;
	} else {
		document.location.href = "pengguna.add.php?nip="+nip+"&nama="+nama+"&tingkat="+tingkat;
	}
	
}