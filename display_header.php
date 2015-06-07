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

$template->set('main_menu', $menu);
