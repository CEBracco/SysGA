var selectedTramite;
var itemCollapsable='<li><div class="collapsible-header"><i class="material-icons">subject</i>{{ fecha }} - {{ estado }}</div><div class="collapsible-body"><span>{{ observacion }}</span></div></li>';

function modalPago(tramiteJson){
	var tramite=tramiteJson;
    selectedTramite=tramite.id;
    // var totalGestoria=tramite.selladosGestoria+tramite.honorarios+tramite.otros;
    // var totalEnRegistro=tramite.selladosRegistro+tramite.gastosArancel+tramite.impuestosPatente;

    $('.gastosArancel').text(printMoney(tramite.gastosArancel));
    $('.impuestosPatente').text(printMoney(tramite.impuestosPatente));
    $('.selladosGestoria').text(printMoney(tramite.selladosGestoria));
    $('.selladosRegistro').text(printMoney(tramite.selladosRegistro));
    $('.honorarios').text(printMoney(tramite.honorarios));
    $('.otros').text(printMoney(tramite.otros));

	$.each(tramite.gastosAdicionalesEnGestoria, function(index, gasto) {
		printResumenRow(gasto.concepto,gasto.monto);
	})


    $('.totalGestoria').text(printMoney(tramite.totalGestoria));
    $('.totalEnRegistro').text(printMoney(tramite.totalEnRegistro));
	$('.totalDepositadoEnRegistro').text(printMoney(tramite.totalDepositadoEnRegistro));
	$('.restoEnRegistro').text(printMoney(tramite.restoEnRegistro));
    $('.total').text(printMoney(tramite.total));
    if(tramite.fechaLiquidacion != null){
        $('.fechaLiquidacion').text('Tramite Liquidado el día: '+tramite.fechaLiquidacion);
    }
    else{
        $('.fechaLiquidacion').text('');
    }

	if(tramite.restoTransferidoAGestoria == null && tramite.restoEnRegistro > 0){
		$('#tranferRestoButton').prop('disabled', false);
	}
	else{
		$('#tranferRestoButton').prop('disabled', true);
	}

	if($('#tramite-'+selectedTramite).hasClass('transfered')){
		$('#tranferRestoButton').prop('disabled', true);
	}

    $('#payModal').modal({
		complete: function(){
			$('.gastoAdicional').remove();
		}
	});
	$('#payModal').modal('open');
}

function printResumenRow(concepto,monto) {
	var row="<tr class='gastoAdicional'><td>"+ concepto +"</td><td>"+ printMoney(monto) +"</td></tr>"
	$('#totalGestoriaModal').before(row);
}

function doAddStatus(){
    var valueInputEstadoVal=$('#inputEstado').val();
    var valueInputObservacion=$('#inputObservacion').val();
    $.ajax({
        url: selectedTramite + "/addEstado",
        method: "POST",
        data: { estado:valueInputEstadoVal, observacion:valueInputObservacion }
    }).done(function(response) {
        addStatusItem({estado:valueInputEstadoVal,observacion:valueInputObservacion,fecha:new Date()});
        $('#status-'+selectedTramite).html(valueInputEstadoVal);
        resetInputs();
    });
}

function resetInputs(){
    $('#inputEstado').val('Pendiente');
    $('#inputEstado').material_select();
    $('#inputObservacion').val('');
}

function loadEstados(idTramite){
    selectedTramite=idTramite;
    $.ajax({
        url: idTramite + "/estados",
        method: "POST",
        data: {}
    }).done(function( estadosCollection ) {
        renderEstados(JSON.parse(estadosCollection));
    });
}

function renderEstados(estadosCollection){
    $("#statusAccordion").empty();
    $.each(estadosCollection,function(index, status){
        addStatusItem(status);
    });
    $('#statusModal').modal('open');
}

function addStatusItem(status){
    var item=itemCollapsable;
    item=item.replace('{{ estado }}', status.estado);
    item=item.replace('{{ observacion }}', optionalString(status.observacion));
    item=item.replace('{{ fecha }}', formatDate(new Date(status.fecha)));
    $("#statusAccordion").append(item);
}

$(document).ready(function(){
    $("#addStatusModal").modal({dismissible: false});

	$('input.autocomplete').autocomplete({
		data: {},
		limit: 20, // The max amount of results that can be shown at once. Default: Infinity.
		onAutocomplete: function(val) {
			// Callback function when value is autcompleted.
		},
		minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
	});
});

ajaxAutoComplete({
	inputId:'input-titular',
	hiddenInputId:'hiddenInputTitular',
	ajaxUrl:queryTitulares,
	printObject: function(titular) {
		return titular.nombre+" "+titular.apellido+" ("+titular.dni+")";
	}
});

function resetInputs(){
	$('input[name="codigoInternoConcesionaria"').val('');
	$('input[name="codigoInternoConcesionaria"').focus();
	$('input[name="codigoInternoConcesionaria"').blur();

	$('input[name="fromDate"').val('');
	$('input[name="fromDate"').focus();
	$('input[name="fromDate"').blur();

	$('input[name="toDate"').val('');
	$('input[name="toDate"').focus();
	$('input[name="toDate"').blur();

	$('select[name="concesionaria"]').val('');
	$('select[name="concesionaria"]').material_select('destroy');
	$('select[name="concesionaria"]').material_select();

	$('input[name="titular"]').val('');
	$('#input-titular').val("".trim());
	$('#input-titular').focus();
	$('#input-titular').blur();

	$('select[name="estado"]').val('');
	$('select[name="estado"]').material_select('destroy');
	$('select[name="estado"]').material_select();
}

function doAddResto(){
	ajaxCall(selectedTramite + '/addResto',{},function(){
		$("#tramite-" + selectedTramite).addClass('transfered');
		$('#tranferRestoButton').prop('disabled', true);
		showToast("¡La operacion se completo exitosamente!");
	});
}
