<?php require_once(ROOT . DS . 'application' . DS . 'views' . DS . 'admin' . DS . 'topMenu.php' ); ?>
<div class="row">
	<table class="table table-custom">
		<thead>
			<tr class="success">
				<th>From date</th>
				<th>To date</th>
				<th>Price double</th>
				<th>Price triple</th>
				<th>Price plus ron</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($intervals as $interval):?>
			<tr>
				<td><?php echo $interval['Interval']['from_date'] ?></td>
				<td><?php echo $interval['Interval']['to_date'] ?></td>
				<td><?php echo $interval['Interval']['price_double'] ?></td>
				<td><?php echo $interval['Interval']['price_triple'] ?></td>
				<td><?php echo $interval['Interval']['price_plus_ron'] ?></td>
				<td>
					<a href="/admin/addInterval/<?php echo $interval['Interval']['id']?>" class="action"><i class="fa fa-pencil"></i></a>
					<a href="/admin/deleteInterval/<?php echo $interval['Interval']['id']?>" class="action"><i class="fa fa-trash-o"></i></a>
				</td>
			</tr>
			<?php endforeach;?>
		</tbody>
    </table>

</div>