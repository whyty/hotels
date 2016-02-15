<?php require_once(ROOT . DS . 'application' . DS . 'views' . DS . 'admin' . DS . 'topMenu.php' ); ?>
<div class="col-lg-6">
    <form role="form" action="/admin/insertHotel" method="post">
	<fieldset>
	    <input type="hidden" name="id" value="<?php echo $hotel ? $hotel['id'] : '' ?>" />
	    <div class="form-group input-group">
		<span class="input-group-addon custom-label">Name</span>
		<input type="text" class="form-control" placeholder="Hotel Name" value="<?php echo $hotel ? $hotel['name'] : '' ?>" name="name" required>
	    </div>

	    <div class="form-group input-group">
		<span class="input-group-addon custom-label">Stars</span>
		<input type="number" class="form-control" placeholder="Stars" value="<?php echo $hotel ? $hotel['stars'] : '' ?>" name="stars" required>
	    </div>
	    <div class="form-group input-group">
		<span class="input-group-addon custom-label">Country</span>
		<select class="form-control" name="country" required>
		    <option value="">Select country</option>
		    <?php foreach ($countries as $country) : ?>
    		    <option <?php if ($hotel && $hotel['country'] == $country['name']) echo 'selected="selected"' ?> value="<?php echo $country['name'] ?>"><?php echo $country['name'] ?></option>
		    <?php endforeach; ?>
		</select>
	    </div>
	    <div class="form-group input-group">
		<span class="input-group-addon custom-label">City</span>
		<input type="text" class="form-control" placeholder="City" value="<?php echo $hotel ? $hotel['city'] : '' ?>" name="city">
	    </div>
	    <div class="form-group input-group">
		<span class="input-group-addon custom-label">Meal</span>
		<input type="text" class="form-control" placeholder="Meal" value="<?php echo $hotel ? $hotel['meal'] : '' ?>" name="meal">
	    </div>
	    <div id="legend" class="legend">
		<legend class="">Extra information</legend>
	    </div>
	    <div class="form-group input-group">
		<span class="input-group-addon custom-label">Latitude</span>
		<input type="text" class="form-control" placeholder="Latitude" value="<?php echo $hotel ? $hotel['latitude'] : '' ?>" name="latitude">
	    </div>
	    <div class="form-group input-group">
		<span class="input-group-addon custom-label">Longitude</span>
		<input type="text" class="form-control" placeholder="Longitude" value="<?php echo $hotel ? $hotel['longitude'] : '' ?>" name="longitude">
	    </div>
	    <div class="form-group input-group">
		<span class="input-group-addon custom-label">Location</span>
		<textarea class="form-control" name="location" rows="3"><?php echo $hotel ? $hotel['location'] : '' ?></textarea>
	    </div>
	    <div class="form-group input-group">
		<span class="input-group-addon custom-label">Phone</span>
		<input type="text" class="form-control" placeholder="Phone" value="<?php echo $hotel ? $hotel['phone'] : '' ?>" name="phone">
	    </div>
	    <div class="form-group input-group">
		<span class="input-group-addon custom-label">E-mail</span>
		<input type="text" class="form-control" placeholder="E-mail" value="<?php echo $hotel ? $hotel['email'] : '' ?>" name="email">
	    </div>
	    <div class="form-group input-group">
		<span class="input-group-addon custom-label">Web</span>
		<input type="text" class="form-control" placeholder="Web" value="<?php echo $hotel ? $hotel['web'] : '' ?>" name="web">
	    </div>
	    <div class="form-group input-group">
		<span class="input-group-addon custom-label">Facebook</span>
		<input type="text" class="form-control" placeholder="Facebook" value="<?php echo $hotel ? $hotel['facebook'] : '' ?>" name="facebook">
	    </div>
	    <div class="form-group input-group">
		<span class="input-group-addon custom-label">Google Plus</span>
		<input type="text" class="form-control" placeholder="Google Plus" value="<?php echo $hotel ? $hotel['gplus'] : '' ?>" name="gplus">
	    </div>
	    <div class="form-group input-group">
		<span class="input-group-addon custom-label">Twitter</span>
		<input type="text" class="form-control" placeholder="Twitter" value="<?php echo $hotel ? $hotel['twitter'] : '' ?>" name="twitter">
	    </div>
	    <button type="submit" class="btn btn-primary pull-right">Save hotel</button>
	</fieldset>
    </form>
</div>

