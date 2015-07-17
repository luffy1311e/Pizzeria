<h1 class="page-header">Nueva Bebida</h1>

<?php
    $msg_error = "";
    $descripcion = "";
    $mililitros = 0;
    $precio = 0;
    $tipo_bebida = "";
    $cantidad = 0;
    $activo = 1;

    if (isset($_GET['submit'])) {
        $descripcion = ucwords(strtolower(trim($_GET['descripcion'])));
        $mililitros = $_GET['mililitros'];
        $precio = $_GET['precio'];
        $tipo_bebida = $_GET['rdbBebida'];

        if (isset($_GET['cantidad'])) {
          $cantidad = $_GET['cantidad'];
        }
        else{
          $cantidad = 0;
        }

        if (isset($_GET['activo'])) {
          $activo = 1;
        }
        else{
          $activo = 0;
        }

        $bebida = FactoryBebida::getBebida(0, $descripcion, $mililitros, $precio, $cantidad, $activo, $tipo_bebida);

        try {
            $resultado = bebidaBLL::agregar($bebida);
        } catch (Exception $ex) {
            $resultado = $ex->getMessage();
        }

        if ($resultado === true) {
            echo "<div class=\"alert alert-success\" role=\"alert\">
                    <strong>Exito!</strong> Bebida <strong>{$descripcion}</strong> agregado correctamente.
                 </div>";
        }
        else{
            echo "<div class=\"alert alert-danger\" role=\"alert\">
                    <strong>Error!</strong> No se pudo agregar la bebida, <strong>{$resultado}</strong>
                 </div>";
        }

        echo "<p class=\"text-right\">
                <a href=\"mantenimiento.php?view=nueva_bebida\" class=\"btn btn-primary\">
                    <span class=\"glyphicon glyphicon-plus-sign\"></span> Agregar nueva Bebida
                </a>
            </p>";

        return;
    }
?>

<form class="form-horizontal" role="form" method="get">
    <input type="hidden" name="view" id="view" value="nueva_bebida">

    <div class="form-group">
        <label for="descripcion" class="col-sm-3 control-label">Descripcion</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Descripcion"
            required autofocus="autofocus" pattern="[a-zA-Z0-9]*" value="<?php echo $descripcion; ?>">
        </div>
    </div>

    <div class="form-group">
        <label for="mililitros" class="col-sm-3 control-label">Presentacion</label>
        <div class="col-sm-9">
            <div class="input-group">
                <input type="number" class="form-control" name="mililitros" id="mililitros" placeholder="0.00" maxlength="6" required>
                <span class="input-group-addon">ML.</span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="precio" class="col-sm-3 control-label">Precio</label>
        <div class="col-sm-9">
            <div class="input-group">
                <span class="input-group-addon">₡</span>
                <input type="number" class="form-control" name="precio" id="precio" placeholder="0.00" maxlength="6" required>
            </div>
        </div>
    </div>

    <div class="form-group">
          <label for="costo_adicional" class="col-sm-3 control-label">Tipo Bebida</label>
          <div class="col-sm-9">
              <label for="radio-inline">
                  <input type="radio" name="rdbBebida" id="rdbBebidaNatural" value="NAT" checked="checked"> Natural
              </label>
              <label for="radio-inline">
                  <input type="radio" name="rdbBebida" id="rdbBebidaGaseosa" value="GAS"> Gaseosa
              </label>
          </div>
    </div>

    <div class="form-group">
        <label for="cantidad" class="col-sm-3 control-label">Cantidad</label>
        <div class="col-sm-9">
            <div class="input-group">
                <input type="text" class="form-control" name="cantidad" id="cantidad" placeholder="0" required disabled>
                <span class="input-group-addon">Und.</span>
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
                     ?>
                     > Activo
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
</form>

<?php
    if (!empty($msg_error)) {
      echo '<div class="alert alert-danger col-sm-offset-3 col-sm-9" role="alert">
                <strong>Error!</strong> ' . $msg_error . '
            </div>';
    }
 ?>
