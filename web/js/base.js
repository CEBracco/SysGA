var spinnerOff=false;
var refreshSpinner=false;
var $loading = $('#loadingSpinner');
$(document)
	.ajaxStart(function () {
		if(!spinnerOff){
			if(refreshSpinner){
				$("#loadingSpinner").modal({dismissible: false});
			}
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
    $(".modal").not('#confirmationModal,#payModal').modal();
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

	$('.numberInput').keydown(numberValidation);
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

function getDate(dateString){
	var dateArray=dateString.split('/');
	return new Date(dateArray[2] + '-' + dateArray[1] + '-' + dateArray[0] + ' UTC-0300');
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
var confirmFunctionParams=null;

function confirmModal(param, functionParams = null){
	if(param != null && param != ''){
		confirmParam=param;
		confirmFunctionParams=functionParams;
	}
	else{
		confirmParam=emptyFunction;
	}

	$('#confirmationModal').modal();
	$('#confirmationModal').modal('open');
}

function doConfirm(){
	if(confirmParam != null){
		if (typeof confirmParam == 'string' || confirmParam instanceof String) {
			window.location.href = confirmParam;
		}
		else{
			if(confirmFunctionParams == null){
				confirmParam();
			}
			else{
				confirmParam(confirmFunctionParams);
				confirmFunctionParams=null;
			}
		}
	}
}
//


function numberValidation(event){
	var keys=[9,16,17,18,115,116,35,36,37,38,39,40,46,8,190,110,48,49,50,51,52,53,54,55,56,57,96,97,98,99,100,101,102,103,104,105];
	var charCode = (event.which) ? event.which : event.keyCode;
	if(jQuery.inArray(charCode,keys) != -1){
		return true;
	}
	else{
		return false;
	}
}

function printMoney(mount){
	var value=mount;
	if((value+'').includes(',')){
		if((value+'').includes('.')){
			value=(mount+'').replace(',','');
		}
		else{
			value=(mount+'').replace(',','.');
		}
	}
	return '$' + round(value);
}

function round(mount){
	return Math.round(mount * 100) / 100;
}

function showToast(text){
	Materialize.toast(text, 4000);
}

function updateTable(tableId){
	if($('#'+tableId+' tbody tr').length == 0){
		$('#'+tableId).hide();
	}
	else{
		$('#'+tableId).show();
	}
}

function getCanonicalDate(date){
	var meses = new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	return diasSemana[date.getDay()] + ", " + date.getDate() + " de " + meses[date.getMonth()] + " de " + date.getFullYear();
}
