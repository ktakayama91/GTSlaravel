@extends('templates/activosTemplate')
@section('content')
	<div class="row">
        <div class="col-md-12">
            <h3 class="page-header">Agregar Soporte Técnico</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('idsoporte_tecnico') }}</strong></p>			
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('message') }}
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

	{{ Form::open(array('url'=>'equipos/submit_create_soporte_tecnico_equipo', 'role'=>'form')) }}
	{{ Form::hidden('idactivo', $equipo_info->idactivo,array('id' => 'idactivo')) }}	
	<div class="panel panel-default">
	  	<div class="panel-heading">Buscar Soporte Técnico</div>
	  	<div class="panel-body">
	  		<div class="row">
	  			<div class="form-group col-md-4 @if($errors->first('tipo_documento_identidad')) has-error has-feedback @endif">
					{{ Form::label('tipo_documento_identidad_activo','Tipo de Documento') }}
					{{ Form::select('tipo_documento_identidad_activo', array('' => 'Seleccione') + $tipo_documento_identidad,$search_tipo_documento_activo,['class' => 'form-control']) }}						
				</div>
				<div class="form-group col-md-4 @if($errors->first('numero_documento_soporte_tecnico')) has-error has-feedback @endif">
					{{ Form::label('numero_documento_soporte_tecnico_activo','Número de Documento') }}
					{{ Form::text('numero_documento_soporte_tecnico_activo',$search_numero_documento_soporte_tecnico_activo,array('class'=>'form-control')) }}
				</div>
				<div class="form-group col-md-4 @if($errors->first('mensaje_validacion_soporte_tecnico')) has-error has-feedback @endif">
					{{ Form::label('mensaje_validacion_soporte_tecnico_activo','Validación') }}
					{{ Form::text('mensaje_validacion_soporte_tecnico_activo',Input::old('mensaje_validacion_soporte_tecnico_activo'),array('class'=>'form-control','readonly')) }}
				</div>
	  		</div>
	  		<div class="row">
				<div class="form-group col-md-offset-10 col-md-2">
					<button class="btn btn-primary btn-block" type="button" id="btnBuscarSoporteTecnico"><span class="glyphicon glyphicon-search"></span> Buscar</button>
				</div>										
	  		</div>
	  		<div class="row">
	  			{{ Form::hidden('idsoporte_tecnico') }}
	  			<div class="form-group col-md-4 @if($errors->first('nombre_soporte_tecnico')) has-error has-feedback @endif">
					{{ Form::label('nombre_soporte_tecnico_activo','Nombre') }}
					{{ Form::text('nombre_soporte_tecnico_activo',Input::old('nombre_soporte_tecnico_activo'),array('class'=>'form-control','readonly')) }}
				</div>
				<div class="form-group col-md-4 @if($errors->first('apPaterno_soporte_tecnico')) has-error has-feedback @endif">
					{{ Form::label('apPaterno_soporte_tecnico_activo','Apellido Paterno') }}
					{{ Form::text('apPaterno_soporte_tecnico_activo',Input::old('apPaterno_soporte_tecnico_activo'),array('class'=>'form-control','readonly')) }}
				</div>
				<div class="form-group col-md-4 @if($errors->first('apMaterno_soporte_tecnico')) has-error has-feedback @endif">
					{{ Form::label('apMaterno_soporte_tecnico_activo','Apellido Materno') }}
					{{ Form::text('apMaterno_soporte_tecnico_activo',Input::old('apMaterno_soporte_tecnico_activo'),array('class'=>'form-control','readonly')) }}
				</div>
	  		</div>
	  		<div class="row">
	  			<div class="form-group col-md-4 @if($errors->first('especialidad_soporte_tecnico')) has-error has-feedback @endif">
					{{ Form::label('especialidad_soporte_tecnico_activo','Especialidad') }}
					{{ Form::text('especialidad_soporte_tecnico_activo',Input::old('especialidad_soporte_tecnico_activo'),array('class'=>'form-control','readonly')) }}
				</div>
				<div class="form-group col-md-4 @if($errors->first('telefono_soporte_tecnico')) has-error has-feedback @endif">
					{{ Form::label('telefono_soporte_tecnico_activo','Telefono') }}
					{{ Form::text('telefono_soporte_tecnico_activo',Input::old('telefono_soporte_tecnico_activo'),array('class'=>'form-control','readonly')) }}
				</div>
				<div class="form-group col-md-4 @if($errors->first('email_soporte_tecnico')) has-error has-feedback @endif">
					{{ Form::label('email_soporte_tecnico_activo','E-mail') }}
					{{ Form::text('email_soporte_tecnico_activo',Input::old('email_soporte_tecnico_activo'),array('class'=>'form-control','readonly')) }}
				</div>
	  		</div>
	  		<div class="row">
	  			<div class="form-group col-md-offset-8 col-md-2">
	  				{{ Form::button('<span class="glyphicon glyphicon-plus" ></span> Agregar', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}						
				</div>
	  			<div class="form-group col-md-2">
					<button class="btn btn-default btn-block" type="button" id="btnLimpiar_agregar_soporte_tecnico" ><span class="glyphicon glyphicon-refresh"></span> Limpiar</button>
				</div>
	  		</div>
		</div>
	</div>			

	{{ Form::close() }}
	<div class="form-group row">
		<div class="container-fluid">
			<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th class="text-nowrap">Nº</th>
						<th class="text-nowrap">Tipo de Documento</th>
						<th class="text-nowrap">Número de Documento</th>
						<th class="text-nowrap">Nombre</th>
						<th class="text-nowrap">Apellido Paterno</th>
						<th class="text-nowrap">Apellido Materno</th>
						<th class="text-nowrap">Especialidad</th>
						<th class="text-nowrap">Teléfono</th>				
						<th class="text-nowrap">E-mail</th>
						<th class="text-nowrap">Eliminar</th>
					</tr>
					@foreach($soporte_tecnico_info as $index => $soporte_tecnico)
					<tr class="@if($soporte_tecnico->deleted_at) bg-danger @endif">			
						<td class="text-nowrap">
							{{$index + 1}}
						</td>
						<td class="text-nowrap">
							{{$soporte_tecnico->tipo_documento}}
						</td>
						<td class="text-nowrap">
							{{$soporte_tecnico->numero_documento}}
						</td>
						<td class="text-nowrap">
							{{$soporte_tecnico->nombres}}
						</td>
						<td class="text-nowrap">
							{{$soporte_tecnico->apellido_pat}}
						</td>
						<td class="text-nowrap">
							{{$soporte_tecnico->apellido_mat}}
						</td>						
						<td class="text-nowrap">
							{{$soporte_tecnico->especialidad}}
						</td>
						<td class="text-nowrap">
							{{$soporte_tecnico->telefono}}
						</td>
						<td class="text-nowrap">
							{{$soporte_tecnico->email}}
						</td>
						<td class="text-nowrap">
							<a class="btn btn-danger btn-block btn-sm" href="">
							<span class="glyphicon glyphicon-trash"></span> Eliminar</a>
						</td>						
					</tr>
					@endforeach		
				</table>
			</div>
		</div>
	</div>
		
	<div class="container-fluid row">
		<div class="form-group col-md-offset-10 col-md-2">
			<a class="btn btn-default btn-block" href="{{URL::to('/equipos/list_equipos/')}}">
			<span class="glyphicon glyphicon-menu-left"></span> Regresar</a>				
		</div>
	</div>
@stop