<?php

class AccesoriosController extends BaseController
{

	public function submit_delete_accesorio_ajax()
	{
		if(!Request::ajax() || !Auth::check())
		{
			return Response::json(array( 'success' => false ),200);
		}

		if(Auth::check())
		{
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1)
			{		
				
				$idaccesorio = Input::get('idaccesorio');				
				$accesorio = Accesorio::find($idaccesorio);
				$accesorio->delete();
				
				Session::flash('message', 'Se eliminó correctamente el accesorio.');
				return Response::json(array( 'success' => true),200);				
			}
			else{
				return Response::json(array( 'success' => false),200);				
			}		
		}
	}

}