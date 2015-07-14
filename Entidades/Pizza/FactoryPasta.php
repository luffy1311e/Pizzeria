<?php
    /**
     *
     */
    abstract class FactoryPasta
    {
        public function getPasta($id)
        {
            $pasta = new PastaGruesa();

            switch ($id) {
                case PastaDelgadaOPastaGruesa::PASTA_GRUESA:
                    $pasta = new PastaGruesa();
					break;
                case PastaDelgadaOPastaGruesa::PASTA_DELGADA:
                    $pasta = new PastaDelgada();
                    break;
            }

            return $pasta;
        }
    }
 ?>
