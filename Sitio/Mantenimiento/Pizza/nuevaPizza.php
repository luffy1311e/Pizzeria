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

        $pizza = 
    }
 ?>
