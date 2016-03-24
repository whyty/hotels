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
        <tbody>
	    <?php foreach ($vacations as $vacation): ?>
    	    <tr>
    		<td><input type="checkbox" name="vacationSelected[]" value="<?php echo $vacation['id'] ?>"/></td>
    		<td><?php echo $vacation['title'] ?></td>
    		<td><?php echo $vacation['country'] ?></td>
    		<td><?php echo $vacation['city'] ?></td>
    		<td><?php echo $vacation['currency'] ?></td>
    		<td>
    		    <a href="/admin/addVacation/<?php echo $vacation['id'] ?>" class="action"><i class="fa fa-pencil"></i></a>
    		    <a href="/admin/vacationPhotos/<?php echo $vacation['id'] ?>" class="action"><i class="fa fa-picture-o"></i></a>
    		    <a href="/admin/deleteVacation/<?php echo $vacation['id'] ?>" onclick="Travel.confirmDelete(event)" class="action"><i class="fa fa-trash-o"></i></a>
    		</td>
    	    </tr>
	    <?php endforeach; ?>
        </tbody>
    </table>

</div>