<div class = "container">
	<div class="wrapper">
		<form action="/admin/signin" method="post" name="Login_Form" class="form-signin">       
		    <h3 class="form-signin-heading">Welcome! Please login</h3>
			  <hr class="colorgraph">
			  <p class="error"><?php echo $error?></p>
			  <input type="text" class="form-control" name="username" placeholder="Username" required="" autofocus="" />
			  <input type="password" class="form-control" name="password" placeholder="Password" required=""/>     		  
			 
			  <button class="btn btn-lg btn-primary btn-block"  name="submit" value="Login" type="Submit">Login</button>  			
		</form>			
	</div>
</div>
