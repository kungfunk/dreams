<?php
define('THEME_VERSION', wp_get_theme()->version);
define('EDITORIAL_SLUG', 'editorial');
define('PODCAST_SLUG', 'podcast');
define('REVIEW_SLUG', 'analisis');

// support stuff
add_theme_support('automatic-feed-links');
add_theme_support('title-tag');
add_theme_support('post-thumbnails');

// remove admin bar shizzle
add_filter('show_admin_bar', '__return_false');

// remove oEmbed shizzle
remove_action('rest_api_init', 'wp_oembed_register_route');
add_filter('embed_oembed_discover', '__return_false');
remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');
function dreams_disable_embeds_rewrites($rules) {
	foreach($rules as $rule => $rewrite) {
		if(false !== strpos($rewrite, 'embed=true')) {
			unset($rules[$rule]);
		}
	}
	return $rules;
}
add_filter('rewrite_rules_array', 'dreams_disable_embeds_rewrites');

// add menus
function dreams_menus() {
	register_nav_menus([
		'header-menu' => 'Header',
		'nav-menu' => 'Sidebar',
		'footer-menu' => 'Footer',
		'legal-menu' => 'Legal',
	]);
}
add_action('init', 'dreams_menus');

function dreams_get_menu_items($name) {
	$locations = get_nav_menu_locations();
	if (!array_key_exists($name, $locations)) {
		return null;
	}

	return wp_get_nav_menu_items($locations[$name]);
}

// stylesheet
function dream_style() {
	wp_enqueue_style('dream_styles', get_stylesheet_uri(), null, THEME_VERSION);
}
add_action('wp_enqueue_scripts', 'dream_style');

// add extra thumbnail sizes
add_image_size('book-cover', 240, 340, true);
add_image_size('mini-entry', 345, 270, true);
