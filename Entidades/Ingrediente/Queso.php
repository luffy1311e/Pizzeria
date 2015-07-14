<?php
    /**
     *
     */
    class Queso extends TipoIngrediente
    {
        const ID = "QUE";
        const DESCRIPCION = "Queso";

        function __construct(argument)
        {
            parent::__construct(self::ID, self::DESCRIPCION);
        }
    }
 ?>
