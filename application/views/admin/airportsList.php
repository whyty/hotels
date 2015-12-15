<?php require_once(ROOT . DS . 'application' . DS . 'views' . DS . 'admin' . DS . 'topMenu.php' ); ?>
<div class="row">
	<table class="table table-custom">
		<thead>
			<tr class="success">
				<th>Name</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($airports as $airport):?>
			<tr>
				<td><?php echo $airport['name'] ?></td>
				<td>
					<a href="/admin/addAirport/<?php echo $airport['id']?>" class="action"><i class="fa fa-pencil"></i></a>
					<a href="/admin/deleteAirport/<?php echo $airport['id']?>" onclick="Travel.confirmDelete(event)" class="action"><i class="fa fa-trash-o"></i></a>
				</td>
			</tr>
			<?php endforeach;?>
		</tbody>
    </table>

</div>