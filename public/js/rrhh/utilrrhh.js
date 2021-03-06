$( document ).ready(function(){

    $('#form').on('submit', function() {
        $('select').prop('disabled', false);
    });

	$("#datetimepicker1").datetimepicker({
		ignoreReadonly: true,
		format: 'DD-MM-YYYY'
	});

	$("#datetimepicker2").datetimepicker({
		ignoreReadonly: true,
		format: 'DD-MM-YYYY'
	});

	$("#datetimepicker3").datetimepicker({
		ignoreReadonly: true,
		format: 'DD-MM-YYYY'
	});

    $("#datetimepicker1").on("dp.change", function (e) {
        $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
    });
    
    $("#datetimepicker2").on("dp.change", function (e) {
        $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
    });

	$("#datetimepicker_create_plan_difusion_ini").datetimepicker({
		ignoreReadonly: true,
		format: 'DD-MM-YYYY'
	});

	$("#datetimepicker_create_plan_difusion_fin").datetimepicker({
		ignoreReadonly: true,
		format: 'DD-MM-YYYY'
	});

	$("#datetimepicker_fecha_sesion").datetimepicker({
		ignoreReadonly: true,
		format: 'DD-MM-YYYY'
	});


	$("#datetimepicker_hora_inicio").datetimepicker({
		ignoreReadonly: true,
		format: 'HH:ss'
	});


});

function deleteRow(event,el)
{
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;
    parent.parentNode.removeChild(parent);
}