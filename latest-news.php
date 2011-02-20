<?php
/**
 * @package Latest-News
 * @author James Piggot
 * @version 0.2.0
 */
/*
Plugin Name: Latest News
Plugin URI: http://chorosdesign.com/wordpress/plugins/
Description: Allows Latest News posts to be input from the admin menu and tags to output the Latest News items on your templates 
Author: James Piggot
Version: 0.2.0
Author URI: http://chorosdesign.com
License: GPL2
*/
add_action('init', 'jep_latest_news_init');
function jep_latest_news_init() 
{
  // Create new Latest-News custom post type
    $labels = array(
    'name' => _x('Latest News', 'post type general name'),
    'singular_name' => _x('Latest News', 'post type singular name'),
    'add_new' => _x('Add New', 'Latest News'),
    'add_new_item' => __('Add New Latest News'),
    'edit_item' => __('Edit Latest News'),
    'new_item' => __('New Latest News'),
    'view_item' => __('View Latest News'),
    'search_items' => __('Search Latest News'),
    'not_found' =>  __('No Latest News found'),
    'not_found_in_trash' => __('No Latest News found in Trash'), 
    '_builtin' =>  false, 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
  	'exclude_from_search' => false,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => 20,
    'supports' => array('title','editor','author','thumbnail','excerpt','comments'),
  	'taxonomies' => array('category', 'post_tag')
  ); 
  register_post_type('latest-news',$args);  
}

/*
	Template function to output the latest news stories
*/
function jep_latest_news_loop($args = null)	{
	$defaults = array(
		'news_items' => 5, 
		'title' => TRUE,
		'content' => TRUE, 
		'before_title' => '<h3>',
		'after_title' => '<h3>', 
		'before_entry' => '<div class="entry-content">',
		'after_entry' => '</div>'
	);
	
	global $paged;

	$r = wp_parse_args( $args, $defaults );
  	
	$qargs=array(
	   	'post_type'=>'latest-news',
	   	'posts_per_page' => $r[news_items],
		'paged' => $paged
	);

	query_posts($qargs);
 
	while ( have_posts() ) : the_post(); 
	
		if ($r[title]): echo($r[before_title]);?><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php echo($r[after_title]);?>
		<?php endif;?>
		
		<?php if ($r[content]):
				global $more; $more = 0;	/** cure MORE tag problems */?>
				<?php echo($r[before_entry]);?>
				<?php the_content('read more...');?>
				<?php echo($r[after_entry]);?>
		<?php endif;?>	
	<?php endwhile;
}
?>
