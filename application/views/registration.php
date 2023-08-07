<div class="container">
    <div class="col-4 offset-4">
        <?php echo form_open('users/registration'); ?>
        <h2 class="text-center  my-4">Registration</h2>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Username" name="username" value="<?php echo set_value('username'); ?>">
            <?php echo form_error('username'); ?>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Email" name="email" value="<?php echo set_value('email'); ?>">
            <?php echo form_error('email'); ?>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Password" name="password" value="<?php echo set_value('password'); ?>">
            <?php echo form_error('password'); ?>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Confirm Password" name="confirm_password" value="<?php echo set_value('confirm_password'); ?>">
            <?php echo form_error('confirm_password'); ?>
        </div>
        <div class="form-group">
            <a id="captcha-img" href="javascript:void(0);" class="refresh-captcha"><?php echo $captchaImg ?></a>
            <input type="text" class="form-control mt-2" placeholder="Captcha" name="captcha">
            <?php echo form_error('captcha'); ?>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.refresh-captcha').click(function() {
            $.get('<?php print base_url() . "users/refresh"; ?>', function(data) {
                $('#captcha-img').html(data);
            });
        });
    });
</script>