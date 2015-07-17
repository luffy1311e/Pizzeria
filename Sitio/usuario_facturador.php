<?php
    require_once '../Core/core.php';

    if (!usuarioBLL::isLogin()) {
        header("Location: acceso.php");
    }
 ?>

 <!DOCTYPE html>
 <html>
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
         <title>Usuario</title>
     </head>
     <body>
         <?php
            if (usuarioBLL::isAdmin()) {
                header('Location: usuario.php');
            }
            else{
                include 'Menus/menu_facturador.php';
            }
          ?>

          <div class="container_fluid">
              <div class="row">
                  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                      <?php
                            include_once 'Usuario/cambiar_password.php';
                       ?>
                  </div>
              </div>
          </div>

          <!-- Bootstrap core JavaScript
       ================================================== -->
       <script src="js/jquery-ui.js"></script>
       <script src="js/bootstrap.min.js"></script>
       <script src="js/jquery-ui.min.js"></script>
       <script src="js/functions.js"></script>

     </body>
 </html>
