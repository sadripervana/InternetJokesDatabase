<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="joke.css">
  </head>
  <body>

    <div class="jokelist">
      <ul class="categories">
        <?php foreach($categories as $category): ?>
          <li><a href="/joke/list?category=<?=$category->id?>"><?=$category->name?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="jokes">
    <?php if (isset($error)): ?>
      <p>
        <?php echo $error; ?>
      </p>
    <?php else: ?>
      <p>
        <?=$totalJokes?> jokes have been submitted to the Internet Joke Database.
      </p>
      <?php foreach($jokes as $joke): ?>
      <blockquote >
        
          <!-- <?=htmlspecialchars($joke->joketext, ENT_QUOTES, 'UTF-8') ?> -->
          <?php
            $markdown = new \Framework\Markdown($joke->joketext);
            echo $markdown->toHtml();
          ?>
          <!-- or <?=(new \Framework\Markdown($joke->joketext))->toHtml()?> -->

          (by <a href="mailto:<?php echo htmlspecialchars($joke->getAuthor()->email, ENT_QUOTES,'UTF-8'); ?>">
            <?php echo htmlspecialchars($joke->getAuthor()->name, ENT_QUOTES ,'UTF-8'); ?></a>)
            on 
            <?php
            $date = new DateTime($joke->jokedate);
            echo $date->format('jS F Y');
            ?>)

            <?php if ($user): ?>
              <?php if ($user->id == $joke->authorid || 
                    $user->hasPermission(\Ijdb\Entity\Author::EDIT_JOKES)):?>
                <a href="/joke/edit?id=<?=$joke->id?>">Edit</a>
              <?php endif; ?>
              <?php if ($user->id == $joke->authorid ||
                  $user->hasPermission(\Ijdb\Entity\Author::DELETE_JOKES)):?>
                
                <form action="/joke/delete" method="post">
                <input type="hidden" name="id" value="<?=$joke->id?>">
                <input type="submit" value="Delete">
                </form>
              <?php endif; ?>
            <?php endif; ?>

        
      </blockquote>
    <?php endforeach; ?>
  <?php endif;?>

    Select page:
    <?php //Calculate the number of pages
      $numPages = ceil($totalJokes/10);

      for($i = 1; $i <= $numPages; $i++):
        if($i == $currentPage):
    ?>
          <a class="currentpage" href="/joke/list?page=<?=$i?>"> <?=$i?> </a>
        <?php else: ?>
          <a href="/joke/list?page=<?=$i?><?=!empty($categoryId) ? '&category=' . $categoryId : '' ?>">
            <?=$i?></a>
        <?php endif; ?>
      <?php endfor;?>
  </div>
  </body>
</html>
