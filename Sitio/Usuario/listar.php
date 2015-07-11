<h2 class="sub-header">Lista de Usuarios</h2>

<div class="row">
	<div class="col-sm-12">
		<label class="radio-inline">
			<input type="radio" name="rdbIsActivo" id="rdbTodos" value="-1" checked="checked"> Todos
		</label>
		<label class="radio-inline">
			<input type="radio" name="rdbIsActivo" id="rdbActivo" value="1"> Activo
		</label>
		<label class="radio-inline">
			<input type="radio" name="rdbIsActivo" id="rbdFacturador" value="0"> Inactivo
		</label>
	</div>
	<div class="col-sm-6">
		<div class="input-group">
			<span class="input-group-addon">Buscar por</span>
				<select class="form-control" name="cboCriterio" id="cboCriterio">
					<option value="nombre">Nombre</option>
					<option value="username">Username</option>
					<option value="Correo">Correo</option>
					<option value="id">Id</option>
				</select>
		</div>
	</div>
	<div class="col-sm-5">
		<div class="input-group">
			<input type="text" class="form-control" placeholder="Buscar" name="txtValor" id="txtValor">
			<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
		</div>
	</div>
</div>

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
<div id="page" class="hidden">/Usuario/buscar_usuarios.php</div>
