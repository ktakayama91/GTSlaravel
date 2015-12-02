@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Reportes de Instalación</h3>            
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	<div class="container-fluid form-group row">
		<div class="col-md-4 col-md-offset-8">
			<a class="btn btn-primary btn-block" href="{{URL::to('/rep_instalacion/create_rep_instalacion')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar Reporte de Instalación</a>
		</div>
	</div>
    {{ Form::open(array('url'=>'/rep_instalacion/search_rep_instalacion','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
			<div class="search_bar">
				<div class="col-xs-6">
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('search_usuario_responsable','Nombre de usuario solicitante') }}
							{{ Form::text('search_usuario_responsable',$search_usuario_responsable,array('class'=>'form-control','placeholder'=>'Usuario solicitante')) }}
						</div>
						<div class="form-group col-xs-8">
							{{ Form::label('search_proveedor','Proveedor:')}}
							{{ Form::select('search_proveedor',array('' => 'Seleccione')+$proveedor, $search_proveedor,array('class'=>'form-control')) }}
						</div>
					</div>
				</div>
				<div class="col-xs-6">
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('search_codigo_compra','Código de Compra') }}
							{{ Form::text('search_codigo_compra',$search_codigo_compra,array('class'=>'form-control','placeholder'=>'Código de Compra')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('search_area','Departamento:')}}
							{{ Form::select('search_area',array('' => 'Seleccione')+$areas, $search_area,array('class'=>'form-control')) }}
						</div>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="row">
						<div class="form-group col-md-2 col-md-offset-8">
							{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}	
						</div>
					</div>
				</div>
			</div>	
			</div>
		</div>
	{{ Form::close() }}</br>

	<table class="table">
		<tr class="info">
			<th>Código de Compra</th>
			<th>Personal de Revisión</th>
			<th>Proveedor</th>
			<th>Departamento</th>
			<th>Rep. Entorno Concluido</th>
			<th>Rep. Equipo Funcional</th>
		</tr>
		@foreach($reportes_instalacion_data as $reporte_instalacion_data)
		<tr class="@if($reporte_instalacion_data->deleted_at) bg-danger @endif">
			<td>
				{{$reporte_instalacion_data->codigo_compra}}</a>
			</td>
			<td>
				{{$reporte_instalacion_data->nombre_responsable}}
			</td>
			<td>
				{{$reporte_instalacion_data->nombre_proveedor}}
			</td>
			<td>
				{{$reporte_instalacion_data->nombre_area}}
			</td>
			<td>
				<a href="{{URL::to('/rep_instalacion/edit_rep_instalacion/')}}/{{$reporte_instalacion_data->idrep_ent_conc}}">{{$reporte_instalacion_data->rep_entorno_concluido}}</a>
			</td>
			@if($reporte_instalacion_data->rep_equipo_funcional != '')
				<td>
					<a href="{{URL::to('/rep_instalacion/edit_rep_instalacion/')}}/{{$reporte_instalacion_data->idrep_eq_func}}">{{$reporte_instalacion_data->rep_equipo_funcional}}</a>
				</td>	
			@else	
				<td>
					<a class="btn btn-primary btn-block btn-sm" href="{{URL::to('/rep_instalacion/create_rep_instalacion/')}}/{{$reporte_instalacion_data->idrep_ent_conc}}">
						<span class="glyphicon glyphicon-plus"></span> Crear</a>
				</td>
			@endif			
		</tr>
		@endforeach
	</table>
@stop