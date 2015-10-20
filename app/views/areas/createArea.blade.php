@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nueva Área</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('tipo_area') }}</strong></p>
			<p><strong>{{ $errors->first('centro_costo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'areas/submit_area', 'role'=>'form')) }}		
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
				  	<div class="panel-heading">Datos Generales</div>
				  	<div class="panel-body">	
						<div class="row">								
							<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
								{{ Form::label('nombre','Nombre del Area') }}
								{{ Form::text('nombre',Input::old('nombre_area'),['class' => 'form-control'])}}
							</div>
							<div class="form-group col-md-4 @if($errors->first('descripcion')) has-error has-feedback @endif">
								{{ Form::label('descripcion','Descripción') }}
								{{ Form::text('descripcion',Input::old('descripcion'),['class' => 'form-control'])}}
							</div>
						
							<div class="form-group col-md-4 @if($errors->first('tipo_area')) has-error has-feedback @endif">
								{{ Form::label('tipo_area','Tipo de Área') }}
								{{ Form::select('tipo_area',array('0'=> 'Seleccione')+$tipo_areas, Input::old('idtipo_area'),array('class'=>'form-control'))}}
							</div>
							<div class="form-group col-md-4 @if($errors->first('centro_costo')) has-error has-feedback @endif">
								{{ Form::label('centro_costo','Centro de Costo') }}
								{{ Form::select('centro_costo',array('0'=> 'Seleccione')+$centro_costos, Input::old('idcentro_costo'),array('class'=>'form-control'))}}
							</div>
						</div>
					</div>			
				</div>
			</div>
		</div>
		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">				
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/areas/list_areas')}}">Cancelar</a>				
			</div>
		</div>
		{{ Form::close() }}
@stop