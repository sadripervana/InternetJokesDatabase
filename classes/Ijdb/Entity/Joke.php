<?php
namespace Ijdb\Entity;

class Joke {
	public $id;
	public $authorid;
	public $jokedate;
	public $joketext;
	private $authorsTable;
	private $author;
	private $jokeCategoriesTable;

	public function __construct(\Framework\DatabaseTable $authorsTable, 
		\Framework\DatabaseTable $jokeCategoriesTable) {
		$this->authorsTable = $authorsTable;
		$this->jokeCategoriesTable = $jokeCategoriesTable;
	}

	public function getAuthor() {
		if (empty($this->author)) {
			$this->author = $this->authorsTable->findById($this->authorid);
		}
		return $this->author;
	}

	public function addCategory($categoryId) {
		$jokeCat = ['jokeId' => $this->id,
			'categoryId' => $categoryId
		];

		$this->jokeCategoriesTable->save($jokeCat);
	}

	public function hasCategory($categoryId) {
		$jokeCategories = $this->jokeCategoriesTable->find('jokeId', $this->id);

		foreach ($jokeCategories as $jokeCategory) {
			if($jokeCategory->categoryId == $categoryId) {
				return true;
			}
		}
	}

	public function clearCategories() {
		$this->jokeCategoriesTable->deleteWhere('jokeId', $this->id);
	}
}