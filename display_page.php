<?php
// ---------------------------------------------------------------------------
// Display a page (as opposed to a blog entry)
// ---------------------------------------------------------------------------

$template->view('page');

$slug = $db->escapeString($_GET['page']);
$row = $db->querySingle("SELECT titles,content,status FROM mae_pages left join mae_pages_richtextpage on id=page_ptr_id where slug='" . $slug . "'", true);
if(empty($row)) {
    die("Page Ooops. 404 and all that :(");
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

$content = str_replace('/refdirect/?obj=', '/refdirect/', $row['content']);

$template->set('slug', $slug);
$template->set('status', $row['status']);
$template->set('title', $row['titles']);
$template->set('content', $content);
