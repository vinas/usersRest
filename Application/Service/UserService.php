<?php
/**
* User Service Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/10/26
* @version 1.16.0901
* @license SaSeed\license.txt
*/

namespace Application\Service;

use SaSeed\ExceptionHandler;
use Application\Repository\UserRepository;
use Application\Service\ErrorHandlerService;

class UserService {

	private $repository;

	public function __construct()
	{
		$this->repository = new UserRepository();
	}

	public function save($user)
	{
		if ($user->getId() > 0) {
			$this->repository->update($user);
		} else {
			$user = $this->repository->saveNew($user);
		}
		return $user;
	}

	public function listUsers()
	{
		try {
			return $this->repository->listAll();
		} catch (Exception $e) {
			ExceptionHandler::throwing(__CLASS__, __FUNCTION__, $e);
		}
	}

	public function getUserById($userId)
	{
		try {
			if ($userId > 0 && is_numeric($userId)) {
				return $this->repository->getById($userId);
			}
			$error = new ErrorHandlerService();
			return $error->handleError(660);
		} catch (Exception $e) {
			ExceptionHandler::throwing(__CLASS__, __FUNCTION__, $e);
		}
	}

	public function delete($userId)
	{
		try {
			return $this->repository->deleteUserById($userId);
		} catch (Exception $e) {
			ExceptionHandler::throwing(__CLASS__, __FUNCTION__, $e);
		}
	}

}
