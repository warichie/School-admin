jQuery(document).ready(function() {
	    var accd = $('#kodepustaka').val();
		$('#kodepustaka').autocomplete("GetCode.php?search="+accd, {
			width: 400,
			selectFirst: false			
		});
});
function ProsesKode(){
	var kodepustaka = document.getElementById('kodepustaka').value;
	document.location.href = "kembali.php?op=ViewPeminjaman&kodepustaka="+kodepustaka;
}
function BatalkanPengembalian(){
	var kodepustaka = document.getElementById('kodepustaka').value;
	document.location.href = "kembali.php?kodepustaka="+kodepustaka;
}
function Kembalikan(){
	var kodepustaka = document.getElementById('kodepustaka').value;
	var idpinjam = document.getElementById('idpinjam').value;
	var denda = document.getElementById('denda').value;
	var telat = document.getElementById('telat').value;
	var keterangan = document.getElementById('keterangan').value;
	var msg;
	if (isNaN(denda))
	{	
		alert ('Fine must be numeric');
		document.getElementById('dendanya').focus();
		return false;
	}
	if (denda!=0)
	{
		msg = "The data is correct?\nFine is "+numberToRupiah(denda);
	} else {
		msg = "The data is correct?";
	}
	if (confirm(msg))
	{
		document.location.href = "kembali.php?op=KembalikanPustaka&idpinjam="+idpinjam+"&denda="+denda+"&kodepustaka="+kodepustaka+"&telat="+telat+"&keterangan="+keterangan;
	}
}
function KeyPress(elemName, evt) {
    var KodeValue=document.getElementById('kodepustaka').value;
	evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode :
        ((evt.which) ? evt.which : evt.keyCode);
    if (charCode == 13) {
		if (KodeValue=="No Library Code is being borrowed")
		{
			document.getElementById('kodepustaka').value="";
		} else {
			ProsesKode();
		}
        return false;
    }
    return true;
}
