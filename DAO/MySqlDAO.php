<?php
	/**
	*
	*/
	class MySqlDAO
	{
		private $conexion;
		private static $instance;
		private $usuario;
		private $clave;
		private $hayError;
		private $numeroError;
		private $descripcionError;

		function __construct()
		{
			$this->conexion = null;
			$this->instance = null;
			$this->usuario = "root";
			$this->clave = "123456";
			$this->hayError = FALSE;
			$this->numeroError = 0;
			$this->descripcionError = "";
			//$this->abrirConexion("root", "123456");
		}

		public static function getIntance(){

			//Si la instancia es NULL crea la instancia de MySqlDAO
			if (is_null(self::$instance)) {
				self::$instance = new MySqlDAO();
			}

			//Retornar la instancia
			return self::$instance;
		}

		public function getHayError(){
			return $this->hayError;
		}

		public function setHayError($pHayError){
			$this->hayError = $pHayError;
		}

		public function getNumeroError(){
			return $this->numeroError;
		}

		public function setNumeroError($pNumeroError){
			$this->numeroError = $pNumeroError;
		}

		public function getDescripcionError(){
			return $this->descripcionError;
		}

		public function setDescripcionError($pDescripcionError){
			$this->descripcionError = $pDescripcionError;
		}

		public function abrirConexion(){

			$this->conexion = mysqli_connect("localhost", $this->usuario, $this->clave, "pizzeria");

			if(mysqli_connect_error()){
				throw new Exception(mysqli_connect_error());
			}
		}

		public function cerrarConexion(){
			mysqli_close($this->conexion);
		}

		/**
	 	* Metodo que permite seleccionar una base de datos en MySql
	 	* @param String $pNombreBaseDatos Nombre de la Base de Datos a Selecionar
	 	*/
		public function seleccionarBaseDeDatos($pNombreBaseDatos){
			mysqli_select_db($this->conexion, $pNombreBaseDatos);
		}

		/**
	 	* Modifica el CharSet de la session a utf-8
	 	* Ver referencias:
	 	*     http://php.net/manual/es/mysqli.set-charset.php
	 	*     http://dev.mysql.com/doc/refman/5.6/en/charset-charsets.html
	 	*/
		public function modificarSetCharSet() {
			$this->conexion->set_charset("utf8");
		}

		/**
		 * Obtener el resultado de la última sentencia multiple ejecuta hacia la base de datos
		 * por medio de un multi_query
		 */
		public function getStoreResult(){
			return mysqli_store_result( $this->conexion );
		}

		/**
		 * Obtener si hay más resultados en la sentencia multiple ejecutada hacia la base de datos
		 * por medio de un multi_query
		 */
		public function getNextResult(){
			return mysqli_next_result( $this->conexion );
		}

		/**
		 * Ejecutar Sentencias SQL tipo Data Manipulation Lenguaje - DML
		 * (Insert, Update, Delete) hacia la base de datos
		 * @param String $pSQL Sentencia SQL a ejcutar hacia la base de datos
		 * @return Int Cantidad de Registros Afectado en la ejecución de la sentencia, si ocurrio un error o no afecto registros
		 */
		public function ejecutarDML($sql){
			try {

				//Variables locales
				$vFilasAfectadas = 0;

				//Ejecutar la sentencia hacia la base de datos
				mysqli_query($this->conexion, $sql);

				//retonar la cantidad de filas afectadas en última sentencia
				//para las operaciones de Insert, Update o Delete
				//ver --> http://php.net/manual/es/mysqli.affected-rows.php
				$vFilasAfectadas = mysqli_affected_rows($this->conexion);

				return $vFilasAfectadas;

			} catch (Exception $ex) {
				//Actualizar el estado del error
				$this->actualizarEstadoError($ex);
				return 0;
			}
		}

		/**
		 * Ejecutar Sentencias SQL tipo Select o invocación de
		 * Procedimientos Almacenados (Store Procedures) hacia la fuente de datos
		 * @param String $pSQL Select/Store Procedure a ejecutar
		 * @return resource|NULL
		 */
		public function ejecutarSql($sql){
			$result;
			try {

				//Ejecutar la sentencia hacia la base de datos
				$result = mysqli_query($this->conexion, $sql);

				//Si $result == FALSE ocurrió un error en la ejecución con la Base de Datos
				if ( !$result ) {
					//Actualizar el estado del error de la sentencia sql ejecutada en la
					//base de datos
					$this->ActualizarEstadoErrorBaseDatos();
				}
				//Retornar el resultSet
				return $result;

			} catch (Exception $ex) {
				//Actualizar el estado del error
				$this->ActualizarEstadoError($vError);
				return null;
			}
		}

		/**
		 * Ejecutar Multiples Sentencias SQL tipo Select o invocación de
		 * Procedimientos Almacenados (Store Procedures) hacia la fuente de datos
		 * junto a operaciones select dentro de un mismo bloque de ejecución
		 * @param String $pSQL Select's/Store Procedure's a ejecutar
		 * @return True|False si ejecutó o no las consultas
		 */
		public function ejecutarMultipleSql($sql){
			$resultMultiQuery = null;

			try {
				//Ejecutar las sentencias a la Base de datos
				$resultMultiQuery = mysqli_multi_query($this->conexion, $sql);

				//Si $resultMultiQuery = FALSE ocurrió un error en la ejecución con la Base de Datos
				if ( !$resultMultiQuery ) {
					//Actualizar el estado del error de la sentencia
					//sql ejecutada en la base de datos
					$this->ActualizarEstadoErrorBaseDatos();
				}

				//retornar el resultado de la ejecución de las consultas
				return $resultMultiQuery;
			} catch (Exception $e) {
				//Actualizar el estado del error
				$this->ActualizarEstadoError($vError);
				return null;
			}
		}

		public function getRegistrosAfectados() {
			return mysqli_affected_rows($this->conexion);
		}

		/**
		 * Actualizar el estado de último error ejecutado hacia la base datos
		 * @param Exception $pError Objeto con el Error ocurrido
		 */
		private function actualizarEstadoError($pError){
			//Actualizar el estado del error
			$this->setHayError(true);
			$this->setNumeroError($pError->getCode());
			if (mysqli_errno($this->conexion) > 0) {
				//Si hay un error de base de datos concatena el error
				$this->setDescripcionError( $pError->getMessage() . "<br>" . "No. de Error: " . mysqli_errno($this->conexion) . "<br>" . "Mensaje de Error:" . mysqli_errno($this->conexion) );
			}else{
				$this->setDescripcionError( $pError->getMessage() );
			}
		}

		/**
		 * Actualizar el esatado del error de la última sentencia ejecutada
		 * hacia la Base de Datos
		 */
		private function actualizarEstadoErrorBaseDatos(){
			//Verificar si hay un error en la conexión con la Base de Datos
			if (mysqli_errno($this->conexion) != 0 ) {
				$this->setHayError(True);
				$this->setNumeroError( mysqli_errno($this->conexion) );
				$this->setDescripcionError( mysqli_error($this->conexion) );
			}
		}
	}
 ?>
