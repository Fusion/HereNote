<?php
// ---------------------------------------------------------------------------
// Display a single blog post
// ---------------------------------------------------------------------------

if(!defined('RUNNING')) exit(-1);

$template->view('blog');

$slug = $db->escapeString($_GET['blog']);
$row = $db->querySingle("SELECT * FROM mae_posts LEFT JOIN mae_users ON mae_users.id=user_id WHERE section=1 AND slug='" . $slug . "'", true);
if(empty($row)) {
    http_error(404, 'Blog post not found');
}

if($row['format_type'] == 2) {
    require 'thirdparty/Parsedown.php';
    $Parsedown = new Parsedown();
    $content = $Parsedown->text($row['content']);
    $content2 = <<<EOB
<script>
jQuery(document).ready(function() {
  jQuery('pre code').each(function(i, block) {
    hljs.highlightBlock(block);
  });
});
</script>
EOB;
}
else if($row['format_type'] == 1) {
    $content = $row['content'];
    $content2 = <<<EOB
<script>
jQuery(document).ready(function() {
  jQuery('pre').each(function(i, block) {
    hljs.highlightBlock(block);
  });
});
</script>
EOB;
}
else {
    $content = $row['content'];
    $content2 = '';
}

switch($row['content_type']) {
case $config['content_type']['g+']:
    $content_logo = '/assets/img/google_plus.png';
    $content_header = 'From my G+ Feed:';
break;
case $config['content_type']['github']:
    $content_logo = '/assets/img/github.png';
    $content_header = 'From my Github Feed:';
break;
default:
    $content_logo = false;
    $content_header = false;
}

if($user->can_edit) {
    $template->set('edit_menu',
        array(
            array('id' => 'action_edit', 'icon' => 'edit', 'text' => 'Edit'),
            array('id' => 'action_publish_toggle', 'icon' => 'unlink', 'text' => 'Toggle Publish State'),
            array('id' => 'action_delete', 'icon' => 'eraser', 'text' => 'Delete'),
            array('id' => 'action_source', 'icon' => 'bookmark-o', 'text' => 'Change Source'),
        )
    );
}


$template->set('id', $row['id']);
$template->set('slug', $slug);
$template->set('status', $row['status']);
$template->set('title', $row['title']);
$template->set('realname', $row['realname']);
$template->set('ref_url', $row['ref_url']);
$template->set('content_type', $row['content_type']);
$template->set('format_type', $row['format_type']);
$template->set('content', $content . "\n" . $content2);
$template->set('content_logo', $content_logo);
$template->set('content_header', $content_header);
$publish_date = strtotime($row['publish_date']);
$template->set('formatted_publish_date', format_ago($publish_date));
$template->set('disqus_shortname', $config['thirdparty']['disqus']['shortname']);
?>
