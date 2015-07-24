<h2 class="sub-header">Lista de Bebidas</h2>

<div id="listar">
	<?php
		$lista_bebidas = bebidaBLL::obtenerPorCriterio("descripcion","",-1,0,10);

		if ($lista_bebidas == false) {
			echo "<div class=\"alert alert-warning\" role\"alert\">
					<strong>Error!</strong> No hay registros para mostrar.
				 </div>";
		}else{
			echo "<div class=\"table-responsive\">";
					echo bebidaBLL::convertirTableHTML($lista_bebidas, false, false);
			echo "</div>";
		}
	 ?>
</div>
