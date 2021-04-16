<form enctype="multipart/form-data" role="form" method="POST" action="<?php echo site_url(ADMIN_URL."/{$this->router->class}/addprocess"); ?>">
<div class="row">
    <div class="col-xs-12">

        <?php if($error!=''): ?>
            <div class="alert alert-warning alert-dismissible">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <?php echo $error_msg; ?>
            </div>
        <?php endif; ?>

        <div class="box box-primary">   
            <div class="box-body">

                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Title" required="">
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" name="description" rows="5" required=""></textarea>
                </div>

                <div class="form-group">
                    <label>ID Youtube</label>
                    <span class="help-block">Masukkan ID Youtube (yang berwarna merah), contoh: https://www.youtube.com/watch?v=<b style="color: red;"><u>cMb9axM1XxY</u></b></span>
                    <input type="text" name="youtube_id" class="form-control" maxlength="50" placeholder="ID Youtube" required="">
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <select class="form-control" name="category_id">
                    <?php foreach($categories as $x):?>
                        <option value="<?php echo $x->id; ?>"><?php echo $x->title; ?></option>
                    <?php endforeach;?>
                    </select>
                </div>

                <div class="form-group">
					<label>Publish Date</label>
					<input type="text" class="form-control datepicker" name="publish_date" placeholder="Publish Date" required>
				</div>

                <div class="form-group">
					<label>Publish Time</label>
					<input type="text" class="form-control timepicker" name="publish_time" placeholder="Publish Time" required>
				</div>

                <div class="form-group">
                    <label>Active</label>
                    <select class="form-control" name="is_active">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>

        </div>
    </div>
</div>
</div>

      <div>
        <button class="btn btn-success" type="submit">Save</button>
        <a class="btn btn-default" href="<?php echo base_url(ADMIN_URL.'/'.$this->router->class); ?>">Back</a>
      </div>
</form>