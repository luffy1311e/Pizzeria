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
                    <strong>Error!</strong> No se pudo editar el ingrediente <strong>{$resultado}</strong>
                  </div>";
        }

        echo "<p class=\"text-right\">
                    <a href=\"mantenimiento?view=modificar_pizza\" class=\"btn btn-primary\">
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


             </form>';

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
