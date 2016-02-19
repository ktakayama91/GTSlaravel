<?php

class ReportesCalibracionController extends BaseController
{
	public function list_reportes_calibracion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12 ){
				
				$data["search_codigo_reporte"] = null;
				$data["search_codigo_patrimonial"] = null;
				$data["search_nombre_equipo"] = null;
				$data["search_servicio"] = null;
				$data["search_area"] = null;
				$data["search_grupo"] = null;
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["areas"] = Area::lists('nombre','idarea');
				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				$data["reportes_data"] = ReporteCalibracion::getReportesInfo()->distinct()->paginate(10);
				return View::make('riesgos/reporte_calibracion/listReporteCalibracion',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_reporte_calibracion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1)
			{
				$data["search_codigo_reporte"] = Input::get('search_codigo_reporte');
				$data["search_codigo_patrimonial"] = Input::get('search_codigo_patrimonial');
				$data["search_nombre_equipo"] = Input::get('search_nombre_equipo');
				$data["search_servicio"] = Input::get('search_servicio');
				$data["search_area"] = Input::get('search_area');
				$data["search_grupo"] = Input::get('search_grupo');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["areas"] = Area::lists('nombre','idarea');
				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				
				$data["reportes_data"] = ReporteCalibracion::searchReportesCalibracion($data["search_codigo_reporte"],$data["search_codigo_patrimonial"],$data["search_nombre_equipo"],$data["search_servicio"],$data["search_area"],$data["search_grupo"])->distinct()->paginate(10);
				
				return View::make('riesgos/reporte_calibracion/listReporteCalibracion',$data);	
				
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_create_reporte()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12 ){
				
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["areas"] = Area::lists('nombre','idarea');
				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				return View::make('riesgos/reporte_calibracion/createReporteCalibracion',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_reporte_calibracion(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs
				 
				
				$attributes = array(
					
				);



				$messages = array(
					);

				$rules = array(
					
				);

				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages, $attributes);
				

				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('reportes_calibracion/create_reporte')->withErrors($validator)->withInput(Input::all());
				}else{	
					$array_activos_no_registrados = [];
					$cantidad_activos = Input::get('cantidad_activos');
					if($cantidad_activos>0){
						$array_idactivos = Input::get('details_activos');

						for($i=0;$i<$cantidad_activos;$i++){
							$idactivo = $array_idactivos[$i];
							//se realiza una primera validacion de que se estan subierno por lo menos un archivo.
							$existeArchivos = 0;
							for($j=0;$j<5;$j++){
								if(Input::hasFile('input-file-'.$idactivo.'-'.$j)){
									$existeArchivos = 1;
									break;
								}
							}

							

							if($existeArchivos == 1){								
								//como ya existe se crea de una vez el reporte de calibracion
								$reporte_calibracion = new ReporteCalibracion;
								$reporte_calibracion->codigo_abreviatura = "RC";
								$reporte_calibracion->codigo_correlativo = $this->getCorrelativeReportNumber();
								$reporte_calibracion->codigo_anho = date('y');
								$reporte_calibracion->idactivo = $idactivo;
								$reporte_calibracion->save();
								for($j=0;$j<5;$j++){
									if(Input::hasFile('input-file-'.$idactivo.'-'.$j)){	
										$archivo            = Input::file('input-file-'.$idactivo.'-'.$j);
								        $rutaDestino = 'documentos/riesgos/Reportes de Calibracion/' . $reporte_calibracion->codigo_abreviatura . $reporte_calibracion->codigo_correlativo. $reporte_calibracion->codigo_anho  . '/';
								        $nombreArchivo        = $archivo->getClientOriginalName();
								        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
								        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);
										$detalle_reporte_calibracion = new DetalleReporteCalibracion;										
										$detalle_reporte_calibracion->nombre = $nombreArchivo;
										$detalle_reporte_calibracion->nombre_archivo = $nombreArchivo;
										$detalle_reporte_calibracion->nombre_archivo_encriptado = $nombreArchivoEncriptado;
										$detalle_reporte_calibracion->url = $rutaDestino;
										$detalle_reporte_calibracion->idreporte_calibracion = $reporte_calibracion->id;
										$detalle_reporte_calibracion->save();
									}
								}
							}else{	
								array_push($array_activos_no_registrados, $idactivo);
							}					
							
						}
						
						$string = "Se han registrado los reportes de calibracion con excepción de los siguientes equipos:<br>";
						$cantidad = count($array_activos_no_registrados);
						if($cantidad != $cantidad_activos){
							for($i=0;$i<$cantidad;$i++){
								$activo = Activo::searchActivosById($array_activos_no_registrados[$i])->get()[0];
								$familia_activo = FamiliaActivo::find($activo->idfamilia_activo)->get()[0];
								$modelo_activo = ModeloActivo::find($activo->modelo)->get()[0];
								$string_line = ($i+1).': Equipo: '.$familia_activo->nombre_equipo.' Modelo: '.$modelo_activo->nombre.' Cód. Patrimonial: '.$activo->codigo_patrimonial.'<br>';
								$string = $string.$string_line;							
							}
						}else{
							Session::flash('error','Para registrar un reporte de calibración a un equipo debe adjuntarle por lo menos 1 documento.');
							return Redirect::to('reportes_calibracion/create_reporte');
						}
						Session::flash('message', $string);				
						return Redirect::to('reportes_calibracion/list_reportes_calibracion');
					}else{
						Session::flash('error','Ingrese uno o más equipos médicos');
						return Redirect::to('reportes_calibracion/create_reporte');
					}
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}
	

	public function search_activos(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
			|| $data["user"]->idrol == 7 || $data["user"]->idrol == 8  || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$codigo_patrimonial = Input::get('codigo_patrimonial');
			$nombre_equipo = Input::get('nombre_equipo');
			$area = Input::get('area');
			$servicio = Input::get('servicio');
			$grupo = Input::get('grupo');
		
			$activos = Activo::searchActivosCalibracion($codigo_patrimonial,$nombre_equipo,$area,$servicio,$grupo)->get();
			if($activos->isEmpty())
				$activos = null;
			
				

			return Response::json(array( 'success' => true, 'activos' => $activos),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function getCorrelativeReportNumber(){
		$reporte_ultimo = ReporteCalibracion::orderBy('id','desc')->first();
		$string = "";
		if($reporte_ultimo!=null){	
			$numero = $reporte_ultimo->codigo_correlativo;
			$cantidad_digitos = strlen($numero+1);						
			for($i=0;$i<4-$cantidad_digitos;$i++){
				$string = $string."0";
			}
			$string = $string.($numero+1);					
		}else{
			$string = "0001";
		}
		return $string;
	}

	public function search_documentos(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
			|| $data["user"]->idrol == 7 || $data["user"]->idrol == 8  || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$idreporte = Input::get('id_reporte');
			$documentos = ReporteCalibracion::getDetalleReporteCalibracion($idreporte)->get();
				

			return Response::json(array( 'success' => true, 'documentos' => $documentos),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function download_documento($idDocumento=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$documento = DetalleReporteCalibracion::find($idDocumento);
				$rutaDestino = $documento->url.$documento->nombre_archivo_encriptado;
		        $headers = array(
		              'Content-Type',mime_content_type($rutaDestino),
		            );
		        return Response::download($rutaDestino,basename($documento->nombre_archivo),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

}

