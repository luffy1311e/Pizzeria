<h2 class="sub-header">Eliminar Usuario</h2>

<?php 
	if (isset($_GET['submit'])) {
		$id = $_GET['id'];
		$username = trim($_GET['username']);
		$correo = strtolower(trim($_GET['correo']));
		$nombre = ucwords(strtolower(trim($_GET['nombre'])));
		$apellido1 = ucwords(strtolower(trim($_GET['apellido1'])));
		$apellido2 = ucwords(strtolower(trim($_GET['apellido2'])));
		$rol = $_GET['rol'];

		if (isset($_GET['activo'])) {
			$activo = 1;
		}
		else{
			$activo = 0;
		}

		if ($rol == 1) {
			$usuario = new Administrador($id, $username, $correo, $nombre, $apellido1, $apellido2, $activo);
		}
		else{
			$usuario = new Facturador($id, $username, $correo, $nombre, $apellido1, $apellido2, $activo);
		}

		try {
			$resultado = UsuarioBLL::eliminar($id);
		} catch (Exception $ex) {
			$resultado = $ex->getMessage();
		}

		if ($resultado > 0) {
			echo '<div class="alert alert-success" role="alert">
				 	<strong>Exito!</strong> Usuario <strong>{$username}</strong> editado correctamente
				 </div>';
		}
		else{
			echo '<div class="alert alert-danger" role="alert">
			     	<strong>Error!</strong> No se pudo editar al Usuario.
			     	<strong>{$resultado}</strong>
			     </div>';
		}
		echo '<p class="text-right">
			     <a href="usuario.php?view=eliminar_usuario" class="btn btn-primary">
			     <span class="glyphicon glyphicon-remove"></span>Eliminar Otro Usuario</a>
			  </p>';
		return;
	}

	if ($_GET['eliminar']) {
		$id = -1;
		if ($_GET['id']) {
			$id = $_GET['id'];
		}
		if (!UsuarioBLL::isAdmin() and UsuarioBLL::getUser()->getId() != $id) {
			echo '<div class="alert alert-danger" role="alert">
					<strong>Error!</strong> No tiene permisos para modificar este usuario.
				  </div>';
			return;
		}

		try {
			$usuario = UsuarioBLL::obtenerPorID($id);
		} catch (Exception $ex) {
			echo '<div class="alert alert-warning" role="alert">
					<strong>Alto!</strong> {$ex->getMessage()}
				 </div>';
		return;
		}

		echo '
		<form class="form-horizontal" role="form" method="get">
			<input type="hidden" name="view" id="view" value="eliminar_usuario">
			<input type="hidden" name="id" id="id" value="'. $usuario->getId() .'">
			<input type="hidden" name="username" id="username" value="'. $usuario->getUsername() .'">
			<div class="form-group">
				<label for="username" class="col-sm-2 control-label">Username</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="" id=""
						placeholder="Username" value="'. $usuario->getUsername() .'" disabled>
				</div>
			</div>
			<div class="form-group">
				<label for="correo" class="col-sm-2 control-label">Correo</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" name="correo" id="correo"
						placeholder="Correo" autofocus="autofocus"
						pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}"
						value="'. $usuario->getCorreo() .'" required>
				</div>
			</div>
			<div class="form-group">
				<label for="nombre" class="col-sm-2 control-label">Nombre</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="nombre" id="nombre"
						placeholder="Nombre" required pattern="[a-zA-Z]*"
						value="'. $usuario->getNombre() .'" >
				</div>
			</div>
			<div class="form-group">
				<label for="apellido1" class="col-sm-2 control-label">Apellido No.1</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="apellido1"
						id="apellido1" placeholder="Apellido No.1" pattern="[a-zA-Z]*"
						value="'. $usuario->getApellido1() .'" required>
				</div>
			</div>
			<div class="form-group">
				<label for="apellido2" class="col-sm-2 control-label">Apellido No.2</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="apellido2"
						id="apellido2" placeholder="Apellido No.2" required pattern="[a-zA-Z]*"
						value="'. $usuario->getApellido2() .'" required>
				</div>
			</div>
			<div class="form-group">
				<label for="rol" class="col-sm-2 control-label">Tipo de Usuario</label>
				<div class="col-sm-10">
					<label class="radio-inline">
						<input type="radio" name="rol" id="rol" value="1"';
						if ($usuario instanceof Administrador)
						 	echo ' checked="checked"';
						
						echo '> Administrador
					</label> 
					<label class="radio-inline"> 
						<input type="radio" name="rol" id="rol" value="2"';
						if ($usuario instanceof Facturador)
							echo ' checked="checked"';
							
						echo '> Facturador
					</label>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="checkbox">
						<label> <input type="checkbox" name="activo" id="activo"';
						
						if ($usuario->getActivo())
							echo ' checked="checked"';
							
							echo '> Activo
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<a href="usuario.php?view=cambiar_password&id='. $usuario->getId() .'" 
							class="btn btn-default">
						<span class="glyphicon glyphicon-pencil"></span> Cambiar Password
					</a>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" name="submit" id="submit"
						class="btn btn-primary">
						<span class="glyphicon glyphicon-trash"></span> Eliminar
					</button>
					<a href="usuario.php?view=eliminar_usuario" class="btn btn-primary">
						<span class="glyphicon glyphicon-remove"></span> Cancelar
					</a>
				</div>
			</div>
		</form>';
		
		return;
	}
 ?>

<div id="listar-usuarios">
	<?php 
		$listar_usuarios = UsuarioBLL::obtenerPorCriterio("nombre", "", -1, 0,10);
		if ($listar_usuarios == false) {
			echo "<div class=\"alert alert-danger\" role=\"alert\">
					<strong>Error!</strong> Intente más tarde o contacte con el administrador del sistema.
				 </div>";
		}
		else{
			echo "<div class=\"table-responsive\">";
			echo UsuarioBLL::convertirTableHTML($listar_usuarios, false, true);
			echo "</div>";
		}
	 ?>
</div>