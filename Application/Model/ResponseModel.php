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
	private $id;
	private $user;
	private $email;
	private $password;

	public function setId($id = false) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}

	public function setUser($user = false) {
		$this->user = $user;
	}
	public function getUser() {
		return $this->user;
	}

	public function setEmail($email = false) {
		$this->email = $email;
	}
	public function getEmail() {
		return $this->email;
	}

	public function setPassword($password = false) {
		$this->password = $password;
	}
	public function getPassword() {
		return $this->password;
	}

	public function setActive($active = false) {
		$this->active = $active;
	}
	public function getActive() {
		return $this->active;
	}

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