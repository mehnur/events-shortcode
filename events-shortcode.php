<?php
/*
Plugin Name: Events Shortcode
Plugin URI: http://mehnur.org/
Description: This plugin adds an 'Events' link to your admin menu. Add a new event. Then, add a new page called 'Events' or whatever you want to call it.  Then, put the shortcode [events_shortcode] on that page, and your events will be displayed.
Author: Mehnoor Tahir
Version: 1.0.0
Author URI: http://mehnur.org/
*/

/**
 * Adds the custom post type
 */
function events_shortcode_post_type() {
	register_post_type( 
		'sesc1_events',
		array(
			'labels' => array(
				'name' => __( 'Events' ),
				'singular_name' => __( 'Event' )
			),
			'public' => true,
			'has_archive' => false,
			'menu_position'=>5
			//,'rewrite' => array('slug' => 'events')
		)
	);
}

/**
 * events_shortcode  shortcode function
 *
 * @use [events_shortcode]
 */
function events_shortcode_func( $atts ) {
	extract( shortcode_atts( array(
		'content' => 'all_content',
		'link' => 'no_link'
	), $atts ) );

	//TODO remove these hard-coded attribute-overrides in next version release
	$content = 'all_content';
	$link = 'no_link';

	return display_events_shortcode($link, $content);
}

/**
 * Display the custom-type posts
 *
 * The params will do something in future versions
 *
 * @param String $link 
 * @param String $content
 * @return String $html_str 
 */
function display_events_shortcode($link='',$content=''){
	$html_str = '';	

	$args = array( 'post_type' => 'sesc1_events', 'posts_per_page' => 100 );
	$loopy = new WP_Query( $args );

	while ( $loopy->have_posts() ) { 
		$loopy->the_post();
		$html_str .= 
			'<div class="entry-content">'
			. '<h3>'. get_the_title() . '</h3>'
			. '<div>'. wpautop(get_the_content()). '</div>'
			.'</div>';

	}

	return $html_str; 
}

add_shortcode( 'events_shortcode', 'events_shortcode_func' );
add_action( 'init', 'events_shortcode_post_type' );
