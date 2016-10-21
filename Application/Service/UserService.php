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
		$res = new ResponseModel();
		try {
			if ($this->isUserValid($user)) {
				echo 'aqui<br/>';
				if ($user->getId() > 0) {
					$this->repository->update($user);
				} else {
					$user = $this->repository->saveNew($user);
				}
				$res->handleResponse(200);
			} else {
				$res = $responseHandler->handleResponse(100);
			}
		} catch (Exception $e) {
			$res->handleResponse(101);
			ExceptionHandler::throwing(__CLASS__, __FUNCTION__, $e);
		}
		return $res;
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
