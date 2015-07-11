<?php 
	require_once '../../Core/core.php';

	usuarioBLL::logout();

	header('Location: ../acceso.php');
 ?>