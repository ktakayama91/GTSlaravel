@extends('templates/otVerificacionMetrologicaTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Verificación Metrológica</h3>
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

	<div class="container-fluid form-group row">
		<div class="col-md-4 col-md-offset-8">
			<a class="btn btn-primary btn-block" href="{{URL::to('/verif_metrologica/programacion')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar Verificación Metrológica</a>
		</div>
	</div>
    {{ Form::open(array('url'=>'/verif_metrologica/search_ot_verif_metrologica','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	<div class="container-fluid form-group row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Búsqueda</h3>
				</div>
				<div class="panel-body">
					<div class="container-fluid form-group row">
						<div class="form-group col-md-4">
							{{ Form::label('search_ing','Ingeniero a cargo del activo') }}
							{{ Form::text('search_ing',$search_ing,array('class'=>'form-control','placeholder'=>'Nombre o apellidos','id'=>'search_ing')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_cod_pat','Código patrimonial') }}
							{{ Form::text('search_cod_pat',$search_cod_pat,array('class'=>'form-control','id'=>'search_cod_pat','placeholder'=>'Código Patrimonial')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_ubicacion','Ubicación') }}
							{{ Form::text('search_ubicacion',$search_ubicacion,array('class'=>'form-control','placeholder'=>'Ubicación física','id'=>'search_ubicacion')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_ot','Orden de Trabajo de VM') }}
							{{ Form::text('search_ot',$search_ot,array('class'=>'form-control','placeholder'=>'Número de OT','id'=>'search_ot')) }}
						</div>					
						<div class="form-group col-md-4">
							{{ Form::label('search_equipo','Equipo relacionado') }}
							{{ Form::text('search_equipo',$search_equipo,array('class'=>'form-control','id'=>'search_equipo','placeholder'=>'Nombre de Equipo')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_proveedor','Proveedor') }}
							{{ Form::text('search_proveedor',$search_proveedor,array('class'=>'form-control','placeholder'=>'RUC, Razón social o Nombre de contacto','id'=>'search_proveedor')) }}
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
						<div class="form-group col-md-2 col-md-offset-8">
						{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}	
						</div>
						<div class="form-group col-md-2">
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
						<th class="text-nowrap text-center">Orden Trabajo</th>
						<th class="text-nowrap text-center">Fecha y hora</th>
						<th class="text-nowrap text-center">Departamento</th>
						<th class="text-nowrap text-center">Servicio</th>
						<th class="text-nowrap text-center">Ingeniero</th>
						<th class="text-nowrap text-center">Ubicación</th>
						<th class="text-nowrap text-center">Estado</th>
					</tr>
					@foreach($verif_metrologicas_data as $index => $verif_metrologica_data)
					{{form::hidden('fila',$verif_metrologica_data->idot_vmetrologica,array('id'=>'fila'.$index))}}
					<tr>
						<td class="text-nowrap text-center">
							@if($user->idrol==1 || $user->idrol==2 || $user->idrol==3 ||$user->idrol==4)
								@if($verif_metrologica_data->idestado_ot == 9)
									<a href="{{URL::to('/verif_metrologica/create_ot_verif_metrologica/')}}/{{$verif_metrologica_data->idot_vmetrologica}}">{{$verif_metrologica_data->ot_tipo_abreviatura}}{{$verif_metrologica_data->ot_correlativo}}{{$verif_metrologica_data->ot_activo_abreviatura}}</a>		
								@else
									<a href="{{URL::to('/verif_metrologica/view_ot_verif_metrologica/')}}/{{$verif_metrologica_data->idot_vmetrologica}}">{{$verif_metrologica_data->ot_tipo_abreviatura}}{{$verif_metrologica_data->ot_correlativo}}{{$verif_metrologica_data->ot_activo_abreviatura}}</a>
								@endif
							@else
								<a href="{{URL::to('/verif_metrologica/view_ot_verif_metrologica/')}}/{{$verif_metrologica_data->idot_vmetrologica}}">{{$verif_metrologica_data->ot_tipo_abreviatura}}{{$verif_metrologica_data->ot_correlativo}}{{$verif_metrologica_data->ot_activo_abreviatura}}</a>
							@endif
							
						</td>
						<td class="text-nowrap text-center">
							{{date('d-m-Y H:i:s',strtotime($verif_metrologica_data->fecha_programacion))}}
						</td>
						<td class="text-nowrap text-center">
							{{$verif_metrologica_data->nombre_area}}
						</td>
						<td class="text-nowrap text-center">
							{{$verif_metrologica_data->nombre_servicio}}
						</td>
						<td class="text-nowrap text-center">
							{{$verif_metrologica_data->apellido_pat}} {{$verif_metrologica_data->apellido_mat}}, {{$verif_metrologica_data->nombre_user}}
						</td>
						<td class="text-nowrap text-center">
							{{$verif_metrologica_data->nombre_ubicacion}}
						</td>										
						<td class="text-nowrap text-center">
							{{$verif_metrologica_data->nombre_estado}}
						</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>
	
@if($search_ing || $search_cod_pat || $search_ubicacion || $search_ot || $search_equipo || $search_proveedor || $search_ini || $search_fin)
	{{ $verif_metrologicas_data->appends(array('search_ing' => $search_ing,'search_cod_pat'=>$search_cod_pat,'search_ubicacion'=>$search_ubicacion,'search_ot'=>$search_ot,'search_equipo'=>$search_equipo,'search_proveedor'=>$search_proveedor,'search_ini'=>$search_ini,'search_fin'=>$search_fin))->links() }}
@else
	{{ $verif_metrologicas_data->links() }}
@endif
	
<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="modal_list_ot" role="dialog">
    <div class="modal-dialog modal-md">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" id="modal_list_header_ot">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Advertencia</h4>
        </div>
        <div class="modal-body" id="modal_text_list_ot">         	
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" id="btn_close_modal" data-dismiss="modal">Aceptar</button>
        </div>
      </div>      
    </div>
  </div>  
</div>
@stop