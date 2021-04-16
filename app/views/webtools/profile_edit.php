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
          <label>Name</label>
          <input type="text" name="name" class="form-control" placeholder="Name" required="" value="<?php echo $admin->name ?>">
        </div>

        <div class="form-group">
          <label>Username</label>
          <input type="text" name="username" class="form-control" placeholder="Username" required="" value="<?php echo $admin->username ?>" readonly disabled>
        </div>

        <div class="form-group">
          <label for="group">Role</label>
          <select class="form-control" name="group" readonly disabled>
            <?php foreach ($group as $v): ?>
            <option value="<?php echo $v->id ?>" <?php echo $admin->group==$v->id ? 'selected' :'' ?> ><?php echo $v->name ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <?php if ($admin->group == 4) { ?>
        <div class="form-group">
          <label>Bio</label>
          <textarea class="form-control" name="bio" id="descrip" rows="5" required=""> <?php echo $admin->bio ?> </textarea>
        </div>

        <?php if(!empty($admin->image)): ?>
        <div class="form-group">
          <img width="200px" class="img-responsive" src="<?php echo base_url('uploads/expert/'.$admin->image) ?>">
        </div>
        <?php endif; ?>

        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image">
            <span class="help-block">Hanya JPG atau PNG, Maksimal 2MB, rekomendasi 433x650 pixel. Untuk kompres ukuran gambar silahkan di <a target="_blank" href="https://tinypng.com">https://tinypng.com</a></span>
        </div>
        <?php } ?>

      </div>
  
  </div>
</div>
</div>

<div>
  <button class="btn btn-danger" type="submit">Edit</button>
</div>
</form>