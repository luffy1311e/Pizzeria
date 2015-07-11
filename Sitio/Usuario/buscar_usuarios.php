<?php 
	if (isset($_REQUEST['criterio'])) {
		$criterio = $_REQUEST['criterio'];
	}
	else{
		$criterio = "";	
	}

	if (isset($_REQUEST['valor'])) {
		$valor = $_REQUEST['valor'];
	}
	else{
		$valor = "";
	}

	if (isset($_REQUEST['posicion'])) {
		$posicion = $_REQUEST['posicion'];
	}
	else{
		$posicion = 0;
	}

	if (isset($_REQUEST['activo'])){
		$activo = $_REQUEST['activo'];
	}
	else{
		$activo = -1;
	}
	
	$cantidad = 10;

	require_once $_SERVER['DOCUMENT_ROOT'] . '/Proyecto/Core/core.php';

	$lista_usuarios = usuarioBLL::obtenerPorCriterio($criterio, $valor, $posicion, $activo, $cantidad);

	if ($lista_usuarios == false) {
		echo "<div class=\"alert alert-warming\" role=\"alert\">
			  	<strong>Lo sentimos!</strong> No hay registros con esos criterios
			 </div>";
	}
	else{
		echo "<div class=\"table-responsive\">";
		echo usuarioBLL::convertirTableHTML($lista_usuarios, false, false);
		echo "</div>";
	}
 ?>