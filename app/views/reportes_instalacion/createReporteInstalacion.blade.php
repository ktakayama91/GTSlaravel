@extends('templates/reporteInstalacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Reporte de Instalación</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>    

    @if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('idtipo_reporte_instalacion') }}</strong></p>
			<p><strong>{{ $errors->first('codigo_compra') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('idproveedor') }}</strong></p>
			<p><strong>{{ $errors->first('idarea') }}</strong></p>
			<p><strong>{{ $errors->first('fecha') }}</strong></p>
			<p><strong>{{ $errors->first('numero_documento1') }}</strong></p>
			<p><strong>{{ $errors->first('num_doc_relacionado1') }}</strong></p>
			<p><strong>{{ $errors->first('num_doc_relacionado2') }}</strong></p>
			<p><strong>{{ $errors->first('num_doc_relacionado3') }}</strong></p>
			<p><strong>{{ $errors->first('num_doc_relacionado4') }}</strong></p>
			<p><strong>{{ $errors->first('numero_reporte_entorno_concluido') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('message') }}
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>{{ Session::get('error') }}</strong>
		</div>
	@endif  

    {{ Form::open(array('url'=>'/rep_instalacion/submit_create_rep_instalacion','role'=>'form')) }}
		<div>
			{{ Form::hidden('flag_doc1',0,array('id'=>'flag_doc1'))}}
			{{ Form::hidden('flag_doc2',0,array('id'=>'flag_doc2'))}}
			{{ Form::hidden('flag_doc3',0,array('id'=>'flag_doc3'))}}
			{{ Form::hidden('flag_doc4',0,array('id'=>'flag_doc4'))}}
			{{ Form::hidden('type_submit',0,array('id'=>'type_submit'))}}
		</div>
		{{Form::hidden('type_report',0,array('class'=>'form-control','id'=>'type_report'))}}
		<div class="panel panel-default">
		  	<div class="panel-heading">
		    	<h3 class="panel-title">Datos Generales</h3>
		  	</div>
  			<div class="panel-body">
				<div class="col-md-12">
					<div class="form group row">
						<div class="form-group col-md-4 @if($errors->first('idtipo_reporte_instalacion')) has-error has-feedback @endif">
							{{ Form::label('idtipo_reporte_instalacion','Tipo de Reporte de Instalación') }}
							@if($reporte_instalacion_info)
								{{ Form::select('idtipo_reporte_instalacion',array('' => 'Seleccione') + $tipos_reporte_instalacion,2,['class' => 'form-control','readonly'=>'']) }}
							@else
								{{ Form::select('idtipo_reporte_instalacion',array('' => 'Seleccione') + $tipos_reporte_instalacion,Input::old('idtipo_reporte_instalacion'),['class' => 'form-control']) }}
							@endif
						</div>
					</div>
					<div class="form group row">
						<div class="form-group col-md-4 @if($errors->first('codigo_compra')) has-error has-feedback @endif">
							{{ Form::label('codigo_compra','Código de Compra') }}
							@if($reporte_instalacion_info)
								{{ Form::text('codigo_compra',$reporte_instalacion_info->codigo_compra,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('codigo_compra',Input::old('codigo_compra'),array('class'=>'form-control')) }}
							@endif
						</div>			
						<div class="form-group col-md-4 @if($errors->first('idarea')) has-error has-feedback @endif">
							{{ Form::label('idarea','Departamento') }}
							@if($reporte_instalacion_info)
								{{ Form::select('idarea',array('' => 'Seleccione') + $areas,$reporte_instalacion_info->idarea,['class' => 'form-control','readonly'=>'']) }}
							@else
								{{ Form::select('idarea',array('' => 'Seleccione') + $areas,Input::old('idarea'),['class' => 'form-control']) }}
							@endif
						</div>
					</div>
					<div class="form group row">
						<div class="form-group col-md-4 @if($errors->first('idproveedor')) has-error has-feedback @endif">
							{{ Form::label('idproveedor','Proveedor') }}
							@if($reporte_instalacion_info)
								{{ Form::select('idproveedor',array('' => 'Seleccione') + $proveedores,$reporte_instalacion_info->idproveedor,['class' => 'form-control','readonly'=>'']) }}
							@else
								{{ Form::select('idproveedor',array('' => 'Seleccione') + $proveedores,Input::old('idproveedor'),['class' => 'form-control']) }}
							@endif						
						</div>
						<div class="col-md-4">
							{{ Form::label('fecha','Fecha') }}
							<div id="datetimepicker1" class="form-group input-group date @if($errors->first('fecha')) has-error has-feedback @endif">
								{{ Form::text('fecha',Input::old('fecha'),array('class'=>'form-control', 'readonly'=>'')) }}
								<span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
							</div>
						</div>
					</div>
					<div class="form group row">
						<div class="form-group col-md-8 @if($errors->first('descripcion')) has-error has-feedback @endif">
							{{ Form::label('descripcion','Descripción') }}
							{{ Form::textarea('descripcion',Input::old('descripcion'),['class' => 'form-control','style'=>'resize:none;'])}}
						</div>
					</div>
				</div>	
			</div>
		</div>

		<div class="panel panel-default">
		  	<div class="panel-heading">
		    	<h3 class="panel-title">Detalle de Tarea</h3>
		  	</div>
  			<div class="panel-body">
  				<div class="row">
	  				<div class="col-md-6 form-group">
						{{ Form::label('nombre_tarea','Nombre de Tarea') }}
						{{ Form::text('nombre_tarea',Input::old('nombre_tarea'),array('class'=>'form-control','maxlength'=>'100','placeholder'=>'Nombre de Tarea')) }}
					</div>
					<div class="col-md-2 form-group">
						{{ Form::label('tarea_realizada','Estado de Tarea') }}
						{{ Form::select('tarea_realizada',array('1' => 'Realizado','0' => 'No Realizado'),Input::old('tarea_realizada'),['class' => 'form-control']) }}		
					</div>
					<div class="col-md-2 form-group" style="margin-top:25px;">
							<div class="btn btn-primary btn-block" id="btnAgregarFila"><span class="glyphicon glyphicon-plus"></span>Agregar</div>				
					</div>
					<div class="col-md-2 form-group" style="margin-top:25px;">
							<div class="btn btn-default btn-block" id="btnLimpiarFila"><span class="glyphicon glyphicon-refresh"></span>Limpiar</div>				
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
			  				<table class="table">
								<tr class="info">
									<th class="text-nowrap text-center">Tarea</th>
									<th class="text-nowrap text-center">Estado de Tarea</th>
									<th class="text-nowrap text-center">Eliminar</th>
								</tr>		
								<?php 
									$details_tarea = Input::old('details_tarea');
									$details_estado = Input::old('details_estado');
									$count = count($details_tarea);	
								?>	
								<?php for($i=0;$i<$count;$i++){ ?>
								<tr>
									<td>
										<input style="border:0" name='details_tarea[]' value='{{ $details_tarea[$i] }}' readonly/>
									</td>
									<td>
										<input style="border:0" name='details_estado[]' value='{{ $details_estado[$i] }}' readonly/>
									</td>
									<td>
										<a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a>
									</td>						
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
		    	<h3 class="panel-title">Datos de personal que da conformidad</h3>
		  	</div>
  			<div class="panel-body">
  				<div class="row">
  					<div class="form-group col-md-2 @if($errors->first('tipo_documento_identidad1')) has-error has-feedback @endif">
						{{ Form::label('tipo_documento_identidad1','Tipo de Documento') }}<span style="color:red">*</span>
						{{ Form::select('tipo_documento_identidad1', array('' => 'Seleccione') + $tipo_documento_identidad,Input::old('tipo_documento_identidad1'),['class' => 'form-control']) }}						
					</div>
					<div class="form-group col-md-2 @if($errors->first('numero_documento1')) has-error has-feedback @endif">
						{{ Form::label('numero_documento1','Número Documento') }}
						{{ Form::text('numero_documento1',Input::old('numero_documento1'),['class' => 'form-control','id'=>'numero_documento1'])}}
					</div>
					<div class="form-group col-md-2" style="margin-top:25px">
						<a class="btn btn-primary btn-block" onclick="llenar_nombre_responsable(1)"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
					</div>
					<div class="form-group col-md-2" style="margin-top:25px">
						<a class="btn btn-default btn-block" onclick="limpiar_nombre_responsable(1)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
					<div class="form-group col-md-4" >
						{{ Form::label('responsable','Responsable de la Revisión') }}
						{{ Form::text('responsable',Input::old('responsable'),['class' => 'form-control','id'=>'nombre_responsable1','disabled'=>'disabled'])}}
					</div>
				</div>
  			</div>
  		</div>
  		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default" id="panel-documentos-relacionados" hidden>
	  				<div class="panel-heading">Documentos Relacionados</div>
	  				<div class="panel-body">
						<div class="row">
							<div class="form-group col-md-3 @if($errors->first('numero_reporte_entorno_concluido')) has-error has-feedback @endif">
								{{ Form::label('numero_reporte_entorno_concluido','N° Rep. Entorno Concluido') }}
								@if($reporte_instalacion_info)
									{{ Form::text('numero_reporte_entorno_concluido',$reporte_instalacion_info->numero_reporte_abreviatura.$reporte_instalacion_info->numero_reporte_correlativo."-".$reporte_instalacion_info->numero_reporte_anho,['readonly'=>'','class' => 'form-control','id'=>'numero_reporte_entorno_concluido'])}}
								@else
									{{ Form::text('numero_reporte_entorno_concluido',Input::old('numero_reporte_entorno_concluido'),['class' => 'form-control','id'=>'numero_reporte_entorno_concluido'])}}
								@endif
							</div>
							<div class="form-group col-md-2" style="margin-top:25px">
								@if($reporte_instalacion_info)
									<a class="btn btn-primary btn-block disabled" onclick="validar_num_rep_entorno_concluido()"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
								@else
									<a class="btn btn-primary btn-block" onclick="validar_num_rep_entorno_concluido()"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
								@endif
							</div>
							<div class="form-group col-md-2" style="margin-top:25px; margin-left:15px">
								@if($reporte_instalacion_info)
									<a class="btn btn-default btn-block disabled" onclick="limpiar_num_rep_entorno_concluido()"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
								@else
									<a class="btn btn-default btn-block" onclick="limpiar_num_rep_entorno_concluido()"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
								@endif
							</div>
							<div class="form-group col-md-4"  style="margin-left:15px">
								{{ Form::label('mensaje_validacion','Validación') }}
								{{ Form::text('mensaje_validacion',Input::old('mensaje_validacion'),['class' => 'form-control','id'=>'mensaje_validacion','disabled'=>'disabled'])}}
							</div>							
						</div>
						<div class="row">
							<div class="form-group col-md-3 @if($errors->first('num_doc_relacionado1')) has-error has-feedback @endif">
								{{ Form::label('num_doc_relacionado1','Cód. Archivamiento') }}
								{{ Form::text('num_doc_relacionado1',Input::old('num_doc_relacionado1'),['class' => 'form-control','id'=>'num_doc_relacionado1'])}}
							</div>
							<div class="form-group col-md-2" style="margin-top:25px">
								<a class="btn btn-primary btn-block" onclick="llenar_nombre_doc_relacionado(1)"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
							</div>
							<div class="form-group col-md-2" style="margin-top:25px; margin-left:15px">
								<a class="btn btn-default btn-block" onclick="limpiar_nombre_doc_relacionado(1)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
							</div>
							<div class="form-group col-md-4"  style="margin-left:15px">
								{{ Form::label('nombre_doc_relacionado1','Cert. de Funcionalidad') }}
								{{ Form::text('nombre_doc_relacionado1',Input::old('nombre_doc_relacionado1'),['class' => 'form-control','id'=>'nombre_doc_relacionado1','disabled'=>'disabled'])}}
							</div>							
						</div>
						<div class="row">
							<div class="form-group col-md-3 @if($errors->first('num_doc_relacionado2')) has-error has-feedback @endif">
								{{ Form::label('num_doc_relacionado2','Cód. Archivamiento') }}
								{{ Form::text('num_doc_relacionado2',Input::old('num_doc_relacionado2'),['class' => 'form-control','id'=>'num_doc_relacionado2'])}}
							</div>
							<div class="form-group col-md-2" style="margin-top:25px">
								<a class="btn btn-primary btn-block" onclick="llenar_nombre_doc_relacionado(2)"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
							</div>
							<div class="form-group col-md-2" style="margin-top:25px; margin-left:15px">
								<a class="btn btn-default btn-block" onclick="limpiar_nombre_doc_relacionado(2)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
							</div>
							<div class="form-group col-md-4"  style="margin-left:15px">
								{{ Form::label('nombre_doc_relacionado2','Contrato') }}
								{{ Form::text('nombre_doc_relacionado2',Input::old('nombre_doc_relacionado2'),['class' => 'form-control','id'=>'nombre_doc_relacionado2','disabled'=>'disabled'])}}
							</div>						
						</div>
						<div class="row">
							<div class="form-group col-md-3 @if($errors->first('num_doc_relacionado3')) has-error has-feedback @endif">
								{{ Form::label('num_doc_relacionado3','Cód. Archivamiento') }}
								{{ Form::text('num_doc_relacionado3',Input::old('num_doc_relacionado3'),['class' => 'form-control','id'=>'num_doc_relacionado3'])}}
							</div>
							<div class="form-group col-md-2" style="margin-top:25px">
								<a class="btn btn-primary btn-block" onclick="llenar_nombre_doc_relacionado(3)"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
							</div>
							<div class="form-group col-md-2" style="margin-top:25px; margin-left:15px">
								<a class="btn btn-default btn-block" onclick="limpiar_nombre_doc_relacionado(3)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
							</div>
							<div class="form-group col-md-4"  style="margin-left:15px">
								{{ Form::label('nombre_doc_relacionado3','Manual') }}
								{{ Form::text('nombre_doc_relacionado3',Input::old('nombre_doc_relacionado3'),['class' => 'form-control','id'=>'nombre_doc_relacionado3','disabled'=>'disabled'])}}
							</div>	
						</div>
						<div class="row">
							<div class="form-group col-md-3 @if($errors->first('num_doc_relacionado4')) has-error has-feedback @endif">
								{{ Form::label('num_doc_relacionado4','Cód. Archivamiento') }}
								{{ Form::text('num_doc_relacionado4',Input::old('num_doc_relacionado4'),['class' => 'form-control','id'=>'num_doc_relacionado4'])}}
							</div>
							<div class="form-group col-md-2" style="margin-top:25px">
								<a class="btn btn-primary btn-block" onclick="llenar_nombre_doc_relacionado(4)"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
							</div>
							<div class="form-group col-md-2" style="margin-top:25px; margin-left:15px">
								<a class="btn btn-default btn-block" onclick="limpiar_nombre_doc_relacionado(4)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
							</div>
							<div class="form-group col-md-4"  style="margin-left:15px">
								{{ Form::label('nombre_doc_relacionado4','Término de Referencia') }}
								{{ Form::text('nombre_doc_relacionado4',Input::old('nombre_doc_relacionado4'),['class' => 'form-control','id'=>'nombre_doc_relacionado4','disabled'=>'disabled'])}}
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear',array('id'=>'submit-edit','type' => 'submit', 'class'=>'btn btn-primary btn-block')) }}	
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/rep_instalacion/list_rep_instalacion')}}">Cancelar</a>				
			</div>
		</div>	
	{{ Form::close() }}</br>

	
@stop