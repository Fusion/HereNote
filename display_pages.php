<?php
// ---------------------------------------------------------------------------
// Display blog's page list
// ---------------------------------------------------------------------------

if(!defined('RUNNING')) exit(-1);

$template->view('pages');

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

$pages = array();
$pages_list = $db->query("SELECT * FROM mae_posts WHERE section=2 AND status{$status_str} ORDER BY publish_date DESC LIMIT {$config['per_page']} OFFSET $offset");
while($row = $pages_list->fetchArray()) {
    $page = new stdClass();

    $publish_date = strtotime($row['publish_date']);
    $page->formatted_publish_date = format_ago($publish_date);
    $page->short_url = $config['site_root'] . $row['slug'];
    $page->title = $row['title'];

    $pages[] = $page;
}

if($user->can_edit) {
    $template->set('edit_menu',
        array(
            array('id' => 'action_sort', 'icon' => 'sort', 'text' => 'Sort Pages')
        )
    );
}

$template->set('is_home', true);
$template->set('pages', $pages);
$template->set('next_offset', $next_offset);
$template->set('prev_offset', $prev_offset);
