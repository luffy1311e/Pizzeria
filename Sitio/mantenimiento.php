<?php
	require_once '../Core/core.php';

	//validamos que exista un usuario
	if (!usuarioBLL::isLogin() || !usuarioBLL::isAdmin()) {
		header("Location: acceso.php");
	}
 ?>

 <!DOCTYPE html>
 <html lang="en">
	 <head>
	 	<meta charset="UTF-8">
	 	<meta name="viewport" content="width=device-width, initial-scale=1">
	 	<meta name="description" content="">
	 	<meta name="author" content="">
	 	<link rel="icon" href="img/favicon/favicon.ico">

	 	<!-- Bootstrap core CSS -->
	 	<link rel="stylesheet" href="css/bootstrap.min.css">
	 	<link rel="stylesheet" href="css/jquery-ui.min.css">
	 	<link rel="stylesheet" href="css/jquery-ui.theme.min.css">

		<!-- DataTables CSS -->
		<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">

		<!-- jQuery -->
		<script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.10.2.min.js"></script>

		<!-- DataTables -->
		<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.js"></script>

	 	<!-- CSS propios -->
 		<link rel="stylesheet" href="css/style.css">
	 	<title>Mantenimientos</title>
	 </head>
	 <body>
	 	<?php
	 		if (usuarioBLL::isAdmin()) {
	 			include('Menus/menu_admin.php');
	 		}
	 		else{
	 			include('Menus/menu_facturador.php');
	 		}
	 	 ?>
	 	 <div class="container-fluid">
	 	 	<div class="row">
	 	 		<div class="col-sm-3 col-md-2 sidebar">
	 	 			<ul class="nav nav-sidebar">
	 	 				<li><div class="well well-sm">Pizzas</div></li>
	 	 				<li><a href="mantenimiento.php?view=listar_pizzas"><span class="glyphicon glyphicon-th-list"></span> Listar Pizzas</a></li>
	 	 				<li><a href="mantenimiento.php?view=nueva_pizza"><span class="glyphicon glyphicon-plus-sign"></span> Nueva Pizza</a></li>
	 	 				<li><a href="mantenimiento.php?view=modificar_pizza"><span class="glyphicon glyphicon-edit"></span> Editar Pizza</a></li>
	 	 			</ul>

					<ul class="nav nav-sidebar">
	 	 				<li><div class="well well-sm">Ingredientes</div></li>
	 	 				<li><a href="mantenimiento.php?view=listar_ingredientes"><span class="glyphicon glyphicon-th-list"></span> Listar Ingredientes</a></li>
	 	 				<li><a href="mantenimiento.php?view=nuevo_ingrediente"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo Ingrediente</a></li>
	 	 				<li><a href="mantenimiento.php?view=modificar_ingrediente"><span class="glyphicon glyphicon-edit"></span> Editar Ingrediente</a></li>
	 	 			</ul>

	 	 			<ul class="nav nav-sidebar">
	 	 				<li><div class="well well-sm">Bebidas</div></li>
	 	 				<li><a href="mantenimiento.php?view=listar_bebidas"><span class="glyphicon glyphicon-th-list"></span> Listar Bebidas</a></li>
	 	 				<li><a href="mantenimiento.php?view=nueva_bebida"><span class="glyphicon glyphicon-plus-sign"></span> Nueva Bebida</a></li>
	 	 				<li><a href="mantenimiento.php?view=modificar_bebida"><span class="glyphicon glyphicon-edit"></span> Editar Bebida</a></li>
	 	 			</ul>
	 	 		</div>
	 	 		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	 	 			<?php
	 	 				if (isset($_GET['view'])) {
	 	 					switch ($_GET['view']) {
	 	 						//Pizzas
	 	 						case 'listar_pizzas':
	 	 							include_once 'Mantenimiento/Pizza/listarPizza.php';
	 	 							break;
	 	 						case 'nueva_pizza':
	 	 							include_once 'Mantenimiento/Pizza/nuevaPizza.php';
	 	 							break;
	 	 						case 'modificar_pizza':
	 	 							include_once 'Mantenimiento/Pizza/modificarPizza.php';
	 	 							break;

	 	 						//Ingredientes
	 	 						case 'listar_ingredientes':
	 	 							include_once 'Mantenimiento/Ingrediente/listarIngrediente.php';
	 	 							break;
	 	 						case 'nuevo_ingrediente':
	 	 							include_once 'Mantenimiento/Ingrediente/nuevoIngrediente.php';
	 	 							break;
	 	 						case 'modificar_ingrediente':
	 	 							include_once 'Mantenimiento/Ingrediente/modificarIngrediente.php';
	 	 							break;

	 	 						//Bebidas
	 	 						case 'listar_bebidas':
	 	 							include_once 'Mantenimiento/Bebida/listarBebida.php';
	 	 							break;
	 	 						case 'nueva_bebida':
	 	 							include_once 'Mantenimiento/Bebida/nuevaBebida.php';
	 	 							break;
	 	 						case 'modificar_bebida':
	 	 							include_once 'Mantenimiento/Bebida/modificarBebida.php';
	 	 							break;
	 	 					}
	 	 				}
	 	 				else{
	 	 					echo '<h1 class="page-header">Mantenimientos</h1>';
	 	 				}
	 	 			 ?>
	 	 		</div>
	 	 	</div>
	 	 </div>
	 	 <!-- Bootstrap core JavaScript
		================================================== -->
		<!--<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>-->
		<script src="js/jquery-ui.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery-ui.min.js"></script>
		<script src="js/functions.js"></script>
	 </body>
 </html>
