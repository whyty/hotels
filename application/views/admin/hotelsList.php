<?php require_once(ROOT . DS . 'application' . DS . 'views' . DS . 'admin' . DS . 'topMenu.php' ); ?>
<div class="row">
	<table class="table table-custom">
		<thead>
			<tr class="success">
				<th>#</th>
				<th>Hotel name</th>
				<th>Stars</th>
				<th>Meal</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($hotels as $hotel):?>
			<tr>
				<th scope="row">
					<input type="checkbox" value="1" name="selecHotel" />
				</th>
				<td><?php echo $hotel['Hotel']['name'] ?></td>
				<td>
					<?php if($hotel['Hotel']['stars'] > 0) :?>
						<?php for($i = 0; $i < $hotel['Hotel']['stars']; $i++):?>
							<i class="fa fa-star star-colored"></i>
						<?php endfor;?>
					<?php endif;?>
				</td>
				<td><?php echo $hotel['Hotel']['meal']?></td>
				<td>
					<a href="/admin/addHotel/<?php echo $hotel['Hotel']['id']?>" class="action"><i class="fa fa-pencil"></i></a>
					<a href="/admin/deleteHotel/<?php echo $hotel['Hotel']['id']?>" class="action"><i class="fa fa-trash-o"></i></a>
				</td>
			</tr>
			<?php endforeach;?>
		</tbody>
    </table>

</div>