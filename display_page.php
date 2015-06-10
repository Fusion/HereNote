<?php
// ---------------------------------------------------------------------------
// Display a page (as opposed to a blog entry)
// ---------------------------------------------------------------------------

$template->view('page');

$slug = $db->escapeString($_GET['page']);
$row = $db->querySingle("SELECT titles,content,status,format_type FROM mae_pages left join mae_pages_richtextpage on id=page_ptr_id where slug='" . $slug . "'", true);
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
$template->set('title', $row['titles']);
$template->set('content', $content);
