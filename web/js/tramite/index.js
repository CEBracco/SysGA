var selectedTramite;
var itemCollapsable='<li><div class="collapsible-header"><i class="material-icons">subject</i>{{ fecha }} - {{ estado }}</div><div class="collapsible-body"><span>{{ observacion }}</span></div></li>';

function modalPago(id, fechaLiquidacion, gastosArancel, impuestosPatente, sellados, honorarios){
    selectedTramite=id;
    var totalGestoria=sellados+honorarios;
    var totalEnRegistro=gastosArancel+impuestosPatente;

    $('.gastosArancel').text("$"+gastosArancel);
    $('.impuestosPatente').text("$"+impuestosPatente);
    $('.sellados').text("$"+sellados);
    $('.honorarios').text("$"+honorarios);
    $('.totalGestoria').text("$"+totalGestoria);
    $('.totalEnRegistro').text("$"+totalEnRegistro);
    $('.total').text("$"+(totalEnRegistro+totalGestoria));
    $('.honorarios').text("$"+honorarios);
    if(fechaLiquidacion != null){
        $('.fechaLiquidacion').text('Tramite Liquidado el día: '+fechaLiquidacion);
        $('.liquidateButton').addClass('disabled');
    }
    else{
        $('.fechaLiquidacion').text('');
        $('.liquidateButton').removeClass('disabled');
    }

    $('#payModal').modal('open');
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

function liquidateTramite(){
    ajaxCall('../movimiento/newFromTramite/'+selectedTramite,{},function(response){
        var splitedAction=$("#tramite-"+ selectedTramite +" .openModalPago").attr("onclick").split(',');
        var newAction=splitedAction[0]+",'"+formatDateOnly(new Date())+"'";
        for (var i = 2; i < splitedAction.length; i++) {
            newAction=newAction+","+splitedAction[i];
        }

        $("#tramite-"+ selectedTramite +" .openModalPago").attr("onclick",newAction);
        $('#payModal').modal('close');
        Materialize.toast(response.message, 4000);
    });
}

$(document).ready(function(){
    $("#addStatusModal").modal({dismissible: false});
});
