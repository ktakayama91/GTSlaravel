<?php

class ServiciosController extends BaseController
{
	public function list_servicios()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search"] = null;
				$data["search_area"] = null;
				$data["areas"] = Area::lists('nombre','idarea');
				$data["servicios_data"] = Servicio::getServiciosInfo()->paginate(10);
				return View::make('servicios/listServicios',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_servicio(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search"] = Input::get('search');
				$data["search_area"] = Input::get('search_area');
				$data["areas"] = Area::lists('nombre','idarea');
				$data["servicios_data"] = Servicio::searchServicios($data["search"],$data["search_area"])->paginate(10);
				if($data["search"]==null && $data["search_area"] == 0){
					return Redirect::to('servicios/list_servicios');
				}else{
					return View::make('servicios/listServicios',$data);	
				}
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_servicio($idservicio=null){
		
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1) && $idservicio)
			{	
				$data["tipo_servicios"] = TipoServicio::lists('nombre','idtipo_servicios');
				$data["servicio_info"] = Servicio::searchServicioById($idservicio)->get();	
				$servicio = Servicio::withTrashed()->find($idservicio);
				$idarea = $servicio->idarea;
				$data["areas"] = Area::lists('nombre','idarea');
				$data["personal"] = Area::getUserList($servicio->idarea);
				$data["activos_servicio"] = Activo::getActivosByServicioId($idservicio)->paginate(10);
				if($data["servicio_info"]->isEmpty()){
					return Redirect::to('servicios/list_servicios');
				}
				$data["servicio_info"] = $data["servicio_info"][0];

				return View::make('servicios/editServicio',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}

	}

	public function render_create_servicio()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["tipo_servicios"] = TipoServicio::lists('nombre','idtipo_servicios');
				$data["areas"] = Area::lists('nombre','idarea');
				$data["personal"] = array(0=>"");
				return View::make('servicios/createServicio',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_servicio(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'nombre' => 'Nombre del Servicio',
					'descripcion' => 'Descripcion',
					'tipo_servicio' => 'Tipo de Servicio',	
					'area'=>'Area',		
					'personal' => 'Personal',	
					);
				$rules = array(
							'nombre' => 'required|max:100|unique:servicios,nombre|alpha_spaces',
							'descripcion' => 'max:200|alpha_spaces',
							'tipo_servicio' => 'required|min:1',	
							'area' =>'required|min:1',		
							'personal' => 'required|min:1',	
						);

				$messages=array(
					'tipo_servicio' => 'Seleccionar un tipo de servicio.',
					'area.min' => 'Seleccionar un area.',
					'personal.min' => 'Seleccionar un usuario.'
					);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('servicios/create_servicio')->withErrors($validator)->withInput(Input::all());
				}else{
					$servicio = new Servicio;
					$servicio->nombre = Input::get('nombre');
					$servicio->descripcion = Input::get('descripcion');
					$servicio->idtipo_servicios= Input::get('tipo_servicio');
					$servicio->idarea = Input::get('area');
					$servicio->id_usuario_responsable = Input::get('personal');
					$servicio->idestado = 1;
					$servicio->save();
					Session::flash('message', 'Se registró correctamente el servicio.');
					
					return Redirect::to('servicios/list_servicios');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}	

	public function submit_edit_servicio(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$servicio = Servicio::find(Input::get('servicio_id'));
				$attributes = array(
					'nombre' => 'Nombre del Servicio',
					'descripcion' => 'Descripcion',
					'tipo_servicio' => 'Tipo de Servicio',	
					'area'=>'Area',		
					'personal' => 'Personal',	
					);
				$rules = array(
							'nombre' => 'required|max:100|alpha_spaces|unique:servicios,nombre,'.$servicio->idservicio.',idservicio',
							'descripcion' => 'max:200|alpha_spaces',
							'tipo_servicio' => 'required',	
							'area'=>'required',		
							'personal' => 'required',	
						);

				
				$messages=array(
					'tipo_servicio.min' => 'Seleccionar un tipo de servicio.',
					'area.min' => 'Seleccionar un area.',
					'personal.min' => 'Seleccionar un usuario.'
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$servicio_id = Input::get('servicio_id');
					$url = "servicios/edit_servicio"."/".$servicio_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{	
					$servicio_id = Input::get('servicio_id');				
					$url = "servicios/edit_servicio"."/".$servicio_id;					
					$servicio = Servicio::find($servicio_id);
					$servicio->nombre = Input::get('nombre');
					$servicio->descripcion = Input::get('descripcion');
					$servicio->idtipo_servicios = Input::get('tipo_servicio');
					$servicio->idarea = Input::get('area');
					$servicio->id_usuario_responsable = Input::get('personal');
					$servicio->save();
					Session::flash('message', 'Se editó correctamente el servicio.');
					return Redirect::to('servicios/list_servicios');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}
	public function return_usuarios(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			$usuarios_resp = User::searchPersonalActivoByIdArea($data)->get();
			
			return Response::json(array( 'success' => true, 'usuarios_resp' => $usuarios_resp ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function submit_enable_servicio(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$servicio_id = Input::get('servicio_id');
				$url = "servicios/edit_servicio"."/".$servicio_id;
				$servicio = Servicio::withTrashed()->find($servicio_id);
				$servicio->restore();
				Session::flash('message', 'Se habilitó correctamente el servicio.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_disable_servicio(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$servicio_id = Input::get('servicio_id');
				$url = "servicios/edit_servicio"."/".$servicio_id;
				$servicio = Servicio::find($servicio_id);
				$activos = Activo::getEquiposActivosByServicioId($servicio_id)->get();	
				if(count($activos)==0){					
					$servicio->delete();
					Session::flash('message','Se inhabilitó correctamente el servicio.' );
				}
				else{
					Session::flash('error', 'El servicio cuenta con equipos activos. Acción no realizada.' );
				}				
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
}