$( document ).ready(function(){
	$('#list_areas_btnLimpiar').click(function(){
		limpiar_criterios_areas();
	});

	$('#list_group_btnLimpiar').click(function(){
		limpiar_criterios_grupos();
	});

	$('#list_marca_btnLimpiar').click(function(){
		limpiar_criterios_marcas();
	});

	list_marca_btnLimpiar
});


function fill_usuario_responsable_servicio(){		
		var val = document.getElementById("area").value;
		$.ajax({
			url: inside_url+'servicios/return_usuarios/'+val,
			type: 'POST',
			data: { 'selected_id' : val },
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
					var arreglo_usuarios = response['usuarios_resp'];
					var tamano = arreglo_usuarios.length;
					$("#usuario").empty();
					for(i = 0;i<tamano;i++){
						$("#usuario").append('<option value='+arreglo_usuarios[i].id+'>'+arreglo_usuarios[i].nombre_responsable+'</option>');
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

function limpiar_criterios_areas(){
	$('#search_nombre_area').val('');
	$('#search_tipo_area').val('');
}

function limpiar_criterios_grupos(){
	$('#search_nombre_grupo').val('');
}

function limpiar_criterios_marcas(){
	$('#search_nombre_marca').val('');
}