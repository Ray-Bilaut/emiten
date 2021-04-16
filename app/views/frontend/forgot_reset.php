<div class="content-login">
    <div class="bg-login">
        <div class="box-login">
            <div class="logo-login">
                <img src="<?php echo base_url('assets/images/logo.png')?>" alt="emitennews-logo">
            </div>
            <br>
            <form id="form-reset" action="<?php echo base_url('forgot/editprocess/').$code ?>" method="POST">
                <input id="email" type="text" autocomplete="username" hidden>
                <div class="form-group">
                    <p >Insert your new password</p>
                    <label for="">New Password</label>
                    <input type="password" name="password" placeholder=" New Password" required autocomplete="new-password"/>
                </div>
                <div class="form-group">
                    <label for="">Confirm New Password</label>
                    <input type="password" name="confirmpassword" placeholder="Confirm New Password" required autocomplete="new-password"/>
                </div>
                <div class="form-group">
                    <button type="submit" value="Submit">SEND</button>
                </div>
            </form>
        </div>
    </div>
</div>