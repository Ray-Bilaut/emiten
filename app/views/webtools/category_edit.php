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
          <label>Title</label>
          <input type="text" name="title" class="form-control" placeholder="Title" required="" value="<?php echo $data->title ?>">
        </div>

        <div class="form-group">
            <label>Parent</label>
            <select class="form-control" name="parent_id">
            <option value="0" <?php echo $data->parent_id == "0" ? 'selected' : '' ?>>-</option>
            <?php foreach($categories as $category):?>
              <option value="<?php echo $category->id; ?>" <?php echo $category->id == $data->parent_id ? 'selected' : '' ?>><?php echo $category->title; ?></option>
            <?php endforeach;?>
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