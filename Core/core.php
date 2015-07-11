<?php 
	
	function __autoload($class_name)
	{
		//root
		$root =$_SERVER['DOCUMENT_ROOT'] . '/Proyecto/';

		$directorys = array(
        	'Entidades/',
        	'Entidades/Bebida/',
        	'Entidades/Ingrediente/',
        	'Entidades/Pizza/',
        	'Entidades/Usuario/',
        	'BLL/',
            'DAL/',
        	'DAO/',
        	'Core/'
        );

        foreach ($directorys as $directory) {
        	if (file_exists($root . $directory.$class_name . '.php')) {
        		require_once($root . $directory.$class_name . '.php');
        		return;
        	}
        }
	}
 ?>