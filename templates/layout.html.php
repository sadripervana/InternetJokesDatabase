<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/joke.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <title><?=$title?></title>
  </head>
  <body>
    <header>
      <h4>Internet Joke Database</h4>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <ul class="navbar-nav mr-auto ">
        <li class="nav-item active"><a class="nav-link" href="/">Home</a></li>
        <li class="nav-item "><a class="nav-link" href="/joke/list">Jokes List </a></li>
        <li class="nav-item "><a class="nav-link" href="/joke/edit">Add a new Joke</a></li>
        <li class="nav-item "><a class="nav-link" href="/author/register">Register Autor</a></li>
        <?php if ($loggedIn): ?>
            <li class="nav-item "><a class="nav-link" href="/logout">Log out</a></li>
          <?php else: ?>
            <li class="nav-item "><a class="nav-link" href="/login">Log in</a></li>
        <?php endif; ?>
        <li class="nav-item "><a class="nav-link" href="/category/list">Category List</a></li>
        <li class="nav-item "><a class="nav-link" href="/author/list">Author List</a></li>
      </ul>
      </nav>
      </header>

      <main>
        <?=$output?>
      </main>

      <footer>
        &copy; Sadri Pervana
      </footer>
    
  </body>
</html>
