@extends('templates/otRetiroServicioTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Retiro de Servicio</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if (Session::has('message'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('message') }}
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

    {{ Form::open(array('url'=>'/retiro_servicio/search_ot_retiro_servicio','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
			<div class="search_bar">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('search_ing','Ingeniero para retiro') }}
						{{ Form::text('search_ing',$search_ing,array('class'=>'form-control','placeholder'=>'Nombre o apellidos')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('search_cod_pat','Código patrimonial') }}
						{{ Form::text('search_cod_pat',$search_cod_pat,array('class'=>'form-control','placeholder'=>'Código Patrimonial')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('search_ubicacion','Ubicación') }}
						{{ Form::text('search_ubicacion',$search_ubicacion,array('class'=>'form-control','placeholder'=>'Ubicación física')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('search_ot','OT') }}
						{{ Form::text('search_ot',$search_ot,array('class'=>'form-control','placeholder'=>'Número de OT')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('search_equipo','Equipo relacionado') }}
						{{ Form::text('search_equipo',$search_equipo,array('class'=>'form-control','placeholder'=>'Nombre del Equipo')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('search_proveedor','Proveedor') }}
						{{ Form::text('search_proveedor',$search_proveedor,array('class'=>'form-control','placeholder'=>'RUC, Razón social o Nombre de contacto')) }}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('search_ini','Fecha inicio') }}
						<div id="datetimepicker1" class="form-group input-group date">
							{{ Form::text('search_ini',$search_ini,array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
						</div>
					</div>
					<div class="col-md-4">
						{{ Form::label('search_fin','Fecha de fin') }}
						<div id="datetimepicker2" class="form-group input-group date">
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
	{{ Form::close() }}</br>

	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th class="text-nowrap text-center">OT</th>
						<th class="text-nowrap text-center">Fecha y hora</th>
						<th class="text-nowrap text-center">Departamento</th>
						<th class="text-nowrap text-center">Servicio Clínico</th>
						<th class="text-nowrap text-center">Ingeniero</th>
						<th class="text-nowrap text-center">Ubicación</th>
						<th class="text-nowrap text-center">Estado</th>
						<th class="text-nowrap text-center">Reporte de retiro de servicio</th>
					</tr>
					@foreach($retiro_servicios_data as $retiro_servicio_data)
					<tr>
						<td class="text-nowrap text-center">
							@if($user->idrol == 1 || $user->idrol == 2 || $user->idrol == 3 || $user->idrol == 4)
								@if($retiro_servicio_data->idestado_ot == 9)
									<a href="{{URL::to('/retiro_servicio/create_ot/')}}/{{$retiro_servicio_data->idot_retiro}}">{{$retiro_servicio_data->ot_tipo_abreviatura}}{{$retiro_servicio_data->ot_correlativo}}{{$retiro_servicio_data->ot_activo_abreviatura}}</a>
								@else
									<a href="{{URL::to('/retiro_servicio/view_ot/')}}/{{$retiro_servicio_data->idot_retiro}}">{{$retiro_servicio_data->ot_tipo_abreviatura}}{{$retiro_servicio_data->ot_correlativo}}{{$retiro_servicio_data->ot_activo_abreviatura}}</a>
								@endif
							@else
								<a href="{{URL::to('/retiro_servicio/view_ot/')}}/{{$retiro_servicio_data->idot_retiro}}">{{$retiro_servicio_data->ot_tipo_abreviatura}}{{$retiro_servicio_data->ot_correlativo}}{{$retiro_servicio_data->ot_activo_abreviatura}}</a>
							@endif
						</td>
						<td class="text-nowrap text-center">
							{{date('d-m-Y H:i:s',strtotime($retiro_servicio_data->fecha_programacion))}}
						</td>
						<td class="text-nowrap text-center">
							{{$retiro_servicio_data->nombre_area}}
						</td>
						<td class="text-nowrap text-center">
							{{$retiro_servicio_data->nombre_servicio}}
						</td>
						<td class="text-nowrap text-center">
							{{$retiro_servicio_data->apellido_pat}} {{$retiro_servicio_data->apellido_mat}}, {{$retiro_servicio_data->nombre_user}}
						</td>
						<td class="text-nowrap text-center">
							{{$retiro_servicio_data->nombre_ubicacion}}
						</td>
						<td class="text-nowrap text-center">
							{{$retiro_servicio_data->nombre_estado}}
						</td>
						<td class="text-nowrap text-center">
							{{$retiro_servicio_data->reporte_tipo_abreviatura}}{{$retiro_servicio_data->reporte_correlativo}}{{$retiro_servicio_data->reporte_activo_abreviatura}}
						</td>
					</tr>
					@endforeach
				</table>				
			</div>
		</div>
	</div>
	
	@if($search_ing || $search_cod_pat || $search_ubicacion || $search_ot || $search_equipo || $search_proveedor || $search_ini || $search_fin)
		{{ $retiro_servicios_data->appends(array('search_ing' => $search_ing,'search_cod_pat'=>$search_cod_pat,'search_cod_pat'=>$search_ubicacion,'search_cod_pat'=>$search_ot,'search_cod_pat'=>$search_equipo,'search_cod_pat'=>$search_proveedor,'search_ini'=>$search_ini,'search_fin'=>$search_fin))->links() }}
	@else
		{{ $retiro_servicios_data->links() }}
	@endif
@stop