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
        <a class="btn btn-primary pull-right" href="<?php echo site_url(ADMIN_URL."/{$this->router->class}/add") ?>">Add new</a>
      </div>

      <div class="box-body">
        <table class="datatable table table-bordered table-hover table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Referal Type</th>
              <th>User ID</th>                  
              <th>Sent</th>
              <th>Active</th>
              <th>Publish Date</th>
              <th>Modified</th>
              <!-- <th width="30px">&nbsp;</th> -->
            </tr>
          </thead>
          <tbody>
            
            <?php foreach($list as $v): ?>
              <tr>
                <td><?php echo $v->id; ?></td>
                <td><?php echo $v->title; ?></td>
                <td><?php echo $v->referal_type; ?></td>
                <td><?php echo $v->user_id != 0 ? $v->user_id : 'All'; ?></td>                    
                <td><?php echo $v->is_sent; ?></td>
                <td><?php echo $v->is_active; ?></td>
                <td><?php echo (new DateTime($v->scheduled_datetime))->format('d M Y - H:i'); ?></td>
                <td><?php echo (new DateTime($v->modified_date))->format('d M Y - H:i') ?></td>
                <!-- <td>
                  <div class="btn-group pull-right">
                    <a class="btn btn-sm btn-default" href="<?php echo site_url(ADMIN_URL."/{$this->router->class}/edit/".$v->id); ?>" title="edit"><i class="fa fa-pencil"></i> Edit</a>
                  </div>
                </td> -->
              </tr>
            <?php endforeach; ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>