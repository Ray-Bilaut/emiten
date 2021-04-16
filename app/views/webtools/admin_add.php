<div class="row">
  <div class="col-xs-12">

                    <?php if($error!=''): ?>
                    <div class="alert alert-warning alert-dismissible">
                      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                      <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                      <?php echo $error_msg; ?>
                    </div>
                    <?php endif; ?>

  		<div class="box box-primary">
              <!--
              <div class="box-header with-border">
                <h3 class="box-title">Add new admin</h3>
              </div>
              -->
              <form role="form" method="POST" action="<?php echo site_url(ADMIN_URL."/{$this->router->class}/addprocess"); ?>">
                	<div class="box-body">

                    <div class="form-group">
                      <label for="group">Role</label>
                      <select class="form-control" name="group">
                        <?php foreach ($group as $v): ?>
                        <option value="<?php echo $v->id ?>"><?php echo $v->name ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Name" required="">
                    </div>

                    <div class="form-group">
                      <label for="username">Username</label>
                      <input class="form-control" type="text" name="username" placeholder="Username">
                    </div>

                    <div class="form-group">
                      <label for="username">Password</label>
                      <input class="form-control" type="password" name="password" placeholder="Password">
                    </div>
               	  
                  </div>
                	<div class="box-footer">
                  	<button class="btn btn-danger" type="submit">Add</button>
                	</div>
              </form>
            </div>
  </div>
</div>