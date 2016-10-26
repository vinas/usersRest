<?php
/**
* User Factory Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/10/26
* @version 1.16.2026
* @license SaSeed\license.txt
*/
namespace Application\Factory;

use SaSeed\Mapper;
use SaSeed\ExceptionHandler;
use Application\Model\UserModel;

class UserFactory extends \SaSeed\Database\DAO {

	private $db;
	private $queryBuilder;
	private $table = 'users';

	public function __construct()
	{
		$this->db = parent::setDatabase('hostinger');
		$this->queryBuilder = parent::setQueryBuilder();
	}

	public function getById($userId = false)
	{
		try {
			$mapper = new Mapper();
			$this->queryBuilder->from($this->table);
			$this->queryBuilder->where([
					$this->queryBuilder->getFromAlias(),
					'id',
					'=',
					$userId
				]);
			return $mapper->populate(
					new UserModel(),
					$this->db->getRow($this->queryBuilder)
				);
		} catch (Exception $e) {
			ExceptionHandler::throwSysException(__CLASS__, __FUNCTION__, $e);
		}
	}

	public function listAll()
	{
		try {
			$mapper = new Mapper();
			$this->queryBuilder->from($this->table);
			$this->queryBuilder->select(['id', 'user', 'email']);
			$users = $this->db->getRows($this->queryBuilder);
			for ($i = 0; $i < count($users); $i++) {
				$users[$i] = $mapper->populate(
						new UserModel(),
						$users[$i]
					);
			}
			return $users;
		} catch (Exception $e) {
			ExceptionHandler::throwSysException(__CLASS__, __FUNCTION__, $e);
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
			ExceptionHandler::throwSysException(__CLASS__, __FUNCTION__, $e);
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
			ExceptionHandler::throwSysException(__CLASS__, __FUNCTION__, $e);
		}
	}

	public function update($user)
	{
		try {
			if (!$user->getId()) {
				ExceptionHandler::throwAppException(
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
			ExceptionHandler::throwSysException(__CLASS__, __FUNCTION__, $e);
		}
		return false;
	}

	public function deleteUser($user)
	{
		try {
			$this->deleteUserById($user->getId());
		} catch (Exception $e) {
			ExceptionHandler::throwSysException(__CLASS__, __FUNCTION__, $e);
		}
	}

	public function deleteUserById($userId)
	{
		try {
			return $this->db->deleteRow($this->table, ['id', '=', $userId]);
		} catch (Exception $e) {
			ExceptionHandler::throwSysException(__CLASS__, __FUNCTION__, $e);
		}
	}
}
