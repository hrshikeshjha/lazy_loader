<?php
include('../../../wp-config.php');
$start=$_POST['min']; // page number
$end=$_POST['end']; // total number of post display in a page.
$max=$_POST['max']; // total count of post.
?>
<?php
if($start=='latest'){
$post_ids = get_posts(array(
    $args, //Your arguments
    'fields'        => 'ids', // Only get post IDs
));
$count=count($post_ids);
$n=0;
for($i=0; $count>$i; $i++) {
$id=$post_ids[$i];
$post   = get_post( $id );
$title=$post->post_title;
$content=$post->post_content;
$category=$post->the_category;
if (strpos($content, '<img') !== false) {
preg_match_all('/<img[^>]+>/i',$content, $img); 
$img=$img[0];
$image=$img[0];
$imgsrc = (string) reset(simplexml_import_dom(DOMDocument::loadHTML($image))->xpath("//img/@src"));
}else { $imgsrc='';}
$content = strip_tags($content);
if (strlen($content) > 500) {
    $stringCut = substr($content, 0, 500);
    $content = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
}
$n++;
?>
<div class="lazy-container">
<header class="entry-header">
<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
<div class="post-info"><span class="post-italic">on</span> <span class="post-italic_info"><?php the_time('F j, Y'); ?></span> <span class="post-italic">in</span> <span class="post-italic_info"><?php the_category();?></span></div>
</header>
<div class="entry-content">
<?php if($imgsrc!=''){echo '<img src="'.$imgsrc.'" width="100%">';}?>
<div class="lazy-content"><?php echo $content; ?></div>
</div> 
<a href="<?php the_permalink(); ?>" class="readmore_link"><div class="readmore">Read More &rarr;</div></a>
</div>
<?php if ($end==$n) {exit();} } }?>


<?php
if($start>0){
$post_ids = get_posts(array(
    $args, //Your arguments
    'fields'        => 'ids', // Only get post IDs
));
$count=count($post_ids);
$start=$end*$start;
$n=0;
for($i=$start; $count>$i; $i++) {
$id=$post_ids[$i];
$post   = get_post( $id );
$title=$post->post_title;
$content=$post->post_content;
$category=$post->the_category;
if (strpos($content, '<img') !== false) {
preg_match_all('/<img[^>]+>/i',$content, $img); 
$img=$img[0];
$image=$img[0];
$imgsrc = (string) reset(simplexml_import_dom(DOMDocument::loadHTML($image))->xpath("//img/@src"));
}else { $imgsrc='';}
$content = strip_tags($content);
if (strlen($content) > 500) {
    $stringCut = substr($content, 0, 500);
    $content = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
}
$n++;
?>
<div class="lazy-container">
<header class="entry-header">
<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
<div class="post-info"><span class="post-italic">on</span> <span class="post-italic_info"><?php the_time('F j, Y'); ?></span> <span class="post-italic">in</span> <span class="post-italic_info"><?php the_category();?></span></div>
</header>
<div class="entry-content">
<?php if($imgsrc!=''){echo '<img src="'.$imgsrc.'" width="100%">';}?>
<div class="lazy-content"><?php echo $content; ?></div>
</div> 
<a href="<?php the_permalink(); ?>" class="readmore_link"><div class="readmore">Read More &rarr;</div></a>
</div>
<?php if ($end==$n) {exit();} } }?>

