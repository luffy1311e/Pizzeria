<?php 

	/**
	*
	*/
	class bebidaDAL extends baseDAL
	{

		function __construct()
		{

		}

		public static function Agregar($bebida)
		{

			if ($bebida instanceof Gaseosa) {
				$cantidad = $bebida->getCantidad();
				$tipo_bebida = GaseosaONatural::Gaseosa;
			}
			else{
				$cantidad = 0;
				$tipo_bebida = GaseosaONatural::Natural;
			}

			$sql = "CALL PA_I_Bebida(
				   '{$bebida->getDescripcion()}',
				   {$bebida->getMililitros()},
				   {$bebida->getPrecio()},
				   {$cantidad},
				   '{$tipo_bebida}',
				   {$bebida->getActivo()},
				   %usuario_id%,
				   '%fecha%',
				   @msg_error)";

			try {
				return self::ejecutarSql($sql);
			} catch (Exception $ex) {
				throw $ex;
			}
		}

		public static function Modificar($bebida)
		{
			if ($bebida instanceof Gaseosa) {
				$cantidad = $bebida->getCantidad();
			}
			else{
				$cantidad = 0;
			}

			$sql = "CALL PA_U_Bebida(
				   {$bebida->getId()},
				   '{$bebida->getDescripcion()}',
				   {$bebida->getMililitros()},
				   {$bebida->getPrecio()},
				   {$cantidad},
				   '{$bebida->getTipo_bebida()}',
				   {$bebida->getActivo()},
				   %usuario_id%,
				   '%fecha%',
				   @msg_error)";

			try {
				return self::ejecutarSql($sql);
			} catch (Exception $ex) {
				throw $ex;

			}
		}

		public static function eliminar($id)
		{

		}

		public static function obtenerTodos($activo)
		{
			$sql = "SELECT id, descripcion, mililitros, precio, cantidad, tipo_bebida, activo
					FROM Bebida
					WHERE activo = {$activo}
					ORDER BY descripcion";

			try {
				$result = self::ejecutarSql($sql);
				return $lista = self::iterarObjetos($result);
			} catch (Exception $ex) {
				throw $ex;
			}
		}

		protected static function iterarObjetos($lista) {
			$lista_bebidas = array();

			while ($row = mysqli_fetch_assoc($lista)) {
				$id = $row['id'];
				$descripcion = $row['descripcion'];
				$mililitros = $row['mililitros'];
				$precio = $row['precio'];
				$cantidad = $row['cantidad'];
				$tipo_bebida = $row['tipo_bebida'];
				$activo = $row['activo'];

				$bebida = FactoryBebida::getBebida($id, $descripcion, $mililitros, $precio, $cantidad, $activo, $tipo_bebida);
				$lista_bebidas[] = $bebida;
			}

			// Liberamos los recursos
			mysqli_free_result($lista);

			return $lista_bebidas;
		}

		public static function obtenerPorCriterio($criterio, $valor, $activo, $posicion, $cantidad)
		{
			$lista_bebidas = array();
			$sql = "SELECT id, descripcion, mililitros, precio, cantidad, tipo_bebida, activo
					FROM Bebida
					WHERE {$criterio} LIKE '{$valor}%' ";

			if ($activo != -1) {
				$sql .= "AND activo = {$activo}";
			}
			else{
				$sql .= "ORDER BY {$criterio}
						LIMIT {$posicion}, {$cantidad}";
			}

			try {
				$conexion = MySqlDAO::getIntance();
				$conexion->abrirConexion();
				$result = $conexion->ejecutarSql($sql);

				while ($row = mysqli_fetch_assoc($result)) {
					$id = $row['id'];
					$descripcion = $row['descripcion'];
					$mililitros = $row['mililitros'];
					$precio = $row['precio'];
					$cantidad = $row['cantidad'];
					$tipo_bebida = $row['tipo_bebida'];
					$activo = $row['activo'];

					$bebida = FactoryBebida::getBebida($id, $descripcion, $mililitros, $precio, $cantidad, $tipo_bebida, $activo);
					$lista_bebidas[] = $bebida;
				}

				mysqli_free_result($result);

				$conexion->cerrarConexion();
				return $lista_bebidas;
			} catch (Exception $ex) {
				throw $ex;
			}
		}

		public static function obtenerPorId($id)
		{
			$slq = "CALL PA_S_Bebida_Por_ID('{$id}', @msg_error)";

			try {
				$result = self::ejecutarSql($sql);
				$lista = self::iterarObjetos($result);
				return $lista[0];
			} catch (Exception $ex) {
				throw $ex;
			}
		}
	}
 ?>
