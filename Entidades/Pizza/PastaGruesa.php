<?php
    /**
     *
     */
    class PastaGruesa extends Pasta
    {
        const ID = 1;
        const DESCRIPCION = "Pasta Gruesa";

        public function __construct()
        {
            parent::__construct(self::ID, self::DESCRIPCION);
        }
    }

 ?>
