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
                    <label>Position</label>
                    <select class="form-control" name="position">
                    <?php foreach($adsPosition as $position):?>
                        <option value="<?php echo $position->id; ?>"><?php echo $position->name; ?></option>
                    <?php endforeach;?>
                    </select>
                </div>

                <div class="form-group">
                     <label>Image</label>
                    <input type="file" name="image" required="">
                    <span class="help-block">JPG or PNG only, max 2MB, recommended 260x235 pixel. To compress image size, please visit <a target="_blank" href="https://tinypng.com">https://tinypng.com</a></span>
                </div>

                <div class="form-group">
                    <label>Click Url</label>
                    <input type="text" name="url" class="form-control" placeholder="https://google.co.id" required="">
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