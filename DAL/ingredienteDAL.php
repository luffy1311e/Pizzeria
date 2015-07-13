<?php
    /**
     *
     */
    class ingredienteDAL extends baseDAL
    {
        public static function agregar($ingrediente)
        {
            $sql = "CALL PA_I_Ingrediente(
    				'{$ingrediente->getDescripcion()}',
    				{$ingrediente->getCosto_adicional()},
    				'{$ingrediente->getTipo_ingrediente()->getId()}',
    				{$ingrediente->getActivo()},
    				%usuario_id%,
    				'%fecha%',
    				@msg_error)";

            try {
                return self::ejecutarSql($sql);
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public static function modificar($ingrediente)
        {
            $sql = "CALL PA_U_Ingrediente(
    				'{$ingrediente->getId()}',
    				'{$ingrediente->getDescripcion()}',
    				{$ingrediente->getCosto_adicional()},
    				'{$ingrediente->getTipo_ingrediente()->getId()}',
    				{$ingrediente->getActivo()},
    				%usuario_id%,
    				'%fecha%',
    				@msg_error)	";
            try {
                return self::ejecutarSql($sql);
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public static function eliminar($id)
        {

        }

        
    }

 ?>
