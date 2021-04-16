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
                    <label>Message</label>
                    <input type="text" name="message" class="form-control" placeholder="Message" required="">
                </div>
                
                <!-- <div class="form-group">
                     <label>Image</label>
                    <input type="file" name="image" required="">
                    <span class="help-block">JPG or PNG only, max 2MB, recommended 433x650 pixel. To compress image size, please visit <a target="_blank" href="https://tinypng.com">https://tinypng.com</a></span>
                </div> -->

                <div class="form-group">
                    <label>Click Url</label>
                    <input type="text" name="url" class="form-control" placeholder="https://google.co.id" value="https://emitennews.com" required="">
                </div>

                <div class="form-group">
                    <label>Publish Date</label>
                    <input class="form-control datepick" id="inputPublishDate" name="publish_date" placeholder="Publish Date" type="text" required="">
                </div>

        </div>
    </div>
</div>
</div>

      <div>
        <button class="btn btn-success" onclick="return confirm('Are you sure you want to save this data?');"  type="submit">Save</button>
        <a class="btn btn-default" href="<?php echo base_url(ADMIN_URL.'/'.$this->router->class); ?>">Back</a>
      </div>
</form>