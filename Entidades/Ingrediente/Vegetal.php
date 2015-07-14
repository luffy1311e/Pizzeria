<?php
    /**
     *
     */
    class Vegetal extends TipoIngrediente
    {

        const ID = "VEG";
        const DESCRIPCION = "Vegetal";

        public function __construct()
        {
            parent::__construct(self::ID, self::DESCRIPCION);
        }
    }
 ?>
