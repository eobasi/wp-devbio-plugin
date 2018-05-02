<?php

/**
 * Definition of tempate constants.
 */
define('DEVBIO_DS', DIRECTORY_SEPARATOR);
define('DEVBIO_PLUGIN_DIR', plugin_dir_path( plugin_dir_path( __FILE__ ) ) . DEVBIO_DS);

define('DEVBIO_PREFIX', 'dev_bio_');
define('DEVBIO_WIDGET_PREFIX', DEVBIO_PREFIX.'widget_');

define('DEVBIO_PROJECTS', 'devbio_projects');
define('DEVBIO_TESTIMONY', 'devbio_testimony');
define('DEVBIO_WORK', 'devbio_work');

function devbio_dir_url()
{
	return plugin_dir_url(plugin_dir_path( __FILE__ ));
}
// ----------------------------------------------
// ---------- excerpt length adjust -------------
// ----------------------------------------------

function truncate_post($amount,  $truncate = false)
{
	$truncate = $truncate ? $truncate : get_the_content();
	$truncate = apply_filters('the_content', $truncate);
	$truncate = preg_replace('@<script[^>]*?>.*?</script>@si', '', $truncate);
	$truncate = preg_replace('@<style[^>]*?>.*?</style>@si', '', $truncate);
	$truncate = strip_tags($truncate);
	$truncate = substr($truncate, 0, strrpos(substr($truncate, 0, $amount), ' '));
	return "$truncate ... ";
}

require_once(DEVBIO_PLUGIN_DIR.'inc/widgets.php');

// Register custom post types
function create_post_type()
{
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Categories', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Catetory', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Categories', 'textdomain' ),
		'all_items'         => __( 'All Categories', 'textdomain' ),
		'parent_item'       => __( 'Parent Catetory', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Catetory:', 'textdomain' ),
		'edit_item'         => __( 'Edit Catetory', 'textdomain' ),
		'update_item'       => __( 'Update Catetory', 'textdomain' ),
		'add_new_item'      => __( 'Add New Catetory', 'textdomain' ),
		'new_item_name'     => __( 'New Catetory Name', 'textdomain' ),
		'menu_name'         => __( 'Catetory', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'project-category' ),
	);

	register_taxonomy( DEVBIO_PROJECTS.'_category', array( DEVBIO_PROJECTS ), $args );

	// Add new taxonomy, NOT hierarchical (like tags)
	$labels = array(
		'name'                       => _x( 'Tags', 'taxonomy general name', 'textdomain' ),
		'singular_name'              => _x( 'Tag', 'taxonomy singular name', 'textdomain' ),
		'search_items'               => __( 'Search Tags', 'textdomain' ),
		'popular_items'              => __( 'Popular Tags', 'textdomain' ),
		'all_items'                  => __( 'All Tags', 'textdomain' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Tag', 'textdomain' ),
		'update_item'                => __( 'Update Tag', 'textdomain' ),
		'add_new_item'               => __( 'Add New Tag', 'textdomain' ),
		'new_item_name'              => __( 'New Tag Name', 'textdomain' ),
		'separate_items_with_commas' => __( 'Separate tags with commas', 'textdomain' ),
		'add_or_remove_items'        => __( 'Add or remove tags', 'textdomain' ),
		'choose_from_most_used'      => __( 'Choose from the most used tags', 'textdomain' ),
		'not_found'                  => __( 'No tags found.', 'textdomain' ),
		'menu_name'                  => __( 'Tags', 'textdomain' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'project-tag' ),
	);

	register_taxonomy( DEVBIO_PROJECTS.'_tag', DEVBIO_PROJECTS, $args );
	
	register_post_type( DEVBIO_PROJECTS, array(
		'labels' => array(
			'name' => __( 'Projects' ),
			'singular_name' => __( 'Project' )
		),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array('slug' => 'projects'),
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
			'excerpt', 
			'revisions' 
		),
		'taxonomies' => array(
			DEVBIO_PROJECTS.'_category',
			DEVBIO_PROJECTS.'_tag'
		),
		'menu_icon' => 'dashicons-portfolio',
	));
	
	register_post_type( DEVBIO_TESTIMONY, array(
		'labels' => array(
			'name' => __( 'Testimonies' ),
			'singular_name' => __( 'Testimony' )
		),
		'public' => true,
		'exclude_from_search' => false,
		'has_archive' => false,
		'rewrite' => array('slug' => 'testimonies'),
		'supports' => array(
			'title',
			'editor',
			'custom-fields', 
			'revisions' 
		),
		'menu_icon' => 'dashicons-format-quote',
	));
	
	register_post_type( DEVBIO_WORK, array(
		'labels' => array(
			'name' => __( 'Employements' ),
			'singular_name' => __( 'Employement' )
		),
		'public' => true,
		'exclude_from_search' => false,
		'has_archive' => true,
		'rewrite' => array('slug' => 'employements'),
		'supports' => array(
			'title',
			'editor',
			'custom-fields', 
			'revisions' 
		),
		'menu_icon' => 'dashicons-building',
	));
}
add_action( 'init', 'create_post_type' );

function devbio_get_domain_name( $url )
{
	$url = parse_url( $url );
	
	// get host name from URL
	$url = !empty( $url['host'] ) ? $url['host'] : $url['path'];
	$url = preg_match( '@^(?:http://)?([^/]+)@i', $url, $matches );
	$url = $matches[1];

    // get last two segments of host name
    $url = preg_match('/([^.]+)\.[^.]+$/', $url, $matches);
	
    return ucfirst( $matches[1] );
}

function devbio_gen_img_tag( $src )
{
	return "<img src='$src' class='attachment-thumbnail-widget-big size-thumbnail-widget-big wp-post-image' alt=''>";
}

//function to call first uploaded image in functions file
function main_image( $id = null )
{
	$id = !empty($id) ? $id : get_the_ID();
	
	$files = get_children('post_parent='.$id.'&post_type=attachment
	&post_mime_type=image&order=desc');
	
	  if( $files ) :
		$keys = array_reverse(array_keys($files));
		$j=0;
		$num = $keys[$j];
		$image=wp_get_attachment_image($num, 'large', true);
		$imagepieces = explode('"', $image);
		$imagepath = $imagepieces[1];
		$main = wp_get_attachment_url($num);
		$template = get_template_directory();
		$the_title = get_the_title( $id );
		return $main;
	  endif;
}