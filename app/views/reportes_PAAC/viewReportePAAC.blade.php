@extends('templates/planeamientoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información del Reporte: {{$reporte_paac_info->numero_reporte_abreviatura}}{{$reporte_paac_info->numero_reporte_correlativo}}-{{$reporte_paac_info->numero_reporte_anho}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('idtipo_reporte') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'', 'role'=>'form', 'files'=>true)) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del Reporte</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idtipo_reporte')) has-error has-feedback @endif">
						{{ Form::label('idtipo_reporte','Tipo de Reporte') }}
						{{ Form::select('idtipo_reporte',array(''=>'Seleccione') + $tipo_reporte_paac,$programacion_reporte_paac_info->idtipo_reporte_PAAC,['class' => 'form-control','disabled'=>'disabled']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idservicio')) has-error has-feedback @endif">
						{{ Form::label('idservicio','Servicio') }}
						{{ Form::select('idservicio',array(''=>'Seleccione') + $servicios,$programacion_reporte_paac_info->idservicio,['class' => 'form-control','disabled'=>'disabled']) }}
					</div><div class="form-group col-md-4 @if($errors->first('idarea_select')) has-error has-feedback @endif">
						{{ Form::label('idarea_select','Departamento') }}
						{{ Form::select('idarea_select',array(''=>'Seleccione') + $areas,$programacion_reporte_paac_info->idarea,['class' => 'form-control','disabled'=>'disabled']) }}
						{{ Form::hidden('idarea')}}
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default" id="panel-documentos-relacionados">
	  				<div class="panel-heading">Documento Relacionado</div>
	  				<div class="panel-body">
						<div class="row">
							<div class="form-group col-md-4">
								{{ Form::label('nombre_doc_relacionado','Nombre de Documento') }}
								{{ Form::text('nombre_doc_relacionado',$reporte_paac_info->nombre_archivo,['class' => 'form-control','id'=>'nombre_doc_relacionado','disabled'=>'disabled'])}}
							</div>	
							@if($reporte_paac_info->deleted_at)
								<div class="form-group col-md-2" style="margin-top:25px">
									<a class="btn btn-primary btn-block" href="{{URL::to('/reporte_paac/download_documento/')}}/{{$reporte_paac_info->idreporte_PAAC}}" disabled><span class="glyphicon glyphicon-download"></span> Descargar</a>
								</div>
							@else
								<div class="form-group col-md-2" style="margin-top:25px">
									<a class="btn btn-primary btn-block" href="{{URL::to('/reporte_paac/download_documento/')}}/{{$reporte_paac_info->idreporte_PAAC}}"><span class="glyphicon glyphicon-download"></span> Descargar</a>
								</div>
							@endif						
						</div>
					</div>
				</div>
			</div>
		</div>	
	{{ Form::close() }}
		<div class="row">
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/reporte_paac/list_reporte_paac/')}}">Regresar</a>				
			</div>
		</div>	
@stop