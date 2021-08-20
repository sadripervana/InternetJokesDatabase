<?php 
namespace Framework;

class Authentication {
	private $users;
	private $usernameColumn;
	private $passwordColumn;

	public function __construct (DatabaseTable $users, $usernameColumn, $passwordColumn) {
		session_start();
		$this->users = $users;
		$this->usernameColumn = $usernameColumn;
		$this->passwordColumn = $passwordColumn;
	}

	public function login($username, $password) {
		$user = $this->users->find($this->usernameColumn, strtolower($username));

		if(!empty($user) && password_verify($password, $user[0]->{$this->passwordColumn})) {
			session_regenerate_id();
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $user[0]->{$this->passwordColumn};
			// $_SESSION['userId'] = $userId;
			// var_dump(session_regenerate_id());die;
			return true;
		} else {
			return false;
		}
	}

	public function isLoggedIn() {
		if(empty($_SESSION['username'])) {
			return false;
		}

		$user = $this->users->find($this->usernameColumn, strtolower($_SESSION['username']));

		$passwordColumn = $this->passwordColumn;
		if (!empty($user) && $user[0]->$passwordColumn === $_SESSION['password']) {
			return true;
		} else {
			return false;
		}
	}

	public function getUser() {
    	if($this->isLoggedIn()) {
     	 return $this->users->find($this->usernameColumn,
     	 strtolower($_SESSION['username']))[0];
    	} else {
      		return false;
    	}
  	}

	// if(!empty($author) && password_verify($password, $author[0]['passowrd'])) {
	// 	session_regenerate_id();
	// 	$_SESSION['email'] = $email;
	// 	$_SESSION['password'] = $author['password'];
	// 	return true;
	// }
}