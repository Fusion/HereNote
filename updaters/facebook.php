<?php

/*
 * description: item->description or item->name (latter needs cleanup)
 * content: item->message // not always present... if it is a link then it's a story and needs to be assembled...avoid stories?
 ( we also have picture and icon and link...
 * Important: check that item->from->id == our id! If note it's stuff posted by others
 * item->created_time
 * check item->is_hidden
 */

error_reporting(E_ALL);
require '../config.php';

$db = new SQLite3($config['db_file']);

// First, load all source ids so that we do not have duplicates
$existing_source_ids = array();
$result = $db->query("SELECT source_id FROM mae_posts WHERE content_type=" . $config['content_type']['facebook']);
while ($row = $result->fetchArray(SQLITE3_NUM)) {
  $existing_source_ids[$row[0]] = true;
}

$stmt = $db->prepare("INSERT INTO mae_posts(site_id,section,in_sitemap,user_id,status,gen_description,allow_comments,content_type,format_type,rating_sum,rating_count,rating_average,comments_count,keywords_string,source_id,slug,short_url,featured_image,title,content,description,publish_date,ref_url) VALUES(1,1,1,2,2,1,1,".$config['content_type']['facebook'].",1,5,1,5,0,'',:sourceid,:slug,:shorturl,:featuredimage,:title,:content,:description,:publishdate,:refurl)");

$ACCESS_TOKEN = $config['updaters']['facebook']['access_token'];
$USER_ID      = $config['updaters']['facebook']['user_id'];

$API_URL = 'https://graph.facebook.com/' . $USER_ID . '/feed?access_token=' . $ACCESS_TOKEN;

$MAX_ITEMS = 500;

$feed = json_decode(file_get_contents($API_URL));

foreach ($feed->data as $data) {
    print_r($data);
    break;
}

exit;

$item_ctr = 0;
foreach ($feed->data as $item) {
  if(isset($existing_source_ids[$item->id])) {
    continue;
  }

  if(++$item_ctr > $MAX_ITEMS) {
    break;
  }

  unset($suggested_featured_image);
  unset($substitute_title);
  unset($suggested_content_sub);
  unset($suggested_content);
  unset($suggested_description);

  if(!empty($item->object->content)) {
    $suggested_description = $item->object->content;
    $suggested_content = $item->object->content;
  }
  if(!empty($item->object->attachments)) {
    $substitute_title = $item->object->attachments[0]->displayName;
    $atthdr = $item->object->attachments[0]->objectType.': '.$item->object->attachments[0]->displayName.":\n";
    switch($item->object->attachments[0]->objectType) {
      case 'article':
        if(!empty($item->object->attachments[0]->image)) {
          $suggested_featured_image = $item->object->attachments[0]->image->url;
          $att = $atthdr
            .'<a href="'.$item->object->attachments[0]->url.'"><img src="'.$item->object->attachments[0]->image->url.'">'."</a>\n";
          $suggested_content_sub = 
            '<a href="'.$item->object->attachments[0]->url.'"><img src="'.$item->object->attachments[0]->image->url.'">'."</a>\n";
        }
        else {
          $att = $atthdr
            .'<a href="'.$item->object->attachments[0]->url.'">'.$item->object->attachments[0]->displayName."</a>\n";
          $suggested_content_sub = 
            '<a href="'.$item->object->attachments[0]->url.'"><img src="'.$item->object->attachments[0]->image->url.'">'."</a>\n";
        }
        if(empty($suggested_content)) {
          $suggested_description = $item->object->attachments[0]->content;
          $suggested_content = $item->object->attachments[0]->content;
        }
      break;
      case 'photo':
        $suggested_featured_image = $item->object->attachments[0]->image->url;
        $att = $atthdr
          .'<a href="'.$item->object->attachments[0]->url.'"><img src="'.$item->object->attachments[0]->image->url.'">'."</a>\n";
        $suggested_content_sub = 
          '<a href="'.$item->object->attachments[0]->url.'"><img src="'.$item->object->attachments[0]->image->url.'">'."</a>\n";
        if(empty($suggested_content)) {
          $suggested_description = $item->object->attachments[0]->content;
          $suggested_content = $item->object->attachments[0]->content;
        }
      break;
      case 'album':
        $attthumb = array();
        foreach($item->object->attachments[0]->thumbnails as $thumb) {
          if(empty($suggested_featured_image)) {
            $suggested_featured_image = $thumb->image->url;
          }
          $attthumb[] = '<a href="'.$thumb->url.'"><img src="'.$thumb->image->url.'" alt="'.$thumb->description.'">'."</a>\n";
        }
        $att = $atthdr
          .'<a href="'.$item->object->attachments[0]->url.'">'.$item->object->attachments[0]->displayName."</a>\n"
          .implode("\n", $attthumb)."\n";
        if(true || empty($suggested_content)) {
          $suggested_content_sub = 
            '<a href="'.$item->object->attachments[0]->url.'">'.$item->object->attachments[0]->displayName."</a></p><p>"
            .implode("\n", $attthumb)."\n";
        }
      break;
    }
  }
  else {
    $att = '';
  }

  $published = $item->published;

  if(!empty($item->title)) {
    $title_lines = explode("\n", $item->title);
    $title = $title_lines[0];
  }
  else if(!empty($substitute_title)) {
    $title = $substitute_title;
  }
  else {
    $title = '???';
  }
  if(!empty($suggested_featured_image)) {
    $featured_image = $suggested_featured_image;
  }
  else {
    $featured_image = 'uploads/blog/cfr2/logo_g.png';
  }

  if(empty($suggested_content_sub)) {
    #$content = '<p><a href="'.$item->url.'">From my G+ Feed:</a></p>'
    $content = '<p>'.$suggested_content.'</p>';
  }
  else {
    $content = '<p>'.$suggested_content."</p>\n<p>".$suggested_content_sub.'</p>';
  }

  $source_id = $item->id;
  $ref_url = $item->url;

  $description = $suggested_description;

  $fullText = '['.$title."]\n"
    .date('F jS Y @ H:i:s',strtotime($item->published))."\n"
    .$content."\n"
    .$att;

  if(false)
  echo $fullText
    ."--- --- --- ---"
    ."\n\n";

  $slug = trim(substr(preg_replace('/\W+/i', '-', $title), 0, 199), '-');
  $short_url = $config['site_root'].'blog/'.$slug.'/';

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
