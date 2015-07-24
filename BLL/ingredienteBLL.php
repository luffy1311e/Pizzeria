<?php
    /**
     *
     */
    class ingredienteBLL extends baseBLL
    {
        public static function agregar($ingrediente)
        {
            try {
                return ingredienteDAL::agregar($ingrediente);
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public static function modificar($ingrediente)
        {
            try {
                return ingredienteDAL::modificar($ingrediente);
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public static function eliminar($id)
        {

        }

        public static function obtenerTodos($activo)
        {
            try {
                return ingredienteDAL::obtenerTodos($activo);
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public static function obtenerPorCriterio($criterio, $valor, $activo, $posicion, $cantidad)
        {
            try {
                return ingredienteDAL::obtenerPorCriterio($criterio, $valor, $activo, $posicion, $cantidad);
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public static function obtenerPorId($id)
        {
            try {
                return ingredienteDAL::obtenerPorId($id);
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public static function convertirTableHTML($lista, $modificar = false, $eliminar = false)
        {
            try {
                $titulos = ["CÓDIGO","DESCRIPCIÓN","TIPO INGREDIENTE","COSTO ADICIONAL","ACTIVO"];

    			$html = "<table class=\"table table-striped table-hover table-bordered\" id=\"tablaIngrediente\">";
    			$html .= "<thead>";

    			foreach ( $titulos as $titulo ) {
    				$html .= "<th>" . $titulo . "</th>";
    			}

    			if ($modificar == true or $eliminar == true)
    				$html .= "<th>ACCIONES</td>";

    			$html .= "</thead>";
    			$html .= "<tbody>";

    			foreach ( $lista as $ingrediente ) {
    				$html .= "<tr>";
    				$html .= "<td>" . $ingrediente->getId() . "</td>";
    				$html .= "<td>" . $ingrediente->getDescripcion() . "</td>";
    				$html .= "<td>" . $ingrediente->getTipo_ingrediente()->getDescripcion() . "</td>";
    				$html .= "<td>₡ " . $ingrediente->getCosto_adicional() . "</td>";

    				if ($ingrediente->getActivo())
    					$html .= "<td><span class=\"glyphicon glyphicon-ok\"></span></td>";
    				else
    					$html .= "<td><span class=\"glyphicon glyphicon-remove\"></span></td>";

    				if ($modificar == true) {
    					$html .= "<td><a href=\"mantenimiento.php?view=modificar_ingrediente&modificar=true&id={$ingrediente->getId()}\" class=\"btn btn-primary btn-xs\" >
    					<span class=\"glyphicon glyphicon-edit\"></span> Editar</a></td>";
    				}

    				if ($eliminar == true) {
    					if ($ingrediente->getActivo())
    						$html .= "<td><a href=\"{$ingrediente->getId()}\" class=\"btn btn-danger btn-xs\" data-toggle=\"modal\" data-target=\"#modalEliminar\">
    					<span class=\"glyphicon glyphicon-remove\"></span> Deshabilitar</a></td>";
    					else
    						$html .= "<td><a href=\"{$ingrediente->getId()}\" class=\"btn btn-success btn-xs\" data-toggle=\"modal\" data-target=\"#modalEliminar\">
    					<span class=\"glyphicon glyphicon-ok\"></span> Habilitar</a></td>";
    				}

    				$html .= "</tr>";
    			}

    			$html .= "</tbody>";
    			$html .= "</table>";
    			return $html;
            } catch (Exception $ex) {
                throw false;
            }
        }

        public static function convertirObtionHTML($tipo_ingrediente)
        {
            $lista_ingredientes = null;

            try {
                $lista_ingredientes = self::obtenerTodos(1);
            } catch (Exception $ex) {
                throw $ex;
            }

            if ($lista_ingredientes == null)
            {
                return;
            }

            $sql = "";

            foreach ($lista_ingredientes as $ingrediente)
            {
                if (strtolower(get_class($ingrediente->getTipo_ingrediente())) == strtolower($tipo_ingrediente))
                {
                    $sql .= "<option value=\"{$ingrediente->getId()}\">{$ingrediente->getDescripcion()}</option>";
                }
            }

            return $sql;
        }
    }
 ?>
