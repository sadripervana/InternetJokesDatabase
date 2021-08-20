<?php
//As an extra line of defense, it’s possible to type hint a return value.
// If the method returns something other than the expected type, an error will occur.
namespace Framework;

interface Routes {
  public function getRoutes():array;
  public function getAuthentication(): \Framework\Authentication;
  public function checkPermission($permission) : bool;
}

/* Interfaces are a very powerful but under-utilized tool
 that act as bridge between framework code and
project-specific code. */
