<?php 
	require_once("../../controller/Usuario/controlAgendamiento.php");

	class view_agendamiento{

		private $controlador;

			//funcion para loguearse
		public function mostrarFormAgendar($tipoMat){
			$this->controlador = new controller_agendamiento();
			$arregloControler = $this->controlador->pagAgendamiento($tipoMat);	
			//formateamos el array de respuesta del controlador
			return array(
				'TipoMat' => $arregloControler['tipoMat'],
				'html' => $this->get_include_contents($arregloControler['html'])
			);			
		}

		function get_include_contents($filename) {
		    if (is_file($filename)) {
		        ob_start();
		        include $filename;
		        return ob_get_clean();
		    }
		    return false;
		}

	}

	/*
 	*Recibimos la solucitudes de esta vista desde ajax y devuelve el html 
 	o la informacion solicitada
 	*/
	switch (filter_input(INPUT_POST, 'funcion', FILTER_SANITIZE_STRING)) {
	    case 'agendar':
	    	//traemos la informacion
	    	$tipoMat = filter_input(INPUT_POST, 'tipoMat', FILTER_SANITIZE_STRING);
 			$view = new view_agendamiento();
 			echo json_encode($view->mostrarFormAgendar($tipoMat));
	        break;
	    default:
	        include '../site_media/html/home.html';
	        break;
	}  

 ?>