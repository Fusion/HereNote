<?php
// ---------------------------------------------------------------------------
// Display a page (as opposed to a blog entry)
// ---------------------------------------------------------------------------

$template->view('page');

$slug = $db->escapeString($_GET['page']);
$row = $db->querySingle("SELECT titles,content FROM mae_pages left join mae_pages_richtextpage on id=page_ptr_id where slug='" . $slug . "'", true);
if(empty($row)) {
    die("Page Ooops. 404 and all that :(");
}
$content = str_replace('/refdirect/?obj=', '/refdirect/', $row['content']);

$template->set('title', $row['titles']);
$template->set('content', $content);
