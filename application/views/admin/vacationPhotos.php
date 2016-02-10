<?php require_once(ROOT . DS . 'application' . DS . 'views' . DS . 'admin' . DS . 'topMenu.php' ); ?>
<div class="col-lg-6">
    <div class="form-group">
        <div class="btn-toolbar">
            <p>Photos</p>
        </div>
        <button type="button" class="btn btn-info" id="add_data">
            <span>Add photo</span>
        </button>

        <div class="add_data hide">
            <form role="form" action="/admin/savePhoto" method="post" id="intervalForm" enctype="multipart/form-data">
                <input type="hidden" name="vacation_id" value="<?php echo $vacation_id ?>" />
                <div class="form-group">
                    <label>Photo:</label>
                    <input type="file" class="form-control"  value="" name="photo" required>
                </div>

                <div class="btn-toolbar">
                    <button type="submit" name="submit" class="btn btn-primary pull-right">Save photo</button>
                    <button class="btn btn-default pull-right" onclick="window.location.reload()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <?php foreach ($photos as $photo): ?>
            <?php if ($photo['vacation_id'] == $vacation_id && $photo['file'] != ' ') : ?>
                <div class="col-md-3">
                    <div class="thumb-wrapper">
                        <img src="<?php echo strpos($photo['file'], 'http://') !== false ? $photo['file'] : '/uploads/thumbs/'. $photo['file']?>" class="thumbnail img-responsive" />
                        <a href="/admin/deletePhoto/<?php echo $photo['id']?>" class="custom-delete"><i class="fa fa-trash-o"></i></a>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        </ul>
    </div> 
