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
				<td><?php echo $hotel['name'] ?></td>
				<td>
					<?php if($hotel['stars'] > 0) :?>
						<?php for($i = 0; $i < $hotel['stars']; $i++):?>
							<i class="fa fa-star star-colored"></i>
						<?php endfor;?>
					<?php endif;?>
				</td>
				<td><?php echo $hotel['meal']?></td>
				<td>
					<a href="/admin/addHotel/<?php echo $hotel['id']?>" class="action" title="Edit hotel"><i class="fa fa-pencil"></i></a>
					<a href="/admin/hotelIntervals/<?php echo $hotel['id']?>" class="action" title="Hotel intervals"><i class="fa fa-clock-o"></i></a>
					<a href="/admin/deleteHotel/<?php echo $hotel['id']?>" onclick="Travel.confirmDelete(event)" class="action" title="Delete hotel"><i class="fa fa-trash-o"></i></a>
				</td>
			</tr>
			<?php endforeach;?>
		</tbody>
    </table>

</div>