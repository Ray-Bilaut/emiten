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
        <a class="btn btn-primary pull-right" href="<?php echo site_url(ADMIN_URL."/news") ?>">Add</a>
      </div>

      <div class="box-body">
        <table class="datatable table table-bordered table-hover table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Category</th>
              <th>Author</th>
              <th>Expert</th>
              <th>Active</th>
              <th>Publish Date</th>
              <th width="150px">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            
            <?php foreach($list as $v): ?>
              <tr>
                <td><?php echo $v->id;?></td>
                <td><?php echo $v->title;?></td>
                <td>
                    <?php foreach($categories as $x):?>
                        <?php if ($v->category_id == $x->id) { echo $x->title; } ?>
                    <?php endforeach;?>
                </td>
                <td>
                    <?php foreach($authors as $author):?>
                        <?php 
                        if ($v->author_id != 0) {
                          if ($v->author_id == $author->id) { 
                            echo $author->name; 
                          }
                        } else {
                          if ($v->expert_id == $author->id) { 
                            echo $author->name; 
                          } 
                        }
                        ?>
                    <?php endforeach;?>
                </td>
                <td>
                    <?php echo $v->expert_id > 0 ? 'Yes' : 'No'; ?>
                </td>
                <td><?php echo $v->is_active==0 ? 'No' : 'Yes'; ?></td>
                <td><?php echo (new DateTime($v->publish_date))->format('d M Y - H:i');?></td>
                <td>
                  <div class="btn-group pull-right">
                    <a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to remove this data from recommendation?');" href="<?php echo site_url(ADMIN_URL.'/'.$this->router->class.'/remove/'.$v->id); ?>" title="Remove from Recommendation"><i class="fa fa-close"></i> Remove from Recommendation</a>
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