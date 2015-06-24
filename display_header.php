<?php
// ---------------------------------------------------------------------------
// Display a header
// ---------------------------------------------------------------------------

if(!defined('RUNNING')) exit(-1);

$template->header('header');

$menu = array();

$pages_list = $db->query("SELECT title,slug,parent_id,id FROM mae_posts WHERE section=2 AND status=2");
while($row = $pages_list->fetchArray()) {
    $page_id = '' . $row['id'];
    $parent_id = '' . $row['parent_id'];
    $menu[$page_id] = array(
        'slug' => $row['slug'],
        'title' => $row['title'],
        'titles' => $row['title'],
        'parent_id' => $parent_id,
        'children' => array()
    );
}

foreach($menu as $id => $menu_item) {
    if(!empty($menu_item['parent_id'])) {
        $menu[$menu_item['parent_id']]['children'][] = $menu_item;
        unset($menu[$id]);
    }
}

if($user->can_edit) {
    $menu[-1] = array(
        'slug' => '#',
        'title' => '+',
        'children' => array(
            0 => array(
                'slug' => "javascript:inform('View blog posts...',
                    '<a href=\'/posts/published/\'>published</a> or <a href=\'/posts/unpublished/\'>draft</a>',
                    'info', 200, 20000)",
                'title' => 'view blog posts'
            ),
            1 => array(
                'slug' => "javascript:inform('Create blog post using...',
                    '<a href=\'/blog/new_rich/edit/\'>rich text</a> or <a href=\'/blog/new_markdown/edit/\'>markdown</a>',
                    'info', 200, 20000)",
                'title' => 'new blog post'
            ),
            2 => array(
                'slug' => "javascript:inform('View pages...',
                    '<a href=\'/pages/published/\'>published</a> or <a href=\'/pages/unpublished/\'>draft</a>',
                    'info', 200, 20000)",
                'title' => 'view pages'
            ),
            3 => array(
                'slug' => "javascript:inform('Create page using...',
                    '<a href=\'/new_rich/edit/\'>rich text</a> or <a href=\'/new_markdown/edit/\'>markdown</a>',
                    'info', 200, 20000)",
                'title' => 'new page'
            ),
            4 => array(
                'slug' => "javascript:inform('View notes...',
                    '<a href=\'/notes/published/\'>published</a> or <a href=\'/notes/unpublished/\'>draft</a>',
                    'info', 200, 20000)",
                'title' => 'view notes'
            ),
            5 => array(
                'slug' => "javascript:inform('Create note using...',
                    '<a href=\'/note/new_rich/edit/\'>rich text</a> or <a href=\'/note/new_markdown/edit/\'>markdown</a>',
                    'info', 200, 20000)",
                'title' => 'new note'
            ),
        )
    );
}

$template->set('main_menu', $menu);
