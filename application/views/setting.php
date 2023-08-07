<div id="container">
    <div class="col-4 offset-4">
        <h1 id="username"><?php echo $username; ?></h1>
        <div class="row my-3">
            <!-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#avatarUpdatingForm">Update Avatar</button> -->
            <a class="bg-primary rounded text-light text-decoration-none py-1 px-2" href="<?php echo base_url(); ?>upload/upload_avatar">Update Avatar</a>
        </div>
        <div class="row my-3">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#emailUpdatingForm">Update Email</button>
        </div>
        <div class="row my-3">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#passwordUpdatingForm">Update Password</button>
        </div>

        <div class="modal fade" id="emailUpdatingForm" tabindex="-1" role="dialog" aria-labelledby="emailUpdatingFormLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="emailUpdatingFormLabel">Email Updating</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="email_updating_form">
                        <div class="modal-body">
                            <div class="form-group">
                                Current Email: <?php echo $email; ?>
                            </div>
                            <div class="form-group">
                                <label for="new-email" class="col-form-label">New Email:</label>
                                <input type="text" class="form-control" id="new_email" placeholder="New Email" required="required" name="new_email">
                            </div>
                            <div class="error_prefix"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="updatebtn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="passwordUpdatingForm" tabindex="-1" role="dialog" aria-labelledby="passwordUpdatingFormLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="passwordUpdatingFormLabel">Password Updating</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="password_updating_form">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="current_password" class="col-form-label">Current Password:</label>
                                <input type="text" class="form-control" id="current_password" placeholder="Current Password" required="required" name="current_password">
                            </div>
                            <div class="form-group">
                                <label for="new_password" class="col-form-label">New Password:</label>
                                <input type="text" class="form-control" id="new_password" placeholder="New Password" required="required" name="new_password">
                            </div>
                            <div class="error_prefix"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="updatebtn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Ajax for error display
    $("#email_updating_form").submit(function(event) {
        event.preventDefault();
        let username = '<?php echo $username; ?>',
            new_email = $('#new_email').val();
        $.ajax({
            url: "<?php echo base_url(); ?>ajax/update_email",
            method: "POST",
            data: {
                username: username,
                new_email: new_email
            },
            success: function(result) {
                if (result.includes('error')) {
                    $('.error_prefix').html(result);
                } else {
                    $('body').html(result);
                }
            }
        });
    });

    $("#password_updating_form").submit(function(event) {
        event.preventDefault();
        let username = '<?php echo $username; ?>',
            current_password = $('#current_password').val(),
            new_password = $('#new_password').val();
        $.ajax({
            url: "<?php echo base_url(); ?>ajax/update_password",
            method: "POST",
            data: {
                username: username,
                current_password: current_password,
                new_password: new_password
            },
            success: function(result) {
                if (result == 1) {
                    location.reload();
                } else {
                    if (result.includes('error')) {
                        $('.error_prefix').html(result);
                    } else {
                        $('body').html(result);
                    }
                }
            }
        });
    });
</script>