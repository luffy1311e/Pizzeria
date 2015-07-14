<?php
    /**
     *
     */
    class ingrediente
    {
        private $id;
        private $descripcion;
        private $costo_adicional;
        private $tipo_ingrediente;
        private $activo;

        public function __construct($id, $descripcion, $costo_adicional, $tipo_ingrediente, $activo)
        {
            $this->id = $id;
            $this->descripcion = $descripcion;
            $this->costo_adicional = $costo_adicional;
            $this->tipo_ingrediente = $tipo_ingrediente;
            $this->activo = $activo;
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

        public function getCosto_adicional()
        {
            return $this->costo_adicional;
        }

        public function setCosto_adicional($costo_adicional)
        {
            $this->costo_adicional = $costo_adicional;
        }

        public function getTipo_ingrediente()
        {
            return $this->tipo_ingrediente;
        }

        public function setTipo_ingrediente($tipo_ingrediente)
        {
            $this->tipo_ingrediente = $tipo_ingrediente;
        }

        public function getActivo()
        {
            return $this->activo;
        }

        public function setActivo($activo)
        {
            $this->activo = $activo;
        }

        public function getTotal()
        {
            return $this->getTipo_ingrediente()->getPrecio() + $this->getCosto_adicional();
        }

        public function parseArray()
        {
            $array = array();

            $array["object"] = get_class($this);
            $array["id"] = $this->getId();
            $array["descripcion"] = $this->getDescripcion();
            $array["costo_adicional"] = $this->getCosto_adicional();
            $array["tipo_ingrediente"] = $this->getTipo_ingrediente()->parseArray();
            $array["total"] = $this->getTotal();
            $array["activo"] = $this->getActivo();

            return $array;
        }
    }

 ?>
