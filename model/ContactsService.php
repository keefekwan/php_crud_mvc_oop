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

	public function getContact($id) 
	{
		try {
			$this->openDb();
			$result = $this->contactsGateway->selectById($id);
			$this->closeDb();
			return $result;
		} catch(Exception $e) {
			$this->closeDb();
			throw $e;
		}
		return $this->contactsGateway->find($id);
	}

	private function validateContactParams($name, $phone, $email, $address)
	{
		$errors = array();
		if (!isset($name || empty($dbName))) {
			$errors[] = 'Name is required';
		}
		if (empty($errors)) {
			return;
		}
		throw new ValidationException($errors);
	}

	public function createNewContact($name, $phone, $email, $address)
	{
		try {
			$this->openDb();
			$this->validateContactParams($name, $phone, $email, $address);
			$result = $this->contactsGateway->insert($name, $phone, $email, $address);
			$this->closeDb();
			return $result;
		} catch(Exception $e) {
			$this->closeDb();
			throw $e;

		}
	}


	public function deleteContact($id)
	{
		try {
			$this->openDb();
			$result = $this->contactsGateway->delete($id);
			$this->closeDb();
		} catch(Exception $e) {
			$this->closeDb();
			$throw $e;
		}
	}
}

?>
