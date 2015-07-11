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
		<link rel="stylesheet" href="cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css">

	 	<!-- CSS propios -->
 		<link rel="stylesheet" href="css/style.css">
	 	<title>Usuarios</title>
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
	 	 				<li><div class="well well-sm">Usuario</div></li>
	 	 				<li><a href="usuario.php?view=listar_usuarios"><span class="glyphicon glyphicon-th-list"></span> Listar Usuarios</a></li>
	 	 				<li><a href="usuario.php?view=nuevo_usuario"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo Usuario</a></li>
	 	 				<li><a href="usuario.php?view=modificar_usuario"><span class="glyphicon glyphicon-edit"></span> Editar Usuario</a></li>
	 	 				<li><a href="usuario.php?view=eliminar_usuario"><span class="glyphicon glyphicon-remove-sign"></span> Eliminar Usuario</a></li>
	 	 			</ul>
	 	 		</div>
	 	 		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	 	 			<?php
	 	 				if (isset($_GET['view'])) {
	 	 					switch ($_GET['view']) {
	 	 						case 'listar_usuarios':
	 	 							include('Usuario/listar.php');
	 	 							break;
	 	 						case 'nuevo_usuario':
	 	 							include('Usuario/nuevoUsuario.php');
	 	 							break;
	 	 						case 'modificar_usuario':
	 	 							include('Usuario/editarUsuario.php');
	 	 							break;
	 	 						case 'eliminar_usuario':
	 	 							include('Usuario/eliminarUsuario.php');
	 	 							break;
	 	 						case 'cambiar_password':
	 	 							include('Usuario/cambiar_password.php');
	 	 							break;
	 	 					}
	 	 				}
	 	 				else{
	 	 					echo '<h1 class="page-header">Usuarios</h1>';
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
		<script src="cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
		<script src="js/functions.js"></script>
	 </body>
 </html>
