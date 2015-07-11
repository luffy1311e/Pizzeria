<?php 
	/**
	* 
	*/
	abstract class baseBLL
	{
		
		public function __construct()
		{
			# code...
		}

		//public abstract static function getHayError();

		//public abstract static function setHayError($pHayError);

		//public abstract static function getDescripcionError();

		//public abstract static function setDescripcionError($pDescripcionError);

		public abstract static function Agregar($oEntidadBase);

		public abstract static function Modificar($oEntidadBase);

		public abstract static function Eliminar($oEntidadBase);

		//public abstract static function Consultar($oEntidadBase);

		//public abstract static function Listar();
	}
 ?>