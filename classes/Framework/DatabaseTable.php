<?php
namespace Framework;

class DatabaseTable{
  private $pdo;
  private $table;
  private $primaryKey;
  private $className;
  private $constructorArgs;

public function __construct(\PDO $pdo,string $table,string $primaryKey,
  string $className = '\stdClass', array $constructorArgs = []){
  $this->pdo = $pdo;
  $this->table = $table;
  $this->primaryKey = $primaryKey;
  $this->className = $className;
  $this->constructorArgs = $constructorArgs;
}
	
private function query($sql, $parameters = []){
  $query = $this->pdo->prepare($sql);
  // var_dump($parameters);die;
  $query->execute($parameters);

  return $query;
}

public function totalJokes(){
  $query = $this->query('SELECT COUNT(*) FROM `joke`');
  $row = $query->fetch();
  return $row[0];
}

public function getJoke($id){
  $parameters = [':id' => $id];
  $query = $this->query('SELECT * FROM `joke` WHERE `id` = :id', $parameters);
  return $query->fetch();
}

private function insertJoke($fields){
  $query = 'INSERT INTO `joke` (';
  foreach($fields as $key => $value){
    $query .='`'.$key.'`,';
  }

  $query = rtrim($query, ',');
  $query .= ') VALUES (';
  foreach($fields as $key =>$value){
    $query .= ':'.$key.',';
  }

  $query = rtrim($query,',');
  $query .= ')';
  $fields = $this->processDates($fields);
  $this->query($query,$fields);
}

private function updateJoke($fields) {
$query = ' UPDATE `joke` SET ';
foreach ($fields as $key => $value) {
$query .= '`' . $key . '` = :' . $key . ',';
}
$query = rtrim($query, ',');
$query .= ' WHERE `id` = :primaryKey';
// Set the :primaryKey variable
$fields['primaryKey'] = $fields['id'];
$fields = $this->processDates($fields);
$this->query($query, $fields);
}

private function processDates($fields){
  foreach ($fields as $key => $value){
  if($value instanceof \DateTime){
    $fields[$key] = $value->format('Y-m-d');
  }
}
return $fields;
}

public function deleteJoke($id){
  $parameters = [':id' => $id];
  $this->query('DELETE FROM `joke` WHERE `id`=:id',$parameters);
}

public function allJokes(){
  $jokes = $this->query($this->pdo, 'SELECT `joke`.`id`,`joketext`,`jokedate`,`name`,`email` FROM `joke` INNER JOIN `author` ON `authorid`=`author`.`id`');
  return $jokes->fetchAll();
}

// AUTHOR ---------------
public function allAuthors(){
  $authors = $this->query($this->pdo,'SELECT * FROM `author`');

  return $authors->fetchAll();
}

public function deleteAuthor($id){
  $parameters = [':id' => $id];
  $this->query('DELETE FROM `author` WHERE `id` = :id',$parameters);
}

private function insertAuthor($fields){
  $query = 'INSERT INTO `author` (';

  foreach($fields as $key=>$value){
    $query .='`'.$key.'`,';
  }
  $query = rtrim($query,',');
  $query .=') VALUES (';

  foreach($fields as $key => $value){
    $query .= ':'.$key.',';
  }
  $query = rtrim($query, ',');
  $query .= ')';

  $fields = $this->processDates($fields);
  $this->query($query, $fields);
}



public function delete($id){
  $parameters = [':id' => $id];

  $this->query('DELETE FROM `'.$this->table.'` WHERE `'.$this->primaryKey.'` = :id',$parameters);
}

private function insert($fields){
  $query = 'INSERT INTO `'.$this->table.'` (';
  foreach($fields as $key => $value){
    $query .='`'.$key.'`,';
  }

  $query = rtrim($query, ',');
  $query .=') VALUES (';
  foreach($fields as $key => $value){
    $query .=':'.$key.',';
  }
  $query = rtrim($query, ',');
  $query .=')';
  $fields = $this->processDates($fields);
  $this->query($query, $fields);

  return $this->pdo->lastInsertId();
}

private function update($fields) {
  $query = ' UPDATE `' . $this->table .'` SET ';
  foreach ($fields as $key => $value) {
    $query .= '`' . $key . '` = :' . $key . ',';
  }
  $query = rtrim($query, ',');
  $query .= ' WHERE `' . $this->primaryKey . '` = :primaryKey';
  // Set the :primaryKey variable
  $fields['primaryKey'] = $fields['id'];
  $fields = $this->processDates($fields);
  $this->query($query, $fields);
}

public function findById($value){
  $query = 'SELECT * FROM `'.$this->table.'` WHERE `'.$this->primaryKey.'` = :value';

  $parameters = [':value'=>$value];

  $query = $this->query($query,$parameters);
  return $query->fetchObject($this->className, $this->constructorArgs);
}

public function total($field = null, $value = null){
  $sql = 'SELECT COUNT(*) FROM `'.$this->table.'`';
  $parameters = [];
  if(!empty($field)) {
    $sql .= ' WHERE `' . $field . '` = :value';
    $parameters = ['value' => $value];
  }

  $query = $this->query($sql, $parameters);
  $row = $query->fetch();
  return $row[0];
}

public function findAll($orderBy = null, $limit = null, $offset = null){
  $query = 'SELECT * FROM `'.$this->table . '`';

  if($orderBy != null) {
    $query .= ' ORDER BY ' . $orderBy;
  }

  if ($limit != null) {
    $query .= ' LIMIT ' . $limit;
  }

  if ($offset != null) {
    $query .= ' OFFSET ' . $offset;
  }

  $result = $this->query($query);

  return $result->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
}


public function save($record){
  $entity = new $this->className(...$this->constructorArgs);

  try{
    if($record[$this->primaryKey] == ''){
       $record[$this->primaryKey] = null;
    }
    $insertId = $this->insert($record);
    $entity->{$this->primaryKey} = $insertId;
  }
  catch(\PDOException $e){
    $this->update($record);
  }

  foreach($record as $key => $value){
    if(!empty($value)) {
      $entity->$key = $value;
    }
  }

  return $entity;
}

public function find($column, $value, $orderBy = null, $limit = null, $offset = null) {
  $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $column . ' = :value';
  $parameters = ['value' => $value];

  if($orderBy != null) {
    $query .= ' ORDER BY ' . $orderBy;
  }

  if ($limit != null) {
    $query .= ' LIMIT ' . $limit;
  }

  if ($offset != null) {
    $query .= ' OFFSET ' . $offset;
  }

  $query = $this->query($query, $parameters);
  return $query->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
}

public function deleteWhere($column, $value) {
  $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $column . ' =:value';

  $parameters = ['value' => $value];
  $query = $this->query($query, $parameters);
}
}