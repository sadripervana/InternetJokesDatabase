<?php 
if(isset($error)): 
	echo '<div class="errors">' . $error . '</div>';

endif; ?>
<form class="form-style" method="post" action="">
	<div class="form-group row">
		<div class="form-group row">
			<label for="email" >Your email address</label>
			<div class="col-sm-10">
				<input type="text" id="email" name="email">
			</div>
		</div>
		<div class="form-group row">
			<label for="password"  >Your password</label>
			<div class="col-sm-10">
				<input type="password" id="password" name="password">
			</div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-sm-10 add">
			<button type="submit" name="login" class="btn btn-primary ">Login</button>
		</div>
	</div>
</form>
<p>Don't have an account? <a href="/author/register">Click here to register an account</a></p>