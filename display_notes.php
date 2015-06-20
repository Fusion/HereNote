<?php
// ---------------------------------------------------------------------------
// Display blog's note list
// ---------------------------------------------------------------------------

if(!defined('RUNNING')) exit(-1);

$template->view('notes');

// Status: 2 == published
if($user->get('display', 'unpublished'))
    $status_str = '!=2';
else
    $status_str = '=2';

$post_count_query = $db->query("SELECT COUNT(*) AS count FROM mae_posts WHERE section=3 AND status{$status_str}");
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

$notes = array();
$notes_list = $db->query("SELECT * FROM mae_posts WHERE section=3 AND status{$status_str} ORDER BY publish_date DESC LIMIT {$config['per_page']} OFFSET $offset");
while($row = $notes_list->fetchArray()) {
    $note = new stdClass();

    $publish_date = strtotime($row['publish_date']);
    $note->formatted_publish_date = format_ago($publish_date);
    $note->short_url = $config['site_root'] . 'note/' . $row['slug'];
    $note->title = $row['title'];

    $notes[] = $note;
}

$template->set('is_home', true);
$template->set('notes', $notes);
$template->set('next_offset', $next_offset);
$template->set('prev_offset', $prev_offset);
