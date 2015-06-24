<?php
// ---------------------------------------------------------------------------
// Edit a page
// ---------------------------------------------------------------------------

if(!defined('RUNNING')) exit(-1);

function traverse_parents($parent_list, $parent_id=0, $indent=2) {
    $next_indent = $indent + 2;
    $ret = array();

    foreach($parent_list as $id => $parent) {
        if($parent['parent_id'] == $parent_id) {
            $parent['id'] = $id;
            $parent['indent'] = $indent;
            $ret[] = $parent;
            $ret = array_merge($ret, traverse_parents($parent_list, $id, $next_indent));
        }
    }
    return $ret;
}

if(!$user->can_edit) {
    die("No, you are not allowed to do that.");
}
else {
    if(!empty($_POST['Save'])) {
        $slug = $_GET['page_edit'];
        $title = $_POST['title'];
        $parent = $_POST['parent'];
        $content = str_replace(
            "\xc2\xa0", ' ', str_replace(
                "\x0d\x0a", "\x0a", $_POST['content']));

        if($slug == 'new_rich' || $slug == 'new_markdown') {
            $clean_slug = preg_replace( '/[^[:alnum:]]/ui', '-', $title);
            $stmt = $db->prepare("INSERT INTO mae_posts(site_id,section,in_sitemap,user_id,status,gen_description,allow_comments,content_type,format_type,rating_sum,rating_count,rating_average,comments_count,keywords_string,source_id,slug,short_url,title,content,description,publish_date,ref_url,parent_id) VALUES(1,2,1,2,:status,1,1,3,:formattype,5,1,5,0,'',:sourceid,:slug,:shorturl,:title,:content,:description,:publishdate,:refurl,:parentid)");
            $stmt->bindValue(':formattype', ($slug == 'new_rich' ? 1 : 2));
            $stmt->bindValue(':status', 1); // Draft
            $stmt->bindValue(':sourceid', 1); // Blog
            $stmt->bindValue(':shorturl', $config['site_root'] . '/' . $clean_slug . '/');
            $stmt->bindValue(':refurl', '');
            $stmt->bindValue(':slug', $clean_slug);
            $stmt->bindValue(':title', $title);
            $stmt->bindValue(':parentid', $parent);
            $stmt->bindValue(':content', $content);
            $stmt->bindValue(':description', $title);
            $stmt->bindValue(':publishdate', date('Y-m-d H:i:s'));
            $stmt->execute();

            $slug = $clean_slug; // From now on we will be editing an existing page.
        }
        else if(empty($title)) {
            // pass
        }
        else {
            $stmt = $db->prepare("UPDATE mae_posts SET title=:title, content=:content, description=:description, parent_id=:parentid WHERE section=2 AND slug=:slug");
            $stmt->bindValue(':slug', $slug);
            $stmt->bindValue(':title', $title);
            $stmt->bindValue(':parentid', $parent);
            $stmt->bindValue(':content', $content);
            $stmt->bindValue(':description', '');
            $stmt->execute();
        }
    }
    else {
        // pass
    }

    // Parent
    $parent_list = array();

    $pages_list = $db->query("SELECT title,slug,parent_id,id FROM mae_posts WHERE section=2 AND status=2");
    while($row = $pages_list->fetchArray()) {
        $page_id = '' . $row['id'];
        $parent_id = '' . $row['parent_id'];
        $parent_list[$page_id] = array(
            'slug' => $row['slug'],
            'title' => $row['title'],
            'titles' => $row['title'],
            'parent_id' => $parent_id
        );
    }

    $parent_menu = array_merge(
        array(array('id' => 0, 'title' => 'Root')),
        traverse_parents($parent_list));
    //

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
        $row = $db->querySingle("SELECT * FROM mae_posts WHERE section=2 AND slug='" . $slug . "'", true);
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
        $template->set('parent_id', $row['parent_id']);
        $template->set('parent_menu', $parent_menu);
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
        $template->set('parent_id', $row['parent_id']);
        $template->set('parent_menu', $parent_menu);
        $template->set('editor', get_editor_html('editor', $row['content']));
        $template->header_append(get_editor_header());
    }
}
