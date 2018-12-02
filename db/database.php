<?php
/*
*	This file contains code for database interation 
*	Database can be configured in config.php
*/

class Database {
	
	// Datbase configuration
	// This can be setup in config.php
	private $host;
	private $user;
	private $password;
	private $database_name;

	// Database connection object
	// Will be created when instance of class will be created
	private $db;

	// config variable to hold instance of config class
//	private $config;

	// Database construct
	// Setup database configuration from config.php into private variables
	// Make the database PDO connection object
	public function __construct()
	{
		// config.php is required_once in init.php
		// database class can access it using global keyword
		global $config;
		
		$this->host = $config['db_host'];
		$this->user = $config['db_user'];
		$this->password = $config['db_pass'];
		$this->database_name = $config['db_name'];

		try {
			$this->db = new PDO('mysql:host='.$this->host.';dbname='.$this->database_name.';charset=utf8', $this->user, $this->password);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		} catch (Exception $e) {
			//if($config['debug'])
				echo "ERROR : ".__file__." : ".$e->getMessage();
		}
	}

	// will query database and return the result
	public function query($query)
	{
		try {
			$stmt = $this->db->prepare($query);
			$stmt->execute(array());
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if($result)
				return $result;
			else
				return null;
		} catch (Exception $e) {
			//if($config['debug'])
				echo "ERROR : ".__file__." : ".$e->getMessage();
		}
	}

	// will execute the query without returning any result
	public function execute($query)
	{
		try {
			$stmt = $this->db->prepare($query);
			$stmt->execute(array());
		} catch (Exception $e) {
			//if($config['debug'])
				echo "ERROR : ".__file__." : ".$e->getMessage();
		}
	}

	// will destroy the database connection object
	public function __destruct()
	{
		$db = null;
	}

}
?>