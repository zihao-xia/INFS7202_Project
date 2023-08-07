<?php
$comment_view = '<div class="container px-5 py-4 my-3 shadow rounded" style="background-color: #98e3d7;">
                    <div class="d-flex justify-content-between">
                        <div>
                            <img src="%s" class="rounded" style="width: 60px;">
                            <h5 class="rounded p-1" style="background-color: #e3df68;">%s</h5>
                        </div>
                        <div>#%d</div>
                    </div>
                    <hr>
                    <p class="my-4 text-justify">%s</p>
                    <hr>
                    <div class="row d-flex justify-content-end">
                        <div class="col-2">%s</div>
                    </div>
                </div>';
?>
<div class="container px-5 py-4 my-3 shadow rounded" style="background-color: #98e3d7;">
    <h2 class="text-center  mb-4"><?php echo $post['title']; ?></h2>
    <div class="d-flex justify-content-between">
        <div>
            <img src="<?php echo base_url('./uploads/avatar/' . $this->user_model->get_avatar($post['author'])); ?>" class="rounded" style="width: 60px;">
            <h5 class="rounded p-1" style="background-color: #e3df68;"><?php echo $post['author']; ?></h5>
        </div>
        <div id="likebtn">
            <?php $username = $this->session->userdata('username');
            if (!$this->favourites_model->is_liked($username, $post['id'])) : ?>
                <button type="button" class="btn btn-outline-danger likebtn">Like</button>
            <?php else : ?>
                <button type="button" class="btn btn-danger likedbtn">Liked</button>
            <?php endif; ?>
        </div>
    </div>
    <hr>
    <p class="my-4 text-justify"><?php echo nl2br($post['content']); ?></p>
    <hr>
    <div class="row">
        <div class="col-10"></div>
        <div class="col-2"><?php echo $post['createdAt']; ?></div>
    </div>
</div>

<?php foreach ($comments as $comment) {
    printf(
        $comment_view,
        base_url('./uploads/avatar/' . $this->user_model->get_avatar($comment['username'])),
        $comment['username'],
        $comment['floor'],
        nl2br($comment['content']),
        $comment['commentedAt']
    );
} ?>

<div class="text-center"><?php echo $links; ?></div>

<div class="container p-3 my-3 shadow rounded" style="background-color: #98e3d7;">
    <?php echo form_open('home/comment/' . $post['id']); ?>
    <div class="form-group row my-4 px-5">
        <label for="comment">Comment</label>
        <textarea class="form-control" id="comment" rows="10" name="comment" required="required"></textarea>
    </div>
    <div class="form-group my-4 px-4">
        <a class="btn btn-success" href="<?php echo base_url('home'); ?>" role="button">Back</a>
        <div class="float-right">
            <button type="submit" class="btn btn-success">comment</button>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<style>
    #cke_comment {
        margin: auto;
    }

    .pagination .page-link a {
        color: green;
    }

    .pagination .page-item.active a {
        background-color: green;
        border-color: green;
    }
</style>

<script>
    // Ajax for toggle of like button
    $(".likebtn").click(function(event) {
        event.preventDefault();
        let username = '<?php echo $username; ?>',
            post_id = '<?php echo $post['id']; ?>';
        thisbtn = this;
        if ($(thisbtn).text() == 'Like') {
            $.ajax({
                url: "<?php echo base_url(); ?>ajax/like_post",
                method: "POST",
                data: {
                    username: username,
                    post_id: post_id
                },
                success: function(result) {
                    $(thisbtn).addClass('btn-danger likedbtn');
                    $(thisbtn).removeClass('btn-outline-danger likebtn');
                    $(thisbtn).text('Liked');
                }
            });
        } else {
            $.ajax({
                url: "<?php echo base_url(); ?>ajax/unlike_post",
                method: "POST",
                data: {
                    username: username,
                    post_id: post_id
                },
                success: function(result) {
                    $(thisbtn).addClass('btn-outline-danger likebtn');
                    $(thisbtn).removeClass('btn-danger likedbtn');
                    $(thisbtn).text('Like');
                }
            });
        }
    });

    $(".likedbtn").click(function(event) {
        event.preventDefault();
        let username = '<?php echo $username; ?>',
            post_id = '<?php echo $post['id']; ?>';
        thisbtn = this;
        if ($(thisbtn).text() == 'Liked') {
            $.ajax({
                url: "<?php echo base_url(); ?>ajax/unlike_post",
                method: "POST",
                data: {
                    username: username,
                    post_id: post_id
                },
                success: function(result) {
                    $(thisbtn).addClass('btn-outline-danger likebtn');
                    $(thisbtn).removeClass('btn-danger likedbtn');
                    $(thisbtn).text('Like');
                }
            });
        } else {
            $.ajax({
                url: "<?php echo base_url(); ?>ajax/like_post",
                method: "POST",
                data: {
                    username: username,
                    post_id: post_id
                },
                success: function(result) {
                    $(thisbtn).addClass('btn-danger likedbtn');
                    $(thisbtn).removeClass('btn-outline-danger likebtn');
                    $(thisbtn).text('Liked');
                }
            });
        }
    });

    // ckeditor
    CKEDITOR.replace('comment');
</script>