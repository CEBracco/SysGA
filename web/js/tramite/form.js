var totalEnRegistro=0;
var totalGestoria=0;
var total=0;

$(document).ready(function(){
	initValues();

	$('.totalEnRegistro').on('change keyup',function(){
		totalEnRegistro=0;
		$.each($('.totalEnRegistro'),function(index, totalIngresado){
			if(totalIngresado.value != ''){
				totalEnRegistro = totalEnRegistro + getValue(totalIngresado.value);
			}
		});
		total=totalEnRegistro + totalGestoria;
		$('.showTotalEnRegistro').text(totalEnRegistro);
		$('.showTotal').text(round(getFloat(total)));
	});

	$('.totalGestoria').on('change keyup',function(){
		totalGestoria=totalGastosAdicionalesGestoria;
		$.each($('.totalGestoria'),function(index, totalIngresado){
			if(totalIngresado.value != ''){
				totalGestoria = totalGestoria + getValue(totalIngresado.value);
			}
		});
		total=totalEnRegistro + totalGestoria;
		$('.showTotalGestoria').text(totalGestoria);
		$('.showTotal').text(round(getFloat(total)));
	});

	$('.newGastoAdicionalField').on('change keyup', function(){
		var isEmpty=false;
		$.each($('.newGastoAdicionalField'),function(index, input){
			if(input.value == null || input.value == ''){
				isEmpty=true;
			}
		});
		if(!isEmpty){
			$('#addGastoAdicionalButton').prop('disabled', false);
		}
		else{
			$('#addGastoAdicionalButton').prop('disabled', true);
		}
	});

	$('#addGastoModal').modal({
		ready: function(){
			if(totalEnRegistro > totalDepositado && !isDiferenciaApplied()){
				$('#cargarDiferenciaButton').prop('disabled', false);
			}
			else{
				$('#cargarDiferenciaButton').prop('disabled', true);
			}
		}
	});

	updateTable('gastosAdicionalesTable');
	updateTable('depositosTable');
});

function getValue(value){
	var integerVal=getFloat(value);
	if(isNaN(integerVal)){
		return 0;
	}
	return integerVal;
}

function initValues(){
	totalGestoria=totalGestoria + totalGastosAdicionalesGestoria;
	$.each($('.totalGestoria'),function(index, totalIngresado){
		totalGestoria = totalGestoria + getValue(totalIngresado.value);
	});

	$.each($('.totalEnRegistro'),function(index, totalIngresado){
		totalEnRegistro = totalEnRegistro + getValue(totalIngresado.value);
	});
}

//gastosAdicionales

var gastosAdicionalesNuevos=[];
var indexGastosAdicionalesNuevos=0;
var cargandoDiferencia=false;

function addGastoAdicional(){
	var nuevoGasto={
		id: ++indexGastosAdicionalesNuevos,
		concepto:$('#conceptoNuevoGasto').val(),
		monto:$('#montoNuevoGasto').val(),
		isDiferencia: isDiferencia
	}
	gastosAdicionalesNuevos.push(nuevoGasto);

	var row="<tr id='gasto-"+ nuevoGasto.id +"-new'>"
			+ "<td>"+ nuevoGasto.concepto +"</td><td>$"+ nuevoGasto.monto +"</td><td>"
			+ "<a onclick='confirmModal(deleteGastoAdicional,{id:"+nuevoGasto.id+", monto:"+ nuevoGasto.monto +", isPersisted:false})' class='btn waves-effect waves-light no-lateral-padding red'><i class='material-icons'>delete</i></a>"
			+ "</td></tr>";
	$('#gastosAdicionalesTable > tbody:last-child').append(row);

	$('#conceptoNuevoGasto').val('');
	$('#montoNuevoGasto').val('');
	Materialize.updateTextFields();
	updateJSONgastosAdicionales();
	updateTable('gastosAdicionalesTable');
	updateTotalGestoria(nuevoGasto.monto,true);
	resetModalAddGastoAdicional();
}

function deleteGastoAdicional(gastoAdicional){
	if(gastoAdicional.isPersisted){
		ajaxCall(deleteGastoPath.replace('idGasto',gastoAdicional.id),{},function(){
			$('#gasto-'+gastoAdicional.id).remove();
			updateTable('gastosAdicionalesTable');
			updateTotalGestoria(gastoAdicional.monto,false);

			//para modal resumen
			gastosPersistidos=_.remove(gastosPersistidos,function(gasto){
				gasto.id==gastoAdicional.id;
			})
		});
	}
	else{
		_.remove(gastosAdicionalesNuevos, function(g) {
			return g.id == gastoAdicional.id;
		});
		$('#gasto-'+gastoAdicional.id+'-new').remove();
		updateJSONgastosAdicionales();
		updateTable('gastosAdicionalesTable');
		updateTotalGestoria(gastoAdicional.monto,false);
	}
}

