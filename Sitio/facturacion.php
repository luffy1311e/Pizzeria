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

		<!-- DataTables CSS -->
		<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">

		<!-- jQuery -->
		<script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.10.2.min.js"></script>

		<!-- DataTables -->
		<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.js"></script>

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
	 	 							include_once 'Facturacion/listarFacturas.php';
	 	 							break;
	 	 						case 'nueva_factura':
	 	 							include_once 'Facturacion/nuevaFactura.php';
	 	 							break;
	 	 						case 'anular_factura':
	 	 							include_once 'Facturacion/anularFacturas.php';
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
		 <!-- <script src="//code.jquery.com/jquery-1.11.3.min.js"></script> -->
		 <script src="js/jquery-ui.js"></script>
		 <script src="js/bootstrap.min.js"></script>
		 <script src="js/jquery-ui.min.js"></script>
		 <script src="js/functions.js"></script>
		 <script src="js/facturar.js"></script>
	 </body>
 </html>
