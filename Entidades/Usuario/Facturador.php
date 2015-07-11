<?php 
	/**
	* 
	*/
	class Facturador extends usuario
	{
		public function __construct($id, $username, $correo, $nombre, 
			$apellido1, $apellido2, $activo)
		{
			parent::__construct($id, $username, $correo, $nombre, 
				$apellido1, $apellido2, $activo);
		}

		public function __toString(){
			return "Esto es un usuario facturador";
		}
	}
 ?>