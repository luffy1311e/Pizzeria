<?php
    /**
     *
     */
    abstract class TipoIngrediente
    {

        private $id;
        private $descripcion;
        private $precio;

        function __construct($id, $descripcion)
        {
            $this->id = $id;
            $this->descripcion = $descripcion;
            $this->precio = $this->cargarPrecio();
        }

        public function cargarPrecio()
        {
            $precio = 0;

            switch ($this->id) {
                case CarneVegetalQueso::CARNE:
                    $precio = 100;
                    break;
                case CarneVegetalQueso::VEGETAL:
                    $precio = 200;
                    break;
                case CarneVegetalQueso::QUESO:
                    $precio = 300;
                    break;
            }
            return $precio;
        }

        public function __toString()
        {
            return $this->id . " - " . $this->descripcion;
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
        }
    }

 ?>
