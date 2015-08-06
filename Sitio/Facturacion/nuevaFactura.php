<h2 class="page-header">Nueva Factura</h2>
<div class="row">
    <div class="col-sm-6">
        <div class="row">
            <div id="factura" class="col-sm-12">
                <div id="encabezado">
                    <h3 class="page-header">Pizzeria Santa Cecilia</h3>
                    <div class="input-group">
                        <span class="input-group-addon">Cliente</span>
                        <input type="text" class="form-control" placeholder="Cliente">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">Fecha</span>
                        <input type="text" class="form-control" placeholder="Fecha" disabled="disabled" value="<?php echo date('Y-m-d H:i:s'); ?>">
                    </div>
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default active rdbTipoPago">
                            <input type="radio" name="rdbTipoPago" id="rdbContado" checked> Contado
                        </label>
                        <label class="btn btn-default rdbTipoPago">
                            <input type="radio" name="rdbTipoPago" id="rdbTarjeta"> Tarjeta
                        </label>
                    </div>
                    <div class="input-group hidden" id="txtNumeroTarjeta">
                        <span class="input-group-addon">No. Tarjeta</span>
                        <input type="text" class="form-control" placeholder="No. Tarjeta">
                    </div>
                    <hr>
                </div>
                <div class="clearfix">
                </div>
                <div id="detalle-pizza">
                    <ul>
                        <li>
                            <p class="text-center">Arrastre las pizzas, productos o bebidas aqui.</p>
                        </li>
                    </ul>
                </div>
                <div id="papelera">
                    <button id="papelera" type="button" class="btn btn-default btn-lg btn-block" disabled>
                        <span class="glyphicon glyphicon-trash"></span> Eliminar
                    </button>
                </div>
                <div id="totales">
                    <div class="input-group">
                        <span class="input-group-addon">Subtotal ₡</span>
                        <input type="text" id="txtSubtotal" class="form-control" placeholder="0" disabled="disabled">
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon">I.V. ₡</span>
                        <input type="text" id="txtIV" class="form-control" placeholder="0" disabled="disabled">
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon">Total a Pagar ₡</span>
                        <input type="text" id="txtTotal" class="form-control" placeholder="0" disabled="disabled">
                    </div>
                </div>

                <div>
                    <button type="button" id="btnFacturar" class="btn btn-success btn-lg btn-block">
                        Facturar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <ul class="nav nav-tabs" role="tablist" id="myTab">
            <li class="active">
                <a href="#tab_pizzas_listas" role="tab" data-toggle="tab">Pizzas Listas</a>
            </li>
            <li>
                <a href="#tab_nueva_pizza" role="tab" data-toggle="tab">Pizza Nueva</a>
            </li>
            <li>
                <a href="#tab_bebida" role="tab" data-toggle="tab">Bebidas</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="tab_pizzas_listas">
                <?php
                    $lista_pizzas = pizzaBLL::obtenerPorCriterio("descripcion", "", -1, 0, 10);
                    $pizzas = pizzaBLL::separarPizzaPorPasta($lista_pizzas);

                    foreach ($pizzas as $pizza)
                    {
                        echo "<div class=\"pizza-lista\">";
                        echo "<div class=\"hidden\">" . json_encode($pizza->parseArray()) . "</div>";
                        echo '<li class="alert alert-info alert dismissible" role="producto" id="' . $pizza->getId() . '"
                             object="' . get_class($pizza) . '" token="' . $pizza->getTotal() . '">
                                    <strong>'. $pizza->getDescripcion() . ' ' . $pizza->getPasta()->getDescripcion()
                                    . ' - Precio: ₡ ' . number_format($pizza->getTotal(), 2) . '</strong>
                             </li>';
                        echo "</div>";
                    }
                 ?>
            </div>

            <div class="tab-pane" id="tab_nueva_pizza">
                <div class="nueva-pizza">
                    <h4>Pastas</h4>
                    <?php
                        $pastaDelgada = FactoryPasta::getPasta(PastaDelgadaOPastaGruesa::PASTA_DELGADA);
                        $pastaGruesa = FactoryPasta::getPasta(PastaDelgadaOPastaGruesa::PASTA_GRUESA);

                        echo "<div>";
                            echo "<div class=\"hidden\">" . json_encode($pastaDelgada->parseArray()) . "</div>";
                            echo '<li class="alert alert-info alert-dismissible" role="producto" id="' . $pastaDelgada->getId()	.'"
    							object="'. get_class($pastaDelgada) .'" token="' . $pastaDelgada->getPrecio() .'">
    							<strong>'. $pastaDelgada->getDescripcion()
    							.' - Precio: ₡ ' . number_format($pastaDelgada->getPrecio()) .'</strong>
    							</li>';
                        echo "</div>";

                        echo "<div>";
                            echo "<div class=\"hidden\">" . json_encode($pastaGruesa->parseArray()) . "</div>";
                            echo '<li class="alert alert-info alert-dismissible" role="producto" id="' . $pastaGruesa->getId()	.'"
    							object="'. get_class($pastaGruesa) .'" token="' . $pastaGruesa->getPrecio() .'">
    							<strong>'. $pastaGruesa->getDescripcion()
    							.' - Precio: ₡ ' . number_format($pastaGruesa->getPrecio()) .'</strong>
    							</li>';
                        echo "</div>";
                     ?>
                     <!-- #queso -->
                     <br>
                     <h4 class="page-header">Queso</h4>
                     <div id="queso">
                         <div class="row">
                             <div class="col-sm-4">
                                 <div class="input-group">
                                     <span class="input-group-addon">Queso</span>
                                     <input type="text" class="form-control" placeholder="Cliente" disabled id="amount">
                                 </div>
                             </div>
                             <div class="col-sm-8">
                                 <br>
                                 <div id="slider"></div>
                             </div>
                         </div>
                     </div> <!-- #queso -->
                     <br>
                     <h4 class="page-header">Ingredientes</h4>
                     <?php
                        $ingredientes = ingredienteBLL::obtenerTodos(1);

                        foreach ($ingredientes as $ingrediente)
                        {
                            echo "<div>";
                                echo "<div class=\"hidden\">" . json_encode($ingrediente->parseArray()) . "</div>";
                                echo '<li class="alert alert-info alert-dismissible" role="producto" id="' . $ingrediente->getId()	.'"
        							object="'. get_class($ingrediente) .'" token="' . $ingrediente->getTotal() .'">
        							<strong>'. $ingrediente->getDescripcion()
        							.' - Precio: ₡ ' . number_format($ingrediente->getTotal(), 2) .'</strong>
        							</li>';
                            echo "</div>";
                        }
                      ?>
                </div>
            </div>

            <div class="tab-pane" id="tab_bebida">
                <div class="add-bebida">
                    <?php
                        try {
                            $lista_bebidas = bebidaBLL::obtenerTodos(1);
                            $bebidas = bebidaBLL::separarBebidasPorAguaOLeche($lista_bebidas);
                        } catch (Exception $ex) {
                            echo $ex->getMessage();
                        }

                        foreach ($bebidas as $bebida)
                        {
                            if ($bebida instanceof Natural)
                            {
                                $precio = $bebida->calcularPrecio();
                            }else {
                                $precio = $bebida->getPrecio();
                            }

                            echo "<div>";
                                echo "<div class=\"hidden\">" . json_encode($bebida->parseArray()) . "</div>";
                                echo '<li class="alert alert-info alert-dismissible" role="producto" id="' . $bebida->getId() .'"
        							object="'. get_class($bebida) .'" token="' . $precio .'">
        							<strong>'. $bebida->getDescripcion();

                                    if ($bebida instanceof Natural)
                                    {
                                        if ($bebida->getBase() == BaseLecheOAgua::AGUA)
                                        {
                                            echo ' en Agua';
                                        }else {
                                            echo " en Leche";
                                        }
                                    }

        							echo ' - Precio: ₡ ' . number_format($precio, 2) .'</strong>
        							</li>';
                            echo "</div>";
                        }
                     ?>
                </div>
            </div>
        </div>
    </div>
</div>
