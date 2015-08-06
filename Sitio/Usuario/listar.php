<h1 class="sub-header">Lista de Usuarios</h1>

<div id="listar">
	<?php
		$listar_usuarios = usuarioBLL::obtenerPorCriterio("nombre", "", -1, 0, 10);

		if ($listar_usuarios == false) {
			echo '<div class="alert alert-danger" role="alert">
						<strong>Error!</strong> Intentelo mas tarde!
				  </div>';
		}
		else{
			echo '<div class="table-responsive">';
			echo usuarioBLL::convertirTableHTML($listar_usuarios, false);
			echo '</div>';
		}
	 ?>
</div>
