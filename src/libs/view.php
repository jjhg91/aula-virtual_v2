<?php 

/**
 * 
 */
class View
{
	
	function __construct()
	{
		# code...
	}

	public function render($nombre)
	{
		require 'views/' . $nombre . '.php';
	}
}

?>