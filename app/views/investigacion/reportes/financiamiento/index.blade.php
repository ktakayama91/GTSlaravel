@extends('templates/investigacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Busqueda de Reporte que certifica la problemática e identificación de financiamiento</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

{{ Form::open(array('route'=>'reporte_financiamiento.search','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Búsqueda</h3>
	  </div>
	  <div class="panel-body">
	    <div class="form-group row">
			<div class="col-xs-4">
				{{ Form::label('search_nombre','Nombre') }}
				{{ Form::text('search_nombre',$search_nombre,array('class'=>'form-control','placeholder'=>'Nombre')) }}
			</div>
			<div class="col-xs-4">
				{{ Form::label('search_categoria','Categoría') }}
				{{ Form::text('search_categoria',$search_categoria,array('class'=>'form-control','placeholder'=>'Categoría')) }}
			</div>
			<div class="col-xs-4">
				{{ Form::label('search_servicio_clinico','Servicio Clínico') }}
				{{ Form::select('search_servicio_clinico',[0=>"Seleccione"]+$servicios,$search_servicio_clinico,array('class'=>'form-control','placeholder'=>'Servicio Clínico')) }}
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4">
				{{ Form::label('search_departamento','Departamento') }}
				{{ Form::select('search_departamento',[0=>"Seleccione"]+$departamentos,$search_departamento,array('class'=>'form-control','placeholder'=>'Departamento')) }}
			</div>
			<div class="col-xs-4">
				{{ Form::label('search_responsable','Responsable') }}
				{{ Form::text('search_responsable',$search_responsable,array('class'=>'form-control','placeholder'=>'Responsable')) }}
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-2 col-md-offset-8">
				{{ Form::button('<span class="glyphicon glyphicon-search"></span> Filtrar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}				
			</div>
			<div class="form-group col-md-2">
				<div class="btn btn-default btn-block" id="btnLimpiar" onclick="limpiar_criterios_ins_serv()">Limpiar</div>				
			</div>
		</div>
	  </div>
	</div>
	{{ Form::close() }}</br>

	<div class="container-fluid form-group row">
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" href="{{route('reporte_financiamiento.create')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<tr class="info">
					<th>N° de reporte</th>
					<th>Nombre</th>
					<th>Categoría</th>
					<th>Servicio Clínico</th>
					<th>Departamento</th>
					<th>Responsable</th>					
				</tr>
				@foreach($reportes_data as $reporte_data)
				<tr class="@if($reporte_data->deleted_at) bg-danger @endif">
					<td>{{$reporte_data->id}}</td>
					<td>
						<a href="{{URL::to('/plantillas_servicios/show_servicio/')}}/{{$reporte_data->idfamilia_activo}}">{{$reporte_data->nombre}}</a>
					</td>
					<td>{{$reporte_data->id_categoria}}</td>
					<td>{{$reporte_data->servicio->nombre}}</td>
					<td>{{$reporte_data->departamento->nombre}}</td>
					<td>{{$reporte_data->responsable->nombre}} {{$reporte_data->responsable->apellido_pat}}</td>			
				</tr>
				@endforeach
			</table>
		</div>
		<div class="col-md-12">
		@if($search_nombre!=0)
			{{ $reportes_data->appends(array('search_nombre' => $search_nombre))->links() }}
		@else
			{{ $reportes_data->links() }}
		@endif
		</div>
	</div>
@stop