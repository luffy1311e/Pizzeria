<?php
	/**
	*
	*/
	class Gaseosa extends Bebida
	{
		private $cantidad;

		public function __construct($id, $descripcion, $mililitros, $precio, $activo)
		{
			parent::__construct($id, $descripcion, $mililitros, $precio, $activo);
		}

		public function getCantidad()
		{
			return $this->cantidad;
		}

		public function setCantidad($cantidad)
		{
			$this->cantidad = $cantidad;
		}

		public function calcularPrecio()
		{
			$total = $this->getPrecio();

			if ($this->getMililitros() > 600) {
				$total -= ($this->getPrecio() * 0.1);
			}

			return $total;
		}

		public function parseArray()
		{
			$array = array();

			$array["object"] = get_class($this);
			$array["id"] = $this->getId();
			$array["descripcion"] = $this->getDescripcion();
			$array["mililitros"] = $this->getMililitros();
			$array["precio"] = $this->getPrecio();
			$array["cantidad"] = $this->getCantidad();
			$array["activo"] = $this->getActivo();

			return $array;
		}
	}
 ?>
