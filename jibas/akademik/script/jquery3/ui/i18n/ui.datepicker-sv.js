/* Swedish initialisation for the jQuery UI date picker plugin. */
/* Written by Anders Ekdahl ( anders@nomadiz.se). */
jQuery(function($){
    $.datepicker.regional['sv'] = {
		clearText: 'Rensa', clearStatus: '',
		closeText: 'Stäng', closeStatus: '',
        prevText: '&laquo;Förra',  prevStatus: '',
		prevBigText: '&#x3c;&#x3c;', prevBigStatus: '',
		nextText: 'Nästa&raquo;', nextStatus: '',
		nextBigText: '&#x3e;&#x3e;', nextBigStatus: '',
		currentText: 'Idag', currentStatus: '',
        monthNames: ['January','February','Mars','April','Maj','June',
        'July','Augusti','September','October','November','December'],
        monthNamesShort: ['Jan','Feb','Mar','Apr','Maj','Jun',
        'Jul','Aug','Sep','Okt','Nov','Dec'],
		monthStatus: '', yearStatus: '',
		weekHeader: 'Ve', weekStatus: '',
		dayNamesShort: ['Sön','Mån','Tis','Ons','Tor','Fre','Lör'],
		dayNames: ['Söndag','Måndag','Tisdag','Onsdag','Torsdag','Fredag','Lördag'],
		dayNamesMin: ['Sö','Må','Ti','On','To','Fr','Lö'],
		dayStatus: 'DD', dateStatus: 'D, M d',
        dateFormat: 'yy-mm-dd', firstDay: 1,
		initStatus: '', isRTL: false};
    $.datepicker.setDefaults($.datepicker.regional['sv']);
});
