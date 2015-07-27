<h1 class="page-header">Lista de Pizzas</h1>

<div class="listar-usuarios">
    <?php
        $listar_pizzas = pizzaBLL::obtenerPorCriterio("descripcion", "", -1, 0, 10);

        if ($listar_pizzas == false)
        {
            echo "<div class=\"alert alert-warning\" role=\"alert\">
                        <strong>Error!</strong> No hay registros que mostrar.
                  </div>";
        }else {
            echo "<div class=\"table-responsive\">";
            echo pizzaBLL::convertirtableHTML($listar_pizzas, false);
            echo "</div>";
        }
     ?>
</div>
