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
use Application\Model\RequestDataErrorModel;

class ErrorHandlerService
{
	public function handleError($errCode)
	{
		$error = new RequestDataErrorModel();
		switch ($errCode) {
			case 660:
				$error->setCode($errCode);
				$error->setMessage('Invalid or empty Id.');
				break;
			default:
				$error->setCode(101);
				$error->setMessage('Some uninterpreted error has occured.');
		}
		return $error;
	}
}
