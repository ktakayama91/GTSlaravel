@extends('templates/investigacionTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Cronograma</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('servicio_clinico') }}</strong></p>
			<p><strong>{{ $errors->first('responsable') }}</strong></p>
			<p><strong>{{ $errors->first('departamento') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_ini') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_fin') }}</strong></p>
			<p><strong>{{ $errors->first('duracion') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('route'=>['proyecto_cronograma.cronograma.update',$cronograma->id], 'role'=>'form')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Informacion general</h3>
			</div>
			<div class="panel-body">
				
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('id_reporte','Codigo de proyecto') }}
						{{ Form::text('codigo', $cronograma->proyecto->codigo, ['class'=>'form-control','readonly']) }}
					</div>
				</div>
				
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
						{{ Form::label('nombre','Nombre') }}
						{{ Form::text('nombre', $cronograma->nombre, ['class'=>'form-control']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('departamento')) has-error has-feedback @endif">
						{{ Form::label('departamento','Departamento') }}
						{{ Form::select('departamento', $departamentos, $cronograma->id_departamento, ['id'=>'departamento','class'=>'form-control','onChange'=>'getServicios(this)']) }}
					</div>
				</div>
				
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
						{{ Form::label('servicio_clinico','Servicio Clínico') }}
						{{ Form::select('servicio_clinico', $servicios, $cronograma->id_servicio_clinico, ['id'=>'servicio_clinico','class'=>'form-control']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('responsable')) has-error has-feedback @endif">
						{{ Form::label('responsable','Responsable') }}
						{{ Form::select('responsable',$usuarios, $cronograma->id_responsable,['class'=>'form-control'])}}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('fecha_ini')) has-error has-feedback @endif">
						{{ Form::label('fecha_ini','Fecha Inicio') }}
						<div id="datetimepicker_desarrollo_ini" class="form-group input-group date">
							{{ Form::text('fecha_ini',date('d-m-Y',strtotime($cronograma->fecha_ini)),array('class'=>'form-control', 'readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
					<div class="form-group col-md-4 @if($errors->first('fecha_fin')) has-error has-feedback @endif">
						{{ Form::label('fecha_fin','Fecha Fin') }}
						<div id="datetimepicker_desarrollo_fin" class="form-group input-group date">
							{{ Form::text('fecha_fin',date('d-m-Y',strtotime($cronograma->fecha_fin)),array('class'=>'form-control', 'readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
				</div>	

			</div>
		</div>
		
		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</div>

			<div class="form-group col-md-offset-8 col-md-2">
				<a class="btn-under" href="{{route('proyecto_cronograma.show',$cronograma->id_proyecto)}}">
					{{ Form::button('<span class="glyphicon glyphicon-repeat"></span> Regresar', array('class' => 'btn btn-primary btn-block')) }}
				</a>
			</div>
		</div>

	{{ Form::close() }}


@stop