@extends('templates/recursosHumanosTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Presupuesto por Capacitacion</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			@foreach($errors->all() as $error)
				<p><strong>{{ $error }}</strong></p>
			@endforeach		
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('route'=>'presupuesto_capacitacion.store', 'role'=>'form','id'=>'form')) }}
		<div class="panel panel-default">
			
			<div class="panel-body">
				
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('id_capacitacion','Código de Capacitacion') }}
						{{ Form::number('id_capacitacion', null, ['id'=>'id_capacitacion','class'=>'form-control','min'=>'1']) }}
					</div>
					<div class="form-group col-md-2">
						{{ Form::label('','&zwnj;&zwnj;') }}
						{{ Form::button('<span class="glyphicon glyphicon-check"></span> Validar', array('id'=>'submit_create', 'class' => 'btn btn-primary btn-block','onClick'=>'validarCapacitacionExiste()')) }}
					</div>
				</div>
				
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
						{{ Form::label('nombre','Nombre') }}
						{{ Form::text('nombre', Input::old('nombre'), ['class'=>'form-control']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('tipo')) has-error has-feedback @endif">
						{{ Form::label('tipo','Tipo') }}
						{{ Form::select('tipo', $tipos, Input::old('tipo'), ['class'=>'form-control','disabled']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('modalidad')) has-error has-feedback @endif">
						{{ Form::label('modalidad','Modalidad') }}
						{{ Form::select('modalidad', $modalidades, Input::old('modalidad'), ['class'=>'form-control','disabled']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('departamento')) has-error has-feedback @endif">
						{{ Form::label('departamento','Departamento') }}
						{{ Form::select('departamento', $departamentos, Input::old('departamento'), ['id'=>'departamento','class'=>'form-control','onChange'=>'getServicios(this)','disabled']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
						{{ Form::label('servicio_clinico','Servicio Clínico') }}
						{{ Form::select('servicio_clinico', $servicios, Input::old('servicio_clinico'), ['id'=>'servicio_clinico','class'=>'form-control','disabled']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('responsable')) has-error has-feedback @endif">
						{{ Form::label('responsable','Responsable') }}
						{{ Form::select('responsable',$usuarios, Input::old('responsable'),['class'=>'form-control'])}}
					</div>

				</div>

				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Recursos Humanos</h3>
					</div>

				  	<div class="panel-body">
				  		<div class="row form-group">
							<div class="form-group col-md-4 @if($errors->first('rh_actividades')) has-error has-feedback @endif">
								{{ Form::label('rh_actividad','Actividad') }}
								{{ Form::text('rh_actividad' ,null, ['class'=>'form-control']) }}
							</div>
							<div class="form-group col-md-4 @if($errors->first('rh_actividades')) has-error has-feedback @endif">
								{{ Form::label('rh_descripcion','Descripción') }}
								{{ Form::text('rh_descripcion', null, ['class'=>'form-control']) }}
							</div>
							<div class="form-group col-md-4 @if($errors->first('rh_actividades')) has-error has-feedback @endif">
								{{ Form::label('rh_unidad','Unidad') }}
								{{ Form::text('rh_unidad', null, ['class'=>'form-control']) }}
							</div>
							<div class="form-group col-md-4 @if($errors->first('rh_actividades')) has-error has-feedback @endif">
								{{ Form::label('rh_cantidad','Cantidad') }}
								{{ Form::number('rh_cantidad', null, ['class'=>'form-control','min'=>'0']) }}
							</div>
							<div class="form-group col-md-4 @if($errors->first('rh_actividades')) has-error has-feedback @endif">
								{{ Form::label('rh_costo_unitario','Costo por unidad') }}
								{{ Form::number('rh_costo_unitario', null, ['class'=>'form-control','step'=>'0.1','min'=>'0']) }}
							</div>

							<div class="form-group col-md-4">
								{{ Form::label('','&zwnj;&zwnj;') }}
								<div class="btn btn-primary btn-block" onclick="agregarInfRH()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
							</div>
						</div>

						<div class="col-md-12">
							<table class="table">
								<tr class="info">
									<th>Actividad</th>
									<th>Descripcion</th>
									<th>Unidad</th>
									<th>Cantidad</th>
									<th>Costo por unidad</th>
									<th>Subtotal</th>
									<th></th>
								</tr>
								<tbody class="rh_table">
									@if(Input::old('rh_actividades'))
										@foreach(Input::old('rh_actividades') as $key => $req)
											<tr>
												<td><input class="cell" name='rh_actividades[]' value='{{$req}}' readonly/></td>
												<td><input class="cell" name='rh_descripciones[]' value='{{Input::old('rh_descripciones')[$key]}}' readonly/></td>
												<td><input class="cell" name='rh_unidades[]' value='{{Input::old('rh_unidades')[$key]}}' readonly/></td>
												<td><input class="cell" name='rh_cantidades[]' value='{{Input::old('rh_cantidades')[$key]}}' readonly/></td>
												<td><input class="cell" name='rh_costos_unitarios[]' value='{{Input::old('rh_costos_unitarios')[$key]}}' readonly/></td>
												<td><input class="cell" value='{{Input::old('rh_cantidades')[$key] * Input::old('rh_costos_unitarios')[$key]}}' readonly/></td>
												<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfRH(event,this)'>Eliminar</a></td></tr>
											</tr>
										@endforeach
									@endif
								</tbody>
								<th>TOTAL: S/. <input class="cell" name="rh_total" value="{{0+Input::old('rh_total')}}" id="rh_total" readonly/></th>
							</table>
						</div>
					</div>

					<div class="panel-heading">
						<h3 class="panel-title">Equipos y bienes duraderos</h3>
					</div>

				  	<div class="panel-body">
				  		<div class="row form-group">
							<div class="form-group col-md-4 @if($errors->first('eq_actividades')) has-error has-feedback @endif">
								{{ Form::label('eq_actividad','Actividad') }}
								{{ Form::text('eq_actividad', null, ['class'=>'form-control']) }}
							</div>
							<div class="form-group col-md-4 @if($errors->first('eq_actividades')) has-error has-feedback @endif">
								{{ Form::label('eq_descripcion','Descripción') }}
								{{ Form::text('eq_descripcion', null, ['class'=>'form-control']) }}
							</div>
							<div class="form-group col-md-4 @if($errors->first('eq_actividades')) has-error has-feedback @endif">
								{{ Form::label('eq_unidad','Unidad') }}
								{{ Form::text('eq_unidad', null, ['class'=>'form-control']) }}
							</div>
							<div class="form-group col-md-4 @if($errors->first('eq_actividades')) has-error has-feedback @endif">
								{{ Form::label('eq_cantidad','Cantidad') }}
								{{ Form::number('eq_cantidad', null, ['class'=>'form-control','min'=>'0']) }}
							</div>
							<div class="form-group col-md-4 @if($errors->first('eq_actividades')) has-error has-feedback @endif">
								{{ Form::label('eq_costo_unitario','Costo por unidad') }}
								{{ Form::number('eq_costo_unitario', null, ['class'=>'form-control','step'=>'0.1','min'=>'0']) }}
							</div>

							<div class="form-group col-md-4">
								{{ Form::label('','&zwnj;&zwnj;') }}
								<div class="btn btn-primary btn-block" onclick="agregarInfEQ()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
							</div>
						</div>
			
						<div class="col-md-12">
							<table class="table">
								<tr class="info">
									<th>Actividad</th>
									<th>Descripcion</th>
									<th>Unidad</th>
									<th>Cantidad</th>
									<th>Costo por unidad</th>
									<th>Subtotal</th>
									<th></th>
								</tr>
								<tbody class="eq_table">
									@if(Input::old('eq_actividades'))
										@foreach(Input::old('eq_actividades') as $key => $req)
											<tr>
												<td><input class="cell" name='eq_actividades[]' value='{{$req}}' readonly/></td>
												<td><input class="cell" name='eq_descripciones[]' value='{{Input::old('eq_descripciones')[$key]}}' readonly/></td>
												<td><input class="cell" name='eq_unidades[]' value='{{Input::old('eq_unidades')[$key]}}' readonly/></td>
												<td><input class="cell" name='eq_cantidades[]' value='{{Input::old('eq_cantidades')[$key]}}' readonly/></td>
												<td><input class="cell" name='eq_costos_unitarios[]' value='{{Input::old('eq_costos_unitarios')[$key]}}' readonly/></td>
												<td><input class="cell" value='{{Input::old('eq_cantidades')[$key]*Input::old('eq_costos_unitarios')[$key]}}' readonly/></td>
												<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfEQ(event,this)'>Eliminar</a></td></tr>
											</tr>
										@endforeach
									@endif
								</tbody>
								<th>TOTAL: S/. <input class="cell" name="eq_total" value="{{0+Input::old('eq_total')}}" id="eq_total" readonly/></th>
							</table>
						</div>
					</div>

					<div class="panel-heading">
						<h3 class="panel-title">Gastos operativos</h3>
					</div>

				  	<div class="panel-body">
				  		<div class="row form-group">
							<div class="form-group col-md-4 @if($errors->first('go_actividades')) has-error has-feedback @endif">
								{{ Form::label('go_actividad','Actividad') }}
								{{ Form::text('go_actividad', null, ['class'=>'form-control']) }}
							</div>
							<div class="form-group col-md-4 @if($errors->first('go_actividades')) has-error has-feedback @endif">
								{{ Form::label('go_descripcion','Descripción') }}
								{{ Form::text('go_descripcion', null, ['class'=>'form-control']) }}
							</div>
							<div class="form-group col-md-4 @if($errors->first('go_actividades')) has-error has-feedback @endif">
								{{ Form::label('go_unidad','Unidad') }}
								{{ Form::text('go_unidad', null, ['class'=>'form-control']) }}
							</div>
							<div class="form-group col-md-4 @if($errors->first('go_actividades')) has-error has-feedback @endif">
								{{ Form::label('go_cantidad','Cantidad') }}
								{{ Form::number('go_cantidad', null, ['class'=>'form-control','min'=>'0']) }}
							</div>
							<div class="form-group col-md-4 @if($errors->first('go_actividades')) has-error has-feedback @endif">
								{{ Form::label('go_costo_unitario','Costo por unidad') }}
								{{ Form::number('go_costo_unitario', null, ['class'=>'form-control','step'=>'0.1','min'=>'0']) }}
							</div>

							<div class="form-group col-md-4">
								{{ Form::label('','&zwnj;&zwnj;') }}
								<div class="btn btn-primary btn-block" onclick="agregarInfGO()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
							</div>
						</div>

						<div class="col-md-12">
							<table class="table">
								<tr class="info">
									<th>Actividad</th>
									<th>Descripcion</th>
									<th>Unidad</th>
									<th>Cantidad</th>
									<th>Costo por unidad</th>
									<th>Subtotal</th>
									<th></th>
								</tr>
								<tbody class="go_table">
									@if(Input::old('go_actividades'))
										@foreach(Input::old('go_actividades') as $key => $req)
											<tr>
												<td><input class="cell" name='go_actividades[]' value='{{$req}}' readonly/></td>
												<td><input class="cell" name='go_descripciones[]' value='{{Input::old('go_descripciones')[$key]}}' readonly/></td>
												<td><input class="cell" name='go_unidades[]' value='{{Input::old('go_unidades')[$key]}}' readonly/></td>
												<td><input class="cell" name='go_cantidades[]' value='{{Input::old('go_cantidades')[$key]}}' readonly/></td>
												<td><input class="cell" name='go_costos_unitarios[]' value='{{Input::old('go_costos_unitarios')[$key]}}' readonly/></td>
												<td><input class="cell" value='{{Input::old('go_cantidades')[$key]*Input::old('go_costos_unitarios')[$key]}}' readonly/></td>
												<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfGO(event,this)'>Eliminar</a></td></tr>
											</tr>
										@endforeach
									@endif
								</tbody>
								<th>TOTAL: S/. <input class="cell" name="go_total" value="{{0+Input::old('go_total')}}" id="go_total" readonly/></th>
							</table>
						</div>
					</div>

					<div class="panel-heading">
						<h3 class="panel-title">Gastos administrativos y gestión</h3>
					</div>

				  	<div class="panel-body">
				  		<div class="row form-group">
							<div class="form-group col-md-4 @if($errors->first('ga_actividades')) has-error has-feedback @endif">
								{{ Form::label('ga_actividad','Actividad') }}
								{{ Form::text('ga_actividad', null, ['class'=>'form-control']) }}
							</div>
							<div class="form-group col-md-4 @if($errors->first('ga_actividades')) has-error has-feedback @endif">
								{{ Form::label('ga_descripcion','Descripción') }}
								{{ Form::text('ga_descripcion', null, ['class'=>'form-control']) }}
							</div>
							<div class="form-group col-md-4 @if($errors->first('ga_actividades')) has-error has-feedback @endif">
								{{ Form::label('ga_unidad','Unidad') }}
								{{ Form::text('ga_unidad', null, ['class'=>'form-control']) }}
							</div>
							<div class="form-group col-md-4 @if($errors->first('ga_actividades')) has-error has-feedback @endif">
								{{ Form::label('ga_cantidad','Cantidad') }}
								{{ Form::number('ga_cantidad', null, ['class'=>'form-control','min'=>'0']) }}
							</div>
							<div class="form-group col-md-4 @if($errors->first('ga_actividades')) has-error has-feedback @endif">
								{{ Form::label('ga_costo_unitario','Costo por unidad') }}
								{{ Form::number('ga_costo_unitario', null, ['class'=>'form-control','step'=>'0.1','min'=>'0']) }}
							</div>

							<div class="form-group col-md-4">
								{{ Form::label('','&zwnj;&zwnj;') }}
								<div class="btn btn-primary btn-block" onclick="agregarInfGA()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
							</div>
						</div>

						<div class="col-md-12">
							<table class="table">
								<tr class="info">
									<th>Actividad</th>
									<th>Descripcion</th>
									<th>Unidad</th>
									<th>Cantidad</th>
									<th>Costo por unidad</th>
									<th>Subtotal</th>
									<th></th>
								</tr>
								<tbody class="ga_table">
									@if(Input::old('ga_actividades'))
										@foreach(Input::old('ga_actividades') as $key => $req)
											<tr>
												<td><input class="cell" name='ga_actividades[]' value='{{$req}}' readonly/></td>
												<td><input class="cell" name='ga_descripciones[]' value='{{Input::old('ga_descripciones')[$key]}}' readonly/></td>
												<td><input class="cell" name='ga_unidades[]' value='{{Input::old('ga_unidades')[$key]}}' readonly/></td>
												<td><input class="cell" name='ga_cantidades[]' value='{{Input::old('ga_cantidades')[$key]}}' readonly/></td>
												<td><input class="cell" name='ga_costos_unitarios[]' value='{{Input::old('ga_costos_unitarios')[$key]}}' readonly/></td>
												<td><input class="cell" value='{{Input::old('ga_cantidades')[$key] * Input::old('ga_costos_unitarios')[$key]}}' readonly/></td>
												<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfGA(event,this)'>Eliminar</a></td></tr>
											</tr>
										@endforeach
									@endif
								</tbody>
								<th>TOTAL: S/. <input class="cell" name="ga_total" value="{{0+Input::old('ga_total')}}" id="ga_total" readonly/></th>
							</table>
						</div>
					</div>
				</div>


			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</div>

			<div class="form-group col-md-offset-8 col-md-2">
				<a class="btn btn-default btn-block" href="{{route('presupuesto_capacitacion.index')}}">Cancelar</a>				
			</div>
		</div>

	{{ Form::close() }}


@stop