@extends('templates/investigacionTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Requerimiento Clínico y Hospitalario</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('categoria') }}</strong></p>
			<p><strong>{{ $errors->first('servicio_clinico') }}</strong></p>
			<p><strong>{{ $errors->first('responsable') }}</strong></p>
			<p><strong>{{ $errors->first('departamento') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_ini') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_fin') }}</strong></p>
			<p><strong>{{ $errors->first('presupuesto') }}</strong></p>
			<p><strong>{{ $errors->first('observaciones') }}</strong></p>
			<p><strong>{{ $errors->first('tipo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('route'=>'requerimientos_clinicos.store', 'role'=>'form','id'=>'form')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información del proyecto</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('id_reporte','N° de RIPF') }}
						{{ Form::number('id_reporte', null, ['id'=>'id_reporte','class'=>'form-control','min'=>'1']) }}
					</div>
					<div class="form-group col-md-2">
						{{ Form::label('','&zwnj;&zwnj;') }}
						{{ Form::button('<span class="glyphicon glyphicon-check"></span> Validar', array('id'=>'submit_create', 'class' => 'btn btn-primary btn-block','onClick'=>'validarReporte()')) }}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
						{{ Form::label('nombre','Nombre') }}
						{{ Form::text('nombre', null, ['id'=>'nombre','class'=>'form-control']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('categoria')) has-error has-feedback @endif">
						{{ Form::label('categoria','Categoría') }}
						{{ Form::select('categoria', $categorias, Input::old('categoria'), ['id'=>'categoria','class'=>'form-control','disabled']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('departamento')) has-error has-feedback @endif">
						{{ Form::label('departamento','Departamento') }}
						{{ Form::select('departamento', $departamentos, Input::old('departamento'), ['id'=>'departamento','class'=>'form-control','onChange'=>'getServicios(this)','disabled']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
						{{ Form::label('servicio_clinico','Servicio Clínico') }}
						{{ Form::select('servicio_clinico', $servicios, Input::old('servicio_clinico'), ['id'=>'servicio_clinico','class'=>'form-control','disabled']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('responsable')) has-error has-feedback @endif">
						{{ Form::label('responsable','Responsable') }}
						{{ Form::select('responsable', $usuarios, Input::old('responsable'),['id'=>'responsable','class'=>'form-control'])}}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('presupuesto')) has-error has-feedback @endif">
						{{ Form::label('presupuesto','Presupuesto Total') }}
						{{ Form::number('presupuesto',Input::old('presupuesto'),['class'=>'form-control','step'=>'0.01','min'=>'0'])}}
					</div>
					<div class="form-group col-md-4 @if($errors->first('tipo')) has-error has-feedback @endif">
						{{ Form::label('tipo','Tipo') }}
						{{ Form::select('tipo',[1=>'Clínico',2=>'Hospitalario'],Input::old('tipo'),array('class'=>'form-control')) }}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('fecha_ini')) has-error has-feedback @endif">
						{{ Form::label('fecha_ini','Fecha Inicio') }}
						<div id="datetimepicker_requerimiento_ini" class="form-group input-group date">
							{{ Form::text('fecha_ini',Input::old('fecha_ini'),array('class'=>'form-control', 'readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
					<div class="form-group col-md-4 @if($errors->first('fecha_fin')) has-error has-feedback @endif">
						{{ Form::label('fecha_fin','Fecha Fin') }}
						<div id="datetimepicker_requerimiento_fin" class="form-group input-group date">
							{{ Form::text('fecha_fin',Input::old('fecha_fin'),array('class'=>'form-control', 'readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('observaciones')) has-error has-feedback @endif">
						{{ Form::label('observaciones','Observaciones') }}
						{{ Form::textarea('observaciones',Input::old('observaciones'),['class'=>'form-control','rows'=>5])}}
					</div>
				</div>
				
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</div>
		</div>

	{{ Form::close() }}

@stop