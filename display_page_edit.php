<?php
// ---------------------------------------------------------------------------
// Edit a page
// ---------------------------------------------------------------------------

if(!$user->can_edit) {
    die("No, you are not allowed to do that.");
}
else {
    if(!empty($_POST['Save'])) {
        $slug = $_GET['page_edit'];
        $page_id = $_POST['id'];
        $title = $_POST['title'];
        $content = str_replace(
            "\xc2\xa0", ' ', str_replace(
                "\x0d\x0a", "\x0a", $_POST['content']));

        if($slug == 'new_rich' || $slug == 'new_markdown') {
            $clean_slug = preg_replace( '/[^[:alnum:]]/ui', '-', $title);
            $now = date('Y-m-d H:i:s');
            $stmt = $db->prepare("INSERT INTO mae_pages(status,updated,titles,description,title,login_required,site_id,keywords_string,in_sitemap,publish_date,slug,gen_description,format_type) VALUES(:status,:updated,:titles,:description,:title,0,1,'',1,:publishdate,:slug,1,:formattype)");
            $stmt->bindValue(':formattype', ($slug == 'new_rich' ? 1 : 2));
            $stmt->bindValue(':status', 1); // Draft
            $stmt->bindValue(':slug', $clean_slug);
            $stmt->bindValue(':title', $title);
            $stmt->bindValue(':titles', $title);
            $stmt->bindValue(':description', $title);
            $stmt->bindValue(':publishdate', $now);
            $stmt->bindValue(':updated', $now);
            $stmt->execute();

            $id = $db->lastInsertRowID();

            $stmt = $db->prepare("INSERT INTO mae_pages_richtextpage(page_ptr_id,content) VALUES(:id,:content)");
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':content', $content);
            $stmt->execute();

            $slug = $clean_slug; // From now on we will be editing an existing page.
        }
        else if(empty($title)) {
            // pass
        }
        else {
            $stmt = $db->prepare("UPDATE mae_pages SET title=:title WHERE slug=:slug");
            $stmt->bindValue(':slug', $slug);
            $stmt->bindValue(':title', $title);
            $stmt->execute();

            $stmt = $db->prepare("UPDATE mae_pages_richtextpage SET content=:content WHERE page_ptr_id=:id");
            $stmt->bindValue(':id', $page_id);
            $stmt->bindValue(':content', $content);
            $stmt->execute();
        }
    }
    else {
        // pass
    }

    if(!isset($slug)) {
        $slug = $db->escapeString($_GET['page_edit']);
    }

    if($slug == 'new_rich' || $slug == 'new_markdown') {
        $row = array(
                'new' => true,
                'clean_title' => 'New page',
                'title' => '',
                'parent_url' => $config['site_root'],
                'content' => '');
        if($slug == 'new_rich')
            $row['format_type'] = 1;
        else
            $row['format_type'] = 2;
    }
    else {
        $row = $db->querySingle("SELECT id,title,content,format_type FROM mae_pages left join mae_pages_richtextpage on id=page_ptr_id where slug='" . $slug . "'", true);
        if(empty($row)) {
            die("Blog-Edit Ooops. 404 and all that :(");
        }
        $row['parent_url'] = $config['site_root'] . $slug .'/';
    }

    switch($row['format_type']) {
    case 1:
        $template->view('page_rich_edit');
        require 'display_rich_editor.php';
        $template->set('slug', $slug);
        $template->set('parent_url', $row['parent_url']);
        $template->set('id', $row['id']);
        $template->set('new', (!empty($row['new'])));
        $template->set('clean_title', isset($row['clean_title']) ? $row['clean_title'] : $row['title']);
        $template->set('title', $row['title']);
        $template->set('editor', get_editor_html('editor', $row['content']));
        $template->header_append(get_editor_header());
    break;
    case 2:
        $template->view('page_markdown_edit');
        require 'display_markdown_editor.php';
        $template->set('slug', $slug);
        $template->set('parent_url', $row['parent_url']);
        $template->set('id', $row['id']);
        $template->set('new', (!empty($row['new'])));
        $template->set('clean_title', isset($row['clean_title']) ? $row['clean_title'] : $row['title']);
        $template->set('title', $row['title']);
        $template->set('editor', get_editor_html('editor', $row['content']));
        $template->header_append(get_editor_header());
    }
}
