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
use SaSeed\Mapper;
use Application\Repository\UserRepository;
use Application\Service\ResponseHandlerService;
use Application\Model\ResponseModel;

class UserService {

	private $repository;

	public function __construct()
	{
		$this->repository = new UserRepository();
	}

	public function save($user)
	{
		$responseHandler = new ResponseHandlerService();
		$mapper = new Mapper();
		try {
			if ($this->isUserValid($user)) {
				$user->setPassword(md5($user->getPassword()));
				if ($user->getId() > 0) {
					$this->repository->update($user);
				} else {
					$user = $this->repository->saveNew($user);
				}
				return $mapper->populate(
						$responseHandler->handleResponse(200),
						$user
					);
			}
			return $responseHandler->handleResponse(100);
		} catch (Exception $e) {
			ExceptionHandler::throwing(__CLASS__, __FUNCTION__, $e);
			return $responseHandler->handleResponse(101);
		}
	}

	public function listUsers()
	{
		try {
			return $this->repository->listAll();
		} catch (Exception $e) {
			ExceptionHandler::throwing(__CLASS__, __FUNCTION__, $e);
		}
	}

	public function getUserById($userId = false)
	{
		try {
			if ($userId) {
				$user = $this->repository->getById($userId);
				if ($user->getId() > 0 && is_numeric($user->getId())) {
					return $user;
				}
			}
			$error = new ResponseHandlerService();
			return $error->handleResponse(660);
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

	private function isUserValid($user)
	{
		if (strlen($user->getUser()) < 1) {
			return false;
		} else if (strlen($user->getEmail()) < 1) {
			return false;
		} else if (strlen($user->getPassword()) < 1) {
			return false;
		}
		return true;
	}

}
