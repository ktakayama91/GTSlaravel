@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-md-12">
            <h3 class="page-header">Agregar Consumible: <strong>{{$familia_activo_info->nombre_equipo}} - {{$modelo_info->nombre}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('nombre_consumible') }}</strong></p>
			<p><strong>{{ $errors->first('cantidad_consumible') }}</strong></p>
			<p><strong>{{ $errors->first('costo_consumible') }}</strong></p>			
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success alert-dissmisable">
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

	{{ Form::open(array('url'=>'familia_activos/submit_create_consumible_modelo_familia_activo', 'role'=>'form')) }}
	{{ Form::hidden('idmodelo_equipo', $modelo_info->idmodelo_equipo) }}
		<div class="panel panel-default">
		  	<div class="panel-heading">Nuevo Consumible</div>
		  	<div class="panel-body">
		  		<div class="row">
		  			<div class="form-group col-md-4 @if($errors->first('nombre_consumible')) has-error has-feedback @endif">
						{{ Form::label('nombre_consumible','Nombre') }}
						{{ Form::text('nombre_consumible',Input::old('nombre_consumible'),array('class'=>'form-control','maxlength'=>'45')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('cantidad_consumible')) has-error has-feedback @endif">
						{{ Form::label('cantidad_consumible','Cantidad') }}
						{{ Form::text('cantidad_consumible',Input::old('cantidad_consumible'),array('class'=>'form-control','maxlength'=>'45')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('costo_consumible')) has-error has-feedback @endif">
						{{ Form::label('costo_consumible','Costo') }}
						{{ Form::text('costo_consumible',Input::old('costo_consumible'),array('class'=>'form-control','maxlength'=>'45')) }}
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
				<th>Nombre</th>
				<th>Cantidad</th>				
				<th>Costo (S/.)</th>
				<th>Eliminar</th>
			</tr>
			@foreach($consumibles_info as $index => $consumible_info)
			<tr>
				<td>
					{{$index + 1}}
				</td>
				<td>
					{{$consumible_info->nombre}}
				</td>
				<td>
					{{$consumible_info->cantidad}}
				</td>
				<td>
					{{number_format($consumible_info->costo,2)}}
				</td>
				<td>
					<button class="btnEliminarConsumible btn btn-danger btn-block btn-sm" data-value="{{$consumible_info->idconsumible}}">
					<span class="glyphicon glyphicon-trash"></span> Eliminar</button>					
				</td>
			</tr>
			@endforeach
		</table>
	</div>


<div id="modal_delete_consumible" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">ADVERTENCIA</h4>
      </div>
      <div class="modal-body">
        <p>¿Está seguro que desea eliminar el consumible?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="modal_btnEliminarConsumible btn btn-danger">Eliminar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop