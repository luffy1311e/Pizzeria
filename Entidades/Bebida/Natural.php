<?php
	/**
	*
	*/
	class Natural extends Bebida
	{
		private $base;
		const PORCENTAJE = 0.03;

		function __construct($id, $descripcion, $mililitros, $precio, $activo)
		{
			parent::__construct($id, $descripcion, $mililitros, $precio, $activo);
			$this->setBase(BaseLecheOAgua::AGUA);
		}

		public function getBase()
		{
			return $this->base;
		}

		public function setBase($base)
		{
			$this->base = $base;
		}

		public function calcularPrecio()
		{
			$total = 0;

			switch ($this->getBase()) {
				case BaseLecheOAgua::AGUA:
					$total = $this->getPrecio() + ($this->getPrecio() * self::PORCENTAJE);
					break;
				case BaseLecheOAgua::LECHE:
					$total = $this->getPrecio();
					break;
				default:
					$total = $this->getPrecio();
					break;
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
			$array["precio"] = $this->calcularPrecio();

			if ($this->getBase() == BaseLecheOAgua::AGUA) {
				$array["base"] = "Agua";
			}
			else{
				$array["base"] = "Leche";
			}

			$array["activo"] = $this->getActivo();

			return $array;
		}
	}
 ?>
