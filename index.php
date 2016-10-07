<?php 
/*
Plugin Name: Lazy Loader
Plugin URI: http://inmaxsys.com
Description: Use Short Code -" [lazy-loader class='lazy-loader'][/lazy-loader] " This plugin will auto load posts on scroll.It gives better user experience while navigating you blog posts.
Author: Inmaxsys 
Author URI: http://inmaxsys.com
Text Domain: Lazy Loader, Auto Load
Version: 1.0
*/

wp_register_style( 'Lazy-Loader-CSS', home_url().'/wp-content/plugins/lazy_loader/lazy_loader.css' ); 
wp_enqueue_style('Lazy-Loader-CSS');
wp_register_script( 'Lazy-Loader-JS', home_url().'/wp-content/plugins/lazy_loader/jquery.min.js' ); 
wp_enqueue_script('Lazy-Loader-JS');

add_action( 'admin_menu', 'Lazy_Loader_custom_admin_menu' );
 
function Lazy_Loader_custom_admin_menu() {
    add_options_page(
        'Lazy Loader',
        'Lazy Loader',
        'manage_options',
        'Lazy-Loader',
        'Lazy_Loader_options_page'
    );
}
function Lazy_Loader_options_page() {

    echo '<div class="wrap">
        <h2>Lazy Loader : Options</h2>
<b>This plugin will auto load posts on scroll.</b>
<br><br>
To use this plugin please follow the below steps.
<br>
1.) Creat a Page for listing you posts.
<br>
2.) Copy The short code <b style="color:#09c">[lazy-loader class="lazy-loader"][/lazy-loader]</b> and past in to newly created page.
<br><br>
Thats all.. you are done...<br><br>
Now if you access your newly created page it will load your posts on scroll... 
    </div>
    
 <div style="margin: 20px; padding: 50px; padding-top: 30px; background-color: #f5f5f5; width:400px; border: 1px dashed #c5c5c5;">
<p><big><b>Make a Donation to Lazy Loader</b></big><br />
Please help our development to grow more.</p>
 
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
 
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="sylpho4u@gmail.com">
    <strong>Donation / Contribution? </strong><br />
    <input type="hidden" name="item_name" value="Donation -Lazy Loader">
    <input type="hidden" name="item_number" value="1">
    <strong>How much do you want to donate?</strong><br />
    $ <input type="text" name="amount">
 
    <input type="hidden" name="no_shipping" value="0">
    <input type="hidden" name="no_note" value="1">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="bn" value="PP-BuyNowBF">
    <br /><br />
    <input type="submit" value="Pay with PayPal!" style="background:#09c; color:#fff; border:none; border-radius:5px; cursor:pointer; width:173px;">
 
</form>
</div>
    
    ';
   }




function lazy_loader_shortcode( $atts, $caption ) {
	$a = shortcode_atts( array(
		'class' => $caption,
	), $atts);
	

$posts_per_page = get_option('posts_per_page');
$count_posts = wp_count_posts('post');
$published_posts = $count_posts->publish;
$autoloader=home_url().'/wp-content/plugins/lazy_loader/lazy_loader.php';
$autoloader_img=home_url().'/wp-content/plugins/lazy_loader/loader.gif';
$data='<ul id="posts"></ul>
<p id="loading" style="text-align:center;"><img src="'.$autoloader_img.'" /></p>
<script>$(document).ready(function() {
     var start="latest";
			$.ajax({
				url: "'.$autoloader.'",
				type: "POST",
                data: {min:start, end:'.$posts_per_page.', max:'.$published_posts.'},
				dataType: "html",
				success: function(html) {
					$("#posts").append(html);
					$("#loading").hide();
				}
			});



	var win = $(window);
    var start=1;
	win.scroll(function() {
		if ($(document).height() - win.height() == win.scrollTop()) {
			

			$.ajax({
				url: "'.$autoloader.'",
				type: "POST",
                data: {min:start, end:'.$posts_per_page.', max:'.$published_posts.'},
				dataType: "html",
				success: function(html) {
					$("#posts").append(html);
					$("#loading").hide();
				}
			});
			var loaderimg=start*'.$posts_per_page.';
			if ('.$published_posts.'>loaderimg) {start++; $("#loading").show();}

     		$("#posts").append(randomPost());
			$("#loading").hide();
		}
	});
	
});
</script>
';
	return '<div class="' . esc_attr($a['class']) . '">' .$data.'</div> <div class="clear"></div>';
}
$captions=array('lazy-loader');
$count=count($captions);
for ($i=0; $i<$count; $i++) {
$caption=$captions[$i];
add_shortcode( $caption, 'lazy_loader_shortcode' );
}