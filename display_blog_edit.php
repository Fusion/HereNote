<?php
// ---------------------------------------------------------------------------
// Display a single blog page
// ---------------------------------------------------------------------------

$template->view('blog_edit');

$slug = $db->escapeString($_GET['blog_edit']);
$row = $db->querySingle("SELECT * FROM blog_blogpost WHERE slug='" . $slug . "'", true);
if(empty($row)) {
    die("Blog-Edit Ooops. 404 and all that :(");
}

// Is this a rich text post or a markdown one?
