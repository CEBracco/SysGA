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
		$('.showTotal').text(round(parseFloat(total)));
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
		$('.showTotal').text(round(parseFloat(total)));
	});

	updateTable('gastosAdicionalesTable');
	updateTable('depositosTable');
});

function getValue(value){
	var integerVal=parseFloat(value);
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

function addGastoAdicional(){
	var nuevoGasto={
		id: ++indexGastosAdicionalesNuevos,
		concepto:$('#conceptoNuevoGasto').val(),
		monto:$('#montoNuevoGasto').val()
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
}

// TODO validar los campos de alta de gastoAdicional

function deleteGastoAdicional(gastoAdicional){
	if(gastoAdicional.isPersisted){
		ajaxCall(deleteGastoPath.replace('idGasto',gastoAdicional.id),{},function(){
			$('#gasto-'+gastoAdicional.id).remove();
			updateTable('gastosAdicionalesTable');
			updateTotalGestoria(gastoAdicional.monto,false);
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
	$('.showTotal').text(round(parseFloat(total)));
}

function deleteDeposito(deposito) {
	ajaxCall(deleteDepositoPath.replace('idDeposito',deposito.id),{},function(){
		$('#deposito-'+deposito.id).remove();
		updateTable('depositosTable');
		totalDepositado=totalDepositado - getValue(deposito.monto);
		$('#totalDepositadoEnRegistro').text(printMoney(totalDepositado));
	});
}
