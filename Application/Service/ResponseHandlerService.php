<?php
/**
* Application Error Handling Service Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/10/19
* @version 1.16.1019
* @license SaSeed\license.txt
*/

namespace Application\Service;

use SaSeed\ExceptionHandler;
use Application\Repository\UserRepository;
use Application\Model\ResponseModel;

class ResponseHandlerService
{
	public function handleResponse($code = false)
	{
		$res = new ResponseModel();
		switch ($code) {
			case 100:
				$res->setCode($code);
				$res->setMessage($this->error('Empty or invalid user data.'));
				break;
			case 101:
				$res->setCode($code);
				$res->setMessage($this->error('User could not be saved.'));
				break;
			case 200:
				$res->setCode($code);
				$res->setMessage($this->info('User saved successfully.'));
				break;
			case 660:
				$res->setCode($code);
				$res->setMessage($this->error('Invalid or empty Id.'));
				break;
			default:
				$res->setCode(666);
				$res->setMessage($this->warning());
		}
		return $res;
	}

	private function error($msg = false)
	{
		if ($msg) {
			return 'Error: '.$msg;
		}
		return 'Error: An unexpected error. not that we are expecting any...';
	}

	private function warning($msg = false)
	{
		if ($msg) {
			return 'Warning: '.$msg;
		}
		return 'Warning: Some uninterpreted odd behavior has occured. Fishy...';
	}

	private function info($msg = false)
	{
		if ($msg) {
			return 'Info: '.$msg;
		}
		return 'Info: You should take notice of somehing. We just happened to forget tell you what.';
	}
}
