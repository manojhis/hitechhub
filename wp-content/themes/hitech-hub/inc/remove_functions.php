<?php 

function dequeue_my_css() {
	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('wordfenceAJAXcss');
	wp_dequeue_style('post-views-counter-frontend');
	wp_dequeue_style('rank-math');
	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('dashicons');
  }
  add_action('wp_enqueue_scripts','dequeue_my_css', 100);

  remove_action( 'wp_head', 'wp_oembed_add_discovery_links');

?>