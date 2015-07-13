<?php
    /**
     *
     */
    class ingredienteDAL extends baseDAL
    {
        public static function agregar($ingrediente)
        {
            $sql = "CALL PA_I_Ingrediente(
    				'{$ingrediente->getDescripcion()}',
    				{$ingrediente->getCosto_adicional()},
    				'{$ingrediente->getTipo_ingrediente()->getId()}',
    				{$ingrediente->getActivo()},
    				%usuario_id%,
    				'%fecha%',
    				@msg_error)";

            try {
                return self::ejecutarSql($sql);
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public static function modificar($ingrediente)
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
            //falta por agregar
        }

        public static function obtenerTodos($activo)
        {
            $sql = "SELECT id, descripcion, tipo_ingrediente, costo_adicional, activo
            		FROM Ingrediente";

            if ($activo != -1)
            {
                $sql .= " WHERE activo = {$activo}";
            }
            $sql .= "ORDER BY id";

            try {
                $result = self::ejecutarSql($slq);
                return $lista = self::iterarObjetos($result);
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public static function iterarObjetos($lista)
        {
            $lista_ingredientes = array();
            while ($row = mysqli_fetch_assoc($lista))
            {
                $id = $row['id'];
                $descripcion = $row['descripcion'];
                $costo_adicional = $row['costo_adicional'];
                $tipo_ingrediente = $row['tipo_ingrediente'];
                $activo = $row['activo'];

                $obj_tipo_ingrediente = FactoryTipoIngrediente::getTipoIngrediente($tipo_ingrediente);

                $ingrediente = new Ingrediente($id, $descripcion, $costo_adicional, $obj_tipo_ingrediente, $activo);

                $lista_ingredientes[] = $ingrediente;
            }

            mysqli_free_result($lista);

            return $lista_ingredientes;
        }

        public static function obtenerPorCriterio($criterio, $valor, $activo, $posicion, $cantidad)
        {
            $lista_ingredientes = array();
            $sql = "SELECT id, descripcion, tipo_ingrediente, costo_adicional, activo
    				FROM Ingrediente
    				WHERE {$criterio} LIKE '{$valor}%' ";

            if ($activo != -1)
            {
                $sql .= "AND activo = {$activo}";
            }

            $sql .= "ORDER BY {$criterio} LIMIT {$posicion}, {$cantidad}";

            try {
                $conexion = MySqlDAO::getIntance();
                $conexion->abrirConexion();
                $result = $conexion->ejecutarSql($sql);

                while ($row = mysqli_fetch_assoc($result))
                {
                    $id = $row['id'];
                    $descripcion = $row['descripcion'];
                    $costo_adicional = $row['costo_adicional'];
                    $tipo_ingrediente = $row['tipo_ingrediente'];
                    $activo = $row['activo'];

                    $obj_tipo_ingrediente = FactoryTipoIngrediente::getTipoIngrediente($tipo_ingrediente);

                    $ingrediente = new Ingrediente($id, $descripcion, $costo_adicional, $obj_tipo_ingrediente, $activo);\

                    $lista_ingredientes[] = $ingrediente;
                }

                mysqli_free_result($result);

                $conexion->cerrarConexion();
                return $lista_ingredientes;
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public static function obtenerPorId($id)
        {
            $sql = "CALL PA_S_Ingrediente_Por_ID('{$id}', @msg_error)";

            try {
                $result = self::ejecutarSql($sql);
                $lista =  self::iterarObjetos($result);
                return $lista[0];
            } catch (Exception $ex) {
                throw $ex;
            }
        }
    }
 ?>
