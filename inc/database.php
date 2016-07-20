<?php
/**
 * 	Funcoes de Banco de Dados
 * 
 * 	@version 0.0.1
 */

mysqli_report(MYSQLI_REPORT_STRICT);

/**
 *	Executa a conexao com o DB
 */
function open_database() {

	try {
		// Create connection
		$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

		return $conn;

	} catch (Exception $e) {

		echo $e->getMessage();
		return null;
	}	
}

/**
 *	Fecha a conexao com o DB
 */
function close_database($conn) {

	try {

		mysqli_close($conn);

	} catch (Exception $e) {
		echo $e->getMessage();
	}
}