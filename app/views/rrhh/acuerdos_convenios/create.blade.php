@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Acuerdos y convenios de asociación con entidades</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

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

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('nombre_convenio') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_firma_convenio') }}</strong></p>
			<p><strong>{{ $errors->first('duracion_convenio') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion_convenio') }}</strong></p>
			<p><strong>{{ $errors->first('objetivo_convenio') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>		
			<p><strong>{{ $errors->first('') }}</strong></p>
			<p><strong>{{ $errors->first('') }}</strong></p>
			<p><strong>{{ $errors->first('') }}</strong></p>
		</div>
	@endif

	{{ Form::open(array('route'=>'acuerdo_convenio.store', 'role'=>'form', 'files'=>'true')) }}		
	<div class="panel panel-default">
	  	<div class="panel-heading">Datos Generales</div>
		  	<div class="panel-body">	
				<div class="form-group row">
					<div class="col-md-4 @if($errors->first('nombre_convenio')) has-error has-feedback @endif">
						{{ Form::label('nombre_convenio','Nombre de Convenio') }}<span style='color:red'>*</span>
						{{ Form::text('nombre_convenio',Input::old('nombre_convenio'),['class' => 'form-control'])}}
					</div>					
				</div>
				<div class="form-group row">
					<div class="col-md-4  @if($errors->first('fecha_firma_convenio')) has-error has-feedback @endif">
						{{ Form::label('fecha_firma_convenio','Fecha de Firma') }}<span style='color:red'>*</span>					
						<div id="datetimepicker1" class="form-group input-group date">
							{{ Form::text('fecha_firma_convenio',Input::old('fecha_firma_convenio'),array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>				
					</div>					
					<div class="col-md-4 @if($errors->first('duracion_convenio')) has-error has-feedback @endif">
						{{ Form::label('duracion_convenio','Duración de Convenio (En Meses)') }}<span style='color:red'>*</span>
						{{ Form::text('duracion_convenio',Input::old('duracion_convenio'),['class' => 'form-control'])}}
					</div>
				</div>
				<div class="form-group row">						
					<div class="col-md-12 @if($errors->first('descripcion_convenio')) has-error has-feedback @endif">
						{{ Form::label('descripcion_convenio','Descripción (MAX:200 Caracteres)') }}<span style='color:red'>*</span>
						{{ Form::textarea('descripcion_convenio',Input::old('descripcion_convenio'),['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none'])}}
					</div>
				</div>
				<div class="form-group row">						
					<div class="col-md-12 @if($errors->first('objetivo_convenio')) has-error has-feedback @endif">
						{{ Form::label('objetivo_convenio','Principales Objetivos (MAX:200 Caracteres)') }}<span style='color:red'>*</span>
						{{ Form::textarea('objetivo_convenio',Input::old('objetivo_convenio'),['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none'])}}
					</div>
				</div>			
			</div>
		</div>
		<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Adjuntar Archivo<span style='color:red'>*</span></h3>
		</div>
		<div class="panel-body">
			<div class="col-md-8 @if($errors->first('archivo')) has-error has-feedback @endif">
				<label class="control-label">Seleccione un Documento </label><span style='color:red'>*</span><span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="right" title="Formatos Permitidos: png, jpe, jpeg, jpg, gif, bmp, zip, rar, pdf, doc, docx, xls, xlsx, ppt, pptx"></span>
				<input name="archivo" id="input-file" type="file" class="file file-loading" data-show-upload="false">
			</div>
		</div>	
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Instituciones relacionadas<span style='color:red'>*</span></h3>
			</div>
			<div class="panel-body">
				<div class="form-group row">
					<div class="col-md-4">
					{{ Form::label('institucion_convenio','Nombre de Institución') }}
					{{ Form::text('institucion_convenio',Input::old('institucion_convenio'),['class' => 'form-control'])}}
					</div>
					<div class="col-md-4">
						<a class="btn btn-primary btn-block" style="width:145px; margin-top:25px" onClick="agregarInstitucion()">
						<span class="glyphicon glyphicon-plus"></span> Agregar</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="table-responsive">
							<table class="table" id="institucion_relacionada_table">
								<tr class="info">												
									<th class="text-nowrap text-center">Nombre</th>
									<th></th>																				
								</tr>
								<?php 
									$instituciones = Input::old('instituciones');									
									$count = count($instituciones);	
								?>	
								<?php for($i=0;$i<$count;$i++){ ?>								
								<tr>			
									<td><input style="border:0" name='instituciones[]' value='{{ $instituciones[$i] }}' readonly/></td>
									<td><div class="btn btn-danger btn-block btn-sm" style="width:145px; float: right" onclick="deleteRow(event,this)"><span class="glyphicon glyphicon-trash" ></span> Eliminar</a></div></td>											
								</tr>
								<?php } ?>					
							</table>				
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Representantes institucionales<span style='color:red'>*</span></h3>
			</div>
			<div class="panel-body">
				<div class="form-group row">
					<div class="col-md-4">
					{{ Form::label('representante_institucional_convenio','Número de Documento del Representante') }}
					{{ Form::text('representante_institucional_convenio',Input::old('representante_institucional_convenio'),['class' => 'form-control'])}}
					</div>
					<div class="col-md-4">
						<a class="btn btn-primary btn-block" style="width:145px; margin-top:25px" onClick="agregarRepresentanteInstitucional()">
						<span class="glyphicon glyphicon-plus"></span> Agregar</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table" id="representante_institucional_convenio_table">
								<tr class="info">												
									<th class="text-nowrap text-center">Nombre</th>												
									<th class="text-nowrap text-center">Departamento</th>												
									<th class="text-nowrap text-center">Rol</th>
									<th></th>												
								</tr>
								<?php 
									$representantes_institucional = Input::old('representantes_institucional');									
									$count = count($representantes_institucional);	
								?>								
								<tr>
								<?php for($i=0;$i<$count;$i++){ ?>		
									<td></td>
									<td></td>
									<td></td>
									<td class="hide"><input style="border:0" name='representantes_institucional[]' value='{{ $representantes_institucional[$i] }}' readonly/></td>
									<td><div class="btn btn-danger btn-block btn-sm" style="width:145px; float: right" onclick="deleteRow(event,this)"><span class="glyphicon glyphicon-trash" ></span> Eliminar</a></div></td>
								</tr>
								<?php } ?>				
							</table>				
						</div>
					</div>				
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Representantes de entidad asociada<span style='color:red'>*</span></h3>
			</div>
			<div class="panel-body">
				<div class="form-group row">
					<div class="col-md-4">
					{{ Form::label('nombre_representante_convenio','Nombre') }}
					{{ Form::text('nombre_representante_convenio',Input::old('nombre_representante_convenio'),['class' => 'form-control'])}}
					</div>
					<div class="col-md-4">
					{{ Form::label('appat_representante_convenio','Apellido Paterno') }}
					{{ Form::text('appat_representante_convenio',Input::old('appat_representante_convenio'),['class' => 'form-control'])}}
					</div>
					<div class="col-md-4">
					{{ Form::label('apmat_representante_convenio','Apellido Materno') }}
					{{ Form::text('apmat_representante_convenio',Input::old('apmat_representante_convenio'),['class' => 'form-control'])}}
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-4">
					{{ Form::label('area_representante_convenio','Área') }}
					{{ Form::text('area_representante_convenio',Input::old('area_representante_convenio'),['class' => 'form-control'])}}
					</div>
					<div class="col-md-4">
					{{ Form::label('rol_representante_convenio','Rol') }}
					{{ Form::text('rol_representante_convenio',Input::old('rol_representante_convenio'),['class' => 'form-control'])}}
					</div>
					<div class="col-md-4">
						<a class="btn btn-primary btn-block" style="width:145px; margin-top:25px" onClick="agregarRepresentanteAsociado()">
						<span class="glyphicon glyphicon-plus"></span> Agregar</a>
					</div>				
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table" id="representante_asociado_table">
								<tr class="info">												
									<th class="text-nowrap ">Nombre</th>
									<th class="text-nowrap ">Área</th>												
									<th class="text-nowrap ">Rol</th>
									<th></th>											
								</tr>
								<?php 
									$representantes_nombre = Input::old('representantes_nombre');
									$representantes_appat =	Input::old('representantes_appat');
									$representantes_apmat = Input::old('representantes_apmat');
									$representantes_area = Input::old('representantes_area');
									$representantes_rol	= Input::old('representantes_rol');
									$count = count($representantes_nombre);	
								?>
								<?php for($i=0;$i<$count;$i++){ ?>							
								<tr>
									<td>{{ $representantes_appat[$i] }} .' '. {{ $representantes_apmat[$i] }} .', '.{{$representantes_nombre[$i]}} </td>			
									<td class="hide"><input style="border:0" name='representantes_nombre[]' value='{{ $representantes_nombre[$i] }}' readonly/></td>
									<td class="hide"><input style="border:0" name='representantes_appat[]' value='{{ $representantes_appat[$i] }}' readonly/></td>
									<td class="hide"><input style="border:0" name='representantes_apmat[]' value='{{ $representantes_apmat[$i] }}' readonly/></td>
									<td><input style="border:0" name='representantes_area[]' value='{{ $representantes_area[$i] }}' readonly/></td>											
									<td><input style="border:0" name='representantes_rol[]' value='{{ $representantes_rol[$i] }}' readonly/></td>
									<td><div class="btn btn-danger btn-block btn-sm" style="width:145px; float: right" onclick="deleteRow(event,this)"><span class="glyphicon glyphicon-trash" ></span> Eliminar</a></div></td>
								</tr>
								<?php } ?>						
							</table>				
						</div>
					</div>				
				</div>
			</div>
		</div>
		
		
		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">				
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block', 'style' => 'width:145px')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" style="width:145px" href="{{route('acuerdo_convenio.index')}}">Cancelar</a>				
			</div>
		</div>
		{{ Form::close() }}

	<script>
	$("#input-file").fileinput({
	    language: "es",
	    allowedFileExtensions: ["png","jpe","jpeg","jpg","gif","bmp","zip","rar","pdf","doc","docx","xls","xlsx","ppt","pptx"]
	});
	</script>
@stop