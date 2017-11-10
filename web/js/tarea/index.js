$(document).ready(function(){
	getTareas(selectedUser,new Date());

	$('#searchButton').click(function(){
		var selectedDate=$('#dateInput').val();
		var selectedUser=$('#userInput').val();
		getTareas(selectedUser,getDate(selectedDate));
	});

	$('#backButton').click(function(){
		var selectedDate=getDate($('#dateInput').val());
		var yesterday=new Date(selectedDate.setDate(selectedDate.getDate() - 1));
		var selectedUser=$('#userInput').val();
		getTareas(selectedUser,yesterday);
		$('#dateInput').val(formatDateOnly(yesterday));
	});

	$('#nextButton').click(function(){
		var selectedDate=getDate($('#dateInput').val());
		var tomorrow=new Date(selectedDate.setDate(selectedDate.getDate() + 1));
		var selectedUser=$('#userInput').val();
		getTareas(selectedUser,tomorrow);
		$('#dateInput').val(formatDateOnly(tomorrow));
	});
});

function getTareas(usuarioId,date){
	printCanonicalDate(date);
	ajaxCall(usuarioId + '/listado',{fecha:formatDateOnly(date)},function(response){
		$('#tareasTable > tbody').empty();
		var tareasCollection=JSON.parse(response)
		$.each(tareasCollection,function(index, tarea){
			addTarea(tarea);
		});
	})
}

function addTarea(tarea){
	var row="<tr id='"+ tarea.id +"'>"
			+ "<td>"+ tarea.titulo +"</td><td>"+ tarea.descripcion +"</td><td class='fit'>"
			+ "<a onclick='openDetailsModal(\""+tarea.titulo+"\",\""+tarea.descripcion+"\","+tarea.realizada+")' class='btn waves-effect waves-light no-lateral-padding light-blue darken-3'><i class='material-icons'>info</i></a>"
			+ "<a href='"+ editarTareaPath.replace('idTarea',tarea.id) +"' class='btn waves-effect waves-light no-lateral-padding' style='margin-left:3px'><i class='material-icons'>mode_edit</i></a>"
			+ "<a id='done-"+tarea.id+"' onclick='setTareaDone("+tarea.id+")' class='btn waves-effect waves-light no-lateral-padding amber darken-3' style='margin-left:3px'><i class='material-icons'>check</i></a>"
			+ "<a onclick='confirmModal(\""+ eliminarTareaPath.replace('idTarea',tarea.id) +"\")' class='btn waves-effect waves-light no-lateral-padding red' style='margin-left:3px'><i class='material-icons'>delete</i></a>"
			+ "</td></tr>";
	$('#tareasTable > tbody:last-child').append(row);

	if(tarea.realizada){
		$('#'+tarea.id).addClass('green lighten-3');
		$('#done-'+tarea.id).addClass('disabled');
	}
}

function printCanonicalDate(date){
	$('.dateTitle').text(getCanonicalDate(date));
}

function setTareaDone(tareaId){
	ajaxCall(tareaId + '/done',{},function(response){
		$('#'+tareaId).addClass('green lighten-3');
		$('#done-'+tareaId).addClass('disabled');
		showToast('La Tarea ha sido marcada como completada')
	})
}

function openDetailsModal(title,description,isDone){
	$('.taskTitle').text(title);
	$('.taskDescription').text(description);
	if(isDone){
		$('.taskDone').text("Realizada");
	}
	else{
		$('.taskDone').text("Sin Realizar");
	}
	$('#detailsModal').modal('open');
}
