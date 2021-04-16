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
                    <label>Word</label>
                    <input type="text" name="word[]" class="form-control" placeholder="word" required="">
                    <button type="button" class="btn btn-primary" id="add-word" href="" title="Add"><i class="fa fa-plus"></i></button>
                </div>

                <div id="list-word">

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


<div id="elm" class="hidden">
    <div class="list-word">
        <div class="form-group">
            <!-- <label>Word</label> -->
            <input type="text" name="word[]" class="form-control" placeholder="word" required="">
            <button type="button" class="btn btn-default"><i class="fa fa-trash"></i></button>
        </div>
    </div>
</div