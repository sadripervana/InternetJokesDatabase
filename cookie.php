<?php 
bool setcookie ( string $name [,string $value = "" [,
	int $expire = 0 [, string $path = "" [,
		bool $httponly = false ]]]])

//set a cookie to expirein 1 year
setcookie('mycookie', 'somevalue', time() + 3600 * 24 *365);

//Delete it
setcookie('mycookie', '', time() - 3600 * 24 *365); 

if(!isset($_COOKIE['visits'])){
	$_COOKIE['vistis'] = 0;
} 
$visitis = $_COOKIE['visits'] + 1;
setcookie('visits', $visits, time() + 3600 * 24 * 365);

if($visits > 1) {
	echo "This is visit number $visits.";
} else {
	//First visit
	echo 'Welcome to our website! Click here for a tour!';
}

?>

<?php
session_start();
if(!isset($_SESSION['visits'])){
	$_SESSION['visits'] = 0;
}
$_SESSION['visits'] = $_SESSION['visits'] +1;

if($_SESSION['visits'] > 1) {
	echo 'This is visit number ' . $_SESSION['visits'];
} else {
	//First visit
	echo 'Welcome to my website! Click here for a tour!';
}

$author = $authorsTable->find('email',strtolower($_SESSION['email']))[0];

if(!empty($author) && password_verify($_SESSION['password'], $author['password'])){
	//Display password protected content
}
else {
	//Display an error message and clear the session logging the user out
}


 //OSE 

 $author = $authorsTable->find('email',strtolower($_SESSION['email']));

if(!empty($author) && $author[0]['password'] === $_SESSION['password']){
	//Display password protected content
}
else {
	//Display an error message and clear the session logging the user out
}