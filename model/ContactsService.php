<?php

require_once 'ContactsGateway.php';
require_once 'ValidationException.php';
require_once 'Database.php';

class ContactsService extends ContactsGateway
{

	private $contactsGateway = null;

	public function __construct()
	{
		$this->contactsGateway = new ContactsGateway();
	}

	public function getAllContacts($order) { 
	    try { 
	        self::connect();
	        $res = $this->contactsGateway->selectAll($order); 
	        self::disconnect();
	        return $res; 
	    } catch (Exception $e) { 
	        self::disconnect();
	        throw $e; 
	    } 
	} 

	public function getContact($id) 
	{
		try {
			self::connect();
			$result = $this->contactsGateway->selectById($id);
			self::disconnect();
			return $result;
		} catch(Exception $e) {
			self::disconnect();
			throw $e;
		}
		return $this->contactsGateway->find($id);
	}

	private function validateContactParams($name, $phone, $email, $address)
	{
		$errors = array();
		if (!isset($name) || empty($name)) {
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
			self::connect();
			$this->validateContactParams($name, $phone, $email, $address);
			$result = $this->contactsGateway->insert($name, $phone, $email, $address);
			self::disconnect();
			return $result;
		} catch(Exception $e) {
			self::disconnect();
			throw $e;

		}
	}

	public function deleteContact($id)
	{
		try {
			self::connect();
			$result = $this->contactsGateway->delete($id);
			self::disconnect();
		} catch(Exception $e) {
			self::disconnect();
			throw $e;
		}
	}
}

?>
