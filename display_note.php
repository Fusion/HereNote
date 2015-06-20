<?php
// ---------------------------------------------------------------------------
// Display a note (as opposed to a blog entry)
// ---------------------------------------------------------------------------

if(!defined('RUNNING')) exit(-1);

$template->view('note');

$slug = $db->escapeString($_GET['note']);
$row = $db->querySingle("SELECT title,content,status,format_type FROM mae_posts WHERE section=3 AND slug='" . $slug . "'", true);
if(empty($row)) {
    die("Page Ooops. 404 and all that :(");
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
    $content = preg_replace(
        '/```(.*?)```/',
        '<code>${1}</code>',
        $row['content']);
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

if($user->can_edit) {
    $template->set('edit_menu',
        array(
            array('id' => 'action_edit', 'icon' => 'edit', 'text' => 'Edit'),
            array('id' => 'action_publish_toggle', 'icon' => 'unlink', 'text' => 'Toggle Publish State'),
            array('id' => 'action_delete', 'icon' => 'eraser', 'text' => 'Delete')
        )
    );
}

$content = str_replace('/refdirect/?obj=', '/refdirect/', $content);

$template->set('slug', $slug);
$template->set('status', $row['status']);
$template->set('title', $row['title']);
$template->set('content', $content);
