<?php require_once(ROOT . DS . 'application' . DS . 'views' . DS . 'admin' . DS . 'topMenu.php' ); ?>
<div class="col-lg-6">
	<form role="form" action="/admin/updateSettings" method="post">

		<div class="form-group input-group">
			<span class="input-group-addon">Name</span>
			<input type="text" class="form-control" placeholder="Admin Name" value="<?php echo $username?>" name="name">
		</div>


		<div class="form-group input-group">
			<span class="input-group-addon">Password</span>
			<input type="password" class="form-control" placeholder="Admin Password" name="password">
		</div>
		<button type="submit" class="btn btn-primary pull-right" onclick="Travel.adminSave(event)">Save settings</button>
	</form>
</div>