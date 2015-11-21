<?php require_once(ROOT . DS . 'application' . DS . 'views' . DS . 'admin' . DS . 'topMenu.php' ); ?>
<div class="col-lg-6">
	<form role="form" action="/admin/insertHotel" method="post">
		<input type="hidden" name="id" value="<?php echo $hotel['id']?>" />
		<div class="form-group input-group">
			<span class="input-group-addon">Name</span>
			<input type="text" class="form-control" placeholder="Hotel Name" value="<?php echo $hotel['name']?>" name="name" required>
		</div>

		<div class="form-group input-group">
			<span class="input-group-addon">Stars</span>
			<input type="number" class="form-control" placeholder="Stars" value="<?php echo $hotel['stars']?>" name="stars" required>
		</div>
		<div class="form-group input-group">
			<span class="input-group-addon">Meal</span>
			<input type="text" class="form-control" placeholder="Meal" value="<?php echo $hotel['meal']?>" name="meal">
		</div>
		<button type="submit" class="btn btn-primary pull-right">Save hotel</button>
	</form>
</div>

