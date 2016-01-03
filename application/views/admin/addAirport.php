<?php require_once(ROOT . DS . 'application' . DS . 'views' . DS . 'admin' . DS . 'topMenu.php' ); ?>
<div class="col-lg-6">
	<form role="form" action="/admin/insertAirport" method="post">
		<input type="hidden" name="id" value="<?php echo $airport ? $airport['id'] : '' ?>" />
		<div class="form-group input-group">
			<span class="input-group-addon">Name</span>
			<input type="text" class="form-control" placeholder="Airport Name" value="<?php echo $airport ?  $airport['name'] : '' ?>" name="name" required>
		</div>
		<button type="submit" class="btn btn-primary pull-right">Save airport</button>
	</form>
</div>
