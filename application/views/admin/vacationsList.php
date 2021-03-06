<?php require_once(ROOT . DS . 'application' . DS . 'views' . DS . 'admin' . DS . 'topMenu.php' ); ?>
<div class="row">
    <div class="alert-group">
	<button class="btn btn-primary export">Export</button>
    </div>
    <div class="alert-group export-alert hide">
	<div class="alert alert-success">
	    <a href="/download.php" class="btn btn-xs btn-success export-link pull-right">Download XML file</a>
	    <strong>Succes:</strong> Your selection was exported.
	</div>
    </div>


    <table class="table table-custom" cellspacing="0" width="100%" data-table>
        <thead>
            <tr class="success">
                <th>#</th>
                <th>Title</th>
                <th>Country</th>
                <th>City</th>
                <th>Currency</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class='collection'></tbody>
    </table>
</div>
<?php require_once (ROOT . DS . 'application' . DS . 'views' . DS . 'admin' . DS . 'paginationTemplate.php' ); ?>