<?php 
	/**
	* 
	*/
	class base
	{
		
		private $id;
		private $descripcion;
		private $activo;

		public function __construct($id, $descripcion, $activo)
		{
			$this->id = $id;
			$this->descripcion = $descripcion;
			$this->activo = $activo;
		}

		public function getId() {
			return $this->id;
		}
	
		public function setId($id) {
			$this->id = $id;
		}	
	
		public function getDescripcion() {
			return $this->descripcion;
		}
	
		public function setDescripcion($descripcion) {
			$this->descripcion = $descripcion;
		}
	
		public function getActivo() {
			return $this->activo;
		}
	
		public function setActivo($activo) {
			$this->activo = $activo;
		}
	}
 ?>