<?php 

	require_once("../../controller/Login/controller_login.php");

	class view_login{

		private $controlador;

		public function view_login($funcion1,$args){
			switch ($funcion1) {
				case 'login':
					$this->login($args);
					break;
				
				default:
					# code...
					break;
			}
		}

		private function login($args){
			$this->controlador = new controller_login($args[0],$args[1]);
			$respuesta = $this->controlador->compInfo();
			print_r($respuesta);
		}

	}

	/*
 	*Recibimos la solucitudes de esta vista desde ajax y devuelve el html 
 	o la informacion solicitada
 	*/
	//switch (filter_input(INPUT_POST, 'funcion', FILTER_SANITIZE_STRING)) {
	switch ('login'){
	    case 'login':
	        // seteamos el view
 			$view = new view_login('login',['paaaa','aaaaa']);
	        break;
	    case 'atrasRegistro':
	        include '../site_media/html/home.html';
	        break;
	    default:
	        include '../site_media/html/home.html';
	        break;
	}  

 ?>