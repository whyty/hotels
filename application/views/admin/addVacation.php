<?php require_once(ROOT . DS . 'application' . DS . 'views' . DS . 'admin' . DS . 'topMenu.php' ); ?>
<div class="col-lg-6">
	<form role="form" action="/admin/insertVacation" method="post">
		<input type="hidden" name="id" value="<?php echo $vacation ? $vacation['id'] : '' ?>" />
		<div class="form-group input-group">
			<span class="input-group-addon">Live</span>
                        <select name="live" class="form-control" required>
                            <option>Select</option>
                            <option <?php if($vacation && $vacation['live'] == 1) echo 'selected="selected"'?> value="1">True</option>
                            <option <?php if($vacation && $vacation['live'] == 0) echo 'selected="selected"'?> value="0">False</option>
                        </select>
		</div>
		<div class="form-group input-group">
			<span class="input-group-addon">Title</span>
			<input type="text" class="form-control" placeholder="Vacation Title" value="<?php echo $vacation ?  $vacation['title'] : '' ?>" name="title" required>
		</div>
		<div class="form-group input-group">
			<span class="input-group-addon">Nights</span>
			<input type="text" class="form-control" placeholder="Vacation Nights" value="<?php echo $vacation ?  $vacation['nights'] : '' ?>" name="nights" required>
		</div>
		<div class="form-group input-group">
			<span class="input-group-addon">Country</span>
                        <select class="form-control" name="country" required>
                            <option value="">Select country</option>
                            <?php foreach($countries as $country) :?>
                            <option <?php if($vacation && $vacation['country'] == $country['name']) echo 'selected="selected"'?> value="<?php echo $country['name']?>"><?php echo $country['name']?></option>
                            <?php endforeach; ?>
                        </select>
		</div>
		<div class="form-group input-group">
			<span class="input-group-addon">City</span>
			<input type="text" class="form-control" placeholder="Vacation City" value="<?php echo $vacation ?  $vacation['city'] : '' ?>" name="city" required>
		</div>
		<div class="form-group input-group">
			<span class="input-group-addon">Description</span>
                        <textarea class="form-control"  name="description" rows="5"><?php echo $vacation ?  $vacation['description'] : '' ?></textarea>
		</div>
		<div class="form-group input-group">
			<span class="input-group-addon">Transportation</span>
                        <input type="text" class="form-control" placeholder="Vacation Transportation" value="<?php echo $vacation ?  $vacation['transportation'] : '' ?>" name="transportation" required>
		</div>
                
                <?php if(count($airports) > 0) :?>
                <div class="form-group input-group">
			<span class="input-group-addon">Airports</span>
                        <select id="airport" class="multiselect form-control" name="airports[]" multiple>
				<?php foreach($airports as $airport): ?>
					<option value="<?php echo $airport['id'];?>" <?php echo ($selectedAirports && in_array($airport['id'], $selectedAirports)) ? 'selected="selected"' : ''?>><?php echo $airport['name']?></option>
				<?php endforeach; ?>
			</select>
		</div>
                <?php endif; ?>
		<div class="form-group input-group">
			<span class="input-group-addon">Departure</span>
			<input type="text" class="form-control" placeholder="Vacation Departure" value="<?php echo $vacation ?  $vacation['departure'] : '' ?>" name="departure" required>
		</div>
		<div class="form-group input-group">
			<span class="input-group-addon">Included services</span>
			<input type="text" class="form-control" placeholder="Vacation included services" value="<?php echo $vacation ?  $vacation['included_services'] : '' ?>" name="included_services" required>
		</div>
		<div class="form-group input-group">
			<span class="input-group-addon">Additional services</span>
			<input type="text" class="form-control" placeholder="Vacation additional services" value="<?php echo $vacation ?  $vacation['additional_services'] : '' ?>" name="additional_services" required>
		</div>
		<div class="form-group input-group">
			<span class="input-group-addon">Currency</span>
			<input type="text" class="form-control" placeholder="Vacation currency" value="<?php echo $vacation ?  $vacation['currency'] : '' ?>" name="currency" required>
		</div>
		<div class="form-group input-group">
			<span class="input-group-addon">All taxes</span>
                        <select name="all_taxes" class="form-control" required>
                            <option>Select</option>
                            <option <?php if($vacation && $vacation['all_taxes'] == 1){echo 'selected="selected"';}else{echo '';}?> value="1">True</option>
                            <option <?php if($vacation && $vacation['all_taxes'] == 0){echo 'selected="selected"';}else{echo '';}?> value="0">False</option>
                        </select>
		</div>
                <div class="form-group input-group">
			<span class="input-group-addon">Validity</span>
			<input type="text" class="form-control" placeholder="Vacation availability" value="<?php echo $vacation ?  $vacation['availability'] : '' ?>" name="availability" required>
		</div>
                <?php if(count($themes) > 0) :?>
                <div class="form-group input-group">
			<span class="input-group-addon">Themes</span>
                        <select id="theme" class="multiselect form-control" name="themes[]" multiple>
				<?php foreach($themes as $theme): ?>
                                        <option value="<?php echo $theme['id'];?>" <?php echo ($selectedThemes && in_array($theme['id'], $selectedThemes)) ? 'selected="selected"' : ''?>><?php echo $theme['name']?></option>
				<?php endforeach; ?>
			</select>
		</div>
                <?php endif; ?>
                <?php if(count($hotels) > 0) :?>
                <div class="form-group input-group">
			<span class="input-group-addon">Hotels</span>
                        <select id="theme" class="multiselect form-control" name="hotels[]" multiple>
				<?php foreach($hotels as $hotel): ?>
					<option value="<?php echo $hotel['id'];?>" <?php echo ($selectedHotels && in_array($hotel['id'], $selectedHotels)) ? 'selected="selected"' : ''?>><?php echo $hotel['name']?></option>
				<?php endforeach; ?>
			</select>
		</div>
                <?php endif; ?>
                <?php if(count($classifications) > 0) :?>
                <div class="form-group input-group">
			<span class="input-group-addon">Classifications</span>
                        <select id="theme" class="multiselect form-control" name="classifications[]" multiple>
				<?php foreach($classifications as $classification): ?>
					<option value="<?php echo $classification['id'];?>" <?php echo ($selectedClassifications && in_array($classification['id'], $selectedClassifications)) ? 'selected="selected"' : ''?>><?php echo $classification['name']?></option>
				<?php endforeach; ?>
			</select>
		</div>
                <?php endif; ?>
		<button type="submit" class="btn btn-primary pull-right">Save vacation</button>
	</form>
</div>
