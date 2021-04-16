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
          <input type="text" name="title" class="form-control" maxlength="75" placeholder="Title" required="" value="<?php echo $data->title ?>">
        </div>

        <div class="form-group">
          <label>Description</label>
          <textarea class="form-control" name="description" rows="5" required=""> <?php echo $data->description ?> </textarea>
        </div>

        <div class="form-group">
            <label>ID Youtube</label>
            <span class="help-block">Masukkan ID Youtube (yang berwarna merah), contoh: https://www.youtube.com/watch?v=<b style="color: red;"><u>cMb9axM1XxY</u></b></span>
            <input type="text" name="youtube_id" class="form-control" maxlength="255" placeholder="Id" required="" value="<?php echo $data->youtube_id ?>">
        </div>

        <div class="form-group">
          <label>Category</label>
          <select class="form-control" name="category_id">
            <?php foreach($categories as $x):?>
              <option value="<?php echo $x->id; ?>" <?php echo $x->id == $data->category_id ? 'selected' : '' ?>><?php echo $x->title; ?></option>
            <?php endforeach;?>
          </select>
        </div>

        <div class="form-group">
					<label>Publish Date</label>
					<input type="text" class="form-control datepicker" name="publish_date" value="<?php echo (new DateTime($data->publish_date))->format('d F Y') ?>" required>
				</div>

        <div class="form-group">
					<label>Publish Time</label>
					<input type="text" class="form-control timepicker" name="publish_time" value="<?php echo (new DateTime($data->publish_date))->format('H:i') ?>" placeholder="Publish Time" required>
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