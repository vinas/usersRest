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
	* Throws a system error
	*
	* @param string
	* @param string
	* @param exception
	*/
	public static function throwSysException($path, $method, $err)
	{
		throw('['.$path.'::'.$method.'] - '.$err->getMessage().PHP_EOL);
	}

	/**
	* Throws an application error
	*
	* @param string
	* @param string
	* @param string
	*/
	public static function throwAppException($path, $method, $msg)
	{
		throw New \Exception ("[".$path."::".$method."] - ".$msg.PHP_EOL);
	}

}
