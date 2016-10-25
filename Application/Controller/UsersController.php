<?php
/**
* Users Controller Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/10/26
* @version 1.16.1005
* @license SaSeed\license.txt
*/

namespace Application\Controller;

use SaSeed\View\View;
use SaSeed\URLRequest;
use SaSeed\ExceptionHandler;
use SaSeed\Mapper;

use Application\Model\UserModel;
use Application\Service\ResponseHandlerService;
use Application\Service\UserService;

class UsersController
{

	private $params;
	private $service;

	public function __construct()
	{
		$this->params = new URLRequest();
		$this->service = new UserService();
	}

	public function listUsers()
	{
		$users = false;
		try {
			$users = $this->service->listUsers();
		} catch (Exception $e) {
			ExceptionHandler::throwSysException(__CLASS__, __FUNCTION__, $e);
		}
		View::renderJson($users);
	}

	public function getUser()
	{
		$user = false;
		try {
			$params = $this->params->getParams();
			$user = $this->service->getUserById($params[0]);
		} catch (Exception $e) {
			ExceptionHandler::throwSysException(__CLASS__, __FUNCTION__, $e);
		}
		View::renderJson($user);
	}

	public function save()
	{
		$responseHandler = new ResponseHandlerService();
		$res = $responseHandler->handleResponse();
		try {
			$mapper = new Mapper();
			$user = $mapper->populate(new UserModel(), $this->params->getParams());
			$res = $this->service->save($user);
		} catch (Exception $e) {
			ExceptionHandler::throwSysException(__CLASS__, __FUNCTION__, $e);
		}
		View::renderJson($res);
	}

	public function delete()
	{
		try {
			$params = $this->params->getParams();
			$this->service->delete($params[0]);
			$res = (object) ['code'=>200, 'message'=>'User deleted.'];
		} catch (Exception $e) {
			ExceptionHandler::throwSysException(__CLASS__, __FUNCTION__, $e);
			$res = (object) ['code'=>102, 'message'=>'User could not be deleted'];
		}
		View::renderJson($res);
	}
}
