<?php
    /**
     *
     */
    class PastaDelgada extends Pasta
    {
        const ID=2;
        const DESCRIPCION = "Pasta Delgada";

        function __construct()
        {
            parent::__construct(self::ID, self::DESCRIPCION);
        }
    }

?>
