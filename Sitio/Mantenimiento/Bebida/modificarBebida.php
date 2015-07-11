<h2 class="sub-header">Editar Bebida</h2>

<?php
    if (isset($_GET['submit'])) {
        $id = $_GET['id'];
        $descripcion = ucwords(strtolower(trim($_GET['descripcion'])));
      	$mililitros = $_GET ['mililitros'];
      	$precio = $_GET ['precio'];
      	$tipo_bebida = $_GET ['rdbBebida'];

        if (isset($_GET['cantidad'])) {
            $cantidad = $_GET['cantidad'];
        }
        else{
          $cantidad = 0;
        }

        if (isset($_GET['activo'])) {
            $activo = 1;
        }
        else{
          $activo = 0;
        }

        $bebida = FactoryBebida::getBebida($id, $descripcion, $mililitros, $precio, $cantidad, $tipo_bebida, $activo);

        try {
            $resultado = bebidaBLL::modificar($bebida);
        } catch (Exception $ex) {
            $resultado = $ex->getMessage();
        }

        if ($resultado) {
          echo "<div class=\"alert alert-success\" role=\"alert\">
                  <strong>Exito!</strong> Bebida <strong>{$descripcion}</strong> editado correctamente
               </div>";
        }
        else{
          echo "<div class=\"alert alert-danger\" role=\"alert\">
                  <strong>Error!</strong> no se pudo editar la bebida. <strong>{$resultado}</strong>
               </div>";
        }

        echo "<p class=\"text-right\">
                <a href=\"mantenimiento.php?view=modificarBebida\" class=\"btn btn-primary\">
                    <span class=\"glyphicon glyphicon-edit\"></span> Editar Otra Bebida
                </a>
             </p>";

        return;
    }

    if (isset($_GET['modificar'])) {
        $id = -1;
       if (isset($_GET['id'])) {
          $id = $_GET['id'];

          if (!usuarioBLL::isAdmin() and usuarioBLL::getUser()->getId() != $id) {
        			echo '<div class="alert alert-danger" role="alert">
        				<strong>Error!</strong> No tiene permisos para realizar esta acción.
        				</div>';

        			return;
        	}


      }
    }
 ?>
