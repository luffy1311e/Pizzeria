<?php
    /**
     *
     */
    abstract class Pasta
    {

        private $id;
        private $descripcion;
        private $precio;

        public function __construct($id, $descripcion)
        {
            $this->id = $id;
            $this->descripcion = $descripcion;
            $this->precio = $this->cargarPrecio();
        }

        public function cargarPrecio()
        {
            if ($this->id == PastaDelgadaOPastaGruesa::PASTA_GRUESA)
            {
                return 6000.0;
            }
            else{
                return 4000.0
            }
        }

        public function getId()
        {
            return $this->id;
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function getDescripcion()
        {
            return $this->descripcion;
        }

        public function setDescripcion($descripcion)
        {
            $this->descripcion = $descripcion;
        }

        public function getPrecio()
        {
            return $this->precio;
        }

        public function setPrecio($precio)
        {
            $this->precio = $precio;
        }

        public function parseArray()
        {
            $array = array();

            $array["object"] = get_class($this);
            $array["id"] = $this->getId();
            $array["descripcion"] = $this->getDescripcion();
            $array["precio"] = $this->getPrecio();

            return $array();
        }
    }
 ?>
