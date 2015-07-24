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

        if (isset($_GET['activo']))
        {
            $activo = 1;
        }
        else{
            $activo = 0;
        }

        $bebida = FactoryBebida::getBebida($id, $descripcion, $mililitros, $precio, $cantidad, $activo, $tipo_bebida);

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
       }
       if (!usuarioBLL::isAdmin() and usuarioBLL::getUser()->getId() != $id) {
        	   echo '<div class="alert alert-danger" role="alert">
        				<strong>Error!</strong> No tiene permisos para realizar esta acción.
        			</div>';
               return;
      }

         try {
            $bebida = bebidaBLL::obtenerPorId($id);
         } catch (Exception $ex) {
            echo "<div class=\"alert alert-warning\" role=\"alert\">
                     <strong>Alto!</strong> {$ex->getMessage()}
                  </div>";
            return;
         }

         echo '
            	<form class="form-horizontal" role="form" method="get">
            		<input type="hidden" name="view" id="view" value="modificar_bebida">
            		<input type="hidden" name="id" id="id" value="'. $bebida->getId() .'">

            		<div class="form-group">
            			<label for="descripcion" class="col-sm-3 control-label">Descripción</label>
            			<div class="col-sm-9">
            				<input type="text" class="form-control" name="descripcion" id="descripcion"
            					placeholder="Descripción" required autofocus="autofocus" pattern="[a-zA-Z0-9 ]*"
            					value="'. $bebida->getDescripcion() .'">
            			</div>
            		</div>

            		<div class="form-group">
            			<label for="mililitros" class="col-sm-3 control-label">Presentación</label>
            			<div class="col-sm-9">
            				<div class="input-group">
            				 	<input type="number" class="form-control" name="mililitros" id="mililitros"
            					placeholder="0.00" maxlength="6" required
            					value="'. $bebida->getMililitros() .'">
            					<span class="input-group-addon">ML.</span>
            				</div>
            			</div>
            		</div>

            		<div class="form-group">
            			<label for="precio" class="col-sm-3 control-label">Precio</label>
            			<div class="col-sm-9">
            				<div class="input-group">
            					<span class="input-group-addon">₡</span>
            				 	<input type="number" class="form-control" name="precio" id="precio"
            					placeholder="0.00" maxlength="6" required
            					value="'. $bebida->getPrecio() .'">
            				</div>
            			</div>
            		</div>

            		<div class="form-group">
            			<label for="costo_adicional" class="col-sm-3 control-label">Tipo bebida</label>
            			<div class="col-sm-9">
            				<label class="radio-inline">
            					<input type="radio" name="rdbBebida" id="rdbBebidaNatutal"
            					value="NAT"';

            					if ($bebida instanceof Natural)
            						echo ' checked="checked"';

            					echo '> Natural
            				</label>
            				<label class="radio-inline">
            					<input type="radio"name="rdbBebida" id="rdbBebidaGaseosa"
            					value="GAS"';

            					if ($bebida instanceof Gaseosa)
            						echo ' checked="checked"';

            					echo '> Gaseosa
            				</label>
            			</div>
            		</div>

            		<div class="form-group">
            			<label for="cantidad" class="col-sm-3 control-label">Cantidad</label>
            			<div class="col-sm-9">
            				<div class="input-group">
            					<input type="number" class="form-control" name="cantidad" id="cantidad"
            						placeholder="0" required';

            					if ($bebida instanceof Gaseosa)
            						echo ' value="'. $bebida->getCantidad() .'"';
            					else
            						echo ' disabled';

            					echo '>
            					<span class="input-group-addon">Und.</span>
            				</div>
            			</div>
            		</div>

            		<div class="form-group">
            			<div class="col-sm-offset-3 col-sm-9">
            				<div class="checkbox">
            					<label>
            					<input type="checkbox" name="activo" id="activo"';

            					if ($bebida->getActivo())
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
            				<a href="mantenimiento.php" class="btn btn-primary">
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
         $lista_bebidas = bebidaBLL::obtenerPorCriterio("descripcion", "", -1, 0, 10);

         if ($lista_bebidas == false) {
            echo "<div class=\"alert alert-warning\" role=\"alert\">
                     <strong>Alto!</strong> No hay registro para mostrar.
                  </div>";
         }else {
            echo "<div class=\"table-responsive\">";
            echo bebidaBLL::convertirTableHTML($lista_bebidas, true, false);
            echo "</div>";
         }
     ?>
 </div>
