<?php
// ---------------------------------------------------------------------------
// Display blog's main page
// ---------------------------------------------------------------------------

if(!defined('RUNNING')) exit(-1);

$template->view('main');

// Status: 2 == published
if($user->get('display', 'unpublished'))
    $status_str = '!=2';
else
    $status_str = '=2';

$post_count_query = $db->query("SELECT COUNT(*) AS count FROM mae_posts WHERE section=1 AND status{$status_str}");
$row = $post_count_query->fetchArray();
$post_count = $row['count'];

if(empty($_GET['offset'])) {
    $offset = 0;
}
else {
    $offset = intval($_GET['offset']);
}
$prev_offset = $offset < $config['per_page'] ? 0 : $offset - $config['per_page'];
$next_offset = $offset + $config['per_page'] > $post_count ? $offset : $offset + $config['per_page'];

$posts = array();
$posts_list = $db->query("SELECT * FROM mae_posts WHERE section=1 AND status{$status_str} ORDER BY publish_date DESC LIMIT {$config['per_page']} OFFSET $offset");
while($row = $posts_list->fetchArray()) {
    $post = new stdClass();

    $publish_date = strtotime($row['publish_date']);
    $post->formatted_publish_date = format_ago($publish_date);
    switch($row['content_type']) {
        case $config['content_type']['blog']:
            $post->type_thumbnail = '/assets/img/blog_logo.jpg';
        break;
        case $config['content_type']['g+']:
            $post->type_thumbnail = '/assets/img/google_plus.png';
        break;
        case $config['content_type']['github']:
            $post->type_thumbnail = '/assets/img/github.png';
        break;
    }
    $post->short_url = dynurl($row['short_url']);
    $post->title = $row['title'];
    $post->featured_image = $row['featured_image'];
    $post->description = $row['description'];

    $posts[] = $post;
}

$template->set('is_home', true);
$template->set('posts', $posts);
$template->set('next_offset', $next_offset);
$template->set('prev_offset', $prev_offset);
