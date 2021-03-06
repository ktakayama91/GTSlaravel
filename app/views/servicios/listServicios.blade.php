@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Servicios</h3>
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

    {{ Form::open(array('url'=>'/servicios/search_servicio','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	<div class="panel panel-default">
		<div class="panel-heading">
	    	<h3 class="panel-title">Búsqueda</h3>
	  	</div>
	 	<div class="panel-body">
		 	<div class="row">
				<div class="col-md-4 form-group">
					{{ Form::label('search','Nombre de Servicio:')}}
					{{ Form::text('search',$search,['class' => 'form-control','placeholder'=>'Ingrese búsqueda','id'=>'search']) }}
				</div>
				<div class="col-md-4 form-group">
					{{ Form::label('search_area','Área')}}
					{{ Form::select('search_area',array('0'=>'Seleccione')+$areas,$search_area,['class' => 'form-control','placeholder'=>'Ingrese búsqueda']) }}
				</div>
				<div class="col-md-2 form-group" style="margin-top:25px">
					{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar',array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
				</div>
				<div class="form-group col-md-2">
					<div class="btn btn-default btn-block" id="list_servicios_btnLimpiar" style="margin-top:25px;">Limpiar</div>				
				</div>	
			</div>
		</div>
	</div>
	{{ Form::close() }}
	<div class="container-fluid form-group row">
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" href="{{URL::to('/servicios/create_servicio')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>
 
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th class="text-nowrap text-center">N°</th>
						<th class="text-nowrap text-center">Nombre del Servicio</th>
						<th class="text-nowrap text-center">Area</th>
						<th class="text-nowrap text-center">Tipo de Servicio</th>
						<th class="text-nowrap text-center">Fecha de Creación</th>
						<th class="text-nowrap text-center">Editar</th>
					</tr>
					@foreach($servicios_data as $index => $servicio_data)
					<tr class="@if($servicio_data->deleted_at) bg-danger @endif">			
						<td class="text-nowrap text-center">
							{{$index+1}}
						</td>
						<td>
							{{$servicio_data->nombre}}
						</td>
						<td>
							{{$servicio_data->nombre_area}}
						</td>
						<td class="text-nowrap text-center">
							{{$servicio_data->nombre_tipo_servicio}}
						</td>
						<td class="text-nowrap text-center">
							{{$servicio_data->created_at->format('d-m-Y')}}
						</td>
						<td class="text-nowrap text-center">
							<a class="btn btn-warning btn-block btn-sm" href="{{URL::to('/servicios/edit_servicio/')}}/{{$servicio_data->idservicio}}">
							<span class="glyphicon glyphicon-pencil"></span></a>
						</td>
					</tr>
					@endforeach	
				</table>
			</div>
		</div>
	</div>

	
	@if($search)
		{{ $servicios_data->appends(array('search' => $search,'search_area'=>$search_area))->links() }}
	@else	
		{{ $servicios_data->links()}}
	@endif
	
@stop