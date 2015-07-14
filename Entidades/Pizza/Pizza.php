<?php
    /**
     *
     */
    class Pizza extends base
    {
        private $id;
    	private $descripcion;
    	private $lista_pastas;
    	private $pasta;
    	private $lista_ingredientes;
    	private $queso;
    	private $activo;

        function __construct($id, $descripcion, $activo, $lista_pastas, $lista_ingredientes, $queso)
        {
            parent::__construct($id, $descripcion, $activo);
            $this->lista_ingredientes = $lista_ingredientes;
            $this->queso = $queso;
            $this->pasta = FactoryPasta::getPasta(PastaDelgadaOPastaGruesa::PASTA_DELGADA);

            if ($lista_pastas != null)
            {
                $this->lista_pastas = $lista_pastas;
            }
            else{
                $array_pastas = array();

    			if (strtolower($this->getDescripcion()) != "italiana") {
    				$array_pastas[] = FactoryPasta::getPasta(PastaDelgadaOPastaGruesa::PASTA_GRUESA);
    				$array_pastas[] = FactoryPasta::getPasta(PastaDelgadaOPastaGruesa::PASTA_DELGADA);
    			} else {
    				$array_pastas[] = FactoryPasta::getPasta(PastaDelgadaOPastaGruesa::PASTA_DELGADA);
    			}

    			$this->lista_pastas = $array_pastas;
            }
        }

        public function setPasta($pasta)
        {
		    $this->pasta = $pasta;
    	}

    	public function getPasta()
        {
    		return $this->pasta;
    	}

    	public function setLista_pastas($lista_pastas)
        {
    		$this->lista_pastas = $lista_pastas;
    	}

    	public function getLista_pasta()
        {
    		return $this->lista_pastas;
    	}

    	public function agregarIngrediente($ingrediente)
        {
    		$this->lista_ingredientes[] = $ingrediente;
    	}

    	public function getLista_ingredientes()
        {
    		return $this->lista_ingredientes;
    	}

    	public function setLista_ingredientes($lista_ingredientes)
        {
    		 $this->lista_ingredientes = $lista_ingredientes;
    	}

    	public function setQueso($queso)
        {
    		$this->queso = $queso;
    	}

    	public function getQueso()
        {
    		return $this->queso;
    	}

    	public function getTotal()
        {
    		// Calculamos el valor de la pasta
    		$total = $this->getPasta()->getPrecio();

    		// Calculamos el valor del queso
    		$queso = FactoryTipoIngrediente::getTipoIngrediente(CarneVegetalQueso::QUESO);
    		$precioxgramo = $queso->getPrecio() / 100;
    		$total += $this->getQueso() * $precioxgramo;

    		foreach ($this->getLista_ingredientes() as $ingrediente)
            {
    			$total += $ingrediente->getTotal();
    		}

    		return $total;
    	}

    	public function parseArray()
        {
    		$array = array();

    		$array["object"] = get_class($this);
    		$array["id"] = $this->getId();
    		$array["descripcion"] = $this->getDescripcion();
    		$array["queso"] = $this->getQueso();
    		$array["total"] = $this->getTotal();
    		$array["activo"] = $this->getActivo();
    		$array["pasta"] = $this->getPasta()->parseArray();

    		$array_pastas = array();

    		if ($this->getLista_pasta() == null)
            {
    			if (strtolower($this->getDescripcion()) != "italiana")
                {
    				$array_pastas[] = FactoryPasta::getPasta(PastaDelgadaOPastaGruesa::PASTA_GRUESA)->parseArray();
    				$array_pastas[] = FactoryPasta::getPasta(PastaDelgadaOPastaGruesa::PASTA_DELGADA)->parseArray();
    			}
                else {
    				$array_pastas[] = FactoryPasta::getPasta(PastaDelgadaOPastaGruesa::PASTA_DELGADA)->parseArray();
    			}
    		}
            else {
    			foreach ($this->getLista_pasta() as $pasta)
                {
    				$array_pastas[] = $pasta->parseArray();
    			}
    		}

    		$array["pastas"] = $array_pastas;
    		$array_ingrediente = array();

    		foreach ($this->getLista_ingredientes() as $ingrediente)
            {
    			$array_ingrediente[] = $ingrediente->parseArray();
    		}

    		$array["ingredientes"] = $array_ingrediente;
    		return $array;

    	}

    	public function __toString()
        {
    		$str = "";

    		$str .= $this->getDescripcion();

    		return $str;
    	}
    }
 ?>
