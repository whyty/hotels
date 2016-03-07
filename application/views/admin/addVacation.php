<?php require_once(ROOT . DS . 'application' . DS . 'views' . DS . 'admin' . DS . 'topMenu.php' ); ?>
<div class="col-lg-6">
    <div class="panel with-nav-tabs panel-default">
	<div class="panel-heading">
	    <ul class="nav nav-tabs">
		<li class="active"><a href="#tab1default" data-toggle="tab">Add or Edit</a></li>
		<li><a href="#tab2default" data-toggle="tab">Import</a></li>
	    </ul>
	</div>
	<div class="panel-body">
	    <div class="tab-content">
		<div class="tab-pane fade in active" id="tab1default">
		    <form role="form" action="/admin/insertVacation" method="post">
			<input type="hidden" name="id" value="<?php echo $vacation ? $vacation['id'] : '' ?>" />
			<div class="form-group input-group">
			    <span class="input-group-addon custom-label">Live</span>
			    <select name="live" class="form-control" required>
				<option>Select</option>
				<option <?php if ($vacation && $vacation['live'] == 1) echo 'selected="selected"' ?> value="1">True</option>
				<option <?php if ($vacation && $vacation['live'] == 0) echo 'selected="selected"' ?> value="0">False</option>
			    </select>
			</div>
			<div class="form-group input-group">
			    <span class="input-group-addon custom-label">Title</span>
			    <input type="text" class="form-control" placeholder="Vacation Title" value="<?php echo $vacation ? $vacation['title'] : '' ?>" name="title" required>
			</div>
			<div class="form-group input-group">
			    <span class="input-group-addon custom-label">Nights</span>
			    <input type="text" class="form-control" placeholder="Vacation Nights" value="<?php echo $vacation ? $vacation['nights'] : '' ?>" name="nights" required>
			</div>
			<div class="form-group input-group">
			    <span class="input-group-addon custom-label">Country</span>
			    <select class="form-control" id="vacationCountry" name="country" required>
				<option value="">Select country</option>
				<?php foreach ($countries as $country) : ?>
    				<option <?php if ($vacation && $vacation['country'] == $country['name']) echo 'selected="selected"' ?> value="<?php echo $country['name'] ?>"><?php echo $country['name'] ?></option>
				<?php endforeach; ?>
			    </select>
			</div>
			<div class="form-group input-group">
			    <span class="input-group-addon custom-label">City</span>
			    <input type="text" class="form-control" placeholder="Vacation City" value="<?php echo $vacation ? $vacation['city'] : '' ?>" name="city" required>
			</div>
			<div class="form-group input-group">
			    <span class="input-group-addon custom-label">Description</span>
			    <textarea class="form-control"  name="description" rows="5"><?php echo $vacation ? $vacation['description'] : '' ?></textarea>
			</div>
			<div class="form-group input-group">
			    <span class="input-group-addon custom-label">Transportation</span>
			    <input type="text" class="form-control" placeholder="Vacation Transportation" value="<?php echo $vacation ? $vacation['transportation'] : '' ?>" name="transportation" required>
			</div>

			<?php if (count($airports) > 0) : ?>
    			<div class="form-group input-group">
    			    <span class="input-group-addon custom-label">Airports</span>
    			    <select id="airport" class="multiselect form-control" name="airports[]" multiple>
				    <?php foreach ($airports as $airport): ?>
					<option value="<?php echo $airport['id']; ?>" <?php echo ($selectedAirports && in_array($airport['id'], $selectedAirports)) ? 'selected="selected"' : '' ?>><?php echo $airport['name'] ?></option>
				    <?php endforeach; ?>
    			    </select>
    			</div>
			<?php endif; ?>
			<div class="form-group input-group">
			    <span class="input-group-addon custom-label">Departure</span>
			    <input type="text" class="form-control" placeholder="Vacation Departure" value="<?php echo $vacation ? $vacation['departure'] : '' ?>" name="departure" required>
			</div>
			<div class="form-group input-group">
			    <span class="input-group-addon custom-label">Included services</span>
			    <input type="text" class="form-control" placeholder="Vacation included services" value="<?php echo $vacation ? $vacation['included_services'] : '' ?>" name="included_services" required>
			</div>
			<div class="form-group input-group">
			    <span class="input-group-addon custom-label">Additional services</span>
			    <input type="text" class="form-control" placeholder="Vacation additional services" value="<?php echo $vacation ? $vacation['additional_services'] : '' ?>" name="additional_services" required>
			</div>
			<div class="form-group input-group">
			    <span class="input-group-addon custom-label">Currency</span>
			    <input type="text" class="form-control" placeholder="Vacation currency" value="<?php echo $vacation ? $vacation['currency'] : '' ?>" name="currency" required>
			</div>
			<div class="form-group input-group">
			    <span class="input-group-addon custom-label">All taxes</span>
			    <select name="all_taxes" class="form-control" required>
				<option>Select</option>
				<option <?php if ($vacation && $vacation['all_taxes'] == 1) {
			    echo 'selected="selected"';
			} else {
			    echo '';
			} ?> value="1">True</option>
				<option <?php if ($vacation && $vacation['all_taxes'] == 0) {
			    echo 'selected="selected"';
			} else {
			    echo '';
			} ?> value="0">False</option>
			    </select>
			</div>
			<div class="form-group input-group">
			    <span class="input-group-addon custom-label">Validity</span>
			    <input type="text" class="form-control" placeholder="Vacation availability" value="<?php echo $vacation ? $vacation['availability'] : '' ?>" name="availability" required>
			</div>
			<?php if (count($themes) > 0) : ?>
    			<div class="form-group input-group">
    			    <span class="input-group-addon custom-label">Themes</span>
    			    <select class="multiselect form-control" name="themes[]" multiple>
				    <?php foreach ($themes as $theme): ?>
					<option value="<?php echo $theme['id']; ?>" <?php echo ($selectedThemes && in_array($theme['id'], $selectedThemes)) ? 'selected="selected"' : '' ?>><?php echo $theme['name'] ?></option>
				    <?php endforeach; ?>
    			    </select>
    			</div>
			<?php endif; ?>
			<?php if (count($hotels) > 0) : ?>
    			<div class="form-group input-group">
    			    <span class="input-group-addon custom-label">Hotels</span>
    			    <select id="vacationHotels" class="form-control" name="hotels[]" multiple>
				    <?php foreach ($hotels as $hotel): ?>
					<option value="<?php echo $hotel['id']; ?>" <?php echo ($selectedHotels && in_array($hotel['id'], $selectedHotels)) ? 'selected="selected"' : '' ?>><?php echo $hotel['name'] ?></option>
				    <?php endforeach; ?>
    			    </select>
    			</div>
			<?php endif; ?>
			<?php if (count($classifications) > 0) : ?>
    			<div class="form-group input-group">
    			    <span class="input-group-addon custom-label">Classifications</span>
    			    <select class="multiselect form-control" name="classifications[]" multiple>
				<?php foreach ($classifications as $classification): ?>
					<option value="<?php echo $classification['id']; ?>" <?php echo ($selectedClassifications && in_array($classification['id'], $selectedClassifications)) ? 'selected="selected"' : '' ?>><?php echo $classification['name'] ?></option>
				<?php endforeach; ?>
    			    </select>
    			</div>
			<?php endif; ?>
			<button type="submit" class="btn btn-primary pull-right">Save vacation</button>
		    </form>
		</div>
		<div class="tab-pane fade" id="tab2default">
		    <?php if($errors) :?>
		    <div class="alert-group">
			<div class="alert alert-danger alert-autocloseable-danger">
			    <strong>Error:</strong> <?php echo $errors?>
			</div>
		    </div>
		    <?php endif; ?>
		    <form role="form" action="/admin/importData" method="post" enctype="multipart/form-data">
			<div class="form-group">
			    <label>XML file:</label>
			    <input type="file" class="form-control"  value="" name="file" required>
			</div>

			<div class="btn-toolbar">
			    <button type="submit" name="submit" class="btn btn-primary pull-right">Import data</button>
			    <button class="btn btn-default pull-right" onclick="window.location.reload()">Cancel</button>
			</div>
		    </form>
		</div>
	    </div>
	</div>
    </div
</div>
