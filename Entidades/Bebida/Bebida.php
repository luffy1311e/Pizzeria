<?php 
	/**
	* 
	*/
	abstract class Bebida extends base
	{
		
		private $mililitros;
		private $precio;

		public function __construct($id, $descipcion, $mililitros, $precio, $activo)
		{
			parent::__construct($id, $descipcion, $activo);
			$this->mililitros = $mililitros;
			$this->precio = $precio;
		}

		public function getMililitros()
		{
			return $this->mililitros;
		}

		public function setMililitros($mililitros)
		{
			$this->mililitros = $mililitros;
		}

		public function getPrecio()
		{
			return $this->precio;
		}

		public function setPrecio($precio)
		{
			$this->precio = $precio;
		}
	}
 ?>