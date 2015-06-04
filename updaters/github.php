<?php

/*
 */

error_reporting(E_ALL);
require '../config.php';

$db = new SQLite3($config['db_file']);

// First, load all source ids so that we do not have duplicates
$existing_source_ids = array();
$result = $db->query("SELECT source_id FROM blog_blogpost WHERE content_type=3");
while ($row = $result->fetchArray(SQLITE3_NUM)) {
  $existing_source_ids[$row[0]] = true;
}

$stmt = $db->prepare("INSERT INTO blog_blogpost(site_id,in_sitemap,user_id,status,gen_description,allow_comments,content_type,format_type,rating_sum,rating_count,rating_average,comments_count,keywords_string,source_id,slug,short_url,featured_image,title,content,description,publish_date,ref_url) VALUES(1,1,2,2,1,1,3,2,5,1,5,0,'',:sourceid,:slug,:shorturl,:featuredimage,:title,:content,:description,:publishdate,:refurl)");

$USER_ID = $config['updaters']['github']['user_id'];
$API_URL = 'https://api.github.com/users/'.$USER_ID.'/events';

$MAX_ITEMS = 500;

$options  = array('http' => array('user_agent'=> 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.37 Safari/537.36'));
$context  = stream_context_create($options);
$feed = json_decode(file_get_contents($API_URL, false, $context));

$item_ctr = 0;
foreach ($feed as $item) {
  if(isset($existing_source_ids[$item->id])) {
    continue;
  }

  if($item->type != 'IssuesEvent') {
    continue;
  }

  if($item->payload->action != 'opened') {
    continue;
  }

  if(++$item_ctr > $MAX_ITEMS) {
    break;
  }

  $source_id = $item->id;
  $slug = trim(substr(preg_replace('/\W+/i', '-', $item->payload->issue->title), 0, 199), '-');
  $short_url = $config['site_root'].'/blob/'.$slug.'/';
  $title = $item->payload->issue->title;
  $published = $item->payload->issue->created_at;
  $body = str_replace("\r\n", "\n", str_replace("\0",'',$item->payload->issue->body));
  $featured_image = 'uploads/blog/cfr2/github.png';
  $content = $body;
  $ref_url = $item->payload->issue->html_url;
  $description_lines = explode("\n", $body);
  $description = $description_lines[0];

  echo $slug."\n"
    .$source_id."\n"
    .$short_url."\n"
    .$published."\n"
    .$featured_image."\n"
    .$content."\n"
    .$description."\n"
    ."--- --- --- ---"
    ."\n\n";

  $stmt->bindValue(':sourceid', $source_id, SQLITE3_TEXT);
  $stmt->bindValue(':slug', $slug, SQLITE3_TEXT);
  $stmt->bindValue(':shorturl', $short_url, SQLITE3_TEXT);
  $stmt->bindValue(':title', $title, SQLITE3_TEXT);
  $stmt->bindValue(':publishdate', $published);
  $stmt->bindValue(':featuredimage', $featured_image, SQLITE3_TEXT);
  $stmt->bindValue(':content', $content, SQLITE3_TEXT);
  $stmt->bindValue(':description', $description, SQLITE3_TEXT);
  $stmt->bindValue(':refurl', $ref_url, SQLITE3_TEXT);
  $stmt->execute();
}

?>
