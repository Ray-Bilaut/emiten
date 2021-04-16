    <div class="bg-register">
        <div class="content-profile">
            <div class="image-profile">
                <img src="<?php echo base_url('assets/images/default.png')?>" alt="user-default">
            </div>
            <div class="text-profile">
                <h1><?php echo $user->name ?> </h1>
                <p><?php echo $user->email ?></p>
                <div class="form-group check">
                    <input type="checkbox" id="subscribe-checkbox" name="is_subscribe" <?php echo $user->is_subscribe == 1 ? 'checked' : ''; ?>/>
                    <label for="subscribe">Saya subscribe channel ini</label>
                </div>
                <!-- <div class="form-group">
                    <label for="">Old Password</label><br>
                    <input type="password" name="password" placeholder="Old Password" required/>
                </div> -->
                <form id="form-reset-password" action="<?php echo site_url('ajax/changepassword')?>" method="POST">
                    <div class="form-group">
                        <label for="">New Password</label><br>
                        <input type="password" name="password" placeholder="New Password" required/>
                    </div>
                    <div class="form-group">
                        <label for="">Confirm new Password</label><br>
                        <input type="password" name="confirmpassword" placeholder="Confirm New Password" required/>
                    </div>
                    <div class="form-group">
                        <button type="submit" value="Submit">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>