@extends('templates/investigacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Guías</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('autor') }}</strong></p>
			<p><strong>{{ $errors->first('url') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_publicacion') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'guias_clinica_gpc/create_guia_submit', 'role'=>'form', 'files'=>true, 'method'=>'POST')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos de la guía</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('fecha_publicacion')) has-error has-feedback @endif">
						{{ Form::label('fecha_publicacion','Año de publicación') }}
						@if($programacion)
						{{ Form::text('fecha_publicacion',$programacion->fecha_publicacion,['class' => 'form-control','readonly']) }}
						@else
						<div id="datetimepicker_create_gpc" class="form-group input-group date @if($errors->first('fecha_publicacion')) has-error has-feedback @endif">
							{{ Form::text('fecha_publicacion',Input::old('fecha_publicacion'),array('class'=>'form-control', 'readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
						@endif
					</div>
					<div class="form-group col-md-4 @if($errors->first('autor')) has-error has-feedback @endif">
						{{ Form::label('autor','Autor') }}
						@if($programacion)
						{{ Form::text('autor',$programacion->usuario->nombre." ".$programacion->usuario->apellido_pat." ".$programacion->usuario->apellido_mat,array('class'=>'form-control','readonly')) }}
						@else
						{{ Form::text('autor',$user->nombre." ".$user->apellido_pat." ".$user->apellido_mat,array('class'=>'form-control','readonly')) }}
						@endif
					</div>
					<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
						{{ Form::label('nombre','Nombre de Documento') }}
						@if($programacion)
						{{ Form::text('nombre',$programacion->nombre_reporte,array('class'=>'form-control','readonly')) }}
						@else
						{{ Form::text('nombre', null,array('class'=>'form-control')) }}
						@endif
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-8 @if($errors->first('descripcion')) has-error has-feedback @endif">
						{{ Form::label('descripcion','Descripción') }}
						{{ Form::text('descripcion',Input::old('descripcion'),array('class'=>'form-control')) }}
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Adjuntar Archivo</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-8">
					<label class="control-label">Seleccione un Documento</label>(png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx)
					<input name="archivo" id="input-file" type="file" class="file file-loading" data-show-upload="false">
				</div>
			</div>
		</div>		
		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</div>
		</div>
		@if($programacion)
		{{Form::hidden('id_programacion',$programacion->id)}}	
		@endif

	{{ Form::close() }}
	
	<script>
		$("#input-file").fileinput({
		    language: "es",
		    allowedFileExtensions: ["png","jpe","jpeg","jpg","gif","bmp","zip","rar","pdf","doc","docx","xls","xlsx","ppt","pptx"]
		});
	</script>
	
@stop