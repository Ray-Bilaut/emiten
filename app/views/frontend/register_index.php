<div class="content-register">
    <div class="bg-register">
        <div class="box-register">
            <div class="logo-register">
                <img src="<?php echo base_url('assets/images/logo.png')?>" alt="emitennews-logo">
            </div>
            <form id="form-register" action="<?php echo site_url('register/addprocess')?>" method="POST">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" placeholder="Fullname" required/>
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" placeholder="Email" value="<?php echo $email ?>" required/>
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" placeholder="Password" required/>
                </div>
                <div class="form-group">
                    <label for="">Confirm Password</label>
                    <input type="password" name="confirmpassword" placeholder="Confirm Password" required/>
                </div>
                <div class="form-group check">
                    <input type="checkbox" id="agree" value="1" name="is_confirm" required/>
                    <label for="agree">Saya setuju dengan syarat dan ketentuan yang berlaku</label>
                </div>
                <div id="error"></div>

                <div class="form-group check">
                    <input type="checkbox" id="subscribe" name="is_subscribe" />
                    <label for="subscribe">Saya subscribe newsletter emitennews.com</label>
                </div>
                <div class="form-group">
                    <button type="submit" value="Submit">SIGN UP</button>
                </div>
                <div class="form-group">
                    <div class="text">
                        <h1>Have an account? <a href="<?php echo site_url('login')?>">Login</a></h1>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>