@extends('templates/reporteIncumplimientoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Reporte de Incumplimiento: {{$reporte_data->numero_reporte_abreviatura}}{{$reporte_data->numero_reporte_correlativo}}-{{$reporte_data->numero_reporte_anho}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('numero_ot') }}</strong></p>
			<p><strong>{{ $errors->first('tipo_reporte') }}</strong></p>
			<p><strong>{{ $errors->first('numero_doc1') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_reporte') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion_corta') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('servicio') }}</strong></p>
			<p><strong>{{ $errors->first('proveedor') }}</strong></p>
			<p><strong>{{ $errors->first('costo') }}</strong></p>
			<p><strong>{{ $errors->first('accion_generada') }}</strong></p>
			<p><strong>{{ $errors->first('reincidente') }}</strong></p>
			<p><strong>{{ $errors->first('resultados') }}</strong></p>
			<p><strong>{{ $errors->first('acciones') }}</strong></p>
			<p><strong>{{ $errors->first('numero_doc2') }}</strong></p>
			<p><strong>{{ $errors->first('numero_doc3') }}</strong></p>

		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('message') }}
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger"><strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}</strong>
		</div>
	@endif

	{{ Form::open(array('url'=>'reportes_incumplimiento/submit_edit_reporte', 'role'=>'form')) }}
		{{Form::hidden('reporte_id',$reporte_data->idreporte_incumplimiento) }}
		<div>						
			{{ Form::hidden('flag_ot',2,array('id'=>'flag_ot'))}}
			{{ Form::hidden('flag_doc',1,array('id'=>'flag_doc'))}}
			{{ Form::hidden('type_solicitud',1,array('id'=>'type_solicitud'))}}
		</div>
		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">
			@if(!$reporte_data->deleted_at)				
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit-edit', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
			@endif
			</div>
			<div class="form-group col-md-2">				
				<a class="btn btn-default btn-block" href="{{URL::to('/reportes_incumplimiento/list_reportes')}}">Cancelar</a>
			</div>
		</div>
		<div class="row">
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos</div>
			  	<div class="panel-body">	
					<div class="row">
						<div class="form-group col-md-4 @if($errors->first('codigo_reporte')) has-error has-feedback @endif">
							{{ Form::label('codigo_reporte','Código del reporte') }}<span style="color:red"> *</span>
							{{ Form::text('codigo_reporte',$reporte_data->numero_reporte_abreviatura.$reporte_data->numero_reporte_correlativo."-".$reporte_data->numero_reporte_anho,array('class'=>'form-control','readonly'=>'','placeholder'=>'Código de reporte')) }}						
						</div>								
						<div class="form-group col-md-4 @if($errors->first('numero_ot')) has-error has-feedback @endif">
							{{ Form::label('numero_ot','Número de OT') }}<span style="color:red"> *</span>
							@if($reporte_data->deleted_at)
								{{ Form::text('numero_ot',$reporte_data->codigo_ot,array('class'=>'form-control','readonly'=>'','placeholder'=>'Número de OTM')) }}
							@else
								@if($reporte_data->codigo_ot != null)
									{{ Form::text('numero_ot',$reporte_data->codigo_ot,array('class'=>'form-control','placeholder'=>'Número de OTM','readonly'=>'')) }}
								@else
									{{ Form::text('numero_ot',Input::old(numero_ot),array('class'=>'form-control','placeholder'=>'Número de OTM','readonly'=>'')) }}
								@endif
							@endif							
						</div>						
						<div class="col-md-2" style="margin-top:25px">
							<div class="btn btn-success btn-block" id="btnValidate"><span class="glyphicon glyphicon-ok"></span> Validar</div>
						</div>			
						<div class="form-group col-md-2" style="margin-top:25px">
							<div class="btn btn-default btn-block" onclick="clean_ot()"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
						</div>	
					</div>
					<div class="row">						
						<div class="form-group col-md-4 @if($errors->first('tipo_reporte')) has-error has-feedback @endif">
							{{ Form::label('tipo_reporte','Tipo') }}<span style="color:red"> *</span>
							@if($reporte_data->deleted_at)
								{{ Form::select('tipo_reporte',['0'=>'Seleccione','1'=>'Por Servicio','2'=>'Por Equipo'],$reporte_data->tipo_reporte,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::select('tipo_reporte',['0'=>'Seleccione','1'=>'Por Servicio','2'=>'Por Equipo'],$reporte_data->tipo_reporte,array('class'=>'form-control')) }}
							@endif							
						</div>		
						<div class="col-md-4">
							{{ Form::label('fecha','Fecha')}}<span style="color:red"> *</span>
							<div id="datetimepicker1" class="form-group input-group  @if($errors->first('fecha_reporte')) has-error has-feedback @endif">					
								{{ Form::text('fecha_reporte',date('d-m-Y',strtotime($reporte_data->fecha)),array('class'=>'form-control','readonly'=>'','type'=>'date')) }}
								<span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
				            </div>
				        </div>
		        	</div>
					<div class="row">
						<div class="form-group col-md-2 @if($errors->first('tipo_documento_identidad1')) has-error has-feedback @endif">
							{{ Form::label('tipo_documento_identidad1','Tipo de Documento') }}<span style="color:red">*</span>
							{{ Form::select('tipo_documento_identidad1', array('' => 'Seleccione') + $tipo_documento_identidad,$usuario_revision->idtipo_documento,['class' => 'form-control','readonly'=>'']) }}						
						</div>						
						<div class="form-group col-md-3 @if($errors->first('numero_doc1')) has-error has-feedback @endif">
							{{ Form::label('numero_doc1','Número Documento') }}<span style="color:red"> *</span>
							@if($reporte_data->deleted_at)
								{{ Form::text('numero_doc1',$usuario_revision->numero_doc_identidad,array('class'=>'form-control','readonly'=>'','id'=>'numero_doc1','placeholder'=>'Número de Doc.')) }}
							@else
								{{ Form::text('numero_doc1',$usuario_revision->numero_doc_identidad,array('class'=>'form-control','id'=>'numero_doc1','placeholder'=>'Número de Documento')) }}
							@endif							
						</div>
						<div class="form-group col-md-2" style="margin-top:25px">
							<a class="btn btn-primary btn-block" onclick="fill_name_responsable(1)">
							<span class="glyphicon glyphicon-plus"></span> Agregar</a>
						</div>
						<div class="form-group col-md-2" style="margin-top:25px">
							<div class="btn btn-default btn-block" onclick="clean_name_responsable(1)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
						</div>
						<div class="form-group col-md-3">
							{{ Form::label('responsable','Responsable de la Revisión') }}
							@if($reporte_data->deleted_at)
								{{ Form::text('responsable',$usuario_revision->nombre,array('class'=>'form-control','readonly'=>'','id'=>'nombre_responsable1','disabled'=>'disabled','placeholder'=>'Nombre de Usuario')) }}
							@else
								{{ Form::text('responsable',$usuario_revision->nombre,array('class'=>'form-control','id'=>'nombre_responsable1','disabled'=>'disabled','placeholder'=>'Nombre de Usuario')) }}
							@endif							
						</div>
					</div>
					
		        	<div class="row">		        		
						<div class="col-md-8 @if($errors->first('descripcion_corta')) has-error has-feedback @endif">
		        			{{ Form::label('descripcion_corta','Descripción Corta') }}<span style="color:red"> *</span>
							@if($reporte_data->deleted_at)
								{{ Form::text('descripcion_corta',$reporte_data->descripcion_corta,array('class'=>'form-control','readonly'=>'','placeholder'=>'Ingrese una descripción corta')) }}
							@else
								{{ Form::text('descripcion_corta',$reporte_data->descripcion_corta,array('class'=>'form-control','placeholder'=>'Ingrese una descripción corta')) }}
							@endif		        			
		        		</div>
		        	</div>
		        	<br>
		        	<div class="row">
						<div class="col-md-8 @if($errors->first('descripcion')) has-error has-feedback @endif">
			        		{{ Form::label('descripcion','Descripción del Servicio o Producto no conforme') }}<span style="color:red"> *</span>
							@if($reporte_data->deleted_at)
								{{ Form::textarea('descripcion',$reporte_data->descripcion_servicio,array('class'=>'form-control','readonly'=>'','style'=>'resize:none;','placeholder'=>'Ingrese descripción')) }}
							@else
								{{ Form::textarea('descripcion',$reporte_data->descripcion_servicio,array('class'=>'form-control','style'=>'resize:none;','placeholder'=>'Ingrese descripción')) }}
							@endif
		        		</div>
		        	</div>
		        	<br>
		        	<div class="row">
		        		<div class="form-group col-md-4 @if($errors->first('servicio')) has-error has-feedback @endif">
							{{ Form::label('servicio','Servicio Clínico') }}<span style="color:red"> *</span>
							@if($reporte_data->deleted_at)
								{{ Form::select('servicio',array('0'=> 'Seleccione')+$servicios,$reporte_data->idservicio,array('class'=>'form-control','readonly'=>'',"onchange" => "fill_responsable_servicio()",'id'=>'servicio')) }}
							@else
								{{ Form::select('servicio',array('0'=> 'Seleccione')+$servicios,$reporte_data->idservicio,array('class'=>'form-control',"onchange" => "fill_responsable_servicio()",'id'=>'servicio')) }}
							@endif
						</div>
						<div class="form-group col-md-4  @if($errors->first('responsable_servicio')) has-error has-feedback @endif">
							{{ Form::label('responsable_servicio','Responsable del Servicio') }}
							@if($reporte_data->deleted_at)
								{{ Form::text('responsable_servicio',Input::old('idresponsable'),array('class'=>'form-control','readonly'=>'','disabled'=>'disabled','id'=>'servicio_resp','placeholder'=>'Responsable del servicio')) }}
							@else
								{{ Form::text('responsable_servicio',Input::old('idresponsable'),array('class'=>'form-control','disabled'=>'disabled','id'=>'servicio_resp','placeholder'=>'Responsable del servicio')) }}
							@endif							
						</div>
		        	</div>
		        	<div class="row">
		        		<div class="form-group col-md-4 @if($errors->first('proveedor')) has-error has-feedback @endif">
							{{ Form::label('proveedor','Proveedor') }}<span style="color:red"> *</span>
							@if($reporte_data->deleted_at)
								{{ Form::select('proveedor',array('0'=> 'Seleccione')+$proveedor,$reporte_data->idproveedor,array('class'=>'form-control','readonly'=>'',"onchange" => "fill_contacto_proveedor()",'id'=>'proveedor')) }}
							@else
								{{ Form::select('proveedor',array('0'=> 'Seleccione')+$proveedor,$reporte_data->idproveedor,array('class'=>'form-control',"onchange" => "fill_contacto_proveedor()",'id'=>'proveedor')) }}
							@endif							
						</div>
						<div class="form-group col-md-4  @if($errors->first('contacto_proveedor')) has-error has-feedback @endif">
							{{ Form::label('contacto_proveedor','Contacto de Proveedor') }}
							@if($reporte_data->deleted_at)
								{{ Form::text('contacto_proveedor',Input::old('contacto_proveedor'),array('class'=>'form-control','readonly'=>'','id'=>'contacto_proveedor','disabled'=>'disabled','placeholder'=>'Contacto')) }}
							@else
								{{ Form::text('contacto_proveedor',Input::old('contacto_proveedor'),array('class'=>'form-control','id'=>'contacto_proveedor','disabled'=>'disabled','placeholder'=>'Contacto')) }}
							@endif
						</div>
		        	</div>
		        	<div class="row">
						<div class="col-md-4 form-group @if($errors->first('costo')) has-error has-feedback @endif">
			        		{{ Form::label('costo','Costos Generados') }}<span style="color:red"> *</span>
							@if($reporte_data->deleted_at)
								{{ Form::text('costo',$reporte_data->costo_generado,array('class'=>'form-control','readonly'=>'','placeholder'=>'Ingrese costo generado')) }}
							@else
								{{ Form::text('costo',$reporte_data->costo_generado,array('class'=>'form-control','placeholder'=>'Ingrese costo generado')) }}
							@endif
		        		</div>
						<div class="col-md-4 form-group @if($errors->first('accion_generada')) has-error has-feedback @endif">
			        		{{ Form::label('accion_generada','Acción Correctiva Generada') }}<span style="color:red"> *</span>
							@if($reporte_data->deleted_at)
								{{ Form::text('accion_generada',$reporte_data->accion_correctiva,array('class'=>'form-control','readonly'=>'','placeholder'=>'Ingrese acción generada')) }}
							@else
								{{ Form::text('accion_generada',$reporte_data->accion_correctiva,array('class'=>'form-control','placeholder'=>'Ingrese acción generada')) }}
							@endif
		        		</div>
		        	</div>
		        	<div class="row">
						<div class="col-md-8 @if($errors->first('reincidente')) has-error has-feedback @endif">
			        		{{ Form::label('reincidente','¿Es reincidente?') }}<span style="color:red"> *</span>
			        			@if($reporte_data->flag_reincidente == 1)
			        				{{ Form::radio('reincidente', '1',true) }}SI{{ Form::radio('reincidente', '0') }}NO
			        			@else
			        				{{ Form::radio('reincidente', '1') }}SI{{ Form::radio('reincidente', '0', true) }}NO
								@endif							
						</div> 
					</div>
					<div class="row">
						<div class="col-md-8 form-group @if($errors->first('acciones')) has-error has-feedback @endif">
			        		{{ Form::label('acciones','Acciones a seguir de acuerdo a la disposición determinada') }}<span style="color:red"> *</span>
							@if($reporte_data->deleted_at)
								{{ Form::textarea('acciones',$reporte_data->acciones,array('class'=>'form-control','readonly'=>'','style'=>'resize:none;','placeholder'=>'Ingrese acciones')) }}
							@else
								{{ Form::textarea('acciones',$reporte_data->acciones,array('class'=>'form-control','style'=>'resize:none;','placeholder'=>'Ingrese acciones')) }}
							@endif
		        		</div>
		        	</div>
		        	<br>
		        	<div class="row">
						<div class="col-md-8 form-group @if($errors->first('resultados')) has-error has-feedback @endif">
			        		{{ Form::label('resultados','Resultados / Conclusiones con respecto al servicio') }}<span style="color:red"> *</span>
							@if($reporte_data->deleted_at)
								{{ Form::textarea('resultados',$reporte_data->resultados,array('class'=>'form-control','readonly'=>'','style'=>'resize:none;','placeholder'=>'Ingrese resultados')) }}
							@else
								{{ Form::textarea('resultados',$reporte_data->resultados,array('class'=>'form-control','style'=>'resize:none;','placeholder'=>'Ingrese resultados')) }}
							@endif
		        		</div>
		        	</div>
		        	<div class="row">
		        		<div class="form-group col-md-2 @if($errors->first('tipo_documento_identidad2')) has-error has-feedback @endif">
							{{ Form::label('tipo_documento_identidad2','Tipo de Documento') }}<span style="color:red">*</span>
							{{ Form::select('tipo_documento_identidad2', array('' => 'Seleccione') + $tipo_documento_identidad,$usuario_autorizado->idtipo_documento,['class' => 'form-control','readonly'=>'']) }}						
						</div>	
						<div class="form-group col-md-3 @if($errors->first('numero_doc2')) has-error has-feedback @endif">
							{{ Form::label('numero_doc2','Documento de Identidad') }}<span style="color:red"> *</span>
							@if($reporte_data->deleted_at)
								{{ Form::text('numero_doc2',$usuario_autorizado->numero_doc_identidad,array('class'=>'form-control','readonly'=>'','id'=>'numero_doc2','placeholder'=>'Número de Doc.')) }}
							@else
								{{ Form::text('numero_doc2',$usuario_autorizado->numero_doc_identidad,array('class'=>'form-control','id'=>'numero_doc2','placeholder'=>'Número de Documento')) }}
							@endif	
						</div>
						<div class="form-group col-md-2" style="margin-top:25px">
							<a class="btn btn-primary btn-block" onclick="fill_name_responsable(2)">
							<span class="glyphicon glyphicon-plus"></span> Agregar</a>
						</div>
						<div class="form-group col-md-2" style="margin-top:25px">
							<div class="btn btn-default btn-block" onclick="clean_name_responsable(2)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
						</div>
						<div class="form-group col-md-3">
							{{ Form::label('autorizado','Autorizado por') }}
							@if($reporte_data->deleted_at)
								{{ Form::text('autorizado',$usuario_autorizado->nombre,array('class'=>'form-control','readonly'=>'','id'=>'nombre_responsable2','disabled'=>'disabled','placeholder'=>'Nombre de Usuario')) }}
							@else
								{{ Form::text('autorizado',$usuario_autorizado->nombre,array('class'=>'form-control','id'=>'nombre_responsable2','disabled'=>'disabled','placeholder'=>'Nombre de Usuario')) }}
							@endif
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-2 @if($errors->first('tipo_documento_identidad3')) has-error has-feedback @endif">
							{{ Form::label('tipo_documento_identidad3','Tipo de Documento') }}<span style="color:red">*</span>
							{{ Form::select('tipo_documento_identidad3', array('' => 'Seleccione') + $tipo_documento_identidad,$usuario_elaborado->idtipo_documento,['class' => 'form-control','readonly'=>'']) }}						
						</div>
						<div class="form-group col-md-3 @if($errors->first('numero_doc3')) has-error has-feedback @endif">
							{{ Form::label('numero_doc3','Documento de Identidad') }}<span style="color:red"> *</span>
							@if($reporte_data->deleted_at)
								{{ Form::text('numero_doc3',$usuario_elaborado->numero_doc_identidad,array('class'=>'form-control','readonly'=>'','id'=>'numero_doc3','placeholder'=>'Número de Doc.')) }}
							@else
								{{ Form::text('numero_doc3',$usuario_elaborado->numero_doc_identidad,array('class'=>'form-control','id'=>'numero_doc3','placeholder'=>'Número de Documento')) }}
							@endif

						</div>
						<div class="form-group col-md-2" style="margin-top:25px">
							<a class="btn btn-primary btn-block" onclick="fill_name_responsable(3)">
							<span class="glyphicon glyphicon-plus"></span> Agregar</a>
						</div>
						<div class="form-group col-md-2" style="margin-top:25px">
							<div class="btn btn-default btn-block" onclick="clean_name_responsable(3)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
						</div>
						<div class="form-group col-md-3">
							{{ Form::label('elaborado','Elaborado por') }}
							@if($reporte_data->deleted_at)
								{{ Form::text('elaborado',$usuario_elaborado->nombre,array('class'=>'form-control','readonly'=>'','id'=>'nombre_responsable3','disabled'=>'disabled','placeholder'=>'Nombre de Usuario')) }}
							@else
								{{ Form::text('elaborado',$usuario_elaborado->nombre,array('class'=>'form-control','id'=>'nombre_responsable3','disabled'=>'disabled','placeholder'=>'Nombre de Usuario')) }}
							@endif
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
				  				<div class="panel-heading">Documento Relacionado</div>
				  				<div class="panel-body">
									<div class="row">											
										<div class="form-group col-md-2 @if($errors->first('numero_contrato')) has-error has-feedback @endif">
											{{ Form::label('numero_contrato','Cód. Archivamiento') }}<span style="color:red">*</span>
											@if($reporte_data->deleted_at)
												{{ Form::text('numero_contrato',$documento_info->codigo_archivamiento,array('class'=>'form-control','readonly'=>'','id'=>'numero_contrato','placeholder'=>'Código')) }}
											@else
												{{ Form::text('numero_contrato',$documento_info->codigo_archivamiento,array('class'=>'form-control','id'=>'numero_contrato','placeholder'=>'Código','readonly'=>'')) }}
											@endif								
										</div>
										<div class="col-md-2" style="margin-top:25px">
											<a class="btn btn-primary btn-block" id="btnAddDoc">
											<span class="glyphicon glyphicon-plus"></span> Agregar</a>
										</div>
										<div class="col-md-2" style="margin-top:25px">
											<div class="btn btn-default btn-block" onclick="clean_name_contrato()"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>
										</div>
										<div class="form-group col-md-4">
											{{ Form::label('nombre_contrato','Contrato del Proveedor') }}
											{{ Form::text('nombre_contrato',$documento_info->nombre,['class' => 'form-control','id'=>'nombre_contrato','disabled'=>'disabled','placeholder'=>'Nombre del Doc.'])}}
										</div>	
										{{ Form::close()}}									
										<div class="form-group col-md-2">
											{{ Form::open(array('url'=>'reportes_incumplimiento/download_contrato', 'role'=>'form')) }}
											{{ Form::hidden('numero_contrato_hidden',null)}}
											{{ Form::button('<span class="glyphicon glyphicon-download"></span> Descargar', array('id'=>'btn_descarga', 'type' => 'submit', 'class' => 'btn btn-primary btn-block','style'=>'margin-top:25px')) }}
											{{ Form::close() }}
										</div>
									
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						@if($reporte_data->deleted_at)
						{{ Form::open(array('url'=>'reportes_incumplimiento/submit_enable_reporte', 'role'=>'form','id'=>'submitState')) }}
							{{ Form::hidden('reporte_id', $reporte_data->idreporte_incumplimiento) }}
							<div class="col-md-6">
								<div class="row">
									<div class="form-group col-md-6">
										{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-up"></span> Habilitar', array('id'=>'submit-delete', 'class' => 'btn btn-success btn-block')) }}
									</div>
								</div>	
							</div>	
						{{ Form::close() }}
						@else
						{{ Form::open(array('url'=>'reportes_incumplimiento/submit_disable_reporte', 'role'=>'form','id'=>'submitState')) }}
							{{ Form::hidden('reporte_id', $reporte_data->idreporte_incumplimiento) }}
							<div class="col-md-6">
								<div class="row">
									<div class="form-group col-md-6">
										{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-down"></span> Inhabilitar', array('id'=>'submit-delete', 'class' => 'btn btn-danger btn-block')) }}
									</div>
								</div>	
							</div>	
						{{ Form::close() }}
						@endif
					</div>					
				</div>			
			</div>
		</div>	
@stop