$( document ).ready(function(){
	init_ot_program();

    $('#btnLimpiar').click(function(){
        limpiar();
    });
	
    $('#idservicio').change(function(){
        search_servicio_ajax();
    });
	
    $('#btnAddProgramacion').click(function(){
        addFilaMantenimiento();
    });

    $('#submit_create_ots').click(function(){
        sendDataToController_create();
    });
});	

function init_ot_program(){
    
    $("#datetimepicker_prog_fecha").datetimepicker({
            defaultDate: false,
            ignoreReadonly: true,
            format: 'DD-MM-YYYY',
            sideBySide: true,
            //minDate: new Date()
    });

    $("#datetimepicker_prog_hora_inicio").datetimepicker({
            defaultDate: false,
            ignoreReadonly: true,
            format: 'HH:ss',
            sideBySide: true
    });

    $("#datetimepicker_prog_hora_fin").datetimepicker({
            defaultDate: false,
            ignoreReadonly: true,
            format: 'HH:ss',
            sideBySide: true
    });


    $('#fecha').val('');
    ver_programaciones();
}

function readTableData(){
    var rowSize = document.getElementById("table_programacion").rows.length;
    var rows = document.getElementById("table_programacion").rows;
    // fill the array with values from the table
    var matrix = new Array;

    for(i = 1; i < rowSize; i++){
        index_value = rows[i].cells[0].id; 
        cells = rows[i].cells;
        clen = cells.length;               
        var arr = new Array();
        for(j = 0; j < clen-1; j++){
            if(j==6){
                arr.push(cells[j].id);
            }else if(j==0){
                arr.push(cells[j].id);
            }else
                arr.push(cells[j].innerHTML);
        }
        matrix.push(arr);
    }
    return matrix;

}

function ver_programaciones(){
    var trimestre_ini = $('#trimestre_ini').val();
    var trimestre_fin = $('#trimestre_fin').val();
    $.ajax({
        url: inside_url+'inspec_equipos/ver_programaciones',
        type: 'POST',
        data: {'trimestre_ini': trimestre_ini,
                'trimestre_fin':trimestre_fin },
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
                var programaciones = {};
                array = response["programaciones"];
                array_ot = response["ots"];
                array_hora = response["horas"];
                array_estado = response["estados"];
                fecha_anterior = array[0];  
                for(var i=0;i<array.length;i++){
                    var prog = array[i];
                    if(i==0)
                        dayEvents=[];
                    else{
                        if(prog != fecha_anterior){
                            dayEvents = [];
                            fecha_anterior =prog;
                        }                                                    
                    }
                    dayEvents.push({
                        "title":array_ot[i].ot_tipo_abreviatura+array_ot[i].ot_correlativo,
                        "time": array_hora[i],
                        "status":array_estado[i].nombre,
                        "id":array_ot[i].idot_inspec_equipo
                    });
                    programaciones[prog] = {dayEvents};
                }
                initialize_calendar_inspeccion(programaciones);                
            }else{
                alert('La petición no se pudo completar, inténtelo de nuevo.');
            }
        },
        error: function(){
            alert('La petición no se pudo completar, inténtelo de nuevo.');
        }
    });
}

function fadeOutModalBox(num) {
    setTimeout(function(){ $(".responsive-calendar-modal").fadeOut(); }, num);
}

function removeModalBox() { $(".responsive-calendar-modal").remove(); }

function initialize_calendar_inspeccion(programaciones){
    $('.responsive-calendar').responsiveCalendar({
        translateMonths:{0:'Enero',1:'Febrero',2:'Marzo',3:'Abril',4:'Mayo',5:'Junio',6:'Julio',7:'Agosto',8:'Septiembre',9:'Octubre',10:'Noviembre',11:'Diciembre'},
        events:programaciones,
        onActiveDayClick: function(events) {
        var $today, $dayEvents, $i, $isHoveredOver, $placeholder, $output;
        $i = $(this).data('year')+'-'+zero($(this).data('month'))+'-'+zero($(this).data('day'));
        $today= events[$i];
        $dayEvents = $today.dayEvents;
        $output = '<div class="responsive-calendar-modal">';
        $.each($dayEvents, function() {
          $.each( $(this), function( key ){
            $("#modal_text_ot").empty();    
            $('#modal_ot').modal('show');
            $('#modal_header_ot').removeClass();
            $('#modal_header_ot').addClass("modal-header ");
            $('#modal_header_ot').addClass("bg-info");
            url =  inside_url+'inspec_equipos/create_ot_inspeccion_equipos/'+$(this)[key].id;
            $output += 'OT: <a href="'+url+'" target="_blank">'+$(this)[key].title+'</a>' + '<p>Estado: '+$(this)[key].status+'<br />Hora Inicio:'+$(this)[key].time+'</p>';
            $('#modal_text_ot').append($output);
          });
        });       
        },
    });
}

function zero(num) {
    if (num < 10) { return "0" + num; }
    else { return "" + num; }
  }

function limpiar(){
    $('#idservicio').val(0);
    $('#mes').val('');
    $('#trimestre').val('');
    $('#solicitantes').val(0);
    $('#fecha').val('');
    $('#hora_inicio').val('');
    $('#hora_fin').val('');
}

