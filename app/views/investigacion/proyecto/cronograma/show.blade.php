@extends('templates/investigacionTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Cronograma: {{$cronograma->nombre}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Informacion general del proyecto</h3>
		</div>
		<div class="panel-body">
			
			<div class="row">
				<div class="form-group col-md-4">
					{{ Form::label('id_reporte','Código de proyecto') }}
					{{ Form::text('codigo', $cronograma->proyecto->codigo, ['class'=>'form-control','readonly']) }}
				</div>
			</div>
			
			<div class="row">
				<div class="form-group col-md-4 ">
					{{ Form::label('nombre','Nombre') }}
					{{ Form::text('nombre', $cronograma->nombre, ['class'=>'form-control', 'readonly']) }}
				</div>

				<div class="form-group col-md-4 ">
					{{ Form::label('categoria','Categoría') }}
					{{ Form::text('categoria', $categorias[$cronograma->id_categoria], ['class'=>'form-control', 'readonly']) }}
				</div>

				<div class="form-group col-md-4 ">
					{{ Form::label('departamento','Departamento') }}
					{{ Form::text('departamento', $departamentos[$cronograma->id_departamento], ['id'=>'departamento','class'=>'form-control', 'readonly']) }}
				</div>

				<div class="form-group col-md-4 ">
					{{ Form::label('servicio_clinico','Servicio Clínico') }}
					{{ Form::text('servicio_clinico', $servicios[$cronograma->id_servicio_clinico], ['id'=>'servicio_clinico','class'=>'form-control', 'readonly']) }}
				</div>

				<div class="form-group col-md-4 ">
					{{ Form::label('responsable','Responsable') }}
					{{ Form::text('responsable',$usuarios[$cronograma->id_responsable],['class'=>'form-control', 'readonly'])}}
				</div>

			</div>

			<div class="row">
				<div class="form-group col-md-4">
					{{ Form::label('fecha_ini','Fecha Inicio') }}
					{{ Form::text('fecha_ini',$cronograma->fecha_ini,array('class'=>'form-control', 'readonly'=>'')) }}
				</div>
				<div class="form-group col-md-4">
					{{ Form::label('fecha_fin','Fecha Fin') }}
					{{ Form::text('fecha_fin',$cronograma->fecha_fin,array('class'=>'form-control', 'readonly'=>'')) }}
				</div>
			</div>

	    	@if($cronograma->actividades->isEmpty())
				<div class="panel panel-default">
					<div class="panel-body">
			    		<div class="col-md-12">
				    		No se ha registrado ninguna actividad.
						</div>
					</div>
				</div>
			@else
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Actividades Fase Inversion</h3>
					</div>

				  	<div class="panel-body">
						<div class="col-md-12">
							<table class="table">
								<tr class="info">
									<th>Actividad</th>
									<th>Descripcion</th>
									<th>Fecha Inicio</th>
									<th>Fecha Fin</th>
									<th>Duración</th>
									<th>Actividad Previa</th>
								</tr>
								<tbody id="table" class="table_pre">
									@foreach($cronograma->actividades as $actividad)
										<tr>
											<td>
												<a href="{{route('proyecto_cronograma.actividad.edit',$actividad->id)}}">{{$actividad->nombre}}</a>
											</td>
											<td>{{$actividad->descripcion}}</td>
											<td>{{$actividad->fecha_ini}}</td>
											<td>{{$actividad->fecha_fin}}</td>
											<td>{{$actividad->duracion}}</td>
											<td>
												@if($actividad->id_actividad_previa == 0)
													No posee
												@else
													{{$actividad->actividadPrevia->nombre}}
												@endif
												
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>

					<div class="panel-heading">
						<h3 class="panel-title">Diagrama de Gantt</h3>
					</div>

				  	<div class="panel-body">
						<div class="col-md-12">
							<div class="row">

								<script type="text/javascript">

								    google.charts.load('current', {'packages':['gantt']});
								    google.charts.setOnLoadCallback(drawChart);

								    function daysToMilliseconds(days) {
								    	return days * 24 * 60 * 60 * 1000;
								    }

								    function drawChart() {

										var data = new google.visualization.DataTable();
										data.addColumn('string', 'Task ID');
										data.addColumn('string', 'Task Name');
										data.addColumn('date', 'Start Date');
										data.addColumn('date', 'End Date');
										data.addColumn('number', 'Duration');
										data.addColumn('number', 'Percent Complete');
										data.addColumn('string', 'Dependencies');

										var data2 = new google.visualization.DataTable();
										data2.addColumn('string', 'Task ID');
										data2.addColumn('string', 'Task Name');
										data2.addColumn('date', 'Start Date');
										data2.addColumn('date', 'End Date');
										data2.addColumn('number', 'Duration');
										data2.addColumn('number', 'Percent Complete');
										data2.addColumn('string', 'Dependencies');

										//ID, Titulo, Grupo, Fecha Inicio, Fecha Fin, Duracion en ms, Porcentaje, Dependencia
										var infos = {{$cronograma->actividades}};
										for(key in infos){
											//console.log(infos[key]);
											if(infos[key].id_actividad_previa == 0){
												data.addRows([
													['T'+infos[key].id,	infos[key].nombre, new Date(infos[key].fecha_ini), new Date(infos[key].fecha_fin), null, 0, null],
												]);
											}else{
												data.addRows([
													['T'+infos[key].id,	infos[key].nombre, new Date(infos[key].fecha_ini), new Date(infos[key].fecha_fin), null, 0, 'T'+infos[key].id_actividad_previa],
												]);
											}

										}

										var infos2 = {{$cronograma->actividadespost}};
										for(key in infos2){
											//console.log(infos[key]);
											if(infos2[key].id_actividad_previa == 0){
												data2.addRows([
													['T'+infos2[key].id, infos2[key].nombre, new Date(infos2[key].fecha_ini), new Date(infos2[key].fecha_fin), null, 0, null],
												]);
											}else{
												data2.addRows([
													['T'+infos2[key].id, infos2[key].nombre, new Date(infos2[key].fecha_ini), new Date(infos2[key].fecha_fin), null, 0, 'T'+infos2[key].id_actividad_previa],
												]);
											}

										}
										
										var options = {
											height: 55*infos.length,
											gantt: {
												criticalPathEnabled: false,
												criticalPathStyle: {
												  stroke: '#e64a19',
												  strokeWidth: 5
												},
												/*
												arrow: {
													angle: 100,
													width: 5,
													color: 'green',
													radius: 0
												}
												*/
											}
										};

										var options2 = {
											height: 55*infos2.length,
											gantt: {
												criticalPathEnabled: false,
												criticalPathStyle: {
												  stroke: '#e64a19',
												  strokeWidth: 5
												},
												/*
												arrow: {
													angle: 100,
													width: 5,
													color: 'green',
													radius: 0
												}
												*/
											}
										};

										var chart = new google.visualization.Gantt(document.getElementById('chart_div'));
										var chart2 = new google.visualization.Gantt(document.getElementById('chart_div2'));
										chart.draw(data, options);
										chart2.draw(data2, options2);
								    }
								</script>
							 
							    <div id="chart_div"></div>
							    
							</div>
						</div>
					</div>
				</div>

			@endif

	    	@if($cronograma->actividadespost->isEmpty())
				<div class="panel panel-default">
					<div class="panel-body">
			    		<div class="col-md-12">
				    		No se ha registrado ninguna actividad.
						</div>
					</div>
				</div>
			@else
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Actividades Fase Post Inversión</h3>
					</div>

					<div class="panel-body">
						<div class="col-md-12">
							<table class="table">
								<tr class="info">
									<th>Actividad</th>
									<th>Descripcion</th>
									<th>Fecha Inicio</th>
									<th>Fecha Fin</th>
									<th>Duración</th>
									<th>Actividad Previa</th>
								</tr>
								<tbody id="table" class="table_pre">
									@foreach($cronograma->actividadespost as $actividad)
										<tr>
											<td>
												<a href="{{route('proyecto_cronograma.actividad.edit',$actividad->id)}}">{{$actividad->nombre}}</a>
											</td>
											<td>{{$actividad->descripcion}}</td>
											<td>{{$actividad->fecha_ini}}</td>
											<td>{{$actividad->fecha_fin}}</td>
											<td>{{$actividad->duracion}}</td>
											<td>
												@if($actividad->id_actividad_previa == 0)
													No posee
												@else
													{{$actividad->actividadPrevia->nombre}}
												@endif
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>

					<div class="panel-heading">
						<h3 class="panel-title">Diagrama de Gantt</h3>
					</div>

				  	<div class="panel-body">
						<div class="col-md-12">
							<div class="row">
								<div id="chart_div2"></div>
							</div>
						</div>
					</div>

				</div>

			@endif

			<div class="row">
				<div class="col-md-2">
		    		<a class="btn-under" href="{{route('proyecto_cronograma.edit',$cronograma->id)}}">
						{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Agregar', ['class' => 'btn btn-success btn-block']) }}
					</a>
				</div>

				<div class="col-md-2">
		    		<a class="btn-under" href="{{route('proyecto_cronograma.cronograma.edit',$cronograma->id)}}">
						{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Editar', ['class' => 'btn btn-primary btn-block']) }}
					</a>
				</div>

				<div class="form-group col-md-offset-6 col-md-2">
					<a class="btn-under" href="{{route('proyecto_documentacion.index')}}">
						{{ Form::button('<span class="glyphicon glyphicon-repeat"></span> Regresar', array('class' => 'btn btn-primary btn-block')) }}
					</a>
				</div>
			</div>
		</div>
	</div>

@stop