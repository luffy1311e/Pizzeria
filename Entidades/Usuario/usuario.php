<?php 
	/**
	* 
	*/
	class usuario
	{
		
		private $id;
		private $username;
		private $password;
		private $correo;
		private $nombre;
		private $apellido1;
		private $apellido2;
		private $activo;

		function __construct($id, $username, $correo, $nombre, 
			$apellido1, $apellido2, $activo, $password="")
		{
			$this->id = $id;
			$this->username = $username;
			$this->password = $password;
			$this->correo = $correo;
			$this->nombre = $nombre;
			$this->apellido1 = $apellido1;
			$this->apellido2 = $apellido2;
			$this->activo = $activo;
		}

		public function getId() {
			return $this->id;
		}
	
		public function setId($id) {
			$this->id = $id;
		}
	
		public function getUsername() {
			return $this->username;
		}
	
		public function setUsername($username) {
			$this->username = $username;
		}
	
		public function getPassword() {
			return $this->password;
		}
	
		public function setPassword($password) {
			$this->password = $password;
		}
	
		public function getCorreo() {
			return $this->correo;
		}
	
		public function setCorreo($correo) {
			$this->correo = $correo;
		}
	
		public function getNombre() {
			return $this->nombre;
		}
	
		public function setNombre($nombre) {
			$this->nombre = $nombre;
		}
	
		public function getApellido1() {
			return $this->apellido1;
		}
	
		public function setApellido1($apellido1) {
			$this->apellido1 = $apellido1;
		}
	
		public function getApellido2() {
			return $this->apellido2;
		}
	
		public function setApellido2($apellido2) {
			$this->apellido2 = $apellido2;
		}
	
		public function getActivo() {
			return $this->activo;
		}
	
		public function setActivo($activo) {
			$this->activo = $activo;
		}
	
		public function getFullName() {
			return $this->nombre ." ". $this->apellido1 ." ".$this->apellido2;  
		}
	}
 ?>