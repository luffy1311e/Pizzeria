<h2 class="page-header">Editar Pizza</h2>

<?php
    if (isset($_GET['submit']))
    {
        $id = $_GET['id'];
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

        $pizza = new Pizza($id, $descripcion, $activo, null, $lista_ingredientes, $queso);

        try {
            $resultado = pizzaBLL::modificar($pizza);
        } catch (Exception $ex) {
            $resultado = $ex->getMessage();
        }
        if ($resultado)
        {
            echo "<div class=\"alert alert-success\" role=\"alert\">
                    <strong>Exito!</strong> Pizza <strong>{$descripcion}</strong> editado correctamente.
                 </div>";
        }else {
            echo "<div class=\"alert alert-danger\" role=\"alert\">
                    <strong>Error!</strong> No se pudo editar la Pizza <strong>{$resultado}</strong>
                  </div>";
        }

        echo "<p class=\"text-right\">
                    <a href=\"mantenimiento.php?view=modificar_pizza\" class=\"btn btn-primary\">
                        <span class=\"glyphicon glyphicon-edit\"></span> Editar Otra Pizza.
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
                    <strong>Error!</strong> No tiene permiso para realizar esta acción.
                  </div>';
            return;
        }

        try {
            $pizza = pizzaBLL::obtenerPorId($id);
            $lista_ingredientes = ingredienteBLL::obtenerTodos(1);
            $option_vegetal = "";
            $option_carne = "";

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
        } catch(Exception $ex) {
            echo "<div class=\"alert alert-warning\" role=\"alert\">
                    <strong>Alto!</strong> {$ex->getMessage()}
                  </div>";
            return;
        }

        echo '<form class="form-horizontal" role="form" method="get">
                <input type="hidden" name="view" id="view" value="modificar_pizza">
                <input type="hidden" name="id" id="id" value="' . $pizza->getId() .'">

                <div class="form-group">
                    <label for="descripcion" class="col-sm-3 control-label">Nombre</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Nombre" required
                        autofocus="autofocus" value="' . $pizza->getDescripcion() . '">
                    </div>
                </div>
                <div class="form-group">
                   <label for="ingrediente" class="col-sm-3 control-label">Ingrediente</label>
                   <div class="col-sm-3">
                       <select class="form-control" multiple name="vegetales[]" id="vegetales" required>
                          ' . $option_vegetal . '
                       </select>
                   </div>
                   <div class="col-sm-3">
                       <select class="form-control" multiple name="carnes[]" id="carnes" required>
                          ' . $option_carne . '
                       </select>
                   </div>
                   <div class="col-sm-3">
                       <label for="queso" class="control-label">Queso</label>
                       <input type="number" class="form-control" name="queso" id="queso" placeholder="Ej. 100 gramos" required
                        value="' . $pizza->getQueso() .'" >
                   </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="activo" id="activo"';
                                    if ($pizza->getActivo() == 1)
                                    {
                                        echo ' checked="checked"';
                                    }
                                    echo '> Activo
                            </label>
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
             </form>';

             return;
    }
 ?>

 <div class="listar">
     <?php
         $listar_pizzas = pizzaBLL::obtenerPorCriterio("descripcion", "", -1, 0, 10);

         if ($listar_pizzas == false)
         {
             echo "<div class=\"alert alert-warning\" role=\"alert\">
                         <strong>Error!</strong> No hay registros que mostrar.
                   </div>";
         }else {
             echo "<div class=\"table-responsive\">";
             echo pizzaBLL::convertirtableHTML($listar_pizzas, true, false);
             echo "</div>";
         }
      ?>
 </div>
