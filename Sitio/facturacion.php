<?php 
	require_once '../Core/core.php';

	//validamos que exista un usuario
	if (!usuarioBLL::isLogin()) {
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

	 	<!-- CSS propios -->
 		<link rel="stylesheet" href="css/style.css">
	 	<title>Facturacion</title>
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
	 	 				<li><div class="well well-sm">Facturacion</div></li>
	 	 				<li><a href="facturacion.php?view=listar_facturas"><span class="glyphicon glyphicon-th-list"></span> Listar Facturas</a></li>
	 	 				<li><a href="facturacion.php?view=nueva_factura"><span class="glyphicon glyphicon-plus-sign"></span> Nueva Factura</a></li>
	 	 				<li><a href="facturacion.php?view=anular_factura"><span class="glyphicon glyphicon-remove"></span> Anular Factura</a></li>
	 	 			</ul>
	 	 		</div>
	 	 		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	 	 			<?php 
	 	 				if (isset($_GET['view'])) {
	 	 					switch ($_GET['view']) {
	 	 						case 'listar_facturas':
	 	 							# code...
	 	 							break;
	 	 						case 'nueva_factura':
	 	 							# code...
	 	 							break;
	 	 						case 'anular_factura':
	 	 							# code...
	 	 							break;
	 	 					}
	 	 				}
	 	 				else{
	 	 					echo '<h1 class="page-header">Facturacion</h1>';
	 	 				}
	 	 			 ?>
	 	 		</div>
	 	 	</div>
	 	 </div>
	 	 <!-- Bootstrap core JavaScript
		================================================== -->
		<script src="js/jquery-ui.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery-ui.min.js"></script>
	 </body>
 </html>