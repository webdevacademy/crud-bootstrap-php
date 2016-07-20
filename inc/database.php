<?php
/**
 * 	Funcoes de Banco de Dados
 * 
 * 	@version 0.0.1
 */

//require_once('config.php');

// Ensure reporting is setup correctly 
mysqli_report(MYSQLI_REPORT_STRICT);

/**
 *
 */
function open_database() {

	try {
		// Create connection
		$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

		return $conn;

	} catch (Exception $e) {
		$_SESSION['message'] = $e->getMessage();
		$_SESSION['type'] = 'danger';  	    

		return null;
	}	
}

/**
 *
 */
function close_database($conn) {

	try {

		mysqli_close($conn);

	} catch (Exception $e) {
		$_SESSION['message'] = $e->getMessage();
		$_SESSION['type'] = 'danger';  	    
	}
}

/**
 *
 */
function find( $table = null, $id = null ) {
	
	$database = open_database();
	$found = null;

	try {

		if ($id) {

			$sql = "SELECT * FROM " . $table . " WHERE id = " . $id;
			$result = $database->query($sql);

			if ($result->num_rows > 0) {   	
		    	$found = $result->fetch_assoc();
			}

		} else {
			
			$sql = "SELECT * FROM " . $table;
			$result = $database->query($sql);
			
			if ($result->num_rows > 0) { 
				$found = $result->fetch_all(MYSQLI_ASSOC);
			}
		}

	} catch (Exception $e) { 
		
    	$_SESSION['message'] = $e->GetMessage();
		$_SESSION['type'] = 'danger';
   	}
	
	close_database($database);
	return $found;
}

/**
 *
 */
function find_all( $table = null ) {
	
	return find($table);
}

/**
 *
 */
function remove( $table = null, $id = null ) {

	$database = open_database();
	
	try {
		if ($id) {

			$sql = "DELETE FROM " . $table . " WHERE id = " . $id;
			$result = $database->query($sql);

			if ($result = $database->query($sql)) {   	
		    	$_SESSION['message'] = "Registro Removido com Sucesso.";
				$_SESSION['type'] = 'success';
			}
		}
	} catch (Exception $e) { 
		
    	$_SESSION['message'] = $e->GetMessage();
		$_SESSION['type'] = 'danger';
   	}

	close_database($database);
}

/**
 *
 */
function save($table = null, $data = null) {

	$database = open_database();

	$columns = null;
	$values = null;

	//print_r($data);

	foreach ($data as $key => $value) {
		$columns .= trim($key, "'") . ",";
		$values .= "'$value',";
	}

	// remove a ultima virgula
	$columns = rtrim($columns, ',');
	$values = rtrim($values, ',');
	
	$sql = "INSERT INTO " . $table . "($columns)" . " VALUES " . "($values);";

	try {
		$database->query($sql);

		$_SESSION['message'] = 'Registro cadastrado com sucesso.';
		$_SESSION['type'] = 'success';

	} catch (Exception $e) { 
		
    	$_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
		$_SESSION['type'] = 'danger';
   	} 
	
	close_database($database);
}