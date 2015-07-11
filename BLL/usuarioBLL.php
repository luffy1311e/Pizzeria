<?php
	/**
	*
	*/
	class usuarioBLL extends baseBLL
	{


		private static function validarSession(){
			if (session_status() !== PHP_SESSION_ACTIVE) {
				session_start();
			}
		}

		public static function getUser(){
			self::validarSession();

			if (isset($_SESSION['usuario'])) {
				return $_SESSION['usuario'];
			}
			return null;
		}

		public static function Agregar($object){
			if ($object['rol'] == 1) {
				$usuario = new Administrador(0, $object['username'], $object['correo'],
					$object['nombre'], $object['apellido1'], $object['apellido2'], $object['activo'], $object['password']);
			}
			else{
				$usuario = new Facturador(0, $object['username'], $object['correo'],
					$object['nombre'], $object['apellido1'], $object['apellido2'], $object['activo'], $object['password']);
			}

			try {
				usuarioDAL::Agregar($usuario);
				return true;
			} catch (Exception $ex) {
				return $ex->getMessage();
			}
		}

		public static function Modificar($object){
			try {
				return usuarioDAL::Modificar($object);
			} catch (Exception $ex) {
				throw $ex;
			}
		}

		public static function Eliminar($id) {

		}

		public static function obtenerTodos(){
			try {
				return usuarioDAL::obtenerTodos();
			} catch (Exception $ex) {
				return false;
			}
		}

		public static function obtenerPorCriterio($criterio, $valor, $activo, $posicion, $cantidad){
			try {
				return usuarioDAL::obtenerPorCriterio($criterio, $valor, $activo, $posicion, $cantidad);
			} catch (Exception $ex) {
				throw $ex;
			}
		}

		public static function obtenerPorUsername($user){
			try {
				return usuarioDAL::obtenerPorUsername($user);
			} catch (Exception $ex) {
				throw $ex;
			}
		}

		public static function obtenerPorID($id) {
			try {
				return UsuarioDAL::obtenerPorID($id);
			} catch (Exception $ex) {
				throw $ex;
			}
		}

		public static function actualizarPassword($id, $password){
			try {
				return usuarioDAL::actualizarPassword($id, $password);
			} catch (Exception $ex) {
				throw $ex;
			}
		}

		public static function login($username, $password){
			self::validarSession();

			try {
				if (usuarioDAL::login($username, $password)) {
					$_SESSION['usuario'] = self::obtenerPorUsername($username);
				}else{
					return "prueba";
				}
			} catch (Exception $ex) {
				throw $ex;
			}
		}

		public static function logout(){
			self::validarSession();
			session_destroy();
		}

		public static function isLogin(){

			if (self::getUser() != null) {
				return true;
			}
			else{
				return false;
			}
		}

		public static function isAdmin(){

			if (self::getUser() instanceof Administrador) {
				return true;
			}
			else{
				return false;
			}
		}

		public static function convertirTableHTML($lista_usuarios, $modificar=false, $eliminar=false) {
			try {
				$titulos = ["ID", "USERNAME", "CORREO", "NOMBRE", "ROL", "ACTIVO"];

				$html  = "<table class=\"table table-striped table-hover table-bordered\" id=\"tabla\">";
				$html .= "<thead>";

				foreach ($titulos as $titulo) {
					$html .= "<th>" . $titulo . "</th>";
				}

				if ($modificar == true or $eliminar == true){
					$html .= "<th>ACCIONES</td>";
				}
				$html .= "</thead>";
				$html .= "<tbody>";

				foreach ($lista_usuarios as $usuario) {
					$html .= "<tr>";
					$html .= "<td>" . $usuario->getId() . "</td>";
					$html .= "<td>" . $usuario->getUsername() . "</td>";
					$html .= "<td>" . $usuario->getCorreo() . "</td>";
					$html .= "<td>" . $usuario->getFullName() . "</td>";

					if ($usuario instanceof Administrador){
						$html .= "<td>Administrador</td>";
					}else{
						$html .= "<td>Facturador</td>";
					}

					if ($usuario->getActivo()){
						$html .= "<td><span class=\"glyphicon glyphicon-ok\"></span></td>";
					} else{
						$html .= "<td><span class=\"glyphicon glyphicon-remove\"></span></td>";
					}

					if ($modificar == true) {
						$html .= "<td><a href=\"usuario.php?view=modificar_usuario&modificar=true&id={$usuario->getId()}\" class=\"btn btn-primary btn-xs\">
								 <span class=\"glyphicon glyphicon-edit\"></span> Editar</a></td>";
					}

					if ($eliminar == true) {
						if ($usuario->getActivo()){
							$html .= "<td><a href=\"usuario.php?view=eliminar_usuario&eliminar=true&id={$usuario->getId()}\" class=\"btn btn-danger btn-xs\" data-toggle=\"modal\" data-target=\"#modalEliminar\">
									 <span class=\"glyphicon glyphicon-remove\"></span> Deshabilitar</a></td>";
						} else{
							$html .= "<td><a href=\"{$usuario->getId()}\" class=\"btn btn-success btn-xs\" data-toggle=\"modal\" data-target=\"#modalEliminar\">
									 <span class=\"glyphicon glyphicon-ok\"></span> Habilitar</a></td>";
						}
					}

					$html .= "</tr>";
				}

				$html .= "</tbody>";
				$html .= "</table>";
				return $html;
			} catch (Exeption $ex) {
				return false;
			}
		}
	}
 ?>
