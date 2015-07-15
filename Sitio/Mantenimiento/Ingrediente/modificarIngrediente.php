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

    if (isset($_GET['modificar']))
    {
        $id = -1;
    	if (isset($_GET['id']))
        {
            $id = $_GET['id'];
        }

    	if (!usuarioBLL::isAdmin() and usuarioBLL::getUser()->getId() != $id)
        {
            echo '<div class="alert alert-danger" role="alert">
                    <strong>Error!</strong> No tiene permisos para realizar esta acción
                 </div>';

            return;
        }

        try {
            $ingrediente = ingredienteBLL::obtenerPorId($id);
        } catch (Exception $ex) {
            echo "<div class=\"alert alert-warning\" role=\"alert\">
                    <strong>Alto!</strong> {$ex->getMessage()}
                  </div>";
            return;
        }

        echo '
    	<form class="form-horizontal" role="form" method="get">
    		<input type="hidden" name="view" id="view" value="modificar_ingrediente">
    		<input type="hidden" name="id" id="id" value="'. $ingrediente->getId() .'">

    		<div class="form-group">
    			<label for="descripcion" class="col-sm-3 control-label">Nombre</label>
    			<div class="col-sm-9">
    				<input type="text" class="form-control" name="descripcion" id="descripcion"
    					placeholder="Nombre" required autofocus="autofocus" maxlength="25"
    					value="'.  $ingrediente->getDescripcion() .'">
    			</div>
    		</div>

    		<div class="form-group">
    			<label for="tipo_ingrediente" class="col-sm-3 control-label">Tipo Ingrediente</label>
    			<div class="col-sm-9">
    				<select class="form-control" name="tipo_ingrediente" id="tipo_ingrediente" required>
    					'. TipoIngredienteBLL::obtenerOptionsHTML($ingrediente->getTipo_ingrediente()->getId()) .'
    				</select>
    				<div class="alert alert-danger alert-dismissible" role="alert" style="display: none;">
    			  		<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    			  		<strong>Error!</strong> Debe seleccionar una opción.
    				</div>
    			</div>
    		</div>

    		<div class="form-group">
    			<label for="costo_adicional" class="col-sm-3 control-label">Costo Adicional</label>
    			<div class="col-sm-9">
    				<div class="input-group">
    					<span class="input-group-addon">₡</span>
    				 	<input type="number" class="form-control" name="costo_adicional" id="costo_adicional"
    					placeholder="0.00" maxlength="6" required
    					value="'. $ingrediente->getCosto_adicional() .'">
    				</div>
    			</div>
    		</div>

    		<div class="form-group">
    			<div class="col-sm-offset-3 col-sm-9">
    				<div class="checkbox">
    					<label> <input type="checkbox" name="activo" id="activo"';

    					if ($ingrediente->getActivo())
    						echo ' checked="checked"';

    						echo '> Activo
    					</label>
    				</div>
    			</div>
    		</div>

    		<div class="form-group">
    			<div class="col-sm-offset-3 col-sm-9">
    				<button type="submit" name="submit" id="submit"
    					class="btn btn-primary">
    					<span class="glyphicon glyphicon-floppy-saved"></span> Guardar
    				</button>
    				<a href="mantenimiento.php?view=modificar_ingrediente" class="btn btn-primary">
    					<span class="glyphicon glyphicon-remove"></span> Cancelar
    				</a>
    			</div>
    		</div>
    	</form>';

    	return;
    }
 ?>

 <div class="listar">
     <?php
        $listar_ingredientes = ingredienteBLL::obtenerPorCriterio("descripcion", "", -1, 0, 10);

        if ($listar_ingredientes == false)
        {
            echo "<div class=\"alert alert-danger\" role=\"alert\">
    			     <strong>Error!</strong> Intente más tarde o contacte con el administrador del sistema.
    			  </div>";
        }else {
            echo "<div class=\"table-responsive\">";
    		echo ingredienteBLL::convertirTableHTML($listar_ingredientes, true, false);
    		echo "</div>";
        }
      ?>
 </div>
