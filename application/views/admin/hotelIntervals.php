<?php require_once(ROOT . DS . 'application' . DS . 'views' . DS . 'admin' . DS . 'topMenu.php' ); ?>
<div class="col-lg-6">
    <div class="form-group">
        <div class="btn-toolbar">
            <p>Time intervals</p>
        </div>
        <button type="button" class="btn btn-info" id="add_data">
            <span>Add time interval</span>
        </button>

        <div class="add_data hide">
            <form role="form" action="/admin/insertInterval" method="post" id="intervalForm">
            <input type="hidden" name="id" value="" />
            <input type="hidden" name="hotel_id" value="<?php echo $hotelId ?>" />
            <div class="form-group input-group">
                <span class="input-group-addon custom-label">From date:</span>
                <input type="text" class="form-control"  id="from_date" placeholder="From date" value="" name="from_date" required>
                <span class="input-group-addon" from-date>
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>

            <div class="form-group input-group">
                <span class="input-group-addon custom-label">To date</span>
                <input type="text" class="form-control" id="to_date" placeholder="To date" value="" name="to_date" required>
                <span class="input-group-addon" to-date>
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
            <div class="form-group input-group">
                <span class="input-group-addon custom-label">Price double</span>
                <input type="number" class="form-control" placeholder="Price double" value="" name="price_double" required>
            </div>
            <div class="form-group input-group">
                <span class="input-group-addon custom-label">Price triple</span>
                <input type="number" class="form-control" placeholder="Price triple" value="" name="price_triple" required>
            </div>
            <div class="form-group input-group">
                <span class="input-group-addon custom-label">Price plus ron</span>
                <input type="number" class="form-control" placeholder="Price plus ron" value="" name="price_plus_ron" required>
            </div>
            <div class="btn-toolbar">
                <button type="submit" class="btn btn-primary pull-right">Save interval</button>
                <button class="btn btn-default pull-right" onclick="window.location.reload()">Cancel</button>
            </div>
            </form>
        </div>


        <ul class="list-group">
        <?php foreach ($intervals as $interval): ?>
            <?php if ($interval['hotel_id'] == $hotelId) : ?>
                <li class="list-group-item time-item">
                    <div class="checkbox-inline">
                        <?php echo $interval['from_date'] . " -> " . $interval['to_date'] ?>
                    </div>
                    <div class="pull-right action-buttons">
                        <a href="#" class="item"><span class="glyphicon glyphicon-pencil" onclick="Travel.dataEdit(event, '#intervalForm')" data-edit='<?php echo json_encode($interval)?>'></span></a>
                        <a href="/admin/deleteInterval/<?php echo $interval['id'] ?>" class="trash item" onclick="Travel.confirmDelete(event)"><span class="glyphicon glyphicon-trash"></span></a>
                    </div>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
        </ul>
    </div> 
</div>
