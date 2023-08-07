<div class="container">
    <div class="col-4 offset-4">
        <?php echo form_open('users/forgot_password'); ?>
        <h2 class="text-center  my-4">Forgot Password</h2>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Username" name="username" required="required" value="<?php echo set_value('username'); ?>">
            <?php echo form_error('username'); ?>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Email" name="email" required="required" value="<?php echo set_value('email'); ?>">
            <?php echo form_error('email'); ?>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="New Password" name="new_password" required="required" value="<?php echo set_value('new_password'); ?>">
            <?php echo form_error('new_password'); ?>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Confirm Password" name="confirm_password" required="required" value="<?php echo set_value('confirm_password'); ?>">
            <?php echo form_error('confirm_password'); ?>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>