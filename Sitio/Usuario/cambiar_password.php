<h2 class="sub-header">Editar Password</h2>

<?php 
	$msg_error = "";

	if (isset($_POST['submit'])) {
		$id = $_POST['id'];
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];

		if (strlen($password1) < 6) {
			$msg_error = "El password debe contener 6 caracteres como minimo.";
		}
		elseif ($password1 != $password2) {
			$msg_error = "Las contraseñas no coinciden.";
		}

		if (empty($msg_error)) {
			try {
				usuarioBLL::actualizarPassword($id, $password1);

				echo '<div class="alert alert-success" role="alert">
						<strong>Exito!</strong> Password actualizado.
					 </div>';

				return;
			} catch (Exception $ex) {
				$msg_error = $ex->getMessage();
			}
		}
	}

	if (!isset($_POST['submit']) or !empty($msg_error)) {
		if (!usuarioBLL::isAdmin()) {
			$id = usuarioBLL::getUser()->getId();
			$usuario = usuarioBLL::getUser();
			$username = $usuario->getUsername();
			$nombre = $usuario->getFullName();
			if (usuarioBLL::getUser()->getId() != $id) {
				echo '<div class="alert alert-danger" role="alert">
						<strong>Error!</strong> No tiene permisos para modificar este usuario.
					</div>';
			return;
			}
		}
		else{
			if (isset($_GET['id'])) {
				$id = $_GET['id'];
				$usuario = usuarioBLL::obtenerPorID($id);
				$username = $usuario->getUsername();
				$nombre = $usuario->getFullName();
			}
		}
	}
 ?>

 <form class="form-horizontal" role="form" method="post">
	<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">

	<div class="form-group">
		<label for="username" class="col-sm-3 control-label">Username</label>
		<div class="col-sm-9">
			<input type="text" class="form-control" name="username" id="username"
				placeholder="Username" value="<?php echo $username; ?>" disabled>
		</div>
	</div>
	
	<div class="form-group">
		<label for="nombre" class="col-sm-3 control-label">Nombre</label>
		<div class="col-sm-9">
			<input type="text" class="form-control" name="nombre" id="nombre"
				placeholder="Username" value="<?php echo $nombre; ?>" disabled>
		</div>
	</div>
		
	<div class="form-group">
		<label for="password1" class="col-sm-3 control-label">Nuevo Password</label>
		<div class="col-sm-9">
			<input type="password" class="form-control" name="password1" id="password1"
				placeholder="Password" maxlength="15" value="" required autofocus>
		</div>
	</div>
	
	<div class="form-group">
		<label for="password2" class="col-sm-3 control-label">Confirmar password</label>
		<div class="col-sm-9">
			<input type="password" class="form-control" name="password2" id="password2"
				placeholder="Confirmar Password" maxlength="15" value="" required>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9">
			<button type="submit" name="submit" id="submit" class="btn btn-primary">
				<span class="glyphicon glyphicon-ok"></span> Guardar Cambios
			</button>
			<a href="index.php" class="btn btn-primary">
				<span class="glyphicon glyphicon-remove"></span> Cancelar
			</a>
		</div>
	</div>
</form>

<?php 
	if (!empty($msg_error)) {
		echo '<div class="alert alert-danger col-sm-offset-3 col-sm-9" role="alert">
				<strong>Error!</strong> '. $msg_error .'
			</div>';
	}
 ?>