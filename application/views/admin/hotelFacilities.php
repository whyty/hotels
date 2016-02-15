<?php require_once(ROOT . DS . 'application' . DS . 'views' . DS . 'admin' . DS . 'topMenu.php' ); ?>
<div class="col-lg-6">
    <div class="form-group">
        <button type="button" class="btn btn-info" id="add_data">
            <span>Add facility</span>
        </button>

        <div class="add_data hide">
            <form role="form" action="/admin/insertFacility" method="post" id="facilityForm">
            <input type="hidden" name="id" value="" />
            <input type="hidden" name="hotel_id" value="<?php echo $hotelId ?>" />
            <div class="form-group input-group">
                <span class="input-group-addon custom-label">Facility name</span>
                <input type="text" class="form-control" placeholder="Facility name" value="" name="name" required>
            </div>
            <div class="form-group input-group">
                <span class="input-group-addon custom-label">Facility option</span>
		<select class="form-control" name="option" required>
		    <option value="">Select option</option>
		    <option value="available">Available</option>
		    <option value="unavailable">Unavailable</option>
		</select>
            </div>
            <div class="btn-toolbar">
                <button type="submit" class="btn btn-primary pull-right">Save facility</button>
                <button class="btn btn-default pull-right" onclick="window.location.reload()">Cancel</button>
            </div>
            </form>
        </div>


        <ul class="list-group">
        <?php foreach ($facilities as $facility): ?>
            <?php if ($facility['hotel_id'] == $hotelId) : ?>
                <li class="list-group-item time-item">
                    <div class="checkbox-inline">
                        <?php echo $facility['name'] . ": " . $facility['option'] ?>
                    </div>
                    <div class="pull-right action-buttons">
                        <a href="#" class="item"><span class="glyphicon glyphicon-pencil" onclick="Travel.dataEdit(event, '#facilityForm')" data-edit='<?php echo json_encode($facility)?>'></span></a>
                        <a href="/admin/deleteFacility/<?php echo $facility['id'] ?>" class="trash item" onclick="Travel.confirmDelete(event)"><span class="glyphicon glyphicon-trash"></span></a>
                    </div>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
        </ul>
    </div> 
</div>
