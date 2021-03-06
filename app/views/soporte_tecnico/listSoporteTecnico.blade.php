@extends('templates/bienesTemplate')
@section('content')
	
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Soporte Técnico</h3>
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
		<div class="alert alert-danger alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

    {{ Form::open(array('url'=>'soportes_tecnico/search_soporte_tecnico','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}	
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Búsqueda</h3>
	  </div>
	  <div class="panel-body">

	  	<div class="row">
	  		<div class="form-group col-md-4">
	  			{{ Form::label('proveedor','Proveedor') }}
				{{ Form::select('proveedor', array('' => 'Seleccione') + $proveedor,$search_proveedor,['class' => 'form-control']) }}										
			</div>
  			<div class="form-group col-md-4">
				{{ Form::label('tipo_documento_identidad','Tipo de Documento') }}
				{{ Form::select('tipo_documento_identidad', array('' => 'Seleccione') + $tipo_documento_identidad,$search_tipo_documento,['class' => 'form-control']) }}						
			</div>
			<div class="form-group col-md-4">
				{{ Form::label('numero_documento_soporte_tecnico','Número de Documento') }}
				{{ Form::text('numero_documento_soporte_tecnico',$search_numero_documento,array('class'=>'form-control')) }}
			</div>													
  		</div>

  		<div class="row">
  			<div class="form-group col-md-4">
				{{ Form::label('nombre_soporte_tecnico','Nombre') }}
				{{ Form::text('nombre_soporte_tecnico',$search_nombre,array('class'=>'form-control','placeholder'=>'Nombres')) }}
			</div>
			<div class="form-group col-md-4">
				{{ Form::label('apPaterno_soporte_tecnico','Apellido Paterno') }}
				{{ Form::text('apPaterno_soporte_tecnico',$search_apPaterno,array('class'=>'form-control','placeholder'=>'Apellido Paterno')) }}
			</div>
			<div class="form-group col-md-4">
				{{ Form::label('apMaterno_soporte_tecnico','Apellido Materno') }}
				{{ Form::text('apMaterno_soporte_tecnico',$search_apMaterno,array('class'=>'form-control','placeholder'=>'Apellido Materno')) }}
			</div>
  		</div>

		<div class="row">
			<div class="form-group col-md-2 col-md-offset-8">
				{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}				
			</div>
			<div class="form-group col-md-2">
				<div class="btn btn-default btn-block" id="btnLimpiar_soporte_tecnico">Limpiar</div>				
			</div>
		</div>

	  </div>
	</div>
	
	{{ Form::close() }}			
    <div class="row">
    	<div class="col-md-12">
			<div class="table-responsive">
				<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th class="text-nowrap text-center">Nº</th>
						<th class="text-nowrap text-center">Tipo de Documento</th>
						<th class="text-nowrap text-center">Número de Documento</th>
						<th class="text-nowrap text-center">Nombre</th>
						<th class="text-nowrap text-center">Apellido Paterno</th>
						<th class="text-nowrap text-center">Apellido Materno</th>
						<th class="text-nowrap text-center">Proveedor</th>
						<th class="text-nowrap text-center">Especialidad</th>
						<th class="text-nowrap text-center">Teléfono</th>				
						<th class="text-nowrap text-center">E-mail</th>						
					</tr>
					@foreach($soportes_tecnico_data as $index => $soporte_tecnico)
					<tr class="@if($soporte_tecnico->deleted_at) bg-danger @endif">			
						<td class="text-nowrap text-center">
							{{$index + 1}}
						</td>
						<td class="text-nowrap text-center">
							{{$soporte_tecnico->tipo_documento}}
						</td>
						<td class="text-nowrap text-center">							
							<a href="{{URL::to('/soportes_tecnico/view_soporte_tecnico')}}/{{$soporte_tecnico->idsoporte_tecnico}}">{{$soporte_tecnico->numero_doc_identidad}}</a>							
						</td>	
						<td class="text-nowrap">
							{{$soporte_tecnico->nombres}}
						</td>
						<td class="text-nowrap">
							{{$soporte_tecnico->apellido_pat}}
						</td>
						<td class="text-nowrap">
							{{$soporte_tecnico->apellido_mat}}
						</td>
						<td class="text-nowrap text-center">
							{{$soporte_tecnico->proveedor}}
						</td>					
						<td class="text-nowrap text-center">
							{{$soporte_tecnico->especialidad}}
						</td>
						<td class="text-nowrap text-center">
							{{$soporte_tecnico->telefono}}
						</td>
						<td class="text-nowrap text-center">
							{{$soporte_tecnico->email}}
						</td>										
					</tr>
					@endforeach							
				</table>
				</div>
			</div>
		</div>
	</div>	
@stop