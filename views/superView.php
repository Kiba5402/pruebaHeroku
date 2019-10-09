<?php 

	class view_super{

		public function get_include_contents($filename) {
			$prefijo = "../../site_media/html".$filename;
		    if (is_file($prefijo)) {
		        ob_start();
		        include $prefijo;
		        return ob_get_clean();
		    }
		    return false;
		}

	}

 ?>

