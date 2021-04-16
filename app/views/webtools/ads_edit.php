<form enctype="multipart/form-data" role="form" method="POST" action="<?php echo site_url(ADMIN_URL."/{$this->router->class}/editprocess/{$id}"); ?>">
<div class="row">
<div class="col-xs-12">

    <?php if($error=='error'): ?>
    <div class="alert alert-warning alert-dismissible">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    <h4><i class="icon fa fa-warning"></i> Warning!</h4>
    <?php echo $error_msg; ?>
    </div>
    <?php elseif($error=='success'): ?>
    <div class="alert alert-success alert-dismissible">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    <h4><i class="icon fa fa-check"></i> Success!</h4>
    <?php echo $success_msg; ?>
    </div>
    <?php endif; ?>

  <div class="box box-primary">
      
      <div class="box-body">

        <div class="form-group">
          <label>Title</label> (max 90 chars)
          <input type="text" name="title" class="form-control" maxlength="90" placeholder="Title" required="" value="<?php echo $data->title ?>">
        </div>

        <div class="form-group">
            <label>Position</label>
            <select class="form-control" name="position">
            <?php foreach($adsPosition as $position):?>
                <option value="<?php echo $position->id; ?>" <?php echo $position->id == $data->position_id ? 'selected' : '' ?>><?php echo $position->name; ?></option>
            <?php endforeach;?>
            </select>
        </div>

        <?php if(!empty($data->image)): ?>
        <div class="form-group">
          <img width="200px" class="img-responsive" src="<?php echo base_url('uploads/ads/'.$data->image) ?>">
        </div>
        <?php endif; ?>

        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image">
            <span class="help-block">JPG or PNG only, max 2MB, recommended 260x235 pixel. To compress image size, please visit <a target="_blank" href="https://tinypng.com">https://tinypng.com</a></span>
        </div>

        <div class="form-group">
            <label>Click Url</label>
            <input type="text" name="url" class="form-control" placeholder="https://google.co.id" value="<?php echo $data->url ?>" required="">
        </div>

        <div class="form-group">
          <label>Active</label>
          <select class="form-control" name="is_active">
            <option value="0" <?php echo $data->is_active==0 ? 'selected' : '' ?> >No</option>
            <option value="1" <?php echo $data->is_active==1 ? 'selected' : '' ?> >Yes</option>
          </select>
        </div>

      </div>
  
  </div>
</div>
</div>

<div>
  <button class="btn btn-danger" type="submit">Edit</button>
  <a class="btn btn-default" href="<?php echo base_url(ADMIN_URL.'/'.$this->router->class); ?>">Back</a>
</div>
</form>