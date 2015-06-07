<?php
// ---------------------------------------------------------------------------
// Features under development
// ---------------------------------------------------------------------------

$template->view('search');

$results = array('pages' => array(), 'posts' => array());
$result_list = $db->query("SELECT title,slug FROM mae_posts where title like '%" . 'test' . "%' OR content like '%" . 'test' . "%'");
while($row = $result_list->fetchArray()) {
    $results['posts'][] = array('slug' => $row['slug'], 'title' => $row['title']);
}
$result_list = $db->query("SELECT titles,slug FROM mae_pages left join pages_richtextpage on id=page_ptr_id where content like '%" . 'test' . "%'");
while($row = $result_list->fetchArray()) {
    $results['pages'][] = array('slug' => $row['slug'], 'title' => $row['titles']);
}

$template->set('is_home', true);
$template->set('results', $results);
