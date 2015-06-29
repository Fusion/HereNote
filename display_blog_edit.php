<?php
// ---------------------------------------------------------------------------
// Edit a blog post
// ---------------------------------------------------------------------------

if(!defined('RUNNING')) exit(-1);

if(!$user->can_edit) {
    http_error(403, 'You are not allowed to edit');
}
else {
    // Are we submitting an edited form?
    if(!empty($_POST['Save'])) {

        $slug = $_GET['blog_edit'];
        $title = $_POST['title'];
        $featured_image = $_POST['featured_image'];
        // &nbsp; and \n after JS encoding:
        $content = str_replace(
            "\xc2\xa0", ' ', str_replace(
                "\x0d\x0a", "\x0a", $_POST['content']));
        $description = str_replace(
            "\xc2\xa0", ' ', str_replace(
                "\x0d\x0a", "\x0a", $_POST['description']));

        if($slug == 'new_rich' || $slug == 'new_markdown') {
            $clean_slug = preg_replace( '/[^[:alnum:]]/ui', '-', $title);
            $stmt = $db->prepare("INSERT INTO mae_posts(site_id,section,in_sitemap,user_id,status,gen_description,allow_comments,content_type,format_type,rating_sum,rating_count,rating_average,comments_count,keywords_string,source_id,slug,short_url,featured_image,title,content,description,publish_date,ref_url) VALUES(1,1,1,2,:status,1,1,3,:formattype,5,1,5,0,'',:sourceid,:slug,:shorturl,:featuredimage,:title,:content,:description,:publishdate,:refurl)");
            $stmt->bindValue(':formattype', ($slug == 'new_rich' ? 1 : 2));
            $stmt->bindValue(':status', 1); // Draft
            $stmt->bindValue(':sourceid', 1); // Blog
            $stmt->bindValue(':shorturl', $config['site_root'] . 'blog/' . $clean_slug . '/');
            $stmt->bindValue(':refurl', '');
            $stmt->bindValue(':slug', $clean_slug);
            $stmt->bindValue(':title', $title);
            $stmt->bindValue(':content', $content);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':featuredimage', $featured_image);
            $stmt->bindValue(':publishdate', date('Y-m-d H:i:s'));
            $stmt->execute();

            $slug = $clean_slug; // From now on we will be editing an existing post.
       }
        else if(empty($title)) {
            // pass
        }
        else {
            $stmt = $db->prepare("UPDATE mae_posts SET title=:title, content=:content, description=:description WHERE section=1 AND slug=:slug");
            $stmt->bindValue(':slug', $slug);
            $stmt->bindValue(':title', $title);
            $stmt->bindValue(':content', $content);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':featuredimage', $featured_image);
            $stmt->execute();
        }
    }
    else {
        // pass
    }

    if(!isset($slug)) {
        $slug = $db->escapeString($_GET['blog_edit']);
    }
    if($slug == 'new_rich' || $slug == 'new_markdown') {
        $row = array(
            'new' => true,
            'clean_title' => 'New post',
            'title' => '',
            'description' => '',
            'parent_url' => $config['site_root'],
            'content' => '');
        if($slug == 'new_rich')
            $row['format_type'] = 1;
        else
            $row['format_type'] = 2;
    }
    else {
        $row = $db->querySingle("SELECT * FROM mae_posts WHERE section=1 AND slug='" . $slug . "'", true);
        if(empty($row)) {
            http_error(404, 'Blog post not found');
        }
        $row['parent_url'] = $config['site_root'] . 'blog/' . $slug .'/';
    }

    // Is this a rich text post or a markdown one?
    // TODO
    switch($row['format_type']) {
    case 1:
        $template->view('blog_rich_edit');
        require 'display_rich_editor.php';
        require 'display_uploader.php';
        $template->set('slug', $slug);
        $template->set('parent_url', $row['parent_url']);
        $template->set('new', (!empty($row['new'])));
        $template->set('clean_title', isset($row['clean_title']) ? $row['clean_title'] : $row['title']);
        $template->set('title', $row['title']);
        $template->set('featured_image', $row['featured_image']);
        $template->set('description', $row['description']);
        $template->set('editor', get_editor_html('editor', $row['content']));
        $template->set('editor_d', get_editor_html('editor_d', $row['description']));
        $template->set('uploader', get_uploader_html());
        $template->header_append(get_editor_header());
        $template->header_append(get_uploader_header());
    break;
    case 2:
        $template->view('blog_markdown_edit');
        require 'display_markdown_editor.php';
        $template->set('slug', $slug);
        $template->set('parent_url', $row['parent_url']);
        $template->set('new', (!empty($row['new'])));
        $template->set('clean_title', isset($row['clean_title']) ? $row['clean_title'] : $row['title']);
        $template->set('title', $row['title']);
        $template->set('featured_image', $row['featured_image']);
        $template->set('description', $row['description']);
        $template->set('editor', get_editor_html('editor', $row['content']));
        $template->set('editor_d', get_editor_html('editor_d', $row['description']));
        $template->header_append(get_editor_header());
    break;
    }
}
