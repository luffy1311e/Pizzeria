<h2 class="page-header">Editar Ingrediente</h2>

<?php
    if (isset($_GET['submit']))
    {
        $id = $_GET['id'];
    	$descripcion = ucwords(strtolower(trim($_GET['descripcion'])));
    	$tipo_ingrediente = $_GET['tipo_ingrediente'];
    	$costo_adicional = trim($_GET['costo_adicional']);

        if (isset($_GET['activo']))
        {
            $activo = 1;
        }
        else{
            $activo = 0;
        }

        $obj_tipo_ingrediente = FactoryTipoIngrediente::getTipoIngrediente($tipo_ingrediente);
    	$ingrediente = new Ingrediente($id, $descripcion, $costo_adicional, $obj_tipo_ingrediente, $activo);

        try{
            $resultado = ingredienteBLL::modificar($ingrediente);
        }
        catch(Exception $ex){
            $resultado = $ex->getMessage();
        }

        if ($resultado)
        {
    		echo "<div class=\"alert alert-success\" role=\"alert\">
    		          <strong>Éxito!</strong> Ingrediente <strong>{$descripcion}</strong> editado correctamente.
    		      </div>";
    	} else {
    		echo "<div class=\"alert alert-danger\" role=\"alert\">
    		          <strong>Error!</strong> No se pudo editar el ingrediente.<strong>{$resultado}</strong>
    		     </div>";
    	}

        echo "<p class=\"text-right\">
    	<a href=\"mantenimiento.php?view=modificar_ingrediente\"
    			  	class=\"btn btn-primary\">
    					<span class=\"glyphicon glyphicon-edit\"></span>
    			  		Editar Otro Ingrediente
    			  	</a>
    			  </p>";

    	return;
    }
 ?>
