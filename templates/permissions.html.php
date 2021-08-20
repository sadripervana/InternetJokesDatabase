<h2>Edit <?=$author->name?>'s Permissions</h2>

<form action="" method="post">
	<?php foreach ($permissions as $name => $value): ?>
		<div>
			<input type="checkbox" name="permissions[]" value="<?=$value;?>" 
			    <?php if($author->hasPermission($value)):
			    	echo 'checked'; endif; ?> />
			<label ><?=$name;?></label>
		</div>
	<?php endforeach; ?>
	<input type="submit" value="Submit" />
</form>