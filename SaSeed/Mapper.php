<?php
/**
* Mapper Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/10/28
* @version 1.16.0901
* @license SaSeed\license.txt
*/

namespace SaSeed;

use SaSeed\Model;
use SaSeed\ExceptionHandler;

class Mapper
{

	/**
	* Populates given object
	*
	* Populates given object with values from array, as long
	* as their attributes' names are the same.
	*
	* @param object
	* @param array
	*/
	public function populate($obj, $array) {
		try {
			$attrs = $obj->listProperties();
			foreach ($attrs as $attr) {
				$method = 'set'.ucfirst($attr);
				$obj->$method((isset($array[$attr])) ? $array[$attr] : false);
			}
			return $obj;
		} catch (Exception $e) {
			ExceptionHandler::throwing(__CLASS__, __FUNCTION__, $e);
		}
	}

}
