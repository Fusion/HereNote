<?php
// ---------------------------------------------------------------------------
// Features under development
// ---------------------------------------------------------------------------

if(!defined('RUNNING')) exit(-1);

$template->view('search');

$template->set('is_home', true);

if(!isset($_GET['search'])) {
    $template->set('error_msg', 'Please enter a search term');
}
else {
    $search_term = SQLite3::escapeString($_GET['search']);
    if(strlen($search_term) < 4) {
        $template->set('error_msg', 'Please enter at least 4 characters');
    } else {
        $results = array('pages' => array(), 'posts' => array());
        $result_list = $db->query("SELECT title,slug FROM mae_posts where status=2 AND title like '%" . $search_term . "%' OR content like '%" . $search_term . "%'");
        while($row = $result_list->fetchArray()) {
            $results['posts'][] = array('slug' => $row['slug'], 'title' => $row['title']);
        }
        $result_list = $db->query("SELECT titles,slug FROM mae_pages left join mae_pages_richtextpage on id=page_ptr_id where status=2 AND content like '%" . $search_term . "%'");
        while($row = $result_list->fetchArray()) {
            $results['pages'][] = array('slug' => $row['slug'], 'title' => $row['titles']);
        }

        if(empty($results['posts']) && empty($results['pages'])) {
            $template->set('error_msg', 'Nothing found. Try again with different keywords.');
        }
        else {
            $template->set('search_term', $search_term);
            $template->set('results', $results);
        }
    }
}
