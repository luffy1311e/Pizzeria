<?php 
	
	/**
	* 
	*/
	abstract class baseDAL
	{
		// Atributos privados
		private $hayError = False;
		private $descripcionError = "";

		/**
		 * Constructor de la clase
		 */
		function __construct()
		{
			$this->hayError = False;
			$this->descripcionError = "";
		}

		public function getHayError(){
			return $this->hayError;
		}

		public function setHayError($pHayError) {
			$this->hayError = $pHayError;			
		}

		public function getDescripcionError(){
			return $this->descripcionError;
		}

		public function setDescripcionError($pDescripcionError) {
			$this->descripcionError = $pDescripcionError;
		}

		// Definción de métodos abstratos que deben implementarse
		// en las clases concretas

		/**
		 * Insertar un nuevo registro
		 * @param EntidadBase $oEntidadBase
		 */
		public abstract static function Agregar($oEntidadBase);

		/**
		 * Modificar un registro
		 * @param EntidadBase $oEntidadBase
		 */
		public abstract static function Modificar($oEntidadBase);

		/**
		 * Eliminar un registro
		 * @param EntidadBase $oEntidadBase
		 */
		public abstract static function Eliminar($oEntidadBase);

		/**
		 * Consultar un registro
		 * @param EntidadBase $oEntidadBase
		 */
		//public abstract static function Consultar($oEntidadBase);

		/**
		 * Listar todos los datos de la entidad
		 */
		//public abstract static function Listar();		
	}
 ?>