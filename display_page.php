<?php
$template->view('page');

$slug = $db->escapeString($_GET['page']);
$row = $db->querySingle("SELECT titles,content FROM pages_page left join pages_richtextpage on id=page_ptr_id where slug='" . $slug . "'", true);
if(empty($row)) {
    die("Ooops. 404 and all that :(");
}
$content = str_replace('/refdirect/?obj=', '/refdirect/', $row['content']);

$template->set('title', $row['titles']);
$template->set('content', $content);
