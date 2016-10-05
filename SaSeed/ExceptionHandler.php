<?php
/**
* Exception Handling Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/09/01
* @version 1.16.1005
* @license SaSeed\license.txt
*/

namespace SaSeed;

Final class ExceptionHandler
{

	/**
	* Throws an exception error
	*
	* @param string
	*/
	public static function throwing($path, $method, $err)
	{
		throw('['.$path.'::'.$method.'] - '.$err->getMessage().PHP_EOL);
	}

	public static function throwingNew($path, $method, $msg)
	{

		throw New \Exception ("[".$path."::".$method."] - ".$msg.PHP_EOL);
	}

}
