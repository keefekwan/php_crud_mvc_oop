<?php

class ContactsService {

	private $contactsGateway = null;
	private static $dbName = 'crud_mvc_oop';
	private static $dbHost = 'localhost';
	private static $dbUserName = 'root';
	private static $dbPassword = 'abc123';

	private function openDB() 
		{
			// One conenction through the whole application
			if (null == self::$conn) {
				try {
					self::$conn = new PDO("mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbPassword);
				} catch(PDOException $e) {
					die($e->getMessage());
				}
			}
			return self::$conn;
		}

	private function closeDB()
	{
		self::$conn = null;
	}

	public function __construct()
	{
		$this->contactsGateway = new ContactsGateway();
	}




}

$dbinput = new ContactsService;

$sql = "INSERT INTO contacts";

?>
