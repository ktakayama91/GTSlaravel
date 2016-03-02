$( document ).ready(function(){

	init_createActivo();
	
	$('#mensaje_validacion').prop('readonly',true);

	$('#btnValidarNumReporte').click(function(){
		validate_numero_reporte_ajax();
	});

	$('#btnLimpiarNumReporte').click(function(){
		limpiar_reporte_instalacion();
	});
	
	$('#fecha_calibracion_datetimepicker').datetimepicker({
		defaultDate: false,
		ignoreReadonly: true,
		format: 'DD-MM-YYYY'
	});

	$('#fecha_proximo_datetimepicker').datetimepicker({
		defaultDate: false,
		ignoreReadonly: true,
		format: 'DD-MM-YYYY',
		minDate: new Date()
	});

	
});

function init_createActivo()
{
	$("#mensaje_validacion").css('background-color','#eee');
    $("#mensaje_validacion").css('color','#555');
}

function validate_numero_reporte_ajax()
{
	var numeroReporte = $('#reporte_instalacion').val();

	if(numeroReporte != "")
	{
		$.ajax({
		    url: inside_url+'equipos/validate_numero_reporte_ajax',
		    type: 'POST',
		    data: { 'numero_reporte' : numeroReporte },
		    beforeSend: function(){
		        $("#delete-selected-profiles").addClass("disabled");
		        $("#delete-selected-profiles").hide();
		        $(".loader_container").show();
		    },
		    complete: function(){
		        $(".loader_container").hide();
		        $("#delete-selected-profiles").removeClass("disabled");
		        $("#delete-selected-profiles").show();
		        delete_selected_profiles = true;
		    },
		    success: function(response){
		        if(response.success){
		        	var resp = response["data"];
		            if(resp.length != 0){		                
	                    $("#mensaje_validacion").val("");
	                    $("#mensaje_validacion").css('background-color','#5cb85c');
	                    $("#mensaje_validacion").css('color','white');
	                    $("#mensaje_validacion").val("Número de reporte correcto");
	                    
	                    $('input[name=idreporte_instalacion]').val(resp[0].idreporte_instalacion);		                
		            }else{
		                $("#mensaje_validacion").val("Número de reporte incorrecto");
		                $("#mensaje_validacion").css('background-color','#d9534f');
		                $("#mensaje_validacion").css('color','white');
		            }		            
		        }else{
		            alert('La petición no se pudo completar, inténtelo de nuevo.');
		        }
		    },
		    error: function(){
		        alert('La petición no se pudo completar, inténtelo de nuevo.');
		    }
		});
	}
}

function limpiar_reporte_instalacion()
{
	$('#reporte_instalacion').val("");	
	$('#mensaje_validacion').val("");
	$("#mensaje_validacion").css('background-color','#eee');
    $("#mensaje_validacion").css('color','#555');
}