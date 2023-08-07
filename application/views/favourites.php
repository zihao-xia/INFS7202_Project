<?php
$discussion_view = '<li class="list-group-item list-group-item-primary list-group-item-action my-3 p-4 shadow rounded">
                <a class="text-decoration-none text-dark" href="' . base_url('home/read_post/%s') . '">
                    <h3 class="post-title">%s</h3>
                    <div class="row px-3">
                        <div class="author bg-light rounded px-2">%s</div>
                        <div class="category rounded bg-info text-white mx-4 px-2">%s</div>
                        <div class="created-time rounded bg-secondary text-white px-2">created at %s</div>
                    </div>
                </a>
            </li>';
$question_view = '<li class="list-group-item list-group-item-info list-group-item-action my-3 p-4 shadow rounded">
                <a class="text-decoration-none text-dark" href="' . base_url('home/read_post/%s') . '">
                    <h3 class="post-title">%s</h3>
                    <div class="row px-3">
                        <div class="author bg-light rounded px-2">%s</div>
                        <div class="category rounded bg-warning mx-4 px-2">%s</div>
                        <div class="created-time rounded bg-secondary text-white px-2">created at %s</div>
                    </div>
                </a>
            </li>';
?>
<div class="container">
    <h1>Favourites</h1>
    <ul class="list-group my-4">
        <?php foreach ($posts as $post) {
            if ($post['category'] == 'Discussion') {
                printf($discussion_view, $post['id'], $post['title'], $post['author'], $post['category'], $post['createdAt']);
            } else {
                printf($question_view, $post['id'], $post['title'], $post['author'], $post['category'], $post['createdAt']);
            }
        } ?>
    </ul>
</div>