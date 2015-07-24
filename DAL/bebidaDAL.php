<?php

	/**
	*
	*/
	class bebidaDAL extends baseDAL
	{
		public static function Agregar($bebida)
		{
			$fecha = date('Y-m-d H:i:s');
			if ($bebida instanceof Gaseosa) {
				$cantidad = $bebida->getCantidad();
				$tipo_bebida = GaseosaONatural::GASEOSA;
			}
			else{
				$cantidad = 0;
				$tipo_bebida = GaseosaONatural::NATURAL;
			}

			$sql = "CALL PA_I_Bebida(
				   '{$bebida->getDescripcion()}',
				   {$bebida->getMililitros()},
				   {$bebida->getPrecio()},
				   {$cantidad},
				   '{$tipo_bebida}',
				   {$bebida->getActivo()},
				   1,
				   '{$fecha}',
				   @msg_error)";

			try {
				$conexion = MySqlDAO::getIntance();
				$conexion->abrirConexion();
				$resultado = $conexion->ejecutarSql($sql);
				$conexion->cerrarConexion();
				return $resultado;
				//return self::ejecutarSql($sql);
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
			$lista_bebidas = array();
			$sql = "SELECT id, descripcion, mililitros, precio, cantidad, tipo_bebida, activo
					FROM Bebida
					WHERE activo = {$activo}
					ORDER BY descripcion";

			try {
				$conexion = MySqlDAO::getIntance();
                $conexion->abrirConexion();
                $result = $conexion->ejecutarSql($sql);

				while ($row = mysqli_fetch_assoc($result))
				{
					$id = $row['id'];
					$descripcion = $row['descripcion'];
					$mililitros = $row['mililitros'];
					$precio = $row['precio'];
					$cantidad = $row['cantidad'];
					$tipo_bebida = $row['tipo_bebida'];
					$activo = $row['activo'];

					$bebida = FactoryBebida::getBebida($id, $descripcion, $mililitros, $precio, $cantidad, $activo, $tipo_bebida);
					//$lista_bebidas[] = $bebida;
					array_push($lista_bebidas,$bebida);
				}

				mysqli_free_result($result);

				return $lista_bebidas;
				//$result = self::ejecutarSql($sql);
				//return $lista = self::iterarObjetos($result);
			} catch (Exception $ex) {
				throw $ex;
			}
		}

		public static function obtenerPorCriterio($criterio, $valor, $activo, $posicion, $cantidad)
		{
			$lista_bebidas = array();
			$sql = "SELECT id, descripcion, mililitros, precio, cantidad, tipo_bebida, activo
					FROM Bebida
					WHERE {$criterio} LIKE '{$valor}%' ";

			if ($activo != -1)
			{
				$sql .= "AND activo = {$activo} ";
			}

			$sql .= "ORDER BY {$criterio} LIMIT {$posicion}, {$cantidad}";

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

					$bebida = FactoryBebida::getBebida($id, $descripcion, $mililitros, $precio, $cantidad, $activo, $tipo_bebida);
					$lista_bebidas[] = $bebida;
				}

				mysqli_free_result($result);

				$conexion->cerrarConexion();
				return $lista_bebidas;
			} catch (Exception $ex) {
				throw $ex;
			}
		}

		public static function iterarObjetos($lista)
        {
            $lista_bebidas = array();

            while ($row = mysqli_fetch_assoc($lista))
            {
				$id = $row['id'];
				$descripcion = $row['descripcion'];
				$mililitros = $row['mililitros'];
				$precio = $row['precio'];
				$cantidad = $row['cantidad'];
				$tipo_bebida = $row['tipo_bebida'];
				$activo = $row['activo'];

				$bebida = FactoryBebida::getBebida($id, $descripcion, $mililitros, $precio, $cantidad, $activo, $tipo_bebida);

                array_push($lista_bebidas[],$bebida);
            }

            mysqli_free_result($lista);

            return $lista_bebidas;
        }

		public static function obtenerPorId($id)
		{
			$slq = "CALL PA_S_Bebida_Por_ID('{$id}', @msg_error)";

			try {
				$conexion = MySqlDAO::getIntance();
                $conexion->abrirConexion();
                $result = $conexion->ejecutarSql($sql);
				$lista = self::iterarObjetos($result);
				$conexion->cerrarConexion();
				return $lista[0];
			} catch (Exception $ex) {
				throw $ex;
			}
		}
	}
 ?>
