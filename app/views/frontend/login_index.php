<div class="content-login">
    <div class="bg-login">
        <div class="box-login">
            <div class="logo-login">
                <img src="<?php echo base_url('assets/images/logo.png')?>" alt="emitennews-logo">
            </div>
            <form id="form-login" action="<?php echo base_url('login/addprocess')?>" method="POST">
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" placeholder="Email" required/>
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" placeholder="Password" required/>
                </div>
                <div class="form-group">
                    <button type="submit" value="Submit">LOGIN</button>
                </div>
                <div class="form-group">
                    <div class="text">
                        <h1>Forgot password? <a href="<?php echo site_url('forgot')?>">Reset password</a></h1>
                    </div>
                </div>
                <div class="form-group">
                    <div class="text">
                        <h1>Don't have an account? <a href="<?php echo site_url('register')?>">Register</a></h1>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>