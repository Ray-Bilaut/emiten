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
                    <label>Title</label> (max 90 chars)
                    <input type="text" name="title" maxlength="90" class="form-control" placeholder="Title" required="">
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" id="descrip" name="description" rows="5" required=""> </textarea>
                </div>

                <div class="form-group">
                     <label>Thumbnail</label>
                    <input type="file" name="thumb" required="">
                    <span class="help-block">JPG or PNG only, max 2MB, recommended 244x430 pixel. To compress image size, please visit <a target="_blank" href="https://tinypng.com">https://tinypng.com</a></span>
                </div>

                <div class="form-group">
                     <label>Image</label>
                    <input type="file" name="image" required="">
                    <span class="help-block">JPG or PNG only, max 2MB, recommended 244x430 pixel. To compress image size, please visit <a target="_blank" href="https://tinypng.com">https://tinypng.com</a></span>
                </div>

                <div class="form-group">
                     <label>Mobile Image</label>
                    <input type="file" name="image_mobile" required="">
                    <span class="help-block">JPG or PNG only, max 2MB, recommended 244x430 pixel. To compress image size, please visit <a target="_blank" href="https://tinypng.com">https://tinypng.com</a></span>
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
                    <label>Tags</label> (Tag separate by comma, without "#")
                    <input type="text" name="tags" class="form-control" placeholder="money, investment, economy syaria">
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

<!-- <script type="text/javascript">
  CKEDITOR.replace("descrip1");
</script> -->