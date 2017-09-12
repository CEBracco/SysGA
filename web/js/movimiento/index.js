$(document).ready(function(){
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

	$('select[name="tipo"]').val('');
	$('select[name="tipo"]').material_select('destroy');
	$('select[name="tipo"]').material_select();
}
