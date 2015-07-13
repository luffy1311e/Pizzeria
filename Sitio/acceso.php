<?php
	require_once '../Core/core.php';

	// El usuario ya esta logueado
	if (usuarioBLL::isLogin()) {
		header('Location: index.php');
	}

	if (isset($_POST['submit']))
	{

		// Obtenemos los valores
		$user = $_POST['user'];
		$pass = $_POST['password'];

		try {
			// Verificamos que el usuario exista
			$error = usuarioBLL::login($user, $pass);

			if (usuarioBLL::isLogin()) {
				header('Location: index.php');
			}
		} catch (Exception $ex) {
			$error = $ex->getMessage();
		}
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
		<title>Acceso</title>
	</head>
	<body id="Body">
		<div class="container">
			<form class="form-signin" role="form" method="post">
				<h2 class="form-signin-heading">Log in</h2>
				<input type="text" name="user" id="user" class="form-control" placeholder="usuario"
					<?php if (isset($user)) {
						echo 'value="' . $user . '"';
					} ?>
				required autofocus>
				<input type="password" name="password" id="password" class="form-control" placeholder="password" required>
				<div class="checkbox">
					<label>
						<input type="checkbox" value="recordarme"> Recordarme
					</label>
				</div>
				<button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" id="submit">Entrar</button>
			</form>
			<div id="msg-error">
				<?php
					if (isset($error)) {
						echo '<div class="alert alert-danger" role="alert">
							  	<strong>Error!</strong> '. $error .'
							  </div>';
					}
				?>
			</div>
		</div><!-- /container -->
	</body>
</html>
