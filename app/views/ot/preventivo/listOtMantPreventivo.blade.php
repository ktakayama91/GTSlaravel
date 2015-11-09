@extends('templates/otMantenimientoPreventivoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Programación de mantenimiento preventivo</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
		<div class="container-fluid form-group row">
			<div class="col-md-4 col-md-offset-8">
				<a class="btn btn-primary btn-block" href="{{URL::to('/mant_preventivo/programacion')}}">
				<span class="glyphicon glyphicon-plus"></span> Agregar Mantenimiento Preventivo</a>
			</div>
		</div>
    {{ Form::open(array('url'=>'/mant_preventivo/search_ot_mant_preventivo','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	<div class="container-fluid form-group row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Búsqueda</h3>
				</div>
				<div class="panel-body">
					<div class="container-fluid form-group row">
						<div class="form-group col-md-4">
							{{ Form::label('search_ing','Ingeniero a cargo') }}
							{{ Form::text('search_ing',$search_ing,array('class'=>'form-control','placeholder'=>'Nombre o apellidos')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_cod_pat','Código patrimonial') }}
							{{ Form::text('search_cod_pat',$search_cod_pat,array('class'=>'form-control','placeholder'=>'Código patrimonial')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_ubicacion','Ubicación') }}
							{{ Form::text('search_ubicacion',$search_ubicacion,array('class'=>'form-control','placeholder'=>'Ubicación física')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_ot','Orden de Trabajo de Mantenimiento') }}
							{{ Form::text('search_ot',$search_ot,array('class'=>'form-control','placeholder'=>'Número de OT')) }}
						</div>					
						<div class="form-group col-md-4">
							{{ Form::label('search_equipo','Equipo relacionado') }}
							{{ Form::text('search_equipo',$search_equipo,array('class'=>'form-control','placeholder'=>'Nombre equipo')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_proveedor','Proveedor') }}
							{{ Form::text('search_proveedor',$search_proveedor,array('class'=>'form-control','placeholder'=>'RUC, Razón social o Nombre de contacto')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_servicio','Servicio') }}
							{{ Form::select('search_servicio', array('0' => 'Seleccione') + $servicios ,$search_servicio ,array('class'=>'form-control')) }}
						</div>					
						<div class="form-group col-md-4">
							{{ Form::label('search_ini','Fecha inicio') }}
							<div id="search_datetimepicker1" class="form-group input-group date">
								{{ Form::text('search_ini',$search_ini,array('class'=>'form-control','readonly'=>'')) }}
								<span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
							</div>
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_fin','Fecha fin') }}
							<div id="search_datetimepicker2" class="input-group date">
								{{ Form::text('search_fin',$search_fin,array('class'=>'form-control','readonly'=>'')) }}
								<span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
							</div>
						</div>					
					</div>
					<div class="container-fluid form-group row">
						<div class="col-md-2 col-md-offset-8">
						{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}	
						</div>
						<div class="col-md-2">
							<div class="btn btn-default btn-block" id="btnLimpiar"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
						</div>					
					</div>
				</div>	
			</div>
		</div>
	</div>
	{{ Form::close() }}	
	<div class="container-fluid form-group row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table">
				<tr class="info">
					<th class="text-nowrap">Fecha y hora</th>
					<th class="text-nowrap">Departamento</th>
					<th class="text-nowrap">Servicio</th>
					<th class="text-nowrap">Ingeniero</th>
					<th class="text-nowrap">Ubicación</th>
					<th class="text-nowrap">Orden Trabajo Mantenimiento</th>
					<th class="text-nowrap">Estado</th>
				</tr>
				@foreach($mant_preventivos_data as $mant_preventivo_data)
				<tr>
					<td class="text-nowrap">
						{{date('d-m-Y H:i:s',strtotime($mant_preventivo_data->fecha_programacion))}}
					</td>
					<td class="text-nowrap">
						{{$mant_preventivo_data->nombre_area}}
					</td>
					<td class="text-nowrap">
						{{$mant_preventivo_data->nombre_servicio}}
					</td>
					<td class="text-nowrap">
						{{$mant_preventivo_data->apellido_pat}} {{$mant_preventivo_data->apellido_mat}}, {{$mant_preventivo_data->nombre_user}}
					</td>
					<td class="text-nowrap">
						{{$mant_preventivo_data->nombre_ubicacion}}
					</td>
					<td class="text-nowrap text-center">
						<a href="{{URL::to('/mant_preventivo/create_ot_preventivo/')}}/{{$mant_preventivo_data->idot_preventivo}}">{{$mant_preventivo_data->ot_tipo_abreviatura}}{{$mant_preventivo_data->ot_correlativo}}{{$mant_preventivo_data->ot_activo_abreviatura}}</a>
					</td>					
					<td>
						{{$mant_preventivo_data->nombre_estado}}
					</td>
				</tr>
				@endforeach
				</table>
			</div>
		</div>
	</div>
	
@stop