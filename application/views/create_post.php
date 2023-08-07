<div class="container p-3 my-3" style="background-color: #98e3d7;">
    <?php echo form_open('home/create_post'); ?>
    <h2 class="text-center  my-4">New Post</h2>
    <div class="form-group row my-4 px-5">
        <label for="post_title" class="col-form-label">Title</label>
        <div class="col-md-6 mx-auto">
            <input type="text" class="form-control" id="post_title" placeholder="Title" name="post_title" required="required">
        </div>
    </div>
    <div class="form-group row my-4 px-5">
        <label for="post_category" class="col-form-label">Category</label>
        <div class="col-md-2 mx-auto">
            <select class="form-control" id="post_category" name="post_category">
                <?php foreach ($categories as $category) {
                    echo '<option>' . $category . '</option>';
                } ?>
            </select>
        </div>
    </div>
    <div class="form-group row my-4 px-5">
        <label for="post_content">Content</label>
        <textarea class="form-control" id="post_content" rows="10" name="post_content" required="required"></textarea>
    </div>
    <div class="form-group my-4 px-4">
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#cancelModal">Cancel</button>
        <div class="float-right">
            <button type="submit" class="btn btn-success">Post</button>
        </div>
    </div>
    <?php echo form_close(); ?>

    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelPostTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelPostTitle">Cancel Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to give up editing the post? (the post will not be saved)
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <a class="btn btn-success" href="<?php echo base_url('home'); ?>" role="button">Yes</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #cke_post_content {
        margin: auto;
    }
</style>

<script>
    // ckeditor
    CKEDITOR.replace('post_content');
</script>