<h2 class="page-header">Lista de Pizzas</h2>

<div class="listar-usuarios">
    <?php
        $listar_pizzas = pizzaBLL::obtenerPorCriterio("descripcion", "", -1, 0, 10);

        if ($listar_pizzas == false)
        {
            echo "<div class=\"alert alert-danger\" role=\"alert\">
                        <strong>Error!</strong>  Intente mas tarde o contacte con el administrador del sistema.
                  </div>";
        }else {
            echo "<div class=\"table-responsive\">";
            echo pizzaBLL::convertirtableHTML($listar_pizzas, false);
            echo "</div>";
        }
     ?>
</div>