function search_servicio_ajax(){
    var val = $("#idservicio").val();
    var mes_ini = $('#mes_ini').val();
    var mes_fin = $('#mes_fin').val();
    var trimestre_ini = $('#trimestre_ini').val();
    var trimestre_fin = $('#trimestre_fin').val();
    $.ajax({
        url: inside_url+'inspec_equipos/search_servicio_ajax',
        type: 'POST',
        data: { 'selected_id' : val,
                'mes_ini' : mes_ini,
                'mes_fin' : mes_fin,
                'trimestre_ini': trimestre_ini,
                'trimestre_fin':trimestre_fin},
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
                var count_mes = response['count_mes'];
                var count_trimestre = response['count_trimestre'];
                var count_activos = response['count_activos'];
                $('#mes').val(count_mes);
                $('#trimestre').val(count_trimestre);
                $('#cantidad_activos').val(count_activos);                
            }else{
                alert('La petición no se pudo completar, inténtelo de nuevo.');
            }
        },
        error: function(){
            alert('La petición no se pudo completar, inténtelo de nuevo.');
        }
    });
}

function addFilaMantenimiento(){
    var servicio = $('#idservicio option:selected').text();
    var idservicio = $('#idservicio').val();
    var cantidad_filas = $("#table_programacion tr").length-1;
    var idsolicitantes = $('#solicitantes').val();
    var fecha = $('#fecha').val();
    var hora_inicio = $('#hora_inicio').val();
    var hora_fin = $('#hora_fin').val();
    var usuario_nombre= $('#solicitantes option:selected').html();
    var usuario_id = $('#solicitantes').val();
    var mes = parseInt(fecha.split('-')[1]);
    var count_otMes = $('#mes').val();
    var count_otTrimestre = $('#trimestre').val();
    var cantidad_activos = $('#cantidad_activos').val();
    var array_fecha_inicio = hora_inicio.split(':');
    var array_fecha_fin = hora_fin.split(':');
    var time_inicio = parseInt(array_fecha_inicio[0])*60 + parseInt(array_fecha_inicio[1]);
    var time_fin= parseInt(array_fecha_fin[0])*60 + parseInt(array_fecha_fin[1]);
    var is_correct = true;
    var messages = "";
    if(idservicio==0){
        messages += "Seleccionar servicio\n";
        is_correct = false;
    }else{
        if(cantidad_activos==0){
            messages += "El servicio no cuenta con activos\n";
            is_correct = false;        
        }
    }
    
    if(idsolicitantes==null){
        messages += "Seleccionar un usuario solicitante\n";
        is_correct = false;
    }

    if(fecha==''){
        messages += "Ingresar fecha\n";
        is_correct = false;       
    }

    if(hora_inicio==''){
        messages += "Ingresar hora inicio\n";
        is_correct = false;        
    }
    if(hora_fin==''){
        messages += "Ingresar hora fin\n";
        is_correct = false;       
    }
    if(time_inicio > time_fin){
        messages += "Hora fin debe ser posterior a la fecha de inicio\n";
        is_correct = false;
    }


    if(is_correct){
        $('#table_programacion').append("<tr>"
                +"<td class='text-nowrap text-center' id=\""+idservicio+"\">"+servicio+"</td>"
                +"<td class='text-nowrap text-center'>"+count_otMes+"</td>"
                +"<td class='text-nowrap text-center'>"+count_otTrimestre+"</td>"
                +"<td class='text-nowrap text-center'>"+fecha+"</td>"
                +"<td class='text-nowrap text-center'>"+hora_inicio+"</td>"
                +"<td class='text-nowrap text-center'>"+hora_fin+"</td>"
                +"<td class='text-nowrap text-center' id=\""+usuario_id+"\">"+usuario_nombre+"</td>"
                +"<td class='text-nowrap text-center'><a href='' class='btn btn-danger delete-detail' onclick='deleteRow(event,this)'><span class=\"glyphicon glyphicon-remove\"></span></a></td></tr>");
        limpiar();
    }else{
        dialog = BootstrapDialog.show({
            title: 'Advertencia',
            message: messages,
            type : BootstrapDialog.TYPE_DANGER,
            buttons: [{
                label: 'Aceptar',
                action: function(dialog) {
                    dialog.close();
                }
            }]
        });
    }
}

function deleteRow(event,el){    
    event.preventDefault();
    var parent = el.parentNode;
    parent = parent.parentNode;
    parent.parentNode.removeChild(parent);
}

function sendDataToController_create(){
        var matrix = readTableData();
        document.body.style.cursor='wait';
        BootstrapDialog.confirm({
            title: 'Mensaje de Confirmación',
            message: '¿Está seguro que desea realizar esta acción?', 
            type: BootstrapDialog.TYPE_INFO,
            btnCancelLabel: 'Cancelar', 
            btnOKLabel: 'Aceptar', 
            callback: function(result){
                if(result) {
                     $.ajax({
                        url: inside_url+'inspec_equipos/submit_programacion',
                        type: 'POST',
                        data: {                
                                'matrix_detalle' : matrix,
                             },
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
                                document.body.style.cursor='default';                   
                                var array_detalle = response["url"];
                                var message = response["message"];
                                var type_message = response["type_message"];
                                var inside_url = array_detalle;
                                if(type_message=="bg-success"){
                                    dialog = BootstrapDialog.show({
                                        title: 'Advertencia',
                                        message: message,
                                        type : BootstrapDialog.TYPE_SUCCESS,
                                        buttons: [{
                                            label: 'Aceptar',
                                            action: function(dialog) {
                                                var url = inside_url + "inspec_equipos/list_inspec_equipos";
                                                window.location = url;
                                            }
                                        }]
                                    });
                                }else{
                                    dialog = BootstrapDialog.show({
                                        title: 'Advertencia',
                                        message: message,
                                        type : BootstrapDialog.TYPE_DANGER,
                                        buttons: [{
                                            label: 'Aceptar',
                                            action: function(dialog) {
                                                dialog.close();
                                            }
                                        }]
                                    });
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
        });
       
    }