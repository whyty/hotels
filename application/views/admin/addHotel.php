<?php require_once(ROOT . DS . 'application' . DS . 'views' . DS . 'admin' . DS . 'topMenu.php' ); ?>
<div class="col-lg-6">
	<form role="form" action="/admin/insertHotel" method="post">
		<input type="hidden" name="id" value="<?php echo $hotel ? $hotel['id'] : '' ?>" />
		<div class="form-group input-group">
			<span class="input-group-addon">Name</span>
			<input type="text" class="form-control" placeholder="Hotel Name" value="<?php echo $hotel ? $hotel['name'] : '' ?>" name="name" required>
		</div>

		<div class="form-group input-group">
			<span class="input-group-addon">Stars</span>
			<input type="number" class="form-control" placeholder="Stars" value="<?php echo $hotel? $hotel['stars'] : '' ?>" name="stars" required>
		</div>
		<div class="form-group input-group">
			<span class="input-group-addon">Meal</span>
			<input type="text" class="form-control" placeholder="Meal" value="<?php echo $hotel ? $hotel['meal'] : '' ?>" name="meal">
		</div>
		<?php if(count($intervals) > 0) :?>
		<div class="form-group">
			<label for="intervals">Time intervals</label>
			<select id="intervals" class="form-control" name="intervals[]" multiple>
				<option>Select interval</option>
				<?php foreach($intervals as $interval): ?>
					<option value="<?php echo $interval['id'];?>" <?php echo in_array($interval['id'], $period) ? "selected='selected'" : '';?>><?php echo $interval['from_date'] . " -> " . $interval['to_date']?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<?php endif; ?>
		<button type="submit" class="btn btn-primary pull-right">Save hotel</button>
	</form>
</div>

