@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-md-12">
            <h3 class="page-header">Agregar Componente: <strong>{{$familia_activo_info->nombre_equipo}} - {{$modelo_info->nombre}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre_componente') }}</strong></p>
			<p><strong>{{ $errors->first('modelo_componente') }}</strong></p>
			<p><strong>{{ $errors->first('costo_componente') }}</strong></p>
			<p><strong>{{ $errors->first('numero_pieza') }}</strong></p>		
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('message') }}
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'familia_activos/submit_create_componente_modelo_familia_activo', 'role'=>'form')) }}
	{{ Form::hidden('idmodelo_equipo', $modelo_info->idmodelo_equipo) }}
		<div class="panel panel-default">
		  	<div class="panel-heading">Nuevo Componente</div>
		  	<div class="panel-body">
		  		<div class="row">
		  			<div class="form-group col-md-4 @if($errors->first('nombre_componente')) has-error has-feedback @endif">
						{{ Form::label('nombre_componente','Nombre') }}
						{{ Form::text('nombre_componente',Input::old('nombre_componente'),array('class'=>'form-control','maxlength'=>'45')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('modelo_componente')) has-error has-feedback @endif">
						{{ Form::label('modelo_componente','Modelo') }}
						{{ Form::text('modelo_componente',Input::old('modelo_componente'),array('class'=>'form-control','maxlength'=>'45')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('costo_componente')) has-error has-feedback @endif">
						{{ Form::label('costo_componente','Costo') }}
						{{ Form::text('costo_componente',Input::old('costo_componente'),array('class'=>'form-control','maxlength'=>'45')) }}
					</div>
		  		</div>
		  		<div class="row">
		  			<div class="form-group col-md-4 @if($errors->first('numero_pieza')) has-error has-feedback @endif">
		  				{{ Form::label('numero_pieza','Numero de Pieza') }}
						{{ Form::text('numero_pieza',Input::old('numero_pieza'),array('class'=>'form-control','maxlength'=>'45')) }}
		  			</div>
		  		</div>
			</div>
		</div>			

		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">				
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Agregar', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/familia_activos/edit_familia_activo')}}/{{$familia_activo_info->idfamilia_activo}}">Cancelar</a>				
			</div>
		</div>
	{{ Form::close() }}

	<div class="table-responsive">
		<table class="table">
			<tr class="info">
				<th>Nº</th>
				<th>Numero de Pieza</th>
				<th>Nombre</th>
				<th>Modelo</th>				
				<th>Costo (S/.)</th>
				<th>Eliminar</th>
			</tr>
			@foreach($componentes_info as $index => $componente_info)
			<tr>
				<td>
					{{$index + 1}}
				</td>
				<td>
					{{$componente_info->numero_pieza}}
				</td>
				<td>
					{{$componente_info->nombre}}
				</td>
				<td>
					{{$componente_info->modelo}}
				</td>
				<td>
					{{number_format($componente_info->costo,2)}}
				</td>
				<td>
					<button class="btnEliminarComponente btn btn-danger btn-block btn-sm" data-value="{{$componente_info->idcomponente}}">
					<span class="glyphicon glyphicon-trash"></span> Eliminar</button>					
				</td>
			</tr>
			@endforeach
		</table>
	</div>


<div id="modal_delete_componente" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">ADVERTENCIA</h4>
      </div>
      <div class="modal-body">
        <p>¿Está seguro que desea eliminar el componente?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="modal_btnEliminarComponente btn btn-danger">Eliminar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop