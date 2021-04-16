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
                    <label>Parent</label>
                    <select class="form-control" name="parent_id">
                    <option value="0">-</option>
                    <?php foreach($categories as $category):?>
                        <option value="<?php echo $category->id; ?>"><?php echo $category->title; ?></option>
                    <?php endforeach;?>
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