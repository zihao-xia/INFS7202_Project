<?php
$discussion_view = '<li class="list-group-item list-group-item-primary list-group-item-action my-3 p-4 shadow rounded">
                <a class="text-decoration-none text-dark" href="' . base_url('home/read_post/%s') . '">
                    <h3 class="post-title">%s</h3>
                    <div class="row px-4 d-flex justify-content-between">
                        <div class="row">
                            <div class="author bg-light rounded px-2">%s</div>
                            <div class="category rounded bg-info text-white mx-4 px-2">%s</div>
                            <div class="created-time rounded bg-secondary text-white px-2">created at %s</div>
                        </div>
                        <div class="row">
                            <div class="comment-num mx-2"><ion-icon name="chatbox"></ion-icon> %d</div>
                            <div class="liked-num mx-2"><ion-icon name="heart"></ion-icon> %d</div>
                        </div>
                    </div>
                </a>
            </li>';
$question_view = '<li class="list-group-item list-group-item-info list-group-item-action my-3 p-4 shadow rounded">
                <a class="text-decoration-none text-dark" href="' . base_url('home/read_post/%s') . '">
                    <h3 class="post-title">%s</h3>
                    <div class="row px-4 d-flex justify-content-between">
                        <div class="row">
                            <div class="author bg-light rounded px-2">%s</div>
                            <div class="category rounded bg-warning mx-4 px-2">%s</div>
                            <div class="created-time rounded bg-secondary text-white px-2">created at %s</div>
                        </div>
                        <div class="row">
                            <div class="comment-num mx-2"><ion-icon name="chatbox"></ion-icon> %d</div>
                            <div class="liked-num mx-2"><ion-icon name="heart"></ion-icon> %d</div>
                        </div>
                    </div>
                </a>
            </li>';
?>
<div class="container">
    <h1>Hello, <?php echo $username; ?>.</h1>
    <h1>Welcome to XX Discussion!</h1>
    <div class="my-4"><a class="btn btn-primary" href="<?php echo base_url('home/create_post'); ?>" role="button">New Post</a></div>
    <ul class="list-group my-4">
        <?php foreach ($posts as $post) {
            if ($post['category'] == 'Discussion') {
                printf(
                    $discussion_view,
                    $post['id'],
                    $post['title'],
                    $post['author'],
                    $post['category'],
                    $post['createdAt'],
                    $this->post_model->get_comment_num($post['id']),
                    $this->post_model->get_liked_num($post['id'])
                );
            } else {
                printf(
                    $question_view,
                    $post['id'],
                    $post['title'],
                    $post['author'],
                    $post['category'],
                    $post['createdAt'],
                    $this->post_model->get_comment_num($post['id']),
                    $this->post_model->get_liked_num($post['id'])
                );
            }
        } ?>
    </ul>
    <div class="text-center text-center"><?php echo $links; ?></div>
</div>