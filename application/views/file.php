<?php echo form_open_multipart('upload/upload_avatar'); ?>
<div class="row justify-content-center">
    <div class="col-md-4 col-md-offset-6 centered">
        <div class="text-danger"><?php echo $error; ?></div>
        <div class="form-group">
            <input type="file" name="userfile" accept="image/*" size="20" required />
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Upload</button>
        </div>
    </div>
</div>
<?php echo form_close(); ?>