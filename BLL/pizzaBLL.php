<?php
    /**
     *
     */
    class pizzaBLL extends baseBLL
    {
        public static function agregar($pizza)
        {
            try {
                return pizzaDAL::agregar($pizza);
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public static function modificar($pizza)
        {
            try {
                return pizzaDAL::modificar($pizza);
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
                return pizzaDAL::obtenerTodos($activo);
            } catch (Exception $e) {
                throw $ex;
            }
        }

        public static function obtenerPorCriterio($criterio, $valor, $activo, $posicion, $cantidad)
        {
            try {
                return pizzaDAL::obtenerPorCriterio($criterio, $valor, $activo, $posicion, $cantidad);
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public static function obtenerPorId($id)
        {
            try {
                return pizzaDAL::obtenerPorId($id);
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public static function separarPizzaPorPasta($lista_pizzas)
        {
            $nueva_lista = array();

            foreach ($lista_pizzas as $pizza) {
                if (count($pizza->getLista_pasta()) == 2)
                {
                    $pizzaPastaGruesa = clone $pizza;
                    $pizzaPastaDelgada = clone $pizza;

                    $pizzaPastaGruesa->setPasta(FactoryPasta::getPasta(PastaDelgadaOPastaGruesa::PASTA_GRUESA));
                    $pizzaPastaDelgada->setPasta(FactoryPasta::getPasta(PastaDelgadaOPastaGruesa::PASTA_DELGADA));

                    $nueva_lista[] = $pizzaPastaGruesa;
                    $nueva_lista[] = $pizzaPastaDelgada;
                }
                else{
                    $nueva_lista = $pizza;
                }
            }

            return $nueva_lista;
        }

        public static function convertirTableHTML($lista, $modificar = false, $eliminar = false)
        {
            try {
                $titulos = ["CÓDIGO","NOMBRE","PASTA","QUESO","CARNES","VEGETALES","ACTIVO"];

    			$html = "<table class=\"table table-striped table-hover table-bordered\" id=\"tablaPizza\">";
    			$html .= "<thead>";

    			foreach ( $titulos as $titulo ) {
    				$html .= "<th>" . $titulo . "</th>";
    			}

    			if ($modificar == true or $eliminar == true)
    				$html .= "<th>ACCIONES</td>";

    			$html .= "</thead>";
    			$html .= "<tbody>";

    			foreach ( $lista as $pizza ) {
    				$html .= "<tr>";
    				$html .= "<td>" . $pizza->getId() . "</td>";
    				$html .= "<td>" . $pizza->getDescripcion() . "</td>";

    				$pastas = "";

    				foreach ($pizza->getLista_pasta() as $pasta) {
    					$pastas .= $pasta->getDescripcion() . "<br/>";
    				}

    				$html .= "<td>" . $pastas . "</td>";
    				$html .= "<td>" . $pizza->getQueso() . " gr.</td>";

    				$carnes = "";
    				$vegetales = "";

    				foreach ($pizza->getLista_ingredientes() as $ingrediente) {
    					if (get_class($ingrediente->getTipo_ingrediente()) == "Vegetal")
    						$vegetales .= $ingrediente->getDescripcion() . "<br/>";

    					if (get_class($ingrediente->getTipo_ingrediente()) == "Carne")
    						$carnes .= $ingrediente->getDescripcion() . "<br/>";
    				}

    				$html .= "<td>" . $carnes . "</td>";
    				$html .= "<td>" . $vegetales . "</td>";


    				if ($pizza->getActivo())
    					$html .= "<td><span class=\"glyphicon glyphicon-ok\"></span></td>";
    				else
    					$html .= "<td><span class=\"glyphicon glyphicon-remove\"></span></td>";

    				if ($modificar == true) {
    					$html .= "<td><a href=\"mantenimiento.php?view=modificar_pizza&modificar=true&id={$pizza->getId()}\" class=\"btn btn-primary btn-xs\" >
    					<span class=\"glyphicon glyphicon-edit\"></span> Editar</a></td>";
    				}

    				if ($eliminar == true) {
        				if ($bebida->getActivo())
                        {
                            $html .= "<td><a href=\"{$pizza->getId()}\" class=\"btn btn-danger btn-xs\" data-toggle=\"modal\" data-target=\"#modalEliminar\">
                            <span class=\"glyphicon glyphicon-remove\"></span> Deshabilitar</a></td>";
                        }else{
                            $html .= "<td><a href=\"{$pizza->getId()}\" class=\"btn btn-success btn-xs\" data-toggle=\"modal\" data-target=\"#modalEliminar\">
                            <span class=\"glyphicon glyphicon-ok\"></span> Habilitar</a></td>";
                        }
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
    }

 ?>
