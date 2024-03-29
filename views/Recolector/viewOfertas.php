<?php 
	require_once("../../controller/Recolector/controlOfertas.php");
	require_once("../superView.php");

	class view_ofertas extends view_super{

		private $controlador;

		//funcion que muestra la pagina de pedidos activos
		public function detalleOferta($idOferta){
			$this->controlador = new controller_ofertas();
			$arregloControler = $this->controlador->detalleOferta($idOferta);	
			//formateamos el array de respuesta del controlador
			return array(
				'infoOferta' => $arregloControler['infoOferta'],
				'html' => $this->get_include_contents($arregloControler['html'])
			);			
		}	

		//funcion que trae un listado de ofertas para el recolector
		public function traerOfertas($idPersona){
			$this->controlador = new controller_ofertas();
			$arregloControler = $this->controlador->listaOfertas($idPersona);
			if ($arregloControler != -1) {
				//formateamos el array de respuesta del controlador
				return array(
					'infoOfertas' => $arregloControler['infoOfertas']
				);	
			}else{
				return -1;
			}		
		}

		//funcion que permite aceptar una oferta
		public function aceptaOferta($idPersona, $idOferta){
			if ($idPersona != null && $idOferta != null) {
				$this->controlador = new controller_ofertas();
				$arregloControler = $this->controlador->aceptaOferta($idPersona,$idOferta);
				//formateamos el array de respuesta del controlador
				return array(
					'resultadoUpd' => $arregloControler['resultadoUpd']
				);	
			}else{
				return -1;
			}	
		}
	}

	/*
 	*Recibimos la solucitudes de esta vista desde ajax y devuelve el html 
 	o la informacion solicitada
 	*/
	switch (filter_input(INPUT_POST, 'funcion', FILTER_SANITIZE_STRING)) {
	    case 'detalleOferta':
	    	//traemos la informacion
	    	$idOferta = filter_input(INPUT_POST, 'idOferta', FILTER_SANITIZE_STRING);
 			$view = new view_ofertas();
  			echo json_encode($view->detalleOferta($idOferta));
	        break;
	    case 'traerOfertas': 
	    	//traemos la informacion
	    	$idPersona = filter_input(INPUT_POST, 'idPersona', FILTER_SANITIZE_STRING);
 			$view = new view_ofertas();
  			echo json_encode($view->traerOfertas($idPersona));
	        break;
	     case 'aceptarOferta':
	    	//traemos la informacion
	    	$idPersona = filter_input(INPUT_POST, 'idPersona', FILTER_SANITIZE_STRING);
	    	$idOferta = filter_input(INPUT_POST, 'idOferta', FILTER_SANITIZE_STRING);
 			$view = new view_ofertas();
  			echo json_encode($view->aceptaOferta($idPersona,$idOferta));
	        break;
	    default:
	        include '../site_media/html/home.html';
	        break;
	}  

 ?>