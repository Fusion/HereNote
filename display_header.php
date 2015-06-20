<?php
// ---------------------------------------------------------------------------
// Display a header
// ---------------------------------------------------------------------------

if(!defined('RUNNING')) exit(-1);

$template->header('header');

$menu = array();

$pages_list = $db->query("SELECT title,titles,slug,parent_id,id FROM mae_pages where status=2");
while($row = $pages_list->fetchArray()) {
    $page_id = '' . $row['id'];
    $parent_id = '' . $row['parent_id'];
    $menu[$page_id] = array(
        'slug' => $row['slug'],
        'title' => $row['title'],
        'titles' => $row['titles'],
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
    if($user->get('display', 'unpublished')) {
        $pub_switch = array(
            'slug' => '?setting=display&show=published',
            'title' => 'published mode');
    }
    else {
        $pub_switch = array(
            'slug' => '?setting=display&show=unpublished',
            'title' => 'draft mode');
    }
    $menu[-1] = array(
        'slug' => '#',
        'title' => '+',
        'children' => array(
            0 => $pub_switch,
            1 => array(
                'slug' => '#',
                'title' => ''
            ),
            2 => array(
                'slug' => 'blog/new_rich/edit',
                'title' => 'new rich post'
            ),
            3 => array(
                'slug' => 'blog/new_markdown/edit',
                'title' => 'new markdown post'
            ),
            4 => array(
                'slug' => '#',
                'title' => ''
            ),
            5 => array(
                'slug' => 'pages',
                'title' => 'view pages'
            ),
            6 => array(
                'slug' => 'new_rich/edit',
                'title' => 'new rich page'
            ),
            7 => array(
                'slug' => 'new_markdown/edit',
                'title' => 'new markdown page'
            ),
            8 => array(
                'slug' => '#',
                'title' => ''
            ),
            9 => array(
                'slug' => 'notes',
                'title' => 'view notes'
            ),
            10 => array(
                'slug' => 'note/new_rich/edit',
                'title' => 'new rich note'
            ),
            11 => array(
                'slug' => 'note/new_markdown/edit',
                'title' => 'new markdown note'
            ),
        )
    );
}

$template->set('main_menu', $menu);