function updateJSONgastosAdicionales(){
	$('#appbundle_tramite_gastosAdicionalesNuevos').val(JSON.stringify(gastosAdicionalesNuevos));
}

function updateTotalGestoria(monto,sum){
	totalGestoria=0;
	$.each($('.totalGestoria'),function(index, totalIngresado){
		if(totalIngresado.value != ''){
			totalGestoria = totalGestoria + getValue(totalIngresado.value);
		}
	});

	if(sum){
		totalGastosAdicionalesGestoria=totalGastosAdicionalesGestoria + getValue(monto)
	}
	else{
		totalGastosAdicionalesGestoria=totalGastosAdicionalesGestoria - getValue(monto);
	}

	totalGestoria=totalGestoria + totalGastosAdicionalesGestoria;
	total=totalGestoria + totalEnRegistro;

	$('.showTotalGestoria').text(totalGestoria);
	$('.showTotal').text(round(getFloat(total)));
}

function resetModalAddGastoAdicional(){
	isDiferencia=false;
	$.each($('.newGastoAdicionalField'),function(index, input){
		input.value = '';
	});
	$('#addGastoAdicionalButton').prop('disabled', true);
}

function deleteDeposito(deposito) {
	ajaxCall(deleteDepositoPath.replace('idDeposito',deposito.id),{},function(){
		$('#deposito-'+deposito.id).remove();
		updateTable('depositosTable');
		totalDepositado=totalDepositado - getValue(deposito.monto);
		$('#totalDepositadoEnRegistro').text(printMoney(totalDepositado));
	});
}

function cargarDiferencia(){
	if(totalEnRegistro > totalDepositado){
		isDiferencia=true;
		var diferencia=totalEnRegistro - totalDepositado;
		$('#montoNuevoGasto').val(Math.round(diferencia * 100) / 100);
		$('#conceptoNuevoGasto').val("Diferencia de gastos y depósito en Registro");

		$('.newGastoAdicionalField').trigger("change");
		Materialize.updateTextFields();
	}
}

function isDiferenciaApplied(){
	return $('#gastosAdicionalesTable td').filter(function() {
    	return $(this).text().toLowerCase() == 'Diferencia de gastos y depósito en Registro'.toLowerCase();
	}).length == 1;
}


//modal resumen
var gastosPersistidos=tramiteActual.gastosAdicionalesEnGestoria;

function openModalResumen(){
	var baseId="#appbundle_tramite_";
	tramiteActual.otros=$(baseId+'otros').val();
	tramiteActual.gastosArancel=$(baseId+'gastoArancel').val();
	tramiteActual.honorarios=$(baseId+'honorarios').val();
	tramiteActual.impuestosPatente=$(baseId+'impuestosPatente').val();
	tramiteActual.selladosGestoria=$(baseId+'selladosGestoria').val();
	tramiteActual.selladosRegistro=$(baseId+'selladosRegistro').val();
	tramiteActual.gastosAdicionalesEnGestoria=_.union(gastosPersistidos,gastosAdicionalesNuevos);
	tramiteActual.restoEnRegistro=totalDepositado - (getFloat(tramiteActual.restoTransferidoAGestoria) + totalEnRegistro) + getTotalDiferenciaGastosAdicionales(tramiteActual.gastosAdicionalesEnGestoria);
	tramiteActual.totalDepositadoEnRegistro=totalDepositado;
	tramiteActual.total=totalEnRegistro + totalGestoria;
	tramiteActual.totalEnRegistro=totalEnRegistro;
	tramiteActual.totalGestoria=totalGestoria;
	modalPago(tramiteActual);
}

function getTotalDiferenciaGastosAdicionales(gastos){
	var totalDiferenciaGastosAdicionales=0;
	$.each(gastos,function(index, gasto){
		if(gasto.isDiferencia){
			totalDiferenciaGastosAdicionales=totalDiferenciaGastosAdicionales+getFloat(gasto.monto);
		};
	});
	return totalDiferenciaGastosAdicionales;
}
