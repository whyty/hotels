<?php require_once(ROOT . DS . 'application' . DS . 'views' . DS . 'admin' . DS . 'topMenu.php' ); ?>
<div class="row">
    <table class="table table-custom">
        <thead>
            <tr class="success">
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