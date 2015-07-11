<h1 class="page-header">Nuevo Usuario</h1>

<?php 
	$msg_error = "";
	$username = "";
	$correo = "";
	$nombre = "";
	$apellido1 = "";
	$apellido2 = "";
	$rol = 1;
	$activo = 1;

	if (isset($_GET['submit'])) {
		$username = trim($_GET['username']);
		$correo = trim($_GET['correo']);
		$nombre = trim($_GET['nombre']);
		$apellido1 = trim($_GET['apellido1']);
		$apellido2 = trim($_GET['apellido2']);
		$rol = trim($_GET['rol']);

		if (isset($_GET['activo'])) {
			$activo = 1;
		}
		else{
			$activo = 0;
		}

		$password1 = $_GET['password1'];
		$password2 = $_GET['password2'];

		if (strlen($password1) < 6) {
			$msg_error = "El password debe ser de 6 caracteres mínimo.";
		}
		elseif ($password1 != $password2) {
			$msg_error = "Las contraseñas no coinciden.";
		}

		if (empty($msg_error)) {
			$usuario = array();
			$usuario['username'] = $username;
			$usuario['password'] = $passwrod1;
			$usuario['correo'] = strtolower($correo);
			$usuario['nombre'] = ucwords(strtolower($nombre));
			$usuario['apellido1'] = ucwords(strtolower($apellido1));
			$usuario['apellido2'] = ucwords(strtolower($apellido2));
			$usuario['rol'] = $rol;
			$usuario['activo'] = $activo;

			$resultado = usuarioBLL::Agregar($usuario);

			if ($resultado === True) {
				echo '<div class="alert alert-success" role="alert">
						<strong>Exito!</strong> Usuario <strong>{$username}</strong> agregado correctamente.
					 </div>';
			}
			else{
				echo '<div class="alert alert-danger" role="alert">
						<strong>Error!</strong> No se pudo crear al usuario,
						<strong>{$resultado}</strong>
					 </div>';
			}
			echo '<p class="text-right">
					<a href="usuario.php?view=nuevo_usuario" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign"></span>
					 Agregar Nuevo Usuario</a></p>';
		}
	}

 ?>
 <form class="form-horizontal" role="form" method="get">
 	<input type="hidden" name="view" id="view" value="nuevo_usuario">
 	<div class="form-group">
 		<label for="username" class="col-sm-3 control-label">Username</label>
 		<div class="col-sm-9">
 			<input type="text" class="form-control" name="username" id="username" placeholder="Username" required autofocus="autofocus" 
 			pattern="[a-zA-Z0-9]*" value="<?php echo $username; ?>">
 		</div>
 	</div>
 	<div class="form-group">
 		<label for="passwrod1" class="col-sm-3 control-label">Password</label>
 		<div class="col-sm-9">
 			<input type="password" class="form-control" name="password1" id="password1" placeholder="Password" maxlength="15" required>
 		</div>
 	</div>
 	<div class="form-group">
 		<label for="passwrod2" class="col-sm-3 control-label">Confirmar Password</label>
 		<div class="col-sm-9">
 			<input type="password" class="form-control" name="password2" id="password2" placeholder="Confirmar Password" maxlength="15" required>
 		</div>
 	</div>
 	<div class="form-group">
 		<label for="correo" class="col-sm-3 control-label">Correo</label>
 		<div class="col-sm-9">
 			<input type="email" class="form-control" name="correo" id="correo" placeholder="Correo" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}"
 			required value="<?php echo $correo; ?>">
 		</div>
 	</div>
 	<div class="form-group">
 		<label for="nombre" class="col-sm-3 control-label">Nombre</label>
 		<div class="col-sm-9">
 			<input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" required pattern="[a-zA-z]*"
 			value="<?php echo $nombre; ?>">
 		</div>
 	</div>
 	<div class="form-group">
 		<label for="apellido1" class="col-sm-3 control-label">Apellido No.1</label>
 		<div class="col-sm-9">
 			<input type="text" class="form-control" name="apellido1" id="apellido1" placeholder="Apellido No.1" required pattern="[a-zA-z]*"
 			value="<?php echo $apellido1; ?>">
 		</div>
 	</div>
 	<div class="form-group">
 		<label for="apellido2" class="col-sm-3 control-label">Apellido No.2</label>
 		<div class="col-sm-9">
 			<input type="text" class="form-control" name="apellido2" id="apellido2" placeholder="Apellido No.2" required pattern="[a-zA-z]*"
 			value="<?php echo $apellido2; ?>">
 		</div>
 	</div>
 	<div class="form-group">
 		<label for="rol" class="col-sm-3 control-label">Tipo de Usuario</label>
 		<div class="col-sm-9">
 			<label class="radio-inline">
 				<input type="radio" name="rol" id="rol" value="1" 
 				<?php 
 					if ($rol == 1) {
 						echo ' checked="checked"';
 					} 
 				?>> Administrador
 			</label>
 			<label class="radio-inline">
 				<input type="radio" name="rol" id="rol" value="2"
 				<?php 
 					if ($rol == 2) {
 						echo ' checked="checked"';
 					}
 				 ?>> Facturador
 			</label>
 		</div>
 	</div>
 	<div class="form-group">
 		<div class="col-sm-offset-3 col-md-9">
 			<div class="checkbox">
 				<label>
 					<input type="checkbox" name="activo" id="activo"
					<?php 
						if ($activo == 1) {
							echo ' checked="checked"';
						}
					?>> Activo
 				</label>
 			</div>
 		</div>
 	</div>
	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9">
			<button type="submit" name="submit" id="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> Guardar</button>
			<a href="usuario.php" class="btn btn-primary"><span class="glyphicon glyphicon-remove"></span> Cancelar</a>
		</div>
	</div>
 </form>
 <?php 
 	if (!empty($msg_error)) {
 		echo '<div class="alert alert-danger col-sm-9 col-sm-offset-3" role="alert">
 			 	<strong>Error!</<strong> ' . $msg_error . '
 			 </div>';
 	}
  ?>




















