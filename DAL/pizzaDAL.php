<?php
    /**
     *
     */
    class pizzaDAL extends baseDAL
    {
        public static function agregar($pizza)
        {
            $fecha = date('Y-m-d H:i:s');
            $sql = "CALL PA_I_Pizza(
    				'{$pizza->getDescripcion()}',
    				{$pizza->getQueso()},
    				{$pizza->getActivo()},
    			    1,
    				'{$fecha}',
    				@msg_error,
    				@pId)";

            try {
                $conexion = MySqlDAO::getIntance();
                $conexion->abrirConexion();
                $result = $conexion->ejecutarSql($sql);
                $id = $conexion->obtenerValorPA("SELECT @pId");
                if (is_numeric($id) and $id > 0)
                {
                    $sql = "";
                    foreach ($pizza->getLista_ingredientes() as $ingrediente)
                    {
                        $sql .= "CALL PA_I_DetallePizza(
    							{$id},
    							'{$ingrediente}',
    							1,
    							1,
    							'{$fecha}',
    							@msg_error);";
                    }

                    $result = $conexion->ejecutarMultipleSql($sql);
                    $conexion->cerrarConexion();
                    return $result;
                }
                else {
                    throw new Exception("Consulte con su administrador.");
                }
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public static function modificar($pizza)
        {
            $sql = "CALL PA_U_Ingrediente(
    				'{$ingrediente->getId()}',
    				'{$ingrediente->getDescripcion()}',
    				{$ingrediente->getCosto_adicional()},
    				'{$ingrediente->getTipo_ingrediente()->getId()}',
    				{$ingrediente->getActivo()},
    				%usuario_id%,
    				'%fecha%',
    				@msg_error)	";

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
            $sql = "SELECT id, descripcion, tipo_ingrediente, costo_adicional, activo
            		FROM Ingrediente";

            if ($activo != -1)
            {
                $sql .= " WHERE activo = {$activo}";
            }

            $sql .= " ORDER BY id";

            try {
                $result = self::ejecutarSql($sql);
                return $lista = self::iterarObjetos($result);
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public static function iterarObjetos($lista)
        {
            $lista_pizza = array();

            while ($row = mysqli_fetch_assoc($lista))
            {
                $id = $row['id'];
                $descripcion = $row['descripcion'];
                $queso = $row['queso'];
                $activo = $row['activo'];

                $pizza = new Pizza($id, $descripcion, $activo, null, null, $queso);

                array_push($lista_pizza,$pizza);
            }

            mysqli_free_result($lista);

            return $lista_pizza;
        }

        public static function iterarDetallePizza($lista)
        {
            $lista_Detalle_Pizza = array();

            while ($row = mysqli_fetch_assoc($lista))
            {
                $pizza = $row['pizza'];
                $id = $row['id'];
                $descripcion = $row['descripcion'];
                $tipo_ingrediente = $row['tipo_ingrediente'];
                $costo_adicional = $row['costo_adicional'];
                $activo = $row['activo'];

                $obj_tipo_ingrediente = FactoryTipoIngrediente::getTipoIngrediente($tipo_ingrediente);
                $obj_ingrediente = new Ingrediente($id, $descripcion, $costo_adicional, $obj_tipo_ingrediente, $activo);

                $lista_Detalle_Pizza[] = $obj_ingrediente;
            }

            mysqli_free_result($lista);

            return $lista_Detalle_Pizza;
        }

        public static function obtenerPorCriterio($criterio, $valor, $activo, $posicion, $cantidad)
        {
            $sql = "SELECT id, descripcion, queso, activo
    				FROM Pizza
    				WHERE {$criterio} LIKE '{$valor}%' ";

            if ($activo != -1)
            {
                $sql .= " AND activo = {$activo}";
            }

            $sql .= " ORDER BY {$criterio} LIMIT {$posicion}, {$cantidad}";

            try {
                $conexion = MySqlDAO::getIntance();
                $conexion->abrirConexion();
                $result = $conexion->ejecutarSql($sql);
                $lista = self::iterarObjetos($result);
                foreach ($lista as $pizza)
                {
                    $sql = "select d.pizza, d.ingrediente as id, i.descripcion, i.tipo_ingrediente, i.costo_adicional, i.activo
    						from DetallePizza d
    						inner join Ingrediente i
    						on d.ingrediente = i.id
    						where d.pizza = {$pizza->getId()}";

                    $result = $conexion->ejecutarSql($sql);
                    $lista_ingredientes = self::iterarDetallePizza($result);
                    $pizza->setLista_ingredientes($lista_ingredientes);
                }
                $conexion->cerrarConexion();
                return $lista;
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public static function obtenerPorId($id)
        {
            $sql = "CALL PA_S_Ingrediente_Por_ID('{$id}', @msg_error)";

            try {
                $conexion = MySqlDAO::getIntance();
                $conexion->abrirConexion();
                $result = $conexion->ejecutarSql($sql);
                $lista = self::iterarObjetos($result);
                return $lista[0];
            } catch (Exception $ex) {
                throw $ex;
            }
        }
    }
 ?>
