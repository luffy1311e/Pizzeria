<?php
    /**
     *
     */
    class Queso extends TipoIngrediente
    {
        const ID = "QUE";
        const DESCRIPCION = "Queso";

        function __construct()
        {
            parent::__construct(self::ID, self::DESCRIPCION);
        }
    }
 ?>
