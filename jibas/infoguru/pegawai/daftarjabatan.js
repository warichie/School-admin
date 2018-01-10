function TambahJ()
{
    var nip = document.getElementById('nip').value;
	var addr = "jabaddjadwal.php?nip="+nip;
    newWindow(addr, 'TambahJadwalJabatan','480','250','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function UbahJ(id)
{
	var addr = "jabeditjadwal.php?id="+id;
    newWindow(addr, 'UbahJadwalJabatan','480','250','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function HapusJ(id)
{
	if (confirm('Are you sure want to delete this employee\'s promotion schedule data?'))
    {
        var nip = document.getElementById('nip').value;
		document.location.href = "daftarjabatan.php?id="+id+"&op=239846b7234b6c46786239847x32&nip="+nip;
    }
}

function Add()
{
    var nip = document.getElementById('nip').value;
	var addr = "jabadd.php?nip="+nip;
    newWindow(addr, 'TambahJabatan','580','250','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function Change(id)
{
	var addr = "jabedit.php?id="+id;
    newWindow(addr, 'UbahJabatan','580','300','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function Refresh()
{
    var nip = document.getElementById('nip').value;
	document.location.href = "daftarjabatan.php?nip="+nip;
}

function Hapus(id)
{
	if (confirm("Are you sure want to delete this data?"))
	{
		var nip = document.getElementById('nip').value;
		document.location.href = "daftarjabatan.php?id="+id+"&op=mnrmd2re2dj2mx2x2x3d2s33&nip="+nip;
	}
}

function ChangeLast(id)
{
	if (confirm("Are you sure want to change this to current active position?"))
    {
        var nip = document.getElementById('nip').value;
		document.location.href = "daftarjabatan.php?id="+id+"&op=cn0948cm2478923c98237n23&nip="+nip;
    }
}

function Cetak()
{
    var nip = document.getElementById('nip').value;
	newWindow('daftarjabatan_cetak.php?nip='+nip, 'CetakDaftarJabatan','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
}