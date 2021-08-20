<?php
namespace Ijdb\Controllers;
class Login {
  private $authentication;

  public function __construct(\Framework\Authentication $authentication) {
    $this->authentication = $authentication;
  }
  public function error() {
    return ['template' => 'loginerror.html.php',
      'title' => 'You are not logged in'];
  }

  public function loginForm() {
    return ['template' => 'login.html.php',
      'title' => 'Logi in'];
  }

  public function processLogin() {
    if($this->authentication->login($_POST['email'], $_POST['password'])) {
      header('location: /login/success');
    }
    else {
      return ['template' => 'login.html.php',
        'title' => 'Logi In',
        'variables' => [
          'error' => 'Invalid username/password.'
        ]
      ];
    }
  }

  public function success(){
    return ['template' => 'loginsuccess.html.php',
      'title' => 'Login Successful'
    ];
  }

  public function logout() {
  session_unset();
  return ['template' => 'logout.html.php',
    'title' => 'You have been logged out'];
  }
// unset($_SESSION); will remove any data from the current session

}
