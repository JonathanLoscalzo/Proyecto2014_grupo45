<?php

/* no deberìa ser singleton, dudas!*/
/* no modelo la clase padre model porque estaria vacia?*/
include_once("model/Model.php");

class UserModel extends Model
{
	private $username;
	private $role;

	public function __construct( $username, $role )
	{
		$this->username = $username;
		$this->role = $role;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function getRole()
	{
		return $this->role;
	}



}