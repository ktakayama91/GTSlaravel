@extends('templates/otRetiroServicioTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Orden de trabajo de retiro de servicio - {{$ot_info->ot_tipo_abreviatura}}{{$ot_info->ot_correlativo}}{{$ot_info->ot_activo_abreviatura}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('idestado') }}</strong></p>
			<p><strong>{{ $errors->first('idestado_inicial') }}</strong></p>
			<p><strong>{{ $errors->first('idestado_final') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_conformidad') }}</strong></p>
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
			{{ Session::get('error') }}
		</div>
	@endif

	@if($ot_info->idestado_ot == 9)
	{{ Form::open(array('url'=>'retiro_servicio/submit_create_ot', 'role'=>'form','id'=>'submit_ot_retiro')) }}
	@endif
		{{ Form::hidden('idot_retiro', $ot_info->idot_retiro) }}
		{{ Form::hidden('idactivo', $ot_info->idactivo) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos de la OT</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('codigo','Código OT') }}
						{{ Form::text('codigo',$ot_info->ot_tipo_abreviatura.$ot_info->ot_correlativo.$ot_info->ot_activo_abreviatura,array('class' => 'form-control','readonly'=>'')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('elaborador','Documento Elaborado Por') }}
						{{ Form::text('elaborador',$ot_info->apat_elaborador.' '.$ot_info->amat_elaborador.', '.$ot_info->nombre_elaborador,array('class' => 'form-control','readonly'=>'')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('solicitante','Usuario Solicitante') }}
						{{ Form::text('solicitante',$ot_info->apat_solicitante.' '.$ot_info->amat_solicitante.', '.$ot_info->nombre_solicitante,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('ingeniero','Ejecutor del Mantenimiento') }}
						{{ Form::text('ingeniero',$ot_info->apat_ingeniero.' '.$ot_info->amat_ingeniero.', '.$ot_info->nombre_ingeniero,array('class' => 'form-control','readonly'=>'')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('fecha_programacion','Fecha Programada') }}
						{{ Form::text('fecha_programacion',date("d-m-Y H:i:s",strtotime($ot_info->fecha_programacion)),array('class' => 'form-control','readonly'=>'')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('nombre_servicio','Servicio Hospitalario') }}
						{{ Form::text('nombre_servicio',$ot_info->nombre_servicio,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('nombre_ubicacion','Ubicación Física') }}
						{{ Form::text('nombre_ubicacion',$ot_info->nombre_ubicacion,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del Equipo</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('nombre_equipo','Nombre del Equipo') }}
						{{ Form::text('nombre_equipo',$ot_info->nombre_equipo,array('class' => 'form-control','readonly'=>'')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('codigo_patrimonial','Código Patrimonial') }}
						{{ Form::text('codigo_patrimonial',$ot_info->codigo_patrimonial,array('class' => 'form-control','readonly'=>'')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('numero_serie','Número de Serie') }}
						{{ Form::text('numero_serie',$ot_info->numero_serie,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('nombre_marca','Marca') }}
						{{ Form::text('nombre_marca',$ot_info->nombre_marca,array('class' => 'form-control','readonly'=>'')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('modelo','Modelo') }}
						{{ Form::text('modelo',$ot_info->modelo,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del Reporte de Retiro</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('fecha_baja','Fecha de Baja') }}
						{{ Form::text('fecha_baja',date('d-m-Y H:i',strtotime($ot_info->fecha_baja)),array('class' => 'form-control','readonly'=>'')) }}
					</div>
					@if(!$ot_info->fecha_conformidad)
					<div class="form-group col-md-4">
						{{ Form::label('fecha_conformidad','Ingrese Fecha de Conformidad') }}
						<div class="fecha-hora form-group input-group date @if($errors->first('fecha_conformidad')) has-error has-feedback @endif">
							{{ Form::text('fecha_conformidad',null,array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
					@else
					<div class="form-group col-md-4">
						{{ Form::label('fecha_conformidad','Fecha de Conformidad') }}
						{{ Form::text('fecha_conformidad',date('d-m-Y H:i',strtotime($ot_info->fecha_conformidad)),array('class'=>'form-control','readonly'=>'')) }}
					</div>
					@endif
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Estado de la Orden de Trabajo</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idestado')) has-error has-feedback @endif">
						{{ Form::label('idestado','Equipo No Intervenido') }}
						{{ Form::select('idestado', $estados,$ot_info->idestado_ot,['class' => 'form-control']) }}
					</div>
						<div class="form-group col-md-4 @if($errors->first('idestado_inicial')) has-error has-feedback @endif">
							{{ Form::label('idestado_inicial','Estado Inicial del Activo') }}
							{{ Form::select('idestado_inicial', $estado_activo,$ot_info->idestado_inicial,array('class'=>'form-control')) }}
						</div>
							<div class="form-group col-md-4 @if($errors->first('idestado_final')) has-error has-feedback @endif">
								{{ Form::label('idestado_final','Estado Final del Activo') }}
								{{ Form::select('idestado_final', $estado_activo,$ot_info->idestado_final,array('class'=>'form-control')) }}
							</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos Generales de la Orden de Trabajo de Retiro de Servicio</h3>
			</div>
			<div class="panel-body">
				@if($ot_info->idestado_ot == 9 && ($user->idrol == 1 || $user->idrol == 2 || $user->idrol == 3 || $user->idrol == 4))
				<div class="row">
					<div class="form-group col-md-8">
						{{ Form::text('nombre_tarea', null,array('class'=>'form-control','placeholder'=>'Ingrese aquí la tarea realizada')) }}
					</div>
					<div class="form-group col-md-2">
						{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Agregar',array('id'=>'submit-tarea', 'class'=>'btn btn-primary')) }}
					</div>
				</div>
				@endif
				<div class="row">
					<div class="col-md-6">
						<div class="table-responsive">
							<table id="tareas-table" class="table">
								<tr class="info">
									<th class="text-nowrap text-center">Descripción</th>
									<th class="text-nowrap text-center">Eliminar</th>
								</tr>
								@foreach($tareas as $tarea)
								<tr id="tarea-row-{{ $tarea->idtareas_ot_retiro }}">
									<td class="text-nowrap">{{$tarea->nombre}}</td>
									<td class="text-nowrap text-center">
										@if($ot_info->idestado_ot == 9 && ($user->idrol == 1 || $user->idrol == 2 || $user->idrol == 3 || $user->idrol == 4))
										<button class="btn btn-danger boton-eliminar-tarea" onclick="eliminar_tarea(event,{{$tarea->idtareas_ot_retiro}})" type="button"><span class="glyphicon glyphicon-trash"></span></button>
										@endif
									</td>
								</tr>
								@endforeach
							</table>
						</div>
					</div>
				</div>
				
				
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos de Mano de Obra</h3>
			</div>
			<div class="panel-body">
				@if($ot_info->idestado_ot == 9 && ($user->idrol == 1 || $user->idrol == 2 || $user->idrol == 3 || $user->idrol == 4))
				<div class="row">
					<div class="form-group col-md-5">
						{{ Form::text('nombre_personal', null,array('class'=>'form-control','placeholder'=>'Nombres Apellidos')) }}
					</div>
					<div class="form-group col-md-3">
						{{ Form::text('horas_trabajadas', null,array('class'=>'form-control','placeholder'=>'Hrs. Trab. ejem: 0.5')) }}
					</div>
					<div class="form-group col-md-2">
						{{ Form::text('costo_personal', null,array('class'=>'form-control','placeholder'=>'Costo')) }}
					</div>
					<div class="form-group col-md-2">
						{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Agregar',array('id'=>'submit-personal', 'class'=>'btn btn-primary')) }}
					</div>
				</div>
				@endif
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table id="personal-table" class="table">
								<tr class="info">
									<th class="text-nowrap text-center">Nombres y Apellidos</th>
									<th class="text-nowrap text-center">Horas Trabajadas</th>
									<th class="text-nowrap text-center">Costo por Hora</th>
									<th class="text-nowrap text-center">Eliminar</th>
								</tr>
								@foreach($personal_data as $personal)
								<tr id="personal-row-{{ $personal->idpersonal_ot_retiro }}">
									<td class="text-nowrap">{{$personal->nombre}}</td>
									<td class="text-nowrap text-center">{{$personal->horas_hombre}}</td>
									<td class="text-nowrap text-center">{{$personal->costo}}</td>
									<td class="text-nowrap text-center">
										@if($ot_info->idestado_ot == 9 && ($user->idrol == 1 || $user->idrol == 2 || $user->idrol == 3 || $user->idrol == 4))
										<button class="btn btn-danger boton-eliminar-mano-obra" onclick="eliminar_personal(event,{{$personal->idpersonal_ot_retiro}})" type="button"><span class="glyphicon glyphicon-trash"></span></button>
										@endif
									</td>
								</tr>
								@endforeach
							</table>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-2">
			    		{{ Form::label('costo_total_personal','Gasto Total Mano de Obra (S/.)') }}
			    	</div>
			    	<div class="col-md-2">
			        	{{ Form::text('costo_total_personal', number_format($ot_info->costo_total_personal,2),array('class'=>'form-control','placeholder'=>'Costo','readonly'=>'')) }}
			    	</div>
			    </div>
			</div>
		</div>
		@if($user->idrol == 1 || $user->idrol == 2 || $user->idrol == 3 || $user->idrol == 4)
			<div class="row">
				@if($ot_info->idestado_ot == 9)
				<div class="col-md-2 form-group">
					{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_ot','class' => 'btn btn-primary btn-block')) }}
					{{ Form::close() }}
				</div>
				@endif
				<div class="form-group col-md-2">
					<a class="btn btn-default btn-block" href="{{URL::to('/retiro_servicio/list_retiro_servicio')}}">Cancelar</a>				
				</div>	
				<div class="col-md-2 col-md-offset-6 form-group">
					{{ Form::open(array('url'=>'retiro_servicio/export_pdf', 'role'=>'form')) }}
					{{ Form::hidden('idot_retiro', $ot_info->idot_retiro) }}
					{{ Form::button('<span class="glyphicon glyphicon-export"></span> Exportar', array('id'=>'exportar', 'type'=>'submit' ,'class' => 'btn btn-success btn-block')) }}
					{{ Form::close() }}
				</div>
			</div>
		@endif
@stop