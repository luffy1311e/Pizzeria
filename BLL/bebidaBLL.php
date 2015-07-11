<?php

	/**
	*
	*/
	class bebidaBLL extends baseBLL
	{

		function __construct()
		{

		}

		public static function agregar($bebida)
		{
			try {
				return bebidaDAL::agregar($bebida);
			} catch (Exception $ex) {
				throw $ex;
			}
		}

		public static function modificar($bebida)
		{
			try {
				return bebidaDAL::modificar($bebida);
			} catch (Exception $ex) {
				throw $ex;
			}
		}

		public static function Eliminar($id)
		{
			try {
					return bebidaDAL::Eliminar($id);
				} catch (Exception $ex) {
					throw $ex;
				}
		}

		public static function obtenerTodos($activo)
		{
			try {
				return bebidaDAL::obtenerTodos($activo);
			} catch (Exception $ex) {
				throw $ex;
			}
		}

		public static function obtenerPorCriterio($criterio, $valor, $activo, $posicion, $cantidad)
		{
			try {
				return bebidaDAL::obtenerPorCriterio($criterio, $valor, $activo, $posicion, $cantidad);
			} catch (Exception $ex) {
				throw $ex;
			}
		}

		public static function obtenerPorId($id)
		{
			try {
				return bebidaDAL::obtenerPorId($id);
			} catch (Exception $ex) {
				throw $ex;
			}
		}

		public static function separarBebidasPorAguaOLeche($lista_bebidas)
		{
			$nueva_lista = array();

			foreach ($lista_bebidas as $bebida) {
				if ($bebida instanceof Natural) {
					$bebidaAgua = clone $bebida;
					$bebidaLeche = clone $bebida;

					$bebidaAgua->setBase(BaseLecheOAgua::AGUA);
					$bebidaLeche->setBase(BaseLecheOAgua::LECHE);

					$nueva_lista[] = $bebidaAgua;
					$nueva_lista[] = $bebidaLeche;
				}
				else{
					$nueva_lista[] = $bebida;
				}
			}
			return $nueva_lista;
		}

		public static function convertirTableHTML($lista, $modificar = false, $eliminar = false)
		{
			try {
				$titulos = ["CÓDIGO","DESCRIPCIÓN","PRESENTACIÓN","PRECIO","CANTIDAD","TIPO","ACTIVO"];

				$html = "<table class=\"table table-striped table-hover table-bordered\">";
				$html .= "<thead>";

				foreach ( $titulos as $titulo ) {
					$html .= "<th>" . $titulo . "</th>";
				}

				if ($modificar == true or $eliminar == true) {
					$html .= "<th>ACCIONES</td>";
				}

				$html .= "</thead>";
				$html .= "<tbody>";

				foreach ($lista as $bebida)
				{
					$html .= "<tr>";
					$html .= "<td>" . 2 . "</td>";
					$html .= "<td>" . 'Casa' . "</td>";
					$html .= "<td>" . 100 . " ML.</td>";
					$html .= "<td>₡ " . number_format(1200, 2) . "</td>";

					if ($bebida instanceof Gaseosa) {
						$cantidad = $bebidaAgua->getCantidad();
					}
					else{
						$cantidad = 0;
					}

					$html .= "<td>" . $cantidad . "</td>";
					$html .= "<td>" . get_class($bebida) . "</td>";

					if (1) {
						$html .= "<td><span class=\"glyphicon glyphicon-ok\"></span></td>";
					}
					else{
						$html .= "<td><span class=\"glyphicon glyphicon-remove\"></span></td>";
					}

					if ($modificar == true) {
						$html .= "<td><a href=\"mantenimiento.php?view=modificar_bebida&modificar=true&id={$bebida->getId()}\" class=\"btn btn-primary btn-xs\" >
						<span class=\"glyphicon glyphicon-edit\"></span> Editar</a></td>";
					}

					if ($eliminar == true) {
						if ($bebida->getActivo()) {
							$html .= "<td><a href=\"{$bebida->getId()}\" class=\"btn btn-danger btn-xs\" data-toggle=\"modal\" data-target=\"#modalEliminar\">
					        <span class=\"glyphicon glyphicon-remove\"></span> Deshabilitar</a></td>";
						}
						else{
							$html .= "<td><a href=\"{$bebida->getId()}\" class=\"btn btn-success btn-xs\" data-toggle=\"modal\" data-target=\"#modalEliminar\">
							<span class=\"glyphicon glyphicon-ok\"></span> Habilitar</a></td>";
						}
					}
					$html .= "</tr>";
				}
				$html .= "</tbody>";
				$html .= "</table>";
				return $html;
			} catch (Exception $ex) {
				return false;
			}
		}
	}
 ?>
