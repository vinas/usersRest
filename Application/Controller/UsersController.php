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
			ExceptionHandler::throwing(__CLASS__, __FUNCTION__, $e);
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
			ExceptionHandler::throwing(__CLASS__, __FUNCTION__, $e);
		}
		View::renderJson($user);
	}

	public function save()
	{
		$res = new ResponseHandlerService();
		$res = $res->handleResponse();
		try {
			$mapper = new Mapper();
			$user = $mapper->populate(new UserModel(), $this->params->getParams());
			$user->setPassword(md5($user->getPassword()));
			$res = $this->service->save($user);
		} catch (Exception $e) {
			ExceptionHandler::throwing(__CLASS__, __FUNCTION__, $e);
		}
		//View::renderJson($res);
		View::renderJson($user);
	}

	public function saveJsonResponse()
	{
		try {
			$mapper = new Mapper();
			$user = $mapper->populate(new UserModel(), $this->params->getParams());
			$this->service->save($user);
			$response['message'] = "User saved!";
		} catch (Exception $e) {
			ExceptionHandler::throwing(__CLASS__, __FUNCTION__, $e);
			$response['message'] = "User not saved!";
		}
		View::renderJson($response);
	}

	public function delete()
	{
		try {
			$params = $this->params->getParams();
			$this->service->delete($params[0]);
			View::redirect('/Users/listUsers', true);
		} catch (Exception $e) {
			ExceptionHandler::throwing(__CLASS__, __FUNCTION__, $e);
		}
	}
}
