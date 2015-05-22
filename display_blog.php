<?php
// ---------------------------------------------------------------------------
// Display a single blog page
// ---------------------------------------------------------------------------

$template->view('blog');

$slug = $db->escapeString($_GET['blog']);
$row = $db->querySingle("SELECT * FROM blog_blogpost WHERE slug='" . $slug . "'", true);
if(empty($row)) {
    die("Ooops. 404 and all that :(");
}

if($row['format_type'] == 2) {
    require 'thirdparty/Parsedown.php';
    $Parsedown = new Parsedown();
    $content = $Parsedown->text($row['content']);
    $content2 = <<<EOB
<script>
$(document).ready(function() {
  $('pre code').each(function(i, block) {
    hljs.highlightBlock(block);
  });
});
</script>
EOB;
}
else if($row['format_type'] == 1) {
    $content = $row['content'];
    $content2 = <<<EOB
<script>
$(document).ready(function() {
  $('pre').each(function(i, block) {
    hljs.highlightBlock(block);
  });
});
</script>
EOB;
}
else {
    $content = $row['content'];
    $content2 = '';
}

switch($row['content_type']) {
case 2:
    $content_logo = '/assets/img/google_plus.png';
    $content_header = 'From my G+ Feed:';
break;
case 3:
    $content_logo = '/assets/img/github.png';
    $content_header = 'From my Github Feed:';
break;
default:
    $content_logo = false;
    $content_header = false;
}

$template->set('id', $row['id']);
$template->set('title', $row['title']);
$template->set('ref_url', $row['ref_url']);
$template->set('content_type', $row['content_type']);
$template->set('format_type', $row['format_type']);
$template->set('content', $content . "\n" . $content2);
$template->set('content_logo', $content_logo);
$template->set('content_header', $content_header);
?>
