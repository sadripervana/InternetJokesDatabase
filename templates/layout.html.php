<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/joke.css">
    <title><?=$title?></title>
  </head>
  <body>
    <header>
      <h1>Internet Joke Database</h1>
    </header>
    <nav>
      <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/joke/list">Jokes List </a></li>
        <li><a href="/joke/edit">Add a new Joke</a></li>
        <li><a href="/author/register">Register Autor</a></li>
        <?php if ($loggedIn): ?>
            <li><a href="/logout">Log out</a></li>
          <?php else: ?>
            <li><a href="/login">Log in</a></li>
        <?php endif; ?>
        <li><a href="/category/list">Category List</a></li>
        <li><a href="/author/list">Author List</a></li>
      </ul>
      </nav>
      <main>
        <?=$output?>
      </main>

      <footer>
        &copy; Sadri Pervana
      </footer>
    
  </body>
</html>
