<?php

class OtInspeccionEquiposController extends BaseController {
	private static $nombre_tabla = 'estado_ot';
	private static $estado_activo = 'estado_activo';

	public function list_inspec_equipos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["search_ing"] = null;
				$data["search_ot"] = null;
				$data["search_ini"] = null;
				$data["search_fin"] = null;
				$data["search_servicio"] = null;
				$data["search_equipo"] = null;
				$data["servicios"] = Servicio::orderBy('nombre','asc')->lists('nombre','idservicio');
				$data["inspecciones_equipos_data"] = OrdenesTrabajoInspeccionEquipo::getOtsInspecEquipoInfo()->paginate(10);
				return View::make('ot/inspeccionEquipo/listOtInspecEquipos',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_program_ot_inspeccion_equipo($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data["mes_ini"] = date("Y-m-d",strtotime("first day of this month"));;
				$data["mes_fin"] = date("Y-m-d",strtotime("last day of this month"));;
				$data["trimestre_ini"] = null;
				$data["trimestre_fin"] = null;
				$this->calcular_trimestre($data["trimestre_ini"],$data["trimestre_fin"]);
				$data['servicios'] = Servicio::orderBy('nombre','asc')->lists('nombre','idservicio');
				$data['ingenieros'] = User::getJefes()->get();
				
				return View::make('ot/inspeccionEquipo/createProgramOtInspecEquipos',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function calcular_trimestre(&$fecha_ini,&$fecha_fin){
		$esteMes = date("m");
		switch($esteMes){
			case "1":
			case "4":
			case "7":
			case "10":
					$fecha_ini = date("Y-m-d",strtotime("first day of this month"));
					$fecha_fin = date("Y-m-d",strtotime("last day of +2 month"));
					break;
			case "2":
			case "5":
			case "8":
			case "11":
					$fecha_ini = date("Y-m-d",strtotime("first day of -1 month"));
					$fecha_fin = date("Y-m-d",strtotime("last day of +1 month"));
					break;
			case "3":
			case "6":
			case "9":
			case "12":
					$fecha_ini = date("Y-m-d",strtotime("first day of -2 month"));
					$fecha_fin = date("Y-m-d",strtotime("last day of this month"));
					break;
		}
		return;
	}

	public function search_programaciones(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"	
			$fecha_ini=date("Y-m-d",strtotime("first day of january"));
			$fecha_fin=date("Y-m-d",strtotime('last day of december'));
			$array_ot = null;	
			$array_ot =  OrdenesTrabajoInspeccionEquipo::getOtXPeriodo(9,$fecha_ini,$fecha_fin)->orderBy('fecha_inicio','desc')->get()->toArray();
			$programaciones = [];
			$horas = [];
			$estados = [];

			$length = sizeof($array_ot);

			for($i=0;$i<$length;$i++){
				$programaciones[] = date("Y-m-d",strtotime($array_ot[$i]['fecha_inicio']));
				$hora = date("H:i",strtotime($array_ot[$i]['fecha_inicio']));
				$idestado = $array_ot[$i]['idestado'];
				$estado = Estado::getEstadoById($idestado)->get();
				$estado = $estado[0];
				array_push($horas,$hora);
				array_push($estados, $estado);				
			}
			return Response::json(array( 'success' => true, 'programaciones'=> $programaciones,'horas'=>$horas,'estados'=>$estados,'ots'=>$array_ot),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function search_servicio_ajax(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			$mes = 0;
			$trimestre = 0;	
			$mes_ini = date("Y-m-d",strtotime(Input::get('mes_ini')));
			$mes_fin = date("Y-m-d",strtotime(Input::get('mes_fin')));			
			$trimestre_ini=date("Y-m-d",strtotime(Input::get('trimestre_ini')));
			$trimestre_fin=date("Y-m-d",strtotime(Input::get('trimestre_fin')));
			$count_activos = 0;
			if($data !="vacio"){
				$servicio = Servicio::find($data);
				if($servicio != null){
					$mes = OrdenesTrabajoInspeccionEquipo::getOtXPeriodoXServicio(9,$mes_ini,$mes_fin,$servicio->idservicio)->get()->count();
					$trimestre = OrdenesTrabajoInspeccionEquipo::getOtXPeriodoXServicio(9,$trimestre_ini,$trimestre_fin,$servicio->idservicio)->get()->count();					
					$listActivos = Activo::getEquiposActivosByServicioId($servicio->idservicio)->get(); 
					$count_activos = count($listActivos);
				}else{
				 	$servicio = null;
				 	$mes = 0;
				 	$trimestre = 0;				 	
				}
			}else{
				$servicio = null;
				$mes = 0;
			 	$trimestre = 0;
			}

			return Response::json(array( 'success' => true,'count_trimestre'=>$trimestre, 'count_mes'=>$mes,'count_activos'=>$count_activos ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function getCorrelativeReportNumber(){
		$ot = OrdenesTrabajoInspeccionEquipo::getLastOtInspeccionEquipo()->first();
		$string = "";
		if($ot!=null){	
			$numero = $ot->ot_correlativo;
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


	public function submit_program_ot_inspec_equipos(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
			// Check if the current user is the "System Admin"			
			$array_detalles = Input::get('matrix_detalle');
			$row_size = count($array_detalles);
			if($row_size==0){				
				$message = "No se cargaron todas las OTM con éxito.";
				$type_message = "bg-danger";
				return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'message' => $message, 'type_message'=>$type_message ),200);
			}	
			$list_activos = [];					
			//Agregar Detalle			
			if($row_size > 0){				
				$message = "Se crearon las OTM con éxito";
				$type_message = "bg-success";
				
				for( $i = 0; $i<$row_size; $i++ ){
					$array_detalle = $array_detalles[$i];					
					$fecha_inicio = date('Y-m-d H:i:s',strtotime($array_detalle[3]." ".$array_detalle[4]));
					$fecha_fin = date('Y-m-d H:i:s',strtotime($array_detalle[3]." ".$array_detalle[5]));
					$idservicio =$array_detalle[0];
					$servicio = Servicio::find($idservicio);
					$ot = new OrdenesTrabajoInspeccionEquipo;
					$abreviatura = "PIE";
					// Algoritmo para añadir numeros correlativos
					$string = $this->getCorrelativeReportNumber();
					$ot->fecha_inicio = $fecha_inicio;
					$ot->fecha_fin = $fecha_fin;
					$ot->idservicio = $idservicio;
					$ot->idestado = 9;
					$ot->id_ingeniero = $array_detalle[6];
					$ot->ot_tipo_abreviatura = $abreviatura;
					$ot->ot_correlativo = $string;
					$ot->save();

					$list_activos = Activo::getActivosByServicioId($idservicio)->get();
					if($list_activos->isEmpty()==false){
						foreach($list_activos as $activo){
							$modelo = ModeloActivo::find($activo->idmodelo_equipo);
							$idfamilia_activo = $modelo->idfamilia_activo;
							$otInspeccionxActivo = new OrdenesTrabajoInspeccionEquipoxActivo;
							$otInspeccionxActivo->idot_inspec_equipo = $ot->idot_inspec_equipo;
							$otInspeccionxActivo->idactivo = $activo->idactivo;
							$otInspeccionxActivo->save();
							//asignamos las tareas de ese activo de esa inspeccion
							$tareas = TareasOtInspeccionEquipo::getTareasByFamiliaActivo($idfamilia_activo)->get();
							foreach ($tareas as $tarea) {
								$otInspeccionxActivoxTarea = new TareasOtInspeccionEquipoxActivo;
								$otInspeccionxActivoxTarea->idot_inspec_equiposxactivo = $otInspeccionxActivo->idot_inspec_equiposxactivo;
								$otInspeccionxActivoxTarea->idtareas_inspec_equipo = $tarea->idtareas_inspec_equipo;
								$otInspeccionxActivoxTarea->idestado_realizado = 23; // Estado de tarea no realizada
								$otInspeccionxActivoxTarea->save();
							}
						}
					}
				}							
			}else{
				$message = "No se cargaron todas las OTM con éxito.";
				$type_message = "bg-danger";
				return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'message' =>$message, 'type_message'=>$type_message,'list'=>$list_activos ),200);
			}
			
			return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'message' => $message, 'type_message'=>$type_message ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function validate_servicio(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$x = Input::get('selected_id');
			//$list_activos = Activo::getEquiposActivosByServicioId($data)->get();
			

			return Response::json(array( 'success' => true,'data'=>$x),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function search_ot_inspeccion_equipos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){

				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["search_ing"] = Input::get('search_ing');
				$data["search_ot"] = Input::get('search_ot');
				$data["search_ini"] = Input::get('search_ini');
				$data["search_fin"] = Input::get('search_fin');
				$data["search_servicio"] = Input::get('search_servicio');
				$data["search_equipo"] = Input::get('search_equipo');
				$data["servicios"] = Servicio::orderBy('nombre','asc')->lists('nombre','idservicio');
				if($data["search_ing"]==null && $data["search_ot"]==null && $data["search_ini"]==null && $data["search_fin"]==null
					&& $data["search_servicio"] == 0 && $data["search_equipo"]==null){
					$data["inspecciones_equipos_data"] = OrdenesTrabajoInspeccionEquipo::getOtsInspecEquipoInfo()->paginate(10);
				}else{
					$data["inspecciones_equipos_data"] = OrdenesTrabajoInspeccionEquipo::searchOtsInspecEquipo($data["search_ing"],$data["search_ot"],$data["search_ini"],$data["search_fin"],$data["search_servicio"],$data["search_equipo"])->paginate(10);
				}
				return View::make('ot/inspeccionEquipo/listOtInspecEquipos',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}	

	public function submit_disable_inspeccion(){
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
			$data["inside_url"] = Config::get('app.inside_url');
			$ot_inspeccion = OrdenesTrabajoInspeccionEquipo::find(Input::get('idot_inspec_equipo'));
			$ot_inspeccion->idestado= 25;
			$ot_inspeccion->save();
			$message = "Se ha cancelado la OTM.";
			$type_message = "bg-success";
			return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'message' => $message, 'type_message'=>$type_message ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function render_create_ot($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4) && $id){
				
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["ot_info"] = OrdenesTrabajoInspeccionEquipo::searchOtInspeccionEquipoById($id)->get();
				if($data["ot_info"]->isEmpty()){
					Session::flash('error', 'No se encontró la OT.');
					return Redirect::to('inspec_equipos/list_inspec_equipos');
				}
				$data["ot_info"] = $data["ot_info"][0];		
				$idservicio = $data["ot_info"]->idservicio;
				$data["activos_info"] = Activo::getEquiposActivosByServicioId($idservicio)->get();	
				$data["activosxot_info"] = OrdenesTrabajoInspeccionEquipoxActivo::getOtInspeccionxActivoByIdOtInspeccion($data["ot_info"]->idot_inspec_equipo)->get();
				$cant_activos = count($data["activosxot_info"]);
				$data["tareas_activos"] = [];
				for($i=0;$i<$cant_activos;$i++){
					$otInspeccionxActivo = OrdenesTrabajoInspeccionEquipoxActivo::getOtInspeccionxActivo($data["ot_info"]->idot_inspec_equipo,$data["activos_info"][$i]->idactivo)->get()[0];
					$otInspeccionxActivoxTareas = TareasOtInspeccionEquipoxActivo::getTareasxInspeccionxActivo($otInspeccionxActivo->idot_inspec_equiposxactivo)->get();	
					array_push($data["tareas_activos"],$otInspeccionxActivoxTareas);
				}

				$data["filas"] = [];
				for($i=0;$i<$cant_activos;$i++){
					array_push($data["filas"],$i);
				}
				array_push($data["filas"], $cant_activos);
				return View::make('ot/inspeccionEquipo/createOtInspecEquipos',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_marcar_tarea_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
			$idtareasxactivoxinspeccion = Input::get('idtareasxactivoxinspeccion');
			$otInspeccionxActivoxTarea = TareasOtInspeccionEquipoxActivo::find($idtareasxactivoxinspeccion);
			$otInspeccionxActivoxTarea->idestado_realizado = 22;
			$otInspeccionxActivoxTarea->save();
			return Response::json(array( 'success' => true),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function submit_create_ot(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4)){
				$idot_inspec_equipo = Input::get('idot_inspec_equipo');
				$ot = OrdenesTrabajoInspeccionEquipo::find($idot_inspec_equipo);
				// Validate the info, create rules for the inputs
				$attributes = array(
					'numero_ficha' => 'Número de Ficha'
				);

				$messages = array(
					
				);

				$rules = array(
					'numero_ficha' => 'required|numeric|unique:ot_inspec_equipos,numero_ficha,'.$ot->idot_inspec_equipo.',idot_inspec_equipo',
				);

				$count_activos = Input::get('count_activos');
				for($i=0;$i<$count_activos;$i++){
					$element_rule_img = array('archivo'.$i =>'mimes:jpeg,png');
					$element_rule_obs = array('observaciones_equipo'.$i =>'alpha_num_spaces_colon');
					$element_attribute_img = array('archivo'.$i => 'Archivo del Equipo #'.($i+1));
					$element_attribute_obs = array('observaciones_equipo'.$i=> 'campo Observaciones del Equipo #'.($i+1));
					$rules += $element_rule_img;
					$rules += $element_rule_obs;
					$attributes += $element_attribute_img;
					$attributes += $element_attribute_obs;
				}

				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);

				
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('inspec_equipos/create_ot_inspeccion_equipos/'.$idot_inspec_equipo)->withErrors($validator)->withInput(Input::all());
				}else{
					$ot = OrdenesTrabajoInspeccionEquipo::find($idot_inspec_equipo);
					$ot->numero_ficha = Input::get('numero_ficha');
					$ot->idestado = Input::get('estado_ot');
					$count_activos = Input::get('count_activos');
					$ot->save();
					
					for($i=0;$i<$count_activos;$i++){
						$idactivo = Input::get('idactivo'.$i);
						$ot_inspec_equiposxactivo = OrdenesTrabajoInspeccionEquipoxActivo::getOtInspeccionxActivo($idot_inspec_equipo,$idactivo)->get()[0];
						$rutaDestino ='';
					    $nombreArchivo ='';	
					    $nombreArchivoEncriptado = '';
					    

					    if (Input::hasFile('archivo'.$i)) {
						    if(strcmp($ot_inspec_equiposxactivo->nombre_archivo, $nombreArchivo) != 0 || $ot_inspec_equiposxactivo->nombreArchivo == ''){ 
						        $archivo = Input::file('archivo'.$i);
						        $rutaDestino = 'uploads/inspeccion_equipos/' .$ot->ot_tipo_abreviatura.$ot->ot_correlativo.'/';
						        $nombreArchivo = $archivo->getClientOriginalName();
						        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
						        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);
						    	$ot_inspec_equiposxactivo->nombre_archivo = $nombreArchivo;
								$ot_inspec_equiposxactivo->nombre_archivo_encriptado = $nombreArchivoEncriptado;
								$ot_inspec_equiposxactivo->imagen_url = $rutaDestino;
							}
					    }

					    $observaciones = Input::get('observaciones_equipo'.$i);
						$ot_inspec_equiposxactivo->observaciones = $observaciones;
						$ot_inspec_equiposxactivo->save();
					}
					Session::flash('message', 'Se guardó correctamente la información.');
					return Redirect::to('inspec_equipos/list_inspec_equipos');
				}
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function export_pdf(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12)){
				$idot_inspec_equipo = Input::get('idot_inspec_equipo');
				$data["ot_info"] = OrdenesTrabajoInspeccionEquipo::searchOtInspeccionEquipoById($idot_inspec_equipo)->get()[0];
				$idservicio = $data["ot_info"]->idservicio;
				$data["activos_info"] = Activo::getEquiposActivosByServicioId($idservicio)->get();	
				$data["activosxot_info"] = OrdenesTrabajoInspeccionEquipoxActivo::getOtInspeccionxActivoByIdOtInspeccion($data["ot_info"]->idot_inspec_equipo)->get();
				$cant_activos = count($data["activosxot_info"]);
				$data["tareas_activos"] = [];				
				for($i=0;$i<$cant_activos;$i++){
					$otInspeccionxActivo = OrdenesTrabajoInspeccionEquipoxActivo::getOtInspeccionxActivo($data["ot_info"]->idot_inspec_equipo,$data["activos_info"][$i]->idactivo)->get()[0];
					$otInspeccionxActivoxTareas = TareasOtInspeccionEquipoxActivo::getTareasxInspeccionxActivo($otInspeccionxActivo->idot_inspec_equiposxactivo)->get();	
					array_push($data["tareas_activos"],$otInspeccionxActivoxTareas);
				}
				$html = View::make('ot/inspeccionEquipo/otInspeccionEquipoExport',$data);
				return PDF::load($html,"A4","portrait")->download('OTM Inspeccion Equipos - '.$data["ot_info"]->ot_tipo_abreviatura.$data["ot_info"]->ot_correlativo);

			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_ot($id=null){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12) && $id){
				
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["ot_info"] = OrdenesTrabajoInspeccionEquipo::searchOtInspeccionEquipoById($id)->get();
				if($data["ot_info"]->isEmpty()){
					Session::flash('error', 'No se encontró la OT.');
					return Redirect::to('inspec_equipos/list_inspec_equipos');
				}
				$data["ot_info"] = $data["ot_info"][0];		
				$idservicio = $data["ot_info"]->idservicio;
				$data["activos_info"] = Activo::getEquiposActivosByServicioId($idservicio)->get();	
				$data["activosxot_info"] = OrdenesTrabajoInspeccionEquipoxActivo::getOtInspeccionxActivoByIdOtInspeccion($data["ot_info"]->idot_inspec_equipo)->get();
				$cant_activos = count($data["activosxot_info"]);
				$data["tareas_activos"] = [];
				for($i=0;$i<$cant_activos;$i++){
					$otInspeccionxActivo = OrdenesTrabajoInspeccionEquipoxActivo::getOtInspeccionxActivo($data["ot_info"]->idot_inspec_equipo,$data["activos_info"][$i]->idactivo)->get()[0];
					$otInspeccionxActivoxTareas = TareasOtInspeccionEquipoxActivo::getTareasxInspeccionxActivo($otInspeccionxActivo->idot_inspec_equiposxactivo)->get();	
					array_push($data["tareas_activos"],$otInspeccionxActivoxTareas);
				}
				$data["filas"] = [];
				for($i=0;$i<$cant_activos;$i++){
					array_push($data["filas"],$i);
				}
				array_push($data["filas"], $cant_activos);
				return View::make('ot/inspeccionEquipo/viewOtInspecEquipos',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

}