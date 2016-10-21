<?php
/**
* Request Data Error Model
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/10/19
* @version 1.16.1019
* @license SaSeed\license.txt
*/ 

namespace Application\Model;

class ResponseModel implements \JsonSerializable
{

	private $code;
	private $message;

	public function getCode()
	{
		return $this->code;
	}

	public function setCode($code)
	{
		$this->code = $code;
	}

	public function getMessage()
	{
		return $this->message;
	}

	public function setMessage($message)
	{
		$this->message = $message;
	}

	public function JsonSerialize()
	{
		return get_object_vars($this);
	}
}