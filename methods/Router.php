<?php
class Router {
	public function chargeViews($pg) {
		switch ($pg):
			case 'formulario':
				include 'views/'.$pg.'.html';
				break;

			case 'process_election':
				include 'bin/'.$pg.'.php';
				break;

			case 'instalarDB':
				include 'config/'.$pg.'.php';
				break;

			default:
				include 'views/404.php';
				break;
		endswitch;
	}

	public function validGET($pg) {
		if (empty($pg)) {
			include_once 'views/formulario.html';
		} else {
			return true;
		}
	}
}
