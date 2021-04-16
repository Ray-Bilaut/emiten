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
          <label>Description</label>
          <textarea class="form-control" name="description" id="descrip" rows="5" required=""> <?php echo $data->description ?> </textarea>
        </div>

        <?php if(!empty($data->file_attachment)): ?>
        <div class="form-group">
          <span><?php echo $data->file_attachment?></span>
        </div>
        <?php endif; ?>

        <div class="form-group">
            <label>File Attachment</label>
            <input type="file" name="file_attachment">
            <span class="help-block">Optional, max 5MB.</span>
        </div>

        <?php if(!empty($data->thumb)): ?>
        <div class="form-group">
          <img width="200px" class="img-responsive" src="<?php echo $data->thumb_url ?>">
        </div>
        <?php endif; ?>

        <div class="form-group">
            <label>Thumbnail</label>
            <input type="file" name="thumb">
            <span class="help-block">JPG or PNG only, max 2MB, recommended 185x130 pixel. To compress image size, please visit <a target="_blank" href="https://tinypng.com">https://tinypng.com</a></span>
        </div>

        <?php if(!empty($data->image)): ?>
        <div class="form-group">
          <img width="200px" class="img-responsive" src="<?php echo $data->image_url ?>">
        </div>
        <?php endif; ?>

        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image">
            <span class="help-block">JPG or PNG only, max 2MB, recommended 655x320 pixel. To compress image size, please visit <a target="_blank" href="https://tinypng.com">https://tinypng.com</a></span>
        </div>

        <?php if(!empty($data->image_mobile)): ?>
        <div class="form-group">
          <img width="200px" class="img-responsive" src="<?php echo $data->image_mobile_url ?>">
        </div>
        <?php endif; ?>

        <div class="form-group">
            <label>Mobile Image</label>
            <input type="file" name="image_mobile">
            <span class="help-block">JPG or PNG only, max 2MB, recommended 342x180 pixel. To compress image size, please visit <a target="_blank" href="https://tinypng.com">https://tinypng.com</a></span>
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
            <label>Tags</label> (Tag separate by comma, without "#")
            <input type="text" name="tags" class="form-control" placeholder="money, investment, economy syaria" value="<?php echo $tags; ?>">
        </div>

        <div class="form-group">
          <label>Highlight</label>
          <select class="form-control" name="is_highlight">
            <option value="0" <?php echo $data->is_highlight==0 ? 'selected' : '' ?> >No</option>
            <option value="1" <?php echo $data->is_highlight==1 ? 'selected' : '' ?> >Yes</option>
          </select>
        </div>

        <div class="form-group">
          <label>Recommendation</label>
          <select class="form-control" name="is_recommendation">
            <option value="0" <?php echo $data->is_recommendation==0 ? 'selected' : '' ?> >No</option>
            <option value="1" <?php echo $data->is_recommendation==1 ? 'selected' : '' ?> >Yes</option>
          </select>
        </div>

        <div class="form-group">
          <label>Trending</label>
          <select class="form-control" name="is_trending">
            <option value="0" <?php echo $data->is_trending==0 ? 'selected' : '' ?> >No</option>
            <option value="1" <?php echo $data->is_trending==1 ? 'selected' : '' ?> >Yes</option>
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