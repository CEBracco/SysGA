var spinnerOff=false;
var $loading = $('#loadingSpinner');
$(document)
	.ajaxStart(function () {
		if(!spinnerOff){
			$loading.modal('open');
		}
	})
	.ajaxStop(function () {
		$loading.modal('close');
	})
	.ajaxError(function () {
		$loading.modal('close');
	});

$(document).ready(function() {
    $(".button-collapse").sideNav();
    $(".modal").modal();
    $("#loadingSpinner").modal({dismissible: false});
    $('.datepicker').pickadate({
        labelMonthNext: 'Mes Siguiente',
        labelMonthPrev: 'Mes Anterior',
        labelMonthSelect: 'Seleccione un mes',
        labelYearSelect: 'Seleccione un año',
        monthsFull: [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' ],
        monthsShort: [ 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic' ],
        weekdaysFull: [ 'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado' ],
        weekdaysShort: [ 'Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb' ],
        weekdaysLetter: [ 'D', 'L', 'M', 'M', 'J', 'V', 'S' ],
        today: 'Hoy',
        clear: 'Limpiar',
        close: 'Cerrar',
        selectMonths: true,
        selectYears: 15,
        format: 'dd/mm/yyyy',
        onStart: function (){
        	var date = new Date();
        	this.set('select', [date.getFullYear(), date.getMonth(), date.getDate()]);
        }
    });
	$('.datepickerEmpty').pickadate({
		labelMonthNext: 'Mes Siguiente',
		labelMonthPrev: 'Mes Anterior',
		labelMonthSelect: 'Seleccione un mes',
		labelYearSelect: 'Seleccione un año',
		monthsFull: [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' ],
		monthsShort: [ 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic' ],
		weekdaysFull: [ 'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado' ],
		weekdaysShort: [ 'Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb' ],
		weekdaysLetter: [ 'D', 'L', 'M', 'M', 'J', 'V', 'S' ],
		today: 'Hoy',
		clear: 'Limpiar',
		close: 'Cerrar',
		selectMonths: true,
		selectYears: 15,
		format: 'dd/mm/yyyy'
	});
    $('select').material_select();

	$('#confirmModalButton').click(doConfirm);

});

$(document).bind('keydown', 'ctrl+space', function(){
	$('.button-collapse').sideNav('show');
});

function optionalString(str){
    if(str == null || str == ''){
        return 'N/A';
    }
    return str;
}

function formatDate(date){
    return padTwo(date.getDate())+'/'+padTwo(date.getMonth()+1)+'/'+date.getFullYear()+' '+padTwo(date.getHours())+':'+padTwo(date.getMinutes());
}

function formatDateOnly(date){
    return padTwo(date.getDate())+'/'+padTwo(date.getMonth()+1)+'/'+date.getFullYear();
}

function padTwo(num) {
    return pad(num,2);
}

function pad(num, size) {
    var s = num+"";
    while (s.length < size) s = "0" + s;
    return s;
}

function emptyFunction(){}

function ajaxCall(url,data,success = emptyFunction, error = emptyFunction){
	$.ajax({
		url: url,
		method: "POST",
		data: data
	}).done(success).fail(error);
}

// modal de confirmacion
var confirmParam=null;

function confirmModal(param){
	if(param != null && param != ''){
		confirmParam=param;
	}
	else{
		confirmParam=emptyFunction;
	}
	$('#confirmationModal').modal('open');
}

function doConfirm(){
	if(confirmParam != null){
		if (typeof confirmParam == 'string' || confirmParam instanceof String) {
			window.location.href = confirmParam;
		}
		else{
			confirmParam();
		}
	}
}
