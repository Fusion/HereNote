<?php
// ---------------------------------------------------------------------------
// Display a header
// ---------------------------------------------------------------------------

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
	    'slug' => $config['site_root'] . '?setting=display&show=published',
            'title' => $config['site_root'] . 'published mode');
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
                'slug' => 'blog/new_rich/edit',
                'title' => 'new rich post'
            ),
            2 => array(
                'slug' => 'blog/new_markdown/edit',
                'title' => 'new markdown post'
            ),
            3 => array(
                'slug' => 'new_rich/edit',
                'title' => 'new rich page'
            ),
            4 => array(
                'slug' => 'new_markdown/edit',
                'title' => 'new markdown page'
            ),
	)
    );
}

$template->set('main_menu', $menu);
