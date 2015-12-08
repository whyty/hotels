<?php require_once(ROOT . DS . 'application' . DS . 'views' . DS . 'admin' . DS . 'topMenu.php' ); ?>
<div class="col-lg-6">
	<form role="form" action="/admin/insertInterval" method="post">
		<input type="hidden" name="id" value="<?php echo isset($interval) ? $interval['id'] : '' ?>" />
		<div class="form-group input-group">
			<span class="input-group-addon">From date:</span>
			<input type="text" class="form-control"  id="from_date" placeholder="From date" value="<?php echo isset($interval) ? $interval['from_date'] : '' ?>" name="from_date" required>
			<span class="input-group-addon" from-date>
				<span class="glyphicon glyphicon-calendar"></span>
			</span>
		</div>

		<div class="form-group input-group">
			<span class="input-group-addon">To date</span>
			<input type="text" class="form-control" id="to_date" placeholder="To date" value="<?php echo isset($interval) ? $interval['to_date'] : '' ?>" name="to_date" required>
			<span class="input-group-addon" to-date>
				<span class="glyphicon glyphicon-calendar"></span>
			</span>
		</div>
		<div class="form-group input-group">
			<span class="input-group-addon">Price double</span>
			<input type="number" class="form-control" placeholder="Price double" value="<?php echo isset($interval) ? $interval['price_double'] : '' ?>" name="price_double">
		</div>
		<div class="form-group input-group">
			<span class="input-group-addon">Price triple</span>
			<input type="number" class="form-control" placeholder="Price triple" value="<?php echo isset($interval) ? $interval['price_triple'] : '' ?>" name="price_triple">
		</div>
		<div class="form-group input-group">
			<span class="input-group-addon">Price plus ron</span>
			<input type="number" class="form-control" placeholder="Price plus ron" value="<?php echo isset($interval) ? $interval['price_plus_ron'] : '' ?>" name="price_plus_ron">
		</div>
		<button type="submit" class="btn btn-primary pull-right">Save interval</button>
	</form>
</div>
