<?php 
require_once 'controllers/errores.php';

/**
 * 
 */
class App
{
	
	function __construct()
	{
		$url = isset($_GET['url']) ? $_GET['url']: null;
		$url = rtrim($url,'u/');
		$url = explode('/', $url);
		
		// CUANDO SE INGRESA SIN DEFINIR CONSTANTE EN URL
		if ( empty($url[0]) ) {
			$archivoController = 'controllers/index.php';
			require_once $archivoController;
			$controller = new Index();
			$controller->render();
			return false;
		}

		// VALIDAMOS SI EL CONTROLADOR EXISTE
		$archivoController = 'controllers/'.$url[0].'.php';
		if ( file_exists($archivoController) ) {
			require_once $archivoController;
			$controller = new $url[0];
			$controller->loadModel($url[0]);

			// VALIDAR LOS CUANTOS PARAMETROS HAY EN LA URL
			$nparam = sizeof($url);
			if ( $nparam > 1  ) {

				// VALIDAMOS QUE EL METODO EXISTA DENTRO DEL CONTROLADOR
				if ( method_exists($controller, $url[1]) ) {
					
					// SE VALIDA SI HAY PARAMETROS PARA ENVIAR AL METODO
					if ( $nparam > 2 ) {
						$param = [];
						for( $i = 2; $i < $nparam; $i++ ){
							array_push($param, $url[$i]);
						}
						$controller->{$url[1]}($param);
					}else{
						$controller->{$url[1]}();
					}
				}else{
					$controller = new Errores();
			 		$controller->render();
				}
			}else{
				$controller->render();
			}

		}else{

			$controller = new Errores();
			$controller->render();
		}
	}
}
?>