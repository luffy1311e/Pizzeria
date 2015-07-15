<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="index.php" class="navbar-brand">Pizzeria Santa Cecilia</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<li class="active"><a href="index.php">Inicio</a></li>
				<li><a href="facturacion.php">Facturacion</a></li>
				<li><a href="usuario_facturador.php?view=modificar_usuario">Mi Cuenta</a></li>
				<li><p class="navbar-text">Bienvenidos <?php usuarioBLL::getUser()->getFullName(); ?>,
						<a href="Menus/logout.php" class="navbar-link">Cerrar Sesion</a>
					</p>
				</li>
			</ul>
		</div>
	</div>
</div>
