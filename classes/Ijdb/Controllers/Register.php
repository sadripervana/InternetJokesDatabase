<?php 
namespace Ijdb\Controllers;

use \Framework\DatabaseTable;

class Register{
	private $authorsTable;

	public function __construct(DatabaseTable $authorsTable){
		$this->authorsTable = $authorsTable;
	}

	public function registrationForm(){
		return ['template' => 'register.html.php',
			'title' => 'Register an account'];
	}

	public function success(){
		return ['template' => 'registersuccess.html.php',
			'title' => 'Registration Successful'];
	}

	public function registerUser(){
		$author = $_POST['author'];
		


		//Assume the data is valid to begin with
		$valid = true;
		$errors = [];

		//But if any of the fields have been left blan
		//set $valid to false
		if(empty($author['name'])){
			$valid = false;
			$errors[] = 'Name cannot be blank';
		}

		if(empty($author['password'])){
			$valid = false;
			$errors[] = 'Password cannot be blank';
		}
		//If $valid is still true, no fields were blanl
		//amd the data can be added
		if($valid == true){
			// Hash the password before saving it in the database
			$author['password'] = password_hash($author['password'], PASSWORD_DEFAULT);
			$this->authorsTable->save($author);

			header('Location: /author/success');
		} 
		else {
			//If the data is not valid, show the form again
			return['template' => 'register.html.php',
				'title' => 'Register an account',
				'variables' => [
					'errors' => $errors,
					'author' => $author
				]
			];
		}
	}

	public function list() {
		$authors = $this->authorsTable->findAll();

		return ['template' => 'authorlist.html.php',
			'title' => 'Author List',
			'variables' => [
				'authors' => $authors 
			]
		];
	}

	public function permissions(){
		$author = $this->authorsTable->findById($_GET['id']);
		$reflected = new \ReflectionClass('\Ijdb\Entity\Author');
		$constants = $reflected->getConstants();


		return ['template' => 'permissions.html.php',
			'title' => 'Edit permissions',
			'variables' => [
				'author' => $author,
				'permissions' => $constants
			]
		];
	}

	public function savePermissions() {
		$author = [
			'id' => $_GET['id'],
			'permissions' => array_sum($_POST['permissions'] ?? [])
		];
		$this->authorsTable->save($author);
		header('location: /author/list');
	}
}