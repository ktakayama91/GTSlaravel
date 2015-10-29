@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Servicio: <strong>{{$servicio_info->nombre}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('tipo_servicio') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'servicios/submit_edit_servicio', 'role'=>'form')) }}
	{{ Form::hidden('servicio_id', $servicio_info->idservicio) }}
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
				  	<div class="panel-heading">Datos Generales</div>
				  	<div class="panel-body">	
						<div class="row form-group">								
							<div class="form-group col-md-3 @if($errors->first('nombre')) has-error has-feedback @endif">
								{{ Form::label('nombre','Nombre del Servicio') }}
								@if($servicio_info->deleted_at)
									{{ Form::text('nombre',$servicio_info->nombre,array('class'=>'form-control','readonly'=>'')) }}
								@else
									{{ Form::text('nombre',$servicio_info->nombre,array('class'=>'form-control')) }}
								@endif
							</div>
							<div class="form-group col-md-4 @if($errors->first('descripcion')) has-error has-feedback @endif">
								{{ Form::label('descripcion','Descripción') }}
								@if($servicio_info->deleted_at)
									{{ Form::text('descripcion',$servicio_info->descripcion,array('class'=>'form-control','readonly'=>'')) }}
								@else
									{{ Form::text('descripcion',$servicio_info->descripcion,array('class'=>'form-control')) }}
								@endif							
							</div>						
							<div class="form-group col-md-3 @if($errors->first('tipo_servicio')) has-error has-feedback @endif">
								{{ Form::label('tipo_servicio','Tipo de Servicio') }}
								@if($servicio_info->deleted_at)
									{{ Form::select('tipo_servicio',array('0'=> 'Seleccione')+$tipo_servicios,$servicio_info->idtipo_servicios,array('class'=>'form-control','readonly'=>'')) }}
								@else
									{{ Form::select('tipo_servicio',array('0'=> 'Seleccione')+$tipo_servicios,$servicio_info->idtipo_servicios,array('class'=>'form-control')) }}
								@endif
							</div>
							<div class="form-group col-md-3 @if($errors->first('area')) has-error has-feedback @endif">
								{{ Form::label('area','Area') }}
								{{ Form::select('area',array('0'=> 'Seleccione')+$areas, $servicio_info->idarea,array('class'=>'form-control',"onchange" => "fill_usuario_responsable_servicio()",'id'=>'area'))}}
							</div>
							<div class="form-group col-md-4 @if($errors->first('personal')) has-error has-feedback @endif">
								{{ Form::label('personal','Usuario Responsable') }}
								{{ Form::select('personal',array('0'=> 'Seleccione')+$personal, $servicio_info->id_usuario_responsable,array('class'=>'form-control','id'=>'usuario'))}}
							</div>
						</div>
					</div>			
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
				  	<div class="panel-heading">Lista de Equipos</div>
				  	<div class="panel-body">
				  		<div class="row">
				  			<div class="col-md-1"></div>
				  			<div class="col-md-12">
					  			<table class="table">
					  				<tr>
					  					<th>Código Patrimonial</th>
					  					<th>Número de Serie</th>
					  					<th>Nombre de Equipo</th>
					  				</tr>
					  				@foreach($activos_servicio as $index => $activo_servicio)
					  				<tr>
					  					<td>{{$activo_servicio->codigo_patrimonial}}</td>
					  					<td>{{$activo_servicio->numero_serie}}</td>
					  					<td>{{$activo_servicio->nombre_equipo}}</td>

					  				</tr>
					  				@endforeach
				  				</table>
				  			</div>
				  		</div>
				  	</div>
				</div>
			</div>
		</div>
		<div class="container-fluid row">			
			@if(!$servicio_info->deleted_at)
			<div class="col-md-2 form-group">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit-edit', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}						
			</div>
			@endif
			<div class="col-md-2 form-group">
				<a class="btn btn-default btn-block" href="{{URL::to('/servicios/list_servicios')}}">Cancelar</a>
			</div>	
	{{ Form::close() }}
		@if($servicio_info->deleted_at)
		{{ Form::open(array('url'=>'servicios/submit_enable_servicio', 'role'=>'form')) }}
			{{ Form::hidden('servicio_id', $servicio_info->idservicio) }}
				<div class="form-group col-md-2 col-md-offset-8">
					{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-up"></span> Habilitar', array('id'=>'submit-delete', 'type' => 'submit', 'class' => 'btn btn-success btn-block')) }}
				</div>
		{{ Form::close() }}
		@else
		{{ Form::open(array('url'=>'servicios/submit_disable_servicio', 'role'=>'form')) }}
			{{ Form::hidden('servicio_id', $servicio_info->idservicio) }}
				<div class="form-group col-md-2 col-md-offset-6">
					{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-down"></span> Inhabilitar', array('id'=>'submit-delete', 'type' => 'submit', 'class' => 'btn btn-danger btn-block')) }}
				</div>
		{{ Form::close() }}
		@endif
		</div>
@stop