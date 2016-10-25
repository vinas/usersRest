<?php
/**
* User Repository Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/10/26
* @version 1.16.0901
* @license SaSeed\license.txt
*/
namespace Application\Repository;

use SaSeed\Mapper;
use SaSeed\ExceptionHandler;
use Application\Model\UserModel;

class UserRepository extends \SaSeed\Database\DAO {

	private $db;
	private $table = 'users';

	public function __construct()
	{
		$this->db = parent::setDatabase('hostinger');
	}

	public function getById($userId = false)
	{
		try {
			$mapper = new Mapper();
			return $mapper->populate(
					new UserModel(),
					$this->db->getRow($this->table, '*', "id = {$userId}")
				);
		} catch (Exception $e) {
			ExceptionHandler::throwing(__CLASS__, __FUNCTION__, $e);
		}
	}

	public function listAll()
	{
		try {
			$mapper = new Mapper();
			$users = $this->db->getRows($this->table);
			for ($i = 0; $i < count($users); $i++) {
				$users[$i] = $mapper->populate(
						new UserModel(),
						$users[$i]
					);
			}
			return $users;
		} catch (Exception $e) {
			ExceptionHandler::throwing(__CLASS__, __FUNCTION__, $e);
		}
	}


	public function getByEmail($email = false)
	{
		try {
			$mapper = new Mapper();
			return $mapper->populate(
					new UserModel(),
					$this->db->getRow($this->table, '*', "email = '{$email}'")
				);
		} catch (Exception $e) {
			ExceptionHandler::throwing(__CLASS__, __FUNCTION__, $e);
		}
	}

	public function saveNew($user)
	{
		try {
			$this->db->insertRow(
				$this->table,
				array(
					$user->getUser(),
					$user->getEmail(),
					$user->getPassword()
				)
			);
			$user->setId($this->db->lastId());
			return $user;
		} catch (Exception $e) {
			ExceptionHandler::throwing(__CLASS__, __FUNCTION__, $e);
		}
	}

	public function update($user)
	{
		try {
			if (!$user->getId()) {
				ExceptionHandler::throwingNew(
					__CLASS__,
					__FUNCTION__,
					'No user Id informed.'
				);
				return false;
			}
			$this->db->update(
				$this->table,
				array(
					$user->getUser(),
					$user->getEmail(),
					$user->getPassword()
				),
				array(
					'user',
					'email',
					'password'
				),
				"id = ".$user->getId()
			);
			return true;
		} catch (Exception $e) {
			ExceptionHandler::throwing(__CLASS__, __FUNCTION__, $e);
		}
		return false;
	}

	public function deleteUser($user)
	{
		try {
			return $this->deleteUserById($user->getId());
		} catch (Exception $e) {
			ExceptionHandler::throwing(__CLASS__, __FUNCTION__, $e);
		}
	}

	public function deleteUserById($userId)
	{
		try {
			return $this->db->deleteRow($this->table, " id = " . $userId);
		} catch (Exception $e) {
			ExceptionHandler::throwing(__CLASS__, __FUNCTION__, $e);
		}
	}

	public function findUserByLogin($user, $password)
	{
		try {
			return $this->db->getRow(
				$this->table,
				'*',
				"user = '{$user}' AND password = '{$password}'"
			);
		} catch (Exception $e) {
			ExceptionHandler::throwing(__CLASS__, __FUNCTION__, $e);
		}
	}

}
