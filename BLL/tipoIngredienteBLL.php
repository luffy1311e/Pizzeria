<?php
    /**
     *
     */
    class tipoIngredienteBLL
    {
        public static function obtenerTiposIngredientes()
        {
            $lista_tipo_ingredientes = array();

            $carne = new Carne();
            $vegetal = new Vegetal();
            $queso = new Queso();

            $lista_tipo_ingredientes[] = $carne;
            $lista_tipo_ingredientes[] = $vegetal;
            $lista_tipo_ingredientes[] = $queso;

            return $lista_tipo_ingredientes;
        }

        public static function obtenerOptionsHTML($checked = -1)
        {
            $lista_nueva = array();

            foreach (self::obtenerTiposIngredientes() as $tipoIngrediente)
            {
                $lista_nueva[$tipoIngrediente->getId()] = $tipoIngrediente->getDescripcion();
            }

            return self::convertirOptionsHTML($lista_nueva, $checked);
        }

        public static function convertirOptionsHTML($lista, $checked = -1)
        {
            $html = "<option value=\"-1\">Seleccione una opción</option>";

            foreach ($lista as $valor => $nombre)
            {
                $html .= "<option value=\"{$valor}\" ";

                if ($checked == $valor)
                {
                    $html .= "selected";
                }

                $nombre = ucwords($nombre);
                $html .= "> {$nombre}</option>";
            }

            return $html;
        }
    }

 ?>
