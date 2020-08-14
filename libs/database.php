<?php 

/**
 * 
 */
class Database
{
	private $host;
	private $charset;
	private $user;
	private $db1;
	private $db2;

	function __construct()
	{
		$this->host    = constant('HOST');
		$this->charset = constant('CHARSET');
		$this->user    = constant('USER');
		$this->db1     = constant('DB1');
		$this->db2     = constant('DB2');
	}

	public function connect1()
	{
		try {
			$connection = "mysql:host=" . $this->host . ";dbname=" . $this->db1 . ";charset=" . $this->charset;
			$pdo = new PDO($connection, $this->user);
			return $pdo;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function connect2()
	{
		try {
			$connection = "mysql:host=" . $this->host . ";dbname=" . $this->db2 . ";charset=" . $this->charset;
			$pdo = new PDO($connection, $this->user);
			return $pdo;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
}



?>