<div class="content-login">
    <div class="bg-login">
        <div class="box-login">
            <div class="logo-login">
                <img src="<?php echo base_url('assets/images/logo.png')?>" alt="emitennews-logo">
            </div>
            <form id="form-login" action="<?php echo base_url('verivication/addprocess')?>" method="POST">
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" placeholder="Password" required/>
                </div>
                <div class="form-group">
                    <label for="">Confirm Password</label>
                    <input type="password" name="confirmpassword" placeholder="Confirm Password" required/>
                </div>
                <div class="form-group">
                    <button type="submit" value="Submit">SEND</button>
                </div>
            </form>
        </div>
    </div>
</div>