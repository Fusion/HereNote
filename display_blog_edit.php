<?php
// ---------------------------------------------------------------------------
// Display a single blog page
// ---------------------------------------------------------------------------

if(!$user->can_edit) {
    die("No, you are not allowed to do that.");
}
else {
    // Are we submitting an edited form?
    if(!empty($_POST['Save'])) {
        $slug = $_GET['blog_edit'];
        $title = $_POST['title'];
        // &nbsp; and \n after JS encoding:
        $content = str_replace(
            "\xc2\xa0", ' ', str_replace(
                "\x0d\x0a", "\x0a", $_POST['content']));
        if(empty($title)) {
            // pass
        }
        else {
            $stmt = $db->prepare("UPDATE blog_blogpost SET title=:title, content=:content WHERE slug=:slug");
            $stmt->bindValue(':slug', $slug);
            $stmt->bindValue(':title', $title);
            $stmt->bindValue(':content', $content);
            $stmt->execute();
        }
    }
    else {
        // pass
    }

    $slug = $db->escapeString($_GET['blog_edit']);
    $row = $db->querySingle("SELECT * FROM blog_blogpost WHERE slug='" . $slug . "'", true);
    if(empty($row)) {
        die("Blog-Edit Ooops. 404 and all that :(");
    }

    // Is this a rich text post or a markdown one?
    // TODO
    switch($row['format_type']) {
    case 1:
        $template->view('blog_rich_edit');
        require 'display_rich_editor.php';
        $template->set('slug', $slug);
        $template->set('title', $row['title']);
        $template->set('editor', get_editor_html('editor', $row['content']));
        $template->header_append(get_editor_header());
    break;
    case 2:
        $template->view('blog_markdown_edit');
        require 'display_markdown_editor.php';
        $template->set('slug', $slug);
        $template->set('title', $row['title']);
        $template->set('editor', get_editor_html('editor', $row['content']));
        $template->header_append(get_editor_header());
    break;
    }
}
