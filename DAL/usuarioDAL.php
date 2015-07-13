<?php

	/**
	*
	*/
	class usuarioDAL extends baseDAL
	{

		function __construct()
		{

		}

		public static function Agregar($usuario){
			$fecha = date('Y-m-d H:i:s');
			$usuadio_id = usuarioBLL::getUser()->getId();

			if ($usuario instanceof Administrador) {
				$rol = 1;
			}
			else{
				$rol = 2;
			}

			$passMD5 = md5($usuario->getPassword());

			$sql = "CALL PA_I_Usuario(
					'{$usuario->getUsername()}',
					'{$passMD5}',
					'{$usuario->getCorreo()}',
					'{$usuario->getNombre()}',
					'{$usuario->getApellido1()}',
					'{$usuario->getApellido2()}',
					{$rol},
					{$usuario->getActivo()},
					{$usuario_id},
					'{$fecha}',
					@msg_error
					)";

			try {

				$conexion = MySqlDAO::getIntance();
				// Ejecutamos el procedimiento almacenado
				$conexion->ejecutarSql($sql);

				$conexion->cerrarConexion();
				return true;

			} catch (Exception $e) {
				$conexion->cerrarConexion();
				throw $e;
			}
		}

		public static function Modificar($usuario) {
			$fecha = date('Y-m-d H:i:s');
			$usuario_id = usuarioBLL::getUser()->getId();

			if ($usuario instanceof Administrador){
				$rol = 1;
			}
			else{
				$rol = 2;
			}

			try {
				$conexion = MySqlDAO::getIntance();
				$sql = "CALL PA_U_Usuario(
					{$usuario->getId()},
					'{$usuario->getUsername()}',
					'{$usuario->getCorreo()}',
					'{$usuario->getNombre()}',
					'{$usuario->getApellido1()}',
					'{$usuario->getApellido2()}',
					{$rol},
					{$usuario->getActivo()},
					{$usuario_id},
					'{$fecha}',
					@msg_error)";

				// Ejecutamos el procedimiento almacenado
				$conexion->ejecutarSql($sql);

				$conexion->cerrarConexion();
				// Retornamos la cantidad de registros afectados
				return $conexion->getRegistrosAfectados();

			} catch (Exception $ex) {
				throw $ex;
			}
		}

		public static function Eliminar($id) {

		}

		public static function obtenerTodos($activo) {
			$sql = "SELECT id, username, correo, nombre, apellido1, apellido2, rol, activo, cod_usr_crea, fec_creacion
			FROM Usuario";

			try {
				return self::ejecutarSql($sql);
			} catch (Exception $ex) {
				return $ex;
			}
		}

		public static function obtenerPorCriterio($criterio, $valor, $activo, $posicion, $cantidad){
			$sql = "SELECT id, username, correo, nombre, apellido1, apellido2, rol, activo, cod_usr_crea, fec_creacion
					FROM Usuario
					WHERE {$criterio} LIKE '{$valor}%' ";

			if ($activo != -1) {
				$sql .= "AND activo = {$activo}";
			}
			$sql .= "ORDER BY {$criterio} LIMIT {$posicion}, {$cantidad}";

			try {
				return self::ejecutarConsulta($sql);
			} catch (Exception $ex) {
				throw $ex;

			}
		}

		public static function obtenerPorID($id) {
			try {
				$conexion = MySqlDAO::getIntance();
				$conexion->abrirConexion();
				$sql = "CALL PA_S_Usuario({$id}, @msg_error)";
				// Ejecutamos el procedimiento almacnado
				$result = $conexion->ejecutarSql($sql);
				// Resultado del procedimeinto almacenado
				//$conexion->obtenerResultadoPA();

				$usuario = null;

				while ($row = mysqli_fetch_assoc($result)) {
					$id = $row['id'];
					$username = $row['username'];
					$correo = $row['correo'];
					$nombre = $row['nombre'];
					$apellido1 = $row['apellido1'];
					$apellido2 = $row['apellido2'];
					$rol = $row['rol'];
					$activo = $row['activo'];
					$cod_usr_crea = $row['cod_usr_crea'];
					$fec_creacion = $row['fec_creacion'];

					if ($rol == 1)
						$usuario = new Administrador($id, $username, $correo, $nombre, $apellido1, $apellido2, $activo);
					else
						$usuario = new Facturador($id, $username, $correo, $nombre, $apellido1, $apellido2, $activo);
				}
				$conexion->cerrarConexion();
				return $usuario;

			} catch (Exception $ex) {
				throw $ex;
			}
		}

		protected static function ejecutarConsulta($sql) {
			try {

				$conexion = MySqlDAO::getIntance();

				$conexion->abrirConexion();
				$result = $conexion->ejecutarSql($sql);

				$lista_usuarios = array();

				while ($row = mysqli_fetch_assoc($result)) {
					$id = $row['id'];
					$username = $row['username'];
					$correo = $row['correo'];
					$nombre = $row['nombre'];
					$apellido1 = $row['apellido1'];
					$apellido2 = $row['apellido2'];
					$rol = $row['rol'];
					$activo = $row['activo'];
					$cod_usr_crea = $row['cod_usr_crea'];
					$fec_creacion = $row['fec_creacion'];

					if ($rol == 1)
						$usuario = new Administrador($id, $username, $correo, $nombre, $apellido1, $apellido2, $activo);
					else
						$usuario = new Facturador($id, $username, $correo, $nombre, $apellido1, $apellido2, $activo);

					$lista_usuarios[] = $usuario;

				}

				mysqli_free_result($result);
				$conexion->cerrarConexion();
				return $lista_usuarios;

			} catch (Exception $ex) {
				throw $ex;
			}
		}

		public static function login($username, $password){
			try {
				// Encriptamos el password a MD5
				$passMD5 = md5($password);

				$conexion = MySqlDAO::getIntance();
				$sql = "CALL PA_Login('{$username}', '{$password}', @msg_error)";
				// Abre la conexion
				$conexion->abrirConexion();

				// Ejecutamos el procedimiento almacenado
				$msg_error = $conexion->ejecutarSql($sql);

				//Cerramos conexion
				$conexion->cerrarConexion();
				if ($msg_error != "") {
					return true;
				}else {
					//return false;
				}


			} catch (Exception $ex) {
				throw $ex;
			}
		}

		public static function actualizarPassword($id, $password){
			$fecha = date('Y-m-d H:i:s');
			$usuario_id = usuarioBLL::getUser()->getId();
			$passMD5 = md5($password);

			try {
				$conexion = MySqlDAO::getIntance();

				$sql = "CALL PA_U_Usuario_Password(
				{$id},
				'{$passMD5}',
				{$usuario_id},
				'{$fecha}',
				@msg_error)";

				// Ejecutamos el procedimiento almacenado
				$conexion->ejecutarSql($sql);

				// Retornamos la cantidad de registros afectados
				return $conexion->getRegistrosAfectados();

			} catch (Exception $e) {
				throw $ex;
			}
		}

		public static function obtenerPorUsername($username){
			try {
				$conexion = MySqlDAO::getIntance();
				$sql = "CALL PA_S_Usuario_Username('{$username}', @msg_error)";

				//abrimos conexion
				$conexion->abrirConexion();

				// Ejecutamos el procedimiento almacenado
				$result = $conexion->ejecutarSql($sql);

				$usuario = null;

				while ($row = mysqli_fetch_assoc($result)) {
					$id = $row['id'];
					$username = $row['username'];
					$correo = $row['correo'];
					$nombre = $row['nombre'];
					$apellido1 = $row['apellido1'];
					$apellido2 = $row['apellido2'];
					$rol = $row['rol'];
					$activo = $row['activo'];
					$cod_usr_crea = $row['cod_usr_crea'];
					$fec_creacion = $row['fec_creacion'];

					if ($rol == 1) {
						$usuario = new Administrador($id, $username, $correo, $nombre, $apellido1, $apellido2, $activo);
					}else{
						$usuario = new Facturador($id, $username, $correo, $nombre, $apellido1, $apellido2, $activo);
					}
				}
				//cerramos la conexion
				$conexion->cerrarConexion();
				return $usuario;

			} catch (Exception $ex) {
				throw $ex;
			}
		}
	}
 ?>
