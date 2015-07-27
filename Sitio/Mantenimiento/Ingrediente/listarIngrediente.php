<h2 class="page-header">Lista de Ingredientes</h2>

<div class="listar">
    <?php
        $listar_ingredientes = ingredienteBLL::obtenerPorCriterio("descripcion", "", -1, 0, 10);

        if ($listar_ingredientes == false)
        {
            echo "<div class=\"alert alert-warning\" role=\"alert\">
                      <strong>Error!</strong> No hay registros que mostrar.
                  </div>";
        }
        else{
            echo "<div class=\"table-responsive\">";
            echo ingredienteBLL::convertirTableHTML($listar_ingredientes, false, false);
            echo "</div>";
        }
     ?>
</div>
