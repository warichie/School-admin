/* Indonesian initialisation for the jQuery UI date picker plugin. */
/* Written by Deden Fathurahman (dedenf@gmail.com). */
jQuery(function($){
	$.datepicker.regional['id'] = {
		clearText: 'kosongkan', clearStatus: 'bersihkan tanggal yang sekarang',
		closeText: 'Tutup', closeStatus: 'Tutup tanpa mengubah',
		prevText: '&#x3c;mundur', prevStatus: 'Tampilkan bulan sebelumnya',
		prevBigText: '&#x3c;&#x3c;', prevBigStatus: '',
		nextText: 'maju&#x3e;', nextStatus: 'Tampilkan bulan berikutnya',
		nextBigText: '&#x3e;&#x3e;', nextBigStatus: '',
		currentText: 'hari ini', currentStatus: 'Tampilkan bulan sekarang',
		monthNames: ['January','February','March','April','May','June',
		'July','August','September','October','November','December'],
		monthNamesShort: ['Jan','Feb','Mar','Apr','May','Jun',
		'Jul','Agus','Sep','Okt','Nop','Des'],
		monthStatus: 'Tampilkan bulan yang berbeda', yearStatus: 'Tampilkan tahun yang berbeda',
		weekHeader: 'Mg', weekStatus: 'Sunday dalam tahun',
		dayNames: ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
		dayNamesShort: ['Min','Sen','Sel','Rab','kam','Jum','Sab'],
		dayNamesMin: ['Mg','Sn','Sl','Rb','Km','jm','Sb'],
		dayStatus: 'gunakan DD sebagai awal hari dalam minggu', dateStatus: 'pilih le DD, MM d',
		dateFormat: 'dd/mm/yy', firstDay: 0,
		initStatus: 'Select Date', isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['id']);
});