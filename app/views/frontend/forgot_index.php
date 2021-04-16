<div class="content-login">
    <div class="bg-login">
        <div class="box-login">
            <div class="logo-login">
                <img src="<?php echo base_url('assets/images/logo.png')?>" alt="emitennews-logo">
            </div>
            <br>
            <form id="form-forgot" action="<?php echo base_url('forgot/addprocess')?>" method="POST">
                <div class="form-group">
                    <p >Insert your email to reset your password</p>
                    <label for="">Email</label>
                    <input type="email" name="email" placeholder="Email" required/>
                </div>
                <div class="form-group">
                    <button type="submit" value="Submit">SEND</button>
                </div>
            </form>
        </div>
    </div>
</div>