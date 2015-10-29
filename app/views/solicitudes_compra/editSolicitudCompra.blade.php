@extends('templates/solicitudCompraTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Requerimiento de Compra N° {{$reporte_data->idsolicitud_compra}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('numero_ot') }}</strong></p>
			<p><strong>{{ $errors->first('servicio') }}</strong></p>
			<p><strong>{{ $errors->first('marca1') }}</strong></p>
			<p><strong>{{ $errors->first('sustento') }}</strong></p>
			<p><strong>{{ $errors->first('nombre_equipo1') }}</strong></p>
			<p><strong>{{ $errors->first('usuario_responsable') }}</strong></p>
			<p><strong>{{ $errors->first('tipo') }}</strong></p>
			<p><strong>{{ $errors->first('fecha') }}</strong></p>
			<p><strong>{{ $errors->first('numero_reporte') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	
		{{Form::hidden('reporte_id',$reporte_data->idsolicitud_compra,array('id'=>'reporte_id')) }}
		<div class="row">
			<div class="form-group col-md-2 col-md-offset-8">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_edit_solicitud',  'class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/solicitudes_compra/list_solicitudes')}}">Cancelar</a>				
			</div>
		</div>				
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
			  	<div class="panel-heading">Datos Generales</div>
			  	<div class="panel-body">	
					<div class="form-group row">								
						<div class="form-group col-md-4 @if($errors->first('numero_ot')) has-error has-feedback @endif">
							{{ Form::label('numero_ot','Número de OT:') }}<span style="color:red"> *</span>
							@if($reporte_data->deleted_at)
								{{ Form::text('numero_ot',$reporte_data->idordenes_trabajo,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('numero_ot',$reporte_data->idordenes_trabajo,array('class'=>'form-control')) }}
							@endif	
						</div>
						<div class="form-group col-md-4 @if($errors->first('servicio')) has-error has-feedback @endif">
							{{ Form::label('servicio','Servicio:') }}<span style="color:red"> *</span>
							@if($reporte_data->deleted_at)
								{{ Form::select('servicio',array('0'=> 'Seleccione')+ $servicios,$reporte_data->idservicio,array('class'=>'form-control','readonly'=>'','id'=>'servicio')) }}
							@else
								{{ Form::select('servicio',array('0'=> 'Seleccione')+ $servicios,$reporte_data->idservicio,array('class'=>'form-control','id'=>'servicio')) }}
							@endif							
						</div>
						<div class="form-group col-md-4 @if($errors->first('marca1')) has-error has-feedback @endif">
							{{ Form::label('marca1','Marca:') }}
							@if($reporte_data->deleted_at)
								{{ Form::select('marca1',array('0'=> 'Seleccione')+ $marcas1,$reporte_data->idmarca,array('class'=>'form-control','readonly'=>'','id'=>'marca1')) }}
							@else
								{{ Form::select('marca1',array('0'=> 'Seleccione')+ $marcas1,$reporte_data->idmarca,array('class'=>'form-control','id'=>'marca1')) }}
							@endif
						</div>
						<div class="form-group col-md-4 @if($errors->first('nombre_equipo1')) has-error has-feedback @endif">
							{{ Form::label('nombre_equipo1','Equipo:') }}<span style="color:red"> *</span>
							@if($reporte_data->deleted_at)
								{{ Form::select('nombre_equipo1',$nombre_equipos1,$reporte_data->idfamilia_activo,array('class'=>'form-control','readonly'=>'','id'=>'equipo1')) }}
							@else
								{{ Form::select('nombre_equipo1',$nombre_equipos1,$reporte_data->idfamilia_activo,array('class'=>'form-control','id'=>'equipo1')) }}
							@endif
						</div>
						<div class="form-group col-md-4 @if($errors->first('nombre_equipo')) has-error has-feedback @endif">
							{{ Form::label('usuario_responsable','Usuario Responsable:') }}<span style="color:red"> *</span>
							<select name="usuario_responsable" class="form-control" id="usuario_responsable">
								@foreach($usuarios_responsable as $usuario_responsable)
									@if($reporte_data->id_responsable == $usuario_responsable->id)
										<option value="{{ $usuario_responsable->id }}" selected="selected">{{ $usuario_responsable->apellido_pat }} {{ $usuario_responsable->apellido_mat }}, {{ $usuario_responsable->nombre }}</option>
									@else
										<option value="{{ $usuario_responsable->id }}">{{ $usuario_responsable->apellido_pat }} {{ $usuario_responsable->apellido_mat }}, {{ $usuario_responsable->nombre }}</option>
									@endif
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-4 @if($errors->first('tipo')) has-error has-feedback @endif">
							{{ Form::label('tipo','Tipo de Requerimiento:') }}<span style="color:red"> *</span>
							@if($reporte_data->deleted_at)
								{{ Form::select('tipo',array('0'=> 'Seleccione')+ $tipos,$reporte_data->idtipo_solicitud_compra,array('class'=>'form-control','readonly'=>'','id'=>'tipo')) }}
							@else
								{{ Form::select('tipo',array('0'=> 'Seleccione')+ $tipos,$reporte_data->idtipo_solicitud_compra,array('class'=>'form-control','id'=>'tipo')) }}
							@endif
						</div>
						<div class="col-md-4">
							{{ Form::label('fecha','Fecha:')}}<span style="color:red"> *</span>
							<div id="datetimepicker1" class="form-group input-group date @if($errors->first('fecha')) has-error has-feedback @endif">					
								{{ Form::text('fecha',date('d-m-Y',strtotime($reporte_data->fecha)),array('class'=>'form-control','readonly'=>'')) }}
								<span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
				            </div>
        				</div>
        				<div class="col-md-4 form-group">
        					{{ Form::label('estado','Estado:') }}<span style="color:red"> *</span>
        					@if($reporte_data->deleted_at)
								{{ Form::select('estado',array('0'=> 'Seleccione')+ $estados,$reporte_data->idestado,array('class'=>'form-control','readonly'=>'','id'=>'estado','disabled'=>'disabled')) }}
							@else
								{{ Form::select('estado',array('0'=> 'Seleccione')+ $estados,$reporte_data->idestado,array('class'=>'form-control','id'=>'estado')) }}
							@endif							
        				</div> 
					</div>
				</div>			
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
				  	<div class="panel-heading">Sustento</div>
				  	<div class="panel-body">
				  		<div class="form-group row">
				  			<div class="form-group col-md-12 @if($errors->first('sustento')) has-error has-feedback @endif">
					  			{{ Form::label('sustento','Sustento de la solicitud:') }}
								@if($reporte_data->deleted_at)
									{{ Form::textarea('sustento',$reporte_data->sustento,['class' => 'form-control','style'=>'resize:none;','readonly'=>'','placeholder'=>'Texto para explicar nueva adquisición','id'=>'sustento']) }}
								@else
									{{ Form::textarea('sustento',$reporte_data->sustento,['class' => 'form-control','style'=>'resize:none;','placeholder'=>'Texto para explicar nueva adquisición','id'=>'sustento']) }}
								@endif									
				  			</div>
				  		</div>
				  	</div>
				</div>
			</div>
		</div>
		
		<div class="row ">
			<div class="col-md-12 form-group">
				<div class="panel panel-default">
				  	<div class="panel-heading">Datos del Detalle de Solicitud</div>
				  	<div class="panel-body">
				  		<div class="form-group row">
				  			<div class="form-group col-md-4 @if($errors->first('descripcion')) has-error has-feedback @endif">
								{{ Form::label('descripcion','Descripción:') }}<span style="color:red"> *</span>
								{{ Form::text('descripcion',Input::old('descripcion'),['class' => 'form-control','id'=>'descripcion'])}}
							</div>
							<div class="form-group col-md-4 @if($errors->first('marca2')) has-error has-feedback @endif">
								{{ Form::label('marca2','Marca:') }}<span style="color:red"> *</span>
								{{ Form::text('marca2',Input::old('marca2'),array('class'=>'form-control','id'=>'marca2'))}}
							</div>
							<div class="form-group col-md-4 @if($errors->first('nombre_equipo2')) has-error has-feedback @endif">
								{{ Form::label('nombre_equipo2','Equipo:') }}<span style="color:red"> *</span>
								{{ Form::text('nombre_equipo2', Input::old('nombre_equipo2'), array('class'=>'form-control','id'=>'nombre_equipo2')) }}
							</div>
							<div class="form-group col-md-4 @if($errors->first('serie_parte')) has-error has-feedback @endif">
								{{ Form::label('serie_parte','Número de Serie / Parte:') }}<span style="color:red"> *</span>
								{{ Form::text('serie_parte', Input::old('numero_serie'), array('class'=>'form-control','id'=>'serie_parte')) }}
							</div>
							<div class="form-group col-md-4 @if($errors->first('cantidad')) has-error has-feedback @endif">
								{{ Form::label('cantidad','Cantidad:') }}<span style="color:red"> *</span>
								<div class="form-group input-group">
									{{ Form::text('cantidad',Input::old('cantidad'),['class' => 'form-control bfh-number','id'=>'cantidad'])}}
									<span class="input-group-addon bfh-number-btn inc"><span class="glyphicon glyphicon-chevron-up"></span></span>
								</div>
							</div>
				  		</div>
				  		<div class="container-fluid row form-group">
							<div class="col-md-2 col-md-offset-8">
								<div class="btn btn-primary btn-block" id="btnAgregar"><span class="glyphicon glyphicon-plus"></span>Agregar</div>				
							</div>
							<div class="col-md-2">
								<div class="btn btn-default btn-block" id="btnLimpiar"><span class="glyphicon glyphicon-refresh"></span>Limpiar</div>				
							</div>
						</div>
				  	</div>
				</div>
			</div>
		</div>
		
		<div class="container-fluid row">
			<div class="col-md-12 form-group">
				<div class="table-responsive">
				<table class="table" id="table_solicitud">
					<tr class="info">
						<th>Descripción</th>
						<th>Marca</th>
						<th>Modelo</th>
						<th>Serie/Número de Parte</th>
						<th>Cantidad</th>
						<th>Eliminar Registro </th>
					</tr>					
					@foreach($detalles_solicitud as $index => $detalle_solicitud)
						<tr>
							{{Form::hidden('iddetalle',$detalle_solicitud->iddetalle_solicitud_compra,array('id'=>'iddetalle'.$index))}}
							<td id="{{$index}}">{{$detalle_solicitud->descripcion}}</td>
							<td>{{$detalle_solicitud->marca}}</td>
							<td>{{$detalle_solicitud->modelo}}</td>
							<td>{{$detalle_solicitud->serie_parte}}</td>
							<td>{{$detalle_solicitud->cantidad}}</td>
							<td>
								<a href='' class='btn btn-danger delete-detail' onclick='deleteRow(event,this)'><span class="glyphicon glyphicon-remove"></span>Eliminar</a>
							</td>
						</tr>
					@endforeach					
				</table>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
	  				<div class="panel-heading">Documento Relacionado</div>
	  				<div class="panel-body">
						<div class="row">								
							<div class="form-group col-md-2 @if($errors->first('numero_reporte')) has-error has-feedback @endif">
								{{ Form::label('numero_reporte','N° Reporte:') }}<span style="color:red"> *</span>
								@if($documento_info->deleted_at)
									{{ Form::text('numero_reporte',$documento_info->codigo_archivamiento,array('class'=>'form-control','readonly'=>'','id'=>'numero_reporte')) }}
								@else
									{{ Form::text('numero_reporte',$documento_info->codigo_archivamiento,array('class'=>'form-control','id'=>'numero_reporte')) }}
								@endif								
							</div>
							<div class="form-group col-md-2" style="margin-top:25px">
								<a class="btn btn-primary btn-block" id="btnAgregarReporte">
								<span class="glyphicon glyphicon-plus"></span> Agregar</a>
							</div>
							<div class="form-group col-md-2" style="margin-top:25px;">
								<div class="btn btn-default btn-block" id="btnLimpiarReporte"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>
							</div>
							<div class="form-group col-md-4">
								{{ Form::label('nombre_reporte','Documento') }}
								@if($reporte_data->deleted_at)
									{{ Form::text('nombre_reporte',$documento_info->nombre,array('class'=>'form-control','readonly'=>'','id'=>'nombre_reporte')) }}
								@else
									{{ Form::text('nombre_reporte',$documento_info->nombre,array('class'=>'form-control','id'=>'nombre_reporte')) }}
								@endif
							</div>									
							<div class="form-group col-md-2">
								{{ Form::open(array('url'=>'solicitudes_compra/download_reporte', 'role'=>'form')) }}
								{{ Form::hidden('numero_reporte_hidden',null)}}
								{{ Form::button('<span class="glyphicon glyphicon-download"></span> Descargar', array('id'=>'btn_descarga', 'type' => 'submit', 'class' => 'btn btn-primary btn-block','style'=>'margin-top:25px')) }}
								{{ Form::close() }}
							</div>									
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row container-fluid">
			{{Form::open(array('url'=>'solicitudes_compra/export_pdf', 'role'=>'form'))}}		
				{{Form::hidden('solicitud_id',$reporte_data->idsolicitud_compra) }}
				<div class="form-group col-md-2">
					{{ Form::button('<span class="glyphicon glyphicon-export"></span> Exportar', array('id'=>'exportar', 'type'=>'submit' ,'class' => 'btn btn-success btn-block')) }}
				</div>
			{{ Form::close() }}
			@if($reporte_data->deleted_at)
			{{ Form::open(array('url'=>'solicitudes_compra/submit_enable_solicitud', 'role'=>'form')) }}
				{{ Form::hidden('reporte_id', $reporte_data->idsolicitud_compra) }}
				<div class="form-group col-md-2 col-md-offset-8" style="margin-top:-15px">
					{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-up"></span> Habilitar', array('id'=>'submit-delete', 'type' => 'submit', 'class' => 'btn btn-success btn-block')) }}
				</div>
			{{ Form::close() }}
			@else
			{{ Form::open(array('url'=>'solicitudes_compra/submit_disable_solicitud', 'role'=>'form')) }}
				{{ Form::hidden('reporte_id', $reporte_data->idsolicitud_compra) }}
				<div class="form-group col-md-2 col-md-offset-8" style="margin-top:-15px">
					{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-down"></span> Inhabilitar', array('id'=>'submit-delete', 'type' => 'submit', 'class' => 'btn btn-danger btn-block')) }}
				</div>
			{{ Form::close() }}
			@endif
			
		</div>		
@stop
<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Advertencia</h4>
        </div>
        <div class="modal-body">
          <p>Ingresar todos los campos completos.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>      
    </div>
  </div>  
</div>
<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="modalOT" role="dialog">
    <div class="modal-dialog modal-md">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Advertencia</h4>
        </div>
        <div class="modal-body">
          <p>Orden de Trabajo de Mantenimiento no existe. Ingrese una Orden de Trabajo de Mantenimiento válido</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>      
    </div>
  </div>  
</div>
<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="modal_edit" role="dialog">
    <div class="modal-dialog modal-md">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" id="modal_header_edit">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Advertencia</h4>
        </div>
        <div class="modal-body" id="modal_edit_text">
         	
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" id="btn_close_modal" data-dismiss="modal">Aceptar</button>
        </div>
      </div>      
    </div>
  </div>  
</div>