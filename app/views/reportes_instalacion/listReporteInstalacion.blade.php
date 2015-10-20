@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Reportes de Instalación</h3>
            <p class="text-right">{{ HTML::link('/rep_instalacion/create_rep_instalacion','+ Generar Reporte de Instalación',array('class'=>'')) }}</p>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
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
							{{ Form::label('search','Nombre de usuario solicitante') }}
							{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Usuario solicitante')) }}
						</div>
						<div class="form-group col-xs-8">
							{{ Form::label('search_proveedor','Proveedor:')}}
							{{ Form::select('search_proveedor',array('0' => 'Seleccione')+$proveedor, $search_proveedor,array('class'=>'form-control')) }}
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
							{{ Form::select('search_area',array('0' => 'Seleccione')+$areas, $search_area,array('class'=>'form-control')) }}
						</div>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
						</div>
					</div>
				</div>
			</div>	
			</div>
		</div>
	{{ Form::close() }}</br>

	
@stop