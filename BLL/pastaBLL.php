<?php
    /**
     *
     */
    class pastaBLL
    {
        function __construct()
        {
            # code...
        }

        public static function obtenerTipoPasta()
        {
            $lista_pastas = array();

            $pastaGruesa = new PastaGruesa();
            $pastaDelgada = new PastaDelgada();

            $lista_pastas[] = $pastaGruesa;
            $lista_pastas[] = $pastaDelgada;

            return $lista_pastas;
        }

        public static function obtenerOptionsHTML($checked = -1)
        {
            $lista_nueva = array();

            foreach ($self::obtenerTipoPasta() as $pasta)
            {
                $lista_nueva[$pasta->getId()] = $pasta->getDescripcion();
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
