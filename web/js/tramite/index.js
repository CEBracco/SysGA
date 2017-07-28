var selectedTramite;
var selectedStatus;
var selectedItem=null;

function openStatusModal(index){
    selectedTramite=index;
    $('#statusModal').modal('open');
    if(selectedItem != null){
        selectedItem.removeClass('active');
    }
}

function doUpdateStatus(){
    $.ajax({
        url: selectedTramite + "/change_status",
        method: "POST",
        data: { status : selectedStatus }
    }).done(function( html ) {
        $('#status-'+selectedTramite).html(selectedStatus);
        selectedStatus=null;
    });
}

function modalPago(gastosArancel, impuestosPatente, sellados, honorarios){
    $('.gastosArancel').text("$"+gastosArancel);
    $('.impuestosPatente').text("$"+impuestosPatente);
    $('.sellados').text("$"+sellados);
    $('.honorarios').text("$"+honorarios);

    $('#payModal').modal('open');
}

$(document).ready(function(){
    $('#estadosCollection .collection-item').click(function(){
        selectedStatus=$(this).text();
        if(selectedItem != null){
            selectedItem.removeClass('active');
        }
        $(this).addClass('active');
        selectedItem=$(this);
    });
});
