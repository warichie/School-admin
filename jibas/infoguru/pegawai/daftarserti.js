function TambahS()
{
    var nip = document.getElementById('nip').value;
	var addr = "sertiadd.php?nip="+nip;
    newWindow(addr, 'TambahSertifikat','450','250','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function Change(id)
{
	var addr = "sertiedit.php?id="+id;
    newWindow(addr, 'UbahSertifikat','450','285','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function Refresh()
{
    var nip = document.getElementById('nip').value;
	document.location.href = "daftarserti.php?nip="+nip;
}


function Hapus(id)
{
	if (confirm("Are you sure want to delete this data?"))
	{
		var nip = document.getElementById('nip').value;
		document.location.href = "daftarserti.php?id="+id+"&op=mnrmd2re2dj2mx2x2x3d2s33&nip="+nip;
	}
}

function ChangeLast(id)
{
	if (confirm('Are you sure want to change this data to the latest certificate data?'))
    {
        var nip = document.getElementById('nip').value;
		document.location.href = "daftarserti.php?id="+id+"&op=cn0948cm2478923c98237n23&nip="+nip;
    }
}

function Cetak()
{
    var nip = document.getElementById('nip').value;
	newWindow('daftarserti_cetak.php?nip='+nip, 'CetakDaftarSertifikat','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
}
