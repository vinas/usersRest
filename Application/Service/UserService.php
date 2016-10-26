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
use Application\Model\UserResponseModel;
use Application\Model\UsersListResponseModel;

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
				$user->setPassword($this->encrypt($user->getPassword()));
				if ($user->getId() > 0) {
					$this->repository->update($user);
				} else {
					$user = $this->repository->saveNew($user);
				}
				$res = $mapper->populate(
						new UserResponseModel(),
						$user
					);
				$res = $responseHandler->handleResponse($res, 200);
			} else {
				$res = $responseHandler->handleResponse(new UserResponseModel(), 100);
			}
		} catch (Exception $e) {
			ExceptionHandler::throwSysException(__CLASS__, __FUNCTION__, $e);
			$res = $responseHandler->handleResponse(new UserResponseModel(), 101);
		} finally {
			return $res;
		}
	}

	public function listUsers()
	{
		try {
			$mapper = new Mapper();
			$users = $this->repository->listAll();
			$res = [];
			foreach ($users as $user) {
				$res[] = $mapper->populate(new UsersListResponseModel(), $user);
			}
		} catch (Exception $e) {
			ExceptionHandler::throwSysException(__CLASS__, __FUNCTION__, $e);
		} finally {
			return $res;
		}
	}

	public function getUserById($userId = false)
	{
		try {
			$responseHandler = new ResponseHandlerService();
			if ($userId) {
				$mapper = new Mapper();
				$user = $this->repository->getById($userId);
				if ($user->getId() > 0 && is_numeric($user->getId())) {
					$res = $mapper->populate(
							new UserResponseModel(),
							$user
						);
					$res = $responseHandler->handleResponse($res, 201);
				} else {
					$res = $responseHandler->handleResponse(new UserResponseModel(), 102);
				}
			} else {
				$res = $responseHandler->handleResponse(new UserResponseModel(), 103);
			}
		} catch (Exception $e) {
			ExceptionHandler::throwSysException(__CLASS__, __FUNCTION__, $e);
			$res = $responseHandler->handleResponse(new UserResponseModel(), 102);
		} finally {
			return $res;
		}
	}

	public function delete($userId)
	{
		try {
			return $this->repository->deleteUserById($userId);
		} catch (Exception $e) {
			ExceptionHandler::throwSysException(__CLASS__, __FUNCTION__, $e);
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

	private function encrypt($txt)
	{
		return md5($txt);
	}

}
