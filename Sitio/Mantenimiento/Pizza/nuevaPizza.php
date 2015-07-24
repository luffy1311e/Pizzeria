<h1 class="page-header">Nueva Pizza</h1>

<?php

    $msg_error = "";
    $descripcion = "";
    $carnes = null;
    $vegetales = null;
    $queso = 0;
    $activo = 1;

    if (isset($_GET['submit']))
    {
        $descripcion = ucwords(strtolower(trim($_GET['descripcion'])));

        if ($_GET['carnes'])
        {
            $carnes = $_GET['carnes'];
        }

        if ($_GET['vegetales'])
        {
            $vegetales = $_GET['vegetales'];
        }

        if ($_GET['queso'])
        {
            $queso = $_GET['queso'];
        }

        if (isset($_GET['activo']))
        {
            $activo = 1;
        }else {
            $activo = 0;
        }

        $lista_ingredientes = array();

        foreach ($carnes as $carne)
        {
            array_push($lista_ingredientes,$carne);
        }

        foreach ($vegetales as $vegetal)
        {
            array_push($lista_ingredientes,$vegetal);
        }

        $pizza = new Pizza(0, $descripcion, $activo, null, $lista_ingredientes, $queso);

        try {
            $resultado = pizzaBLL::agregar($pizza);
        } catch (Exception $ex) {
            $resultado = $ex->getMessage();
        }

        if ($resultado === true)
        {
            echo "<div class=\"alert alert-success\" role=\"alert\">
                    <strong>Exito!</strong> Pizza <strong>{$descripcion}</strong> agregado correctamente.
                 </div>";
        }else {
            echo "<div class=\"alert alert-danger\" role=\"alert\">
                    <strong>Error!</strong> No se puedo agregar la pizza.
                 </div>";
        }

        echo "<p class=\"text-right\">
				<a href=\"mantenimiento.php?view=nueva_pizza\"
			  	class=\"btn btn-primary\">
					<span class=\"glyphicon glyphicon-plus-sign\"></span>
			  		Agregar Nueva Pizza
			  	</a>
			  </p>";

        return;
    }else {
        try {
            $option_vegetal = "";
            $option_carne = "";
            $lista_ingredientes = ingredienteBLL::obtenerTodos(1);

            foreach ($lista_ingredientes as $ingrediente)
            {
                if (get_class($ingrediente->getTipo_ingrediente()) == "Vegetal")
                {
                    $option_vegetal .= "<option value=\"{$ingrediente->getId()}\">{$ingrediente->getDescripcion()}</option>";
                }
                if (get_class($ingrediente->getTipo_ingrediente()) == "Carne")
                {
                    $option_carne .= "<option value=\"{$ingrediente->getId()}\">{$ingrediente->getDescripcion()}</option>";
                }
            }
        } catch (Exception $ex) {

        }
    }
 ?>

 <form class="form-horizontal" role="form" method="get">
     <input type="hidden" name="view" id="view" value="nueva_pizza">
     <div class="form-group">
         <label for="descripcion" class="col-sm-3 control-label">Nombre</label>
         <div class="col-sm-9">
             <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Nombre" required autofocus="autofocus"
             value="<?php echo $descripcion; ?>">
         </div>
     </div>
     <div class="form-group">
        <label for="ingrediente" class="col-sm-3 control-label">Ingrediente</label>
        <div class="col-sm-3">
            <select class="form-control" multiple name="vegetales[]" id="vegetales" required>
                <?php echo $option_vegetal; ?>
            </select>
        </div>
        <div class="col-sm-3">
            <select class="form-control" multiple name="carnes[]" id="carnes" required>
                <?php echo $option_carne; ?>
            </select>
        </div>
        <div class="col-sm-3">
            <label for="queso" class="control-label">Queso</label>
            <input type="number" class="form-control" name="queso" id="queso" placeholder="Ej. 100 gramos" required>
        </div>
     </div>

     <div class="form-group">
         <div class="col-sm-offset-3 col-sm-9">
             <div class="checkbox">
                 <label><input type="checkbox" name="activo" id="activo"
                     <?php
                     if ($activo == 1)
                     {
                         echo ' checked="checked"';
                     }
                     ?>> Activo</label>
             </div>
         </div>
     </div>

     <div class="form-group">
         <div class="col-sm-offset-3 col-sm-9">
             <button type="submit" name="submit" id="submit" class="btn btn-primary">
                 <span class="glyphicon glyphicon-floppy-saved"></span> Guardar
             </button>
             <a href="mantenimiento.php" class="btn btn-primary"><span class="glyphicon glyphicon-remove"></span> Cancelar</a>
         </div>
     </div>
 </form>

 <?php
    if (!empty($msg_error))
    {
        echo '<div class="alert alert-danger col-sm-offset-3 col-sm-9" role="alert">
                    <strong>Error!</strong> ' . $msg_error . '
              </div>';
    }
  ?>
