<h2 class="page-header">Editar Pizza</h2>

<?php
    if (isset($_GET['submit']))
    {
        $descripcion = ucwords(strtolower(trim($_GET['descripcion'])));
        
    }
 ?>
