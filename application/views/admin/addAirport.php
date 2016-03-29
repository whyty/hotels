<?php require_once(ROOT . DS . 'application' . DS . 'views' . DS . 'admin' . DS . 'topMenu.php' ); ?>
<div class="col-lg-6">
	<form role="form" action="/admin/insertAirport" method="post">
		<input type="hidden" name="id" value="<?php echo $airport ? $airport['id'] : '' ?>" />
		<div class="form-group input-group">
			<span class="input-group-addon">Name</span>
			<input type="text" class="form-control" placeholder="Airport Name" value="<?php echo $airport ?  $airport['name'] : '' ?>" name="name" required>
		</div>
		<div class="form-group input-group">
		    <span class="input-group-addon custom-label">Country</span>
		    <select class="form-control" name="country" required>
			<option value="">Select country</option>
			<?php foreach ($countries as $country) : ?>
			<option <?php if ($airport && $airport['country'] == $country['name']) echo 'selected="selected"' ?> value="<?php echo $country['name'] ?>"><?php echo $country['name'] ?></option>
			<?php endforeach; ?>
		    </select>
		</div>
		<button type="submit" class="btn btn-primary pull-right">Save airport</button>
	</form>
</div>
