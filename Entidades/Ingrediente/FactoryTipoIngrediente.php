<?php
    /**
     *
     */
    class FactoryTipoIngrediente
    {
        public static function getTipoIngrediente($id)
        {
            $tipo_ingrediente = null;

            switch ($id) {
                case CarneVegetalQueso::CARNE:
                    $tipo_ingrediente = new Carne();
                    break;
                case CarneVegetalQueso::VEGETAL:
                    $tipo_ingrediente = new Vegetal();
                    break;
                case CarneVegetalQueso::QUESO:
                    $tipo_ingrediente = new Queso();
                    break;
            }

            return $tipo_ingrediente;
        }
    }

 ?>
