@extends('templates/investigacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Control de Elaboración de Guías</h3>            
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
    {{ Form::open(array('url'=>'/programacion_guias/search_programacion_guias','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
			<div class="search_bar">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('search_usuario','Usuario Responsable:')}}
						{{ Form::text('search_usuario', $search_usuario,array('class'=>'form-control')) }}
					</div>		
					<div class="form-group col-md-4">
						{{ Form::label('search_fecha','Año') }}
						<div id="datetimepicker_search_anho3" class="form-group input-group date">
							{{ Form::text('search_fecha',$search_fecha,array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="col-md-12">
					<div class="form-group col-md-2 col-md-offset-8">
						{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}				
					</div>
					<div class="form-group col-md-2">
						<div class="btn btn-default btn-block" id="btnLlimpiar_criterios_list_reporte_cn"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
					</div>
				</div>
				</div>
			</div>	
			</div>
		</div>
	{{ Form::close() }}</br>
	<div class="container-fluid form-group row">
		<div class="col-md-3 col-md-offset-9">
			<a class="btn btn-primary btn-block" href="{{URL::to('/programacion_guias/create_programacion_guias')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar Programación</a>
		</div>
	</div>
	@if($search_fecha>0)
		<h1 style="font-weight:bold">Año: {{$search_fecha}}</h1>
	@else
		<h1 style="font-weight:bold">Año: {{$anho_actual}}</h1>
	@endif
	<table class="table">
		<tr>							
			<th bgcolor='lightGreen'></th>
			<th>Concluido</th>
			<th bgcolor='yellow'></th>
			<th>En Elaboración</th>
			<th bgcolor='red'></th>
			<th>Atrasado</th>
		</tr>
	</table>
	@foreach($usuarios_responsable_data as $usuario_responsable_data)
		<table class="table">
			<tr >
				<th bgcolor='white'>Usuario: {{$usuario_responsable_data->apellido_pat}} {{$usuario_responsable_data->apellido_mat}} {{$usuario_responsable_data->nombre}}</th>
				<th class="info">Enero</th>
				<th class="info">Febrero</th>
				<th class="info">Marzo</th>
				<th class="info">Abril</th>
				<th class="info">Mayo</th>
				<th class="info">Junio</th>
				<th class="info">Julio</th>
				<th class="info">Agosto</th>
				<th class="info">Setiembre</th>
				<th class="info">Octubre</th>
				<th class="info">Noviembre</th>
				<th class="info">Diciembre</th>
			</tr>

			<tr bgcolor = 'lightgrey'>
				<th>Guía TS</th>
				<th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
			</tr>
			
			@foreach($programaciones_reporte_ts as $programacion_reporte_ts)
				
				@if($usuario_responsable_data->iduser == $programacion_reporte_ts->iduser)
					<tr><th class="info" style="font-weight:normal">{{$programacion_reporte_ts->nombre_reporte}}</th>
						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month == 1)
							<th bgcolor='@if($programacion_reporte_ts->id_estado==2) lightGreen @elseif($programacion_reporte_ts->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_ts->id_estado==2 || ($programacion_reporte_ts->guia && $programacion_reporte_ts->guia->url=="")) {{URL::to('/guias_tecno_salud/edit_guia/')}}/{{$programacion_reporte_ts->id_guia}} @else {{URL::to('/guias_tecno_salud/create_guia/')}}/{{$programacion_reporte_ts->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif
						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month == 2)
							<th bgcolor='@if($programacion_reporte_ts->id_estado==2) lightGreen @elseif($programacion_reporte_ts->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_ts->id_estado==2 || ($programacion_reporte_ts->guia && $programacion_reporte_ts->guia->url=="")) {{URL::to('/guias_tecno_salud/edit_guia/')}}/{{$programacion_reporte_ts->id_guia}} @else {{URL::to('/guias_tecno_salud/create_guia/')}}/{{$programacion_reporte_ts->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif
						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month == 3)
							<th bgcolor='@if($programacion_reporte_ts->id_estado==2) lightGreen @elseif($programacion_reporte_ts->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_ts->id_estado==2 || ($programacion_reporte_ts->guia && $programacion_reporte_ts->guia->url=="")) {{URL::to('/guias_tecno_salud/edit_guia/')}}/{{$programacion_reporte_ts->id_guia}} @else {{URL::to('/guias_tecno_salud/create_guia/')}}/{{$programacion_reporte_ts->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif
						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month == 4)
							<th bgcolor='@if($programacion_reporte_ts->id_estado==2) lightGreen @elseif($programacion_reporte_ts->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_ts->id_estado==2 || ($programacion_reporte_ts->guia && $programacion_reporte_ts->guia->url=="")) {{URL::to('/guias_tecno_salud/edit_guia/')}}/{{$programacion_reporte_ts->id_guia}} @else {{URL::to('/guias_tecno_salud/create_guia/')}}/{{$programacion_reporte_ts->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif
						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month == 5)
							<th bgcolor='@if($programacion_reporte_ts->id_estado==2) lightGreen @elseif($programacion_reporte_ts->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_ts->id_estado==2 || ($programacion_reporte_ts->guia && $programacion_reporte_ts->guia->url=="")) {{URL::to('/guias_tecno_salud/edit_guia/')}}/{{$programacion_reporte_ts->id_guia}} @else {{URL::to('/guias_tecno_salud/create_guia/')}}/{{$programacion_reporte_ts->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif
						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month == 6)
							<th bgcolor='@if($programacion_reporte_ts->id_estado==2) lightGreen @elseif($programacion_reporte_ts->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_ts->id_estado==2 || ($programacion_reporte_ts->guia && $programacion_reporte_ts->guia->url=="")) {{URL::to('/guias_tecno_salud/edit_guia/')}}/{{$programacion_reporte_ts->id_guia}} @else {{URL::to('/guias_tecno_salud/create_guia/')}}/{{$programacion_reporte_ts->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif
						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month == 7)
							<th bgcolor='@if($programacion_reporte_ts->id_estado==2) lightGreen @elseif($programacion_reporte_ts->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_ts->id_estado==2 || ($programacion_reporte_ts->guia && $programacion_reporte_ts->guia->url=="")) {{URL::to('/guias_tecno_salud/edit_guia/')}}/{{$programacion_reporte_ts->id_guia}} @else {{URL::to('/guias_tecno_salud/create_guia/')}}/{{$programacion_reporte_ts->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif
						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month == 8)
							<th bgcolor='@if($programacion_reporte_ts->id_estado==2) lightGreen @elseif($programacion_reporte_ts->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_ts->id_estado==2 || ($programacion_reporte_ts->guia && $programacion_reporte_ts->guia->url=="")) {{URL::to('/guias_tecno_salud/edit_guia/')}}/{{$programacion_reporte_ts->id_guia}} @else {{URL::to('/guias_tecno_salud/create_guia/')}}/{{$programacion_reporte_ts->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif
						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month == 9)
							<th bgcolor='@if($programacion_reporte_ts->id_estado==2) lightGreen @elseif($programacion_reporte_ts->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_ts->id_estado==2 || ($programacion_reporte_ts->guia && $programacion_reporte_ts->guia->url=="")) {{URL::to('/guias_tecno_salud/edit_guia/')}}/{{$programacion_reporte_ts->id_guia}} @else {{URL::to('/guias_tecno_salud/create_guia/')}}/{{$programacion_reporte_ts->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif
						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month == 10)
							<th bgcolor='@if($programacion_reporte_ts->id_estado==2) lightGreen @elseif($programacion_reporte_ts->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_ts->id_estado==2 || ($programacion_reporte_ts->guia && $programacion_reporte_ts->guia->url=="")) {{URL::to('/guias_tecno_salud/edit_guia/')}}/{{$programacion_reporte_ts->id_guia}} @else {{URL::to('/guias_tecno_salud/create_guia/')}}/{{$programacion_reporte_ts->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif
						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month == 11)
							<th bgcolor='@if($programacion_reporte_ts->id_estado==2) lightGreen @elseif($programacion_reporte_ts->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_ts->id_estado==2 || ($programacion_reporte_ts->guia && $programacion_reporte_ts->guia->url=="")) {{URL::to('/guias_tecno_salud/edit_guia/')}}/{{$programacion_reporte_ts->id_guia}} @else {{URL::to('/guias_tecno_salud/create_guia/')}}/{{$programacion_reporte_ts->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif				
						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month == 12)
							<th bgcolor='@if($programacion_reporte_ts->id_estado==2) lightGreen @elseif($programacion_reporte_ts->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_ts->id_estado==2 || ($programacion_reporte_ts->guia && $programacion_reporte_ts->guia->url=="")) {{URL::to('/guias_tecno_salud/edit_guia/')}}/{{$programacion_reporte_ts->id_guia}} @else {{URL::to('/guias_tecno_salud/create_guia/')}}/{{$programacion_reporte_ts->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_ts->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif

					</tr>
				@endif
			@endforeach

			<tr bgcolor = 'lightgrey'>
				<th>Reporte ETES</th>
				<th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
			</tr>
			@foreach($programaciones_reporte_etes as $programacion_reporte_etes)
				@if($usuario_responsable_data->iduser == $programacion_reporte_etes->iduser)
					<tr>
						<th class="info" style="font-weight:normal">{{$programacion_reporte_etes->nombre_reporte}}</th>
						<th bgcolor='@if($programacion_reporte_etes->idestado_programacion_reportes_enero==2) lightGreen @elseif($programacion_reporte_etes->idestado_programacion_reportes_enero==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>1) red @elseif ($mes_actual==1) @if ($programacion_reporte_etes->enero>=$dia_actual and $programacion_reporte_etes->enero>0) yellow @elseif ($programacion_reporte_etes->enero>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal"><center><a href="@if($programacion_reporte_etes->idestado_programacion_reportes_enero==2) {{URL::to('/reporte_etes/edit_reporte_etes/')}}/{{$programacion_reporte_etes->idreporte_etes_enero}} @else {{URL::to('/reporte_etes/create_reporte_etes/')}}/{{$programacion_reporte_etes->idprogramacion_reporte_etes_enero}} @endif">{{$programacion_reporte_etes->enero}}</a></center></th>
						<th bgcolor='@if($programacion_reporte_etes->idestado_programacion_reportes_febrero==2) lightGreen @elseif($programacion_reporte_etes->idestado_programacion_reportes_febrero==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>2) red @elseif ($mes_actual==2) @if ($programacion_reporte_etes->febrero>=$dia_actual and $programacion_reporte_etes->febrero>0) yellow @elseif ($programacion_reporte_etes->febrero>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal"><center><a href="@if($programacion_reporte_etes->idestado_programacion_reportes_febrero==2) {{URL::to('/reporte_etes/edit_reporte_etes/')}}/{{$programacion_reporte_etes->idreporte_etes_febrero}} @else {{URL::to('/reporte_etes/create_reporte_etes/')}}/{{$programacion_reporte_etes->idprogramacion_reporte_etes_febrero}} @endif">{{$programacion_reporte_etes->febrero}}</a></center></th>
						<th bgcolor='@if($programacion_reporte_etes->idestado_programacion_reportes_marzo==2) lightGreen @elseif($programacion_reporte_etes->idestado_programacion_reportes_marzo==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>3) red @elseif ($mes_actual==3) @if ($programacion_reporte_etes->marzo>=$dia_actual and $programacion_reporte_etes->marzo>0) yellow @elseif ($programacion_reporte_etes->marzo>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal"><center><a href="@if($programacion_reporte_etes->idestado_programacion_reportes_marzo==2) {{URL::to('/reporte_etes/edit_reporte_etes/')}}/{{$programacion_reporte_etes->idreporte_etes_marzo}} @else {{URL::to('/reporte_etes/create_reporte_etes/')}}/{{$programacion_reporte_etes->idprogramacion_reporte_etes_marzo}} @endif">{{$programacion_reporte_etes->marzo}}</a></center></th>
						<th bgcolor='@if($programacion_reporte_etes->idestado_programacion_reportes_abril==2) lightGreen @elseif($programacion_reporte_etes->idestado_programacion_reportes_abril==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>4) red @elseif ($mes_actual==4) @if ($programacion_reporte_etes->abril>=$dia_actual and $programacion_reporte_etes->abril>0) yellow @elseif ($programacion_reporte_etes->abril>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal"><center><a href="@if($programacion_reporte_etes->idestado_programacion_reportes_abril==2) {{URL::to('/reporte_etes/edit_reporte_etes/')}}/{{$programacion_reporte_etes->idreporte_etes_abril}} @else {{URL::to('/reporte_etes/create_reporte_etes/')}}/{{$programacion_reporte_etes->idprogramacion_reporte_etes_abril}} @endif">{{$programacion_reporte_etes->abril}}</a></center></th>
						<th bgcolor='@if($programacion_reporte_etes->idestado_programacion_reportes_mayo==2) lightGreen @elseif($programacion_reporte_etes->idestado_programacion_reportes_mayo==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>5) red @elseif ($mes_actual==5) @if ($programacion_reporte_etes->mayo>=$dia_actual and $programacion_reporte_etes->mayo>0) yellow @elseif ($programacion_reporte_etes->mayo>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal"><center><a href="@if($programacion_reporte_etes->idestado_programacion_reportes_mayo==2) {{URL::to('/reporte_etes/edit_reporte_etes/')}}/{{$programacion_reporte_etes->idreporte_etes_mayo}} @else {{URL::to('/reporte_etes/create_reporte_etes/')}}/{{$programacion_reporte_etes->idprogramacion_reporte_etes_mayo}} @endif">{{$programacion_reporte_etes->mayo}}</a></center></th>
						<th bgcolor='@if($programacion_reporte_etes->idestado_programacion_reportes_junio==2) lightGreen @elseif($programacion_reporte_etes->idestado_programacion_reportes_junio==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>6) red @elseif ($mes_actual==6) @if ($programacion_reporte_etes->junio>=$dia_actual and $programacion_reporte_etes->junio>0) yellow @elseif ($programacion_reporte_etes->junio>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal"><center><a href="@if($programacion_reporte_etes->idestado_programacion_reportes_junio==2) {{URL::to('/reporte_etes/edit_reporte_etes/')}}/{{$programacion_reporte_etes->idreporte_etes_junio}} @else {{URL::to('/reporte_etes/create_reporte_etes/')}}/{{$programacion_reporte_etes->idprogramacion_reporte_etes_junio}} @endif">{{$programacion_reporte_etes->junio}}</a></center></th>
						<th bgcolor='@if($programacion_reporte_etes->idestado_programacion_reportes_julio==2) lightGreen @elseif($programacion_reporte_etes->idestado_programacion_reportes_julio==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>7) red @elseif ($mes_actual==7) @if ($programacion_reporte_etes->julio>=$dia_actual and $programacion_reporte_etes->julio>0) yellow @elseif ($programacion_reporte_etes->julio>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal"><center><a href="@if($programacion_reporte_etes->idestado_programacion_reportes_julio==2) {{URL::to('/reporte_etes/edit_reporte_etes/')}}/{{$programacion_reporte_etes->idreporte_etes_julio}} @else {{URL::to('/reporte_etes/create_reporte_etes/')}}/{{$programacion_reporte_etes->idprogramacion_reporte_etes_julio}} @endif">{{$programacion_reporte_etes->julio}}</a></center></th>
						<th bgcolor='@if($programacion_reporte_etes->idestado_programacion_reportes_agosto==2) lightGreen @elseif($programacion_reporte_etes->idestado_programacion_reportes_agosto==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>8) red @elseif ($mes_actual==8) @if ($programacion_reporte_etes->agosto>=$dia_actual and $programacion_reporte_etes->agosto>0) yellow @elseif ($programacion_reporte_etes->agosto>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal"><center><a href="@if($programacion_reporte_etes->idestado_programacion_reportes_agosto==2) {{URL::to('/reporte_etes/edit_reporte_etes/')}}/{{$programacion_reporte_etes->idreporte_etes_agosto}} @else {{URL::to('/reporte_etes/create_reporte_etes/')}}/{{$programacion_reporte_etes->idprogramacion_reporte_etes_agosto}} @endif">{{$programacion_reporte_etes->agosto}}</a></center></th>
						<th bgcolor='@if($programacion_reporte_etes->idestado_programacion_reportes_setiembre==2) lightGreen @elseif($programacion_reporte_etes->idestado_programacion_reportes_setiembre==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>9) red @elseif ($mes_actual==9) @if ($programacion_reporte_etes->setiembre>=$dia_actual and $programacion_reporte_etes->setiembre>0) yellow @elseif ($programacion_reporte_etes->setiembre>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal"><center><a href="@if($programacion_reporte_etes->idestado_programacion_reportes_setiembre==2) {{URL::to('/reporte_etes/edit_reporte_etes/')}}/{{$programacion_reporte_etes->idreporte_etes_setiembre}} @else {{URL::to('/reporte_etes/create_reporte_etes/')}}/{{$programacion_reporte_etes->idprogramacion_reporte_etes_setiembre}} @endif">{{$programacion_reporte_etes->setiembre}}</a></center></th>
						<th bgcolor='@if($programacion_reporte_etes->idestado_programacion_reportes_octubre==2) lightGreen @elseif($programacion_reporte_etes->idestado_programacion_reportes_octubre==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>10) red @elseif ($mes_actual==10) @if ($programacion_reporte_etes->octubre>=$dia_actual and $programacion_reporte_etes->octubre>0) yellow @elseif ($programacion_reporte_etes->octubre>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal"><center><a href="@if($programacion_reporte_etes->idestado_programacion_reportes_octubre==2) {{URL::to('/reporte_etes/edit_reporte_etes/')}}/{{$programacion_reporte_etes->idreporte_etes_octubre}} @else {{URL::to('/reporte_etes/create_reporte_etes/')}}/{{$programacion_reporte_etes->idprogramacion_reporte_etes_octubre}} @endif">{{$programacion_reporte_etes->octubre}}</a></center></th>
						<th bgcolor='@if($programacion_reporte_etes->idestado_programacion_reportes_noviembre==2) lightGreen @elseif($programacion_reporte_etes->idestado_programacion_reportes_noviembre==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>11) red @elseif ($mes_actual==11) @if ($programacion_reporte_etes->noviembre>=$dia_actual and $programacion_reporte_etes->noviembre>0) yellow @elseif ($programacion_reporte_etes->noviembre>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal"><center><a href="@if($programacion_reporte_etes->idestado_programacion_reportes_noviembre==2) {{URL::to('/reporte_etes/edit_reporte_etes/')}}/{{$programacion_reporte_etes->idreporte_etes_noviembre}} @else {{URL::to('/reporte_etes/create_reporte_etes/')}}/{{$programacion_reporte_etes->idprogramacion_reporte_etes_noviembre}} @endif">{{$programacion_reporte_etes->noviembre}}</a></center></th>
						<th bgcolor='@if($programacion_reporte_etes->idestado_programacion_reportes_diciembre==2) lightGreen @elseif($programacion_reporte_etes->idestado_programacion_reportes_diciembre==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>12) red @elseif ($mes_actual==12) @if ($programacion_reporte_etes->diciembre>=$dia_actual and $programacion_reporte_etes->diciembre>0) yellow @elseif ($programacion_reporte_etes->diciembre>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal"><center><a href="@if($programacion_reporte_etes->idestado_programacion_reportes_diciembre==2) {{URL::to('/reporte_etes/edit_reporte_etes/')}}/{{$programacion_reporte_etes->idreporte_etes_diciembre}} @else {{URL::to('/reporte_etes/create_reporte_etes/')}}/{{$programacion_reporte_etes->idprogramacion_reporte_etes_diciembre}} @endif">{{$programacion_reporte_etes->diciembre}}</a></center></th>		
					</tr>
				@endif
			@endforeach

			<tr bgcolor = 'lightgrey'>
				<th>Guía GPC</th>
				<th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
			</tr>

			@foreach($programaciones_reporte_gpc as $programacion_reporte_gpc)

				@if($usuario_responsable_data->iduser == $programacion_reporte_gpc->iduser)
					<tr><th class="info" style="font-weight:normal">{{$programacion_reporte_gpc->nombre_reporte}}</th>
						
						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month == 1)
							<th bgcolor='@if($programacion_reporte_gpc->id_estado==2) lightGreen @elseif($programacion_reporte_gpc->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_gpc->id_estado==2 || ($programacion_reporte_gpc->guia && $programacion_reporte_gpc->guia->url=="")) {{URL::to('/guias_clinica_gpc/edit_guia/')}}/{{$programacion_reporte_gpc->id_guia}} @else {{URL::to('/guias_clinica_gpc/create_guia/')}}/{{$programacion_reporte_gpc->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif

						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month == 2)
							<th bgcolor='@if($programacion_reporte_gpc->id_estado==2) lightGreen @elseif($programacion_reporte_gpc->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_gpc->id_estado==2 || ($programacion_reporte_gpc->guia && $programacion_reporte_gpc->guia->url=="")) {{URL::to('/guias_clinica_gpc/edit_guia/')}}/{{$programacion_reporte_gpc->id_guia}} @else {{URL::to('/guias_clinica_gpc/create_guia/')}}/{{$programacion_reporte_gpc->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif

						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month == 3)
							<th bgcolor='@if($programacion_reporte_gpc->id_estado==2) lightGreen @elseif($programacion_reporte_gpc->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_gpc->id_estado==2 || ($programacion_reporte_gpc->guia && $programacion_reporte_gpc->guia->url=="")) {{URL::to('/guias_clinica_gpc/edit_guia/')}}/{{$programacion_reporte_gpc->id_guia}} @else {{URL::to('/guias_clinica_gpc/create_guia/')}}/{{$programacion_reporte_gpc->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif

						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month == 4)
							<th bgcolor='@if($programacion_reporte_gpc->id_estado==2) lightGreen @elseif($programacion_reporte_gpc->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_gpc->id_estado==2 || ($programacion_reporte_gpc->guia && $programacion_reporte_gpc->guia->url=="")) {{URL::to('/guias_clinica_gpc/edit_guia/')}}/{{$programacion_reporte_gpc->id_guia}} @else {{URL::to('/guias_clinica_gpc/create_guia/')}}/{{$programacion_reporte_gpc->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif

						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month == 5)
							<th bgcolor='@if($programacion_reporte_gpc->id_estado==2) lightGreen @elseif($programacion_reporte_gpc->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_gpc->id_estado==2 || ($programacion_reporte_gpc->guia && $programacion_reporte_gpc->guia->url=="")) {{URL::to('/guias_clinica_gpc/edit_guia/')}}/{{$programacion_reporte_gpc->id_guia}} @else {{URL::to('/guias_clinica_gpc/create_guia/')}}/{{$programacion_reporte_gpc->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif

						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month == 6)
							<th bgcolor='@if($programacion_reporte_gpc->id_estado==2) lightGreen @elseif($programacion_reporte_gpc->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_gpc->id_estado==2 || ($programacion_reporte_gpc->guia && $programacion_reporte_gpc->guia->url=="")) {{URL::to('/guias_clinica_gpc/edit_guia/')}}/{{$programacion_reporte_gpc->id_guia}} @else {{URL::to('/guias_clinica_gpc/create_guia/')}}/{{$programacion_reporte_gpc->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif

						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month == 7)
							<th bgcolor='@if($programacion_reporte_gpc->id_estado==2) lightGreen @elseif($programacion_reporte_gpc->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_gpc->id_estado==2 || ($programacion_reporte_gpc->guia && $programacion_reporte_gpc->guia->url=="")) {{URL::to('/guias_clinica_gpc/edit_guia/')}}/{{$programacion_reporte_gpc->id_guia}} @else {{URL::to('/guias_clinica_gpc/create_guia/')}}/{{$programacion_reporte_gpc->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif

						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month == 8)
							<th bgcolor='@if($programacion_reporte_gpc->id_estado==2) lightGreen @elseif($programacion_reporte_gpc->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_gpc->id_estado==2 || ($programacion_reporte_gpc->guia && $programacion_reporte_gpc->guia->url=="")) {{URL::to('/guias_clinica_gpc/edit_guia/')}}/{{$programacion_reporte_gpc->id_guia}} @else {{URL::to('/guias_clinica_gpc/create_guia/')}}/{{$programacion_reporte_gpc->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif

						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month == 9)
							<th bgcolor='@if($programacion_reporte_gpc->id_estado==2) lightGreen @elseif($programacion_reporte_gpc->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_gpc->id_estado==2 || ($programacion_reporte_gpc->guia && $programacion_reporte_gpc->guia->url=="")) {{URL::to('/guias_clinica_gpc/edit_guia/')}}/{{$programacion_reporte_gpc->id_guia}} @else {{URL::to('/guias_clinica_gpc/create_guia/')}}/{{$programacion_reporte_gpc->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif

						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month == 10)
							<th bgcolor='@if($programacion_reporte_gpc->id_estado==2) lightGreen @elseif($programacion_reporte_gpc->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_gpc->id_estado==2 || ($programacion_reporte_gpc->guia && $programacion_reporte_gpc->guia->url=="")) {{URL::to('/guias_clinica_gpc/edit_guia/')}}/{{$programacion_reporte_gpc->id_guia}} @else {{URL::to('/guias_clinica_gpc/create_guia/')}}/{{$programacion_reporte_gpc->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif

						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month == 11)
							<th bgcolor='@if($programacion_reporte_gpc->id_estado==2) lightGreen @elseif($programacion_reporte_gpc->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_gpc->id_estado==2 || ($programacion_reporte_gpc->guia && $programacion_reporte_gpc->guia->url=="")) {{URL::to('/guias_clinica_gpc/edit_guia/')}}/{{$programacion_reporte_gpc->id_guia}} @else {{URL::to('/guias_clinica_gpc/create_guia/')}}/{{$programacion_reporte_gpc->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif

						@if(\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month == 12)
							<th bgcolor='@if($programacion_reporte_gpc->id_estado==2) lightGreen @elseif($programacion_reporte_gpc->id_estado==1) @if($anho_actual<$search_fecha and $search_fecha>0) yellow @elseif($anho_actual>$search_fecha and $search_fecha>0) red @else @if($mes_actual>\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) red @elseif($mes_actual<\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) yellow @elseif ($mes_actual==\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->month) @if (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>=$dia_actual and \Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) yellow @elseif (\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day>0) red @endif @else lightGreen @endif @endif @endif' style="font-weight:normal">
							<center><a href="@if($programacion_reporte_gpc->id_estado==2 || ($programacion_reporte_gpc->guia && $programacion_reporte_gpc->guia->url=="")) {{URL::to('/guias_clinica_gpc/edit_guia/')}}/{{$programacion_reporte_gpc->id_guia}} @else {{URL::to('/guias_clinica_gpc/create_guia/')}}/{{$programacion_reporte_gpc->id}} @endif">{{\Carbon\Carbon::createFromFormat('Y-m-d',$programacion_reporte_gpc->fecha)->day}}</a></center></th>
						@else
							<th></th>
						@endif
					</tr>
				@endif
			@endforeach
		</table>
	@endforeach
@stop