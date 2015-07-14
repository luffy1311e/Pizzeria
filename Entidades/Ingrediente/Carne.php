<?php
    /**
     *
     */
    class Carne extends TipoIngrediente
    {
        const ID = "CAR";
        const DESCRIPCION = "Carne";

        public function __construct()
        {
            parent::__construct(self::ID, self::DESCRIPCION);
        }
    }
 ?>
