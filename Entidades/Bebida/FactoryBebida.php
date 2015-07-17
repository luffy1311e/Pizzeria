<?php
	/**
	*
	*/
	 abstract class FactoryBebida
	{
		public static function getBebida($id, $descripcion, $mililitros, $precio,
			$cantidad, $activo, $tipo_bebida)
		{
			$bebida = null;

			switch ($tipo_bebida) {
				case GaseosaONatural::GASEOSA:
					$bebida = new Gaseosa($id, $descripcion, $mililitros, $precio, $activo);
					$bebida->setCantidad($cantidad);
					break;
				case GaseosaONatural::NATURAL:
					$bebida = new Natural($id, $descripcion, $mililitros, $precio, $activo);
					break;
			}
			return $bebida;
		}
	}
 ?>
