<?php 
namespace Ijdb\Controllers;
use \Framework\DatabaseTable;
use \Framework\Authentication;
class Joke{
	private $authorsTable;
	private $jokesTable;
	private $categoriesTable;
	private $authentication;

	public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorsTable, 
		DatabaseTable $categoriesTable,
	  	Authentication $authentication) {
    	$this->jokesTable = $jokesTable;
    	$this->authoresTable = $authorsTable;
    	$this->categoriesTable = $categoriesTable;
    	$this->authentication = $authentication;
 	 }
	public function home(){
			$title = 'Internet Joke Database';
			return ['template' => 'home.html.php', 'title' => $title];
	}

	public function list(){
		$page = $_GET['page'] ?? 1;
		$offset = ($page-1)*10;
		if (isset($_GET['category'])) {
			$category = $this->categoriesTable->findById($_GET['category']);
			$jokes = $category->getJokes(10, $offset);
			$totalJokes = $category->getNumJokes();
		}
		else {
			$jokes = $this->jokesTable->findAll('jokedate DESC', 10, $offset);
			$totalJokes = $this->jokesTable->total();
		}
		
		$title = 'Joke list';
  		$totalJokes = $this->jokesTable->total();
  		$author = $this->authentication->getUser();
  		return ['template' => 'joke.html.php', 
			'title' => $title,
			'variables' => [
				'totalJokes' => $totalJokes,
				'jokes' => $jokes,
				// 'userId' => $author->id ?? null,
				'user' => $author,
				'categories' => $this->categoriesTable->findAll(),
				'currentPage' => $page,
				'category' => $_GET['category'] ?? null
			]
		];
	}
	
	public function delete(){
		$author = $this->authentication->getUser();
  		$joke = $this->jokesTable->findById($_POST['id']);
  		if ($joke->authorid != $author->id && !$author->hasPermission(\Ijdb\Entity\Author::DELETE_JOKES)) {
   			return;
  		}
  		$this->jokesTable->delete($_POST['id']);
 		 header('location: /joke/list');
		exit();
	}


	public function saveEdit() {
  		$author = $this->authentication->getUser();
  		
  		$joke = $_POST['joke'];
  		$joke['jokedate'] = new \DateTime();
  		// var_dump($author);die;
  		$jokeEntity = $author->addJoke($joke);
  		$jokeEntity->clearCategories();

  		foreach($_POST['category'] as $categoryId) {
  			$jokeEntity->addCategory($categoryId);
  		}
  	
 		header('location: /joke/list');
 	 }

	public function edit(){
		$author = $this->authentication->getUser();
		$categories = $this->categoriesTable->findAll();

		if(isset($_GET['id'])){
			$joke = $this->jokesTable->findById($_GET['id']);
		}

		$title = 'Edit joke';

		return [
			'template' => 'editjoke.html.php',
			'title' => $title,
			'variables' => [
				'joke' => $joke ?? null,
				// 'userId' => $author->id ?? null,
				'user' => $author,
				'categories' => $categories
			]
		];
	}
}

