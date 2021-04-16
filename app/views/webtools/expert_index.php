<div class="row">
  <div class="col-xs-12">
    
    <?php if($error=='error'): ?>
    <div class="alert alert-warning alert-dismissible">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
      <?php echo $error_msg; ?>
    </div>
    <?php elseif($error=='success'): ?>
      <div class="alert alert-success alert-dismissible">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $success_msg; ?>
      </div>
    <?php endif; ?>

    <div class="box box-primary">
      <div class="box-header with-border">      
        <a class="btn btn-primary pull-right" href="<?php echo site_url(ADMIN_URL."/admin/add") ?>">Add new</a>
      </div>

      <div class="box-body">
        <table class="datatable table table-bordered table-hover table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Top Expert</th>
              <th>Active</th>
              <th width="120px">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            
            <?php foreach($list as $v): ?>
              <tr>
                <td><?php echo $v->id;?></td>
                <td><?php echo $v->name;?></td>
                <td>
                  <select class="top-order" data-id="<?php echo $v->id;?>">
                    <option value="0" <?php echo $v->top_order == 0 ? 'selected' : ''?> ></option>
                    <option value="1" <?php echo $v->top_order == 1 ? 'selected' : ''?> >1</option>
                    <option value="2" <?php echo $v->top_order == 2 ? 'selected' : ''?>>2</option>
                    <option value="3" <?php echo $v->top_order == 3 ? 'selected' : ''?>>3</option>
                  </select>
                </td>
                <td><?php echo $v->is_active==0 ? 'No' : 'Yes';?></td>
                <td>
                  <div class="btn-group pull-right">
                    <a class="btn btn-sm btn-default" href="<?php echo site_url(ADMIN_URL."/admin/edit/".$v->id); ?>" title="edit"><i class="fa fa-edit"></i> Edit</a>
                    <a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo site_url(ADMIN_URL."/admin/delete/".$v->id); ?>" title="delete"><i class="fa fa-trash"></i> Delete</a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>