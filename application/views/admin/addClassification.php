<?php require_once(ROOT . DS . 'application' . DS . 'views' . DS . 'admin' . DS . 'topMenu.php' ); ?>
<div class="col-lg-6">
	<form role="form" action="/admin/insertClassification" method="post">
		<input type="hidden" name="id" value="<?php echo isset($clasif) ? $clasif['id'] : '' ?>" />
		<div class="form-group input-group">
			<span class="input-group-addon">Name</span>
			<input type="text" class="form-control" placeholder="Classification Name" value="<?php echo isset( $clasif) ?  $clasif['name'] : '' ?>" name="name" required>
		</div>
		<button type="submit" class="btn btn-primary pull-right">Save classification</button>
	</form>
</div>

