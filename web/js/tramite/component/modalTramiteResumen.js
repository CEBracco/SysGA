refreshSpinner=true;

function modalPago(tramite){
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

	$('#payModal').modal('open');
}

function printResumenRow(concepto,monto) {
	var row="<tr class='gastoAdicional'><td>"+ concepto +"</td><td>"+ printMoney(monto) +"</td></tr>"
	$('#totalGestoriaModal').before(row);
}

function doAddResto(){
	ajaxCall(urlAddResto,{},function(){
		tramiteActual.restoTransferidoAGestoria=tramiteActual.restoEnRegistro;
		tramiteActual.restoEnRegistro=0;
		$('#tranferRestoButton').prop('disabled', true);
		showToast("¡La operacion se completo exitosamente!");
	});
}

$(document).ready(function(){
	$('#payModal').modal({
		complete: function(){
			$('.gastoAdicional').remove();
		}
	});
})
