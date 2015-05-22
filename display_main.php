<?php
$template->view('main');
$post_count_query = $db->query("SELECT COUNT(*) AS count FROM blog_blogpost");
$row = $post_count_query->fetchArray();
$post_count = $row['count'];

$MAX_ROWS = 10;
if(empty($_GET['offset'])) {
    $offset = 0;
}
else {
    $offset = intval($_GET['offset']);
}
$prev_offset = $offset < 10 ? 0 : $offset - 10;
$next_offset = $offset + 10 > $post_count ? $offset : $offset + 10;

// Status: 2 == published
$posts = array();
$posts_list = $db->query("SELECT * FROM blog_blogpost WHERE status=2 ORDER BY publish_date DESC LIMIT $MAX_ROWS OFFSET $offset");
while($row = $posts_list->fetchArray()) {
    $post = new stdClass();
    $post->id = format_ago($row['id']);

    $publish_date = strtotime($row['publish_date']);
    $post->formatted_publish_date = format_ago($publish_date);
    switch($row['content_type']) {
        case 1:
            $post->type_thumbnail = '/assets/img/blog_logo.jpg';
        break;
        case 2:
            $post->type_thumbnail = '/assets/img/google_plus.png';
        break;
        case 3:
            $post->type_thumbnail = '/assets/img/github.png';
        break;
    }
    $post->short_url = $row['short_url'];
    $post->title = $row['title'];
    $post->featured_image = $row['featured_image'];
    $post->description = $row['description'];

    $posts[] = $post;
}

$template->set('posts', $posts);
$template->set('next_offset', $next_offset);
$template->set('prev_offset', $prev_offset);
