<?php 
namespace Ijdb\Entity;

class Author {
	public $id;
	public $name;
	public $email;
	public $password;

	const EDIT_JOKES = 1;
	const DELETE_JOKES = 2;
	const LIST_CATEGORIES = 4;
	const EDIT_CATEGORIES = 8;
	const REMOVE_CATEGORIES = 16;
	const EDIT_USER_ACCESS = 32;
	

	public function __construct(\Framework\DatabaseTable $jokesTable) {
		$this->jokesTable = $jokesTable;
	}

	public function getJokes() {
		return $this->jokesTable->find('authorid', $this->id);
	}

	public function addJoke($joke) {
		$joke['authorid'] = $this->id;

		// Store the joke in the database
		return $this->jokesTable->save($joke);
	}

	public function hasPermission($permission) {
		// $permissions = $this->userPermissionsTable->find('authorId', $this->id);

		// foreach ($permissions as $permission) {
		// 	if($permission->permission ==$permission) {
		// 		return true;
		// 	}
		// }

		return $this->permissions & $permission;	
	}

	
}