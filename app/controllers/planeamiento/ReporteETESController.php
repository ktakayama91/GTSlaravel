<?php

class ReporteETESController extends BaseController
{
	public function render_create_reporte_etes()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["tipo_reporte_etes"] = TipoReporteETES::lists('nombre','idtipo_reporte_etes');
				$data["reporte_etes_info"] = null;
				return View::make('reportes_ETES/createReporteETES',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_reporte_etes(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs	
				$rules = array(
							'idtipo_reporte' => 'required',
							'nombre' => 'required|unique:reporte_etes',	
							'archivo' => 'max:15360|mimes:png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx',										
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('reporte_etes/create_reporte_etes')->withErrors($validator)->withInput(Input::all());					
				}else{
					switch (Input::get('idtipo_reporte')) {
					    case 1:
					        $abreviatura = "EC";
					        break;
					    case 2:
					        $abreviatura = "ET";
					        break;
					    case 3:
					        $abreviatura = "EE";
					        break;
					}

				    $rutaDestino ='';
				    $nombreArchivo ='';	
				    if (Input::hasFile('archivo')) {
				        $archivo = Input::file('archivo');
				        $rutaDestino = 'documentos/reporteETES/';
				        $nombreArchivo        = $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);
				    }

					$correlativo = $this->getCorrelativeReportNumber($abreviatura);
					$anho = date('y');
					$reporte_etes = new ReporteETES;
					$reporte_etes->numero_reporte_abreviatura = $abreviatura;
					$reporte_etes->numero_reporte_correlativo = $correlativo;
					$reporte_etes->numero_reporte_anho = $anho;
					$reporte_etes->nombre = Input::get('nombre');
					$reporte_etes->url = $rutaDestino;
					$reporte_etes->nombre_archivo = $nombreArchivo;
					$reporte_etes->nombre_archivo_encriptado = $nombreArchivoEncriptado;
					$reporte_etes->idtipo_reporte_ETES = Input::get('idtipo_reporte');					
					$reporte_etes->iduser = $data["user"]->id;
					$reporte_etes->save();
					
					Session::flash('message', 'Se registró correctamente el Reporte para Certificado de Necesidad.');
					return Redirect::to('reporte_etes/create_reporte_etes');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_reporte_etes($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["tipo_reporte_etes"] = TipoReporteETES::lists('nombre','idtipo_reporte_ETES');
				$data["reporte_etes_info"] = ReporteETES::withTrashed()->find($id);
				return View::make('reportes_ETES/editReporteETES',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_reporte_etes()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search_numero_reporte"] = null;	
				$data["search_fecha_ini"] = null;			
				$data["search_fecha_fin"] = null;
				$data["tipo_reporte_etes"] = TipoReporteETES::lists('nombre','idtipo_reporte_etes');
				$data["search_tipo_reporte_etes"] = null;
				$data["search_usuario"] = null;
				$data["search_nombre_etes"] = null;			

				$data["reportes_etes_data"] = ReporteETES::getReportesETESInfo()->paginate(10);				
				return View::make('reportes_ETES/listReporteETES',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_reporte_etes()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search_numero_reporte"] = Input::get('search_numero_reporte');
				$data["search_fecha_ini"] = Input::get('search_fecha_ini');			
				$data["search_fecha_fin"] = Input::get('search_fecha_fin');		
				$data["tipo_reporte_etes"] = TipoReporteETES::lists('nombre','idtipo_reporte_etes');
				$data["search_tipo_reporte_etes"] = Input::get('search_tipo_reporte_etes');
				$data["search_usuario"] = Input::get('search_usuario');		

				$data["reportes_etes_data"] = ReporteETES::searchReportesETES($data["search_numero_reporte"],
														$data["search_fecha_ini"],$data["search_fecha_fin"],
														$data["search_tipo_reporte_etes"],$data["search_usuario"])->paginate(10);
				return View::make('reportes_ETES/listReporteETES',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function getCorrelativeReportNumber($abreviatura){
		$reporte = ReporteETES::getLastReporte($abreviatura)->first();
		$string = "";
		if($reporte!=null){	
			$numero = $reporte->numero_reporte_correlativo;
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

	public function download_documento($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$reporte_etes = ReporteETES::find($id);
				$file= $reporte_etes->url.$reporte_etes->nombre_archivo_encriptado;
				$headers = array(
		              'Content-Type',mime_content_type($file),
	            );
		        return Response::download($file,basename($reporte_etes->nombre_archivo),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_disable_reporte_etes()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$idreporte_ETES = Input::get('idreporte_ETES');
				$url = "reporte_etes/edit_reporte_etes/".$idreporte_ETES;
				$reporte_etes = ReporteETES::find($idreporte_ETES);
				$reporte_etes->delete();

				Session::flash('message', 'Se inhabilitó correctamente el Reporte.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_enable_reporte_etes()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$idreporte_ETES = Input::get('idreporte_ETES');
				$url = "reporte_etes/edit_reporte_etes/".$idreporte_ETES;
				$reporte_etes = ReporteETES::withTrashed()->find($idreporte_ETES);
				$reporte_etes->restore();

				Session::flash('message', 'Se habilitó correctamente el Reporte.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
}