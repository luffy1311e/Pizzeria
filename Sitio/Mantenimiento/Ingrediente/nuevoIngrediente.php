<h2 class="page-header">Nuevo Ingrediente</h2>

<?php
    $msg_error = "";
    $descripcion = "";
    $tipo_ingrediente = 0;
    $costo_adicional = 0;
    $activo = 1;

    if (isset($_GET['submit']))
    {
        $descripcion = ucfirst(strtolower(trim($_GET['descripcion'])));
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
        $ingrediente = new Ingrediente(0, $descripcion, $costo_adicional, $obj_tipo_ingrediente, $activo);

        try {
            $resultado = ingredienteBLL::agregar($ingrediente);
        } catch (Exception $ex) {
            $resultado = $ex->getMessage();
        }

        if ($resultado === false)
        {
            echo "<div class=\"alert alert-success\" role=\"alert\">
                      <strong>Exitos!</strong> Ingrediente <strong>{$descripcion}</strong> agregados correctamente.
                  </div>";
        }
        else{
            echo "<div class=\"alert alert-danger\" role=\"alert\">
                      <strong>Error!</strong> no se pudo agregar el ingrediente. <strong>{$resultado}</strong>
                  </div>";
        }

        echo "<p class=\"text-right\">
                  <a href=\"mantenimiento.php?view=nuevo_ingrediente\" class=\"btn btn-primary\">
                      <span class=\"glyphicon glyphicon-plus-sign\"></span> Agregar Nuevo Ingrediente
                  </a>
              </p>";

        return;
    }
 ?>

<form class="form-horizontal" role="form" method="get">
    <input type="hidden" name="view" id="view" value="nuevo_ingrediente">

    <div class="form-group">
        <label for="descripcion" class="col-sm-3 control-label">Nombre</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Nombre"
            required autofocus="autofocus" pattern="[a-zA-Z0-9ÁÉÍÓÚáéíóúÑñ ]*" value="<?php echo $descripcion; ?>">
        </div>
    </div>

    <div class="form-group">
        <label for="tipo_ingrediente" class="col-sm-3 control-label">Tipo Ingrediente</label>
        <div class="col-sm-9">
            <select class="form-control" name="tipo_ingrediente" id="tipo_ingrediente" required>
                <?php echo tipoIngredienteBLL::obtenerOptionsHTML(); ?>
            </select>
            <div class="alert alert-danger alert-dismissible" role="alert" style="display: none;">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times</span><span class="sr-only">Close</span>
                </button>
                <strong>Error!</strong> Debe Seleccionar una opcion.
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="costo_adicional" class="col-sm-3 control-label">Costo Adicional</label>
        <div class="col-sm-9">
            <div class="input-group">
                <span class="input-group-addon">₡</span>
                <input type="number" name="costo_adicional" id="costo_adicional" class="form-control" placeholder="0.00" maxlength="6" required>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="activo" id="activo"
                    <?php
                        if ($activo == 1) {
                            echo ' checked="checked"';
                        }
                     ?> > Activo
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <button type="submit" name="submit" id="submit" class="btn btn-primary">
                <span class="glyphicon glyphicon-floppy-saved"></span> Guardar
            </button>
            <a href="mantenimiento.php" class="btn btn-primary">
                <span class="glyphicon glyphicon-remove"></span> Cancelar
            </a>
        </div>
    </div>
</form>

<?php
    if (!empty($msg_error)) {
        echo '<div class="alert alert-danger col-sm-offset-3 col-sm-9" role="alert">
                    <strong>Error!</strong> '. $msg_error .'
              </div>';
    }
 ?>
