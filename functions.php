<?php
define('THEME_VERSION', wp_get_theme()->version);
define('EDITORIAL_SLUG', 'editorial');
define('PODCAST_SLUG', 'podcast');
define('REVIEW_SLUG', 'analisis');
define('SEARCH_URL', '/buscador/');
define('LOGIN_URL', '/login/');
define('SUBTITLE_KEY', 'subtitulo');
define('VIDEO_KEY', 'video');
define('RELATED_KEY', 'relacionados');

// support stuff
add_theme_support('automatic-feed-links');
add_theme_support('title-tag');
add_theme_support('post-thumbnails');

// Show admin bar only for administrators
function dreams_hide_admin_bar($content) {
	return current_user_can('manage_options') ? $content : false;
}
add_filter('show_admin_bar', 'dreams_hide_admin_bar');

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
function dreams_style() {
	wp_enqueue_style('dream_styles', get_stylesheet_uri(), null, THEME_VERSION);
}
add_action('wp_enqueue_scripts', 'dreams_style');

// add extra thumbnail sizes
add_image_size('book-cover', 240, 340, true);
add_image_size('mini-entry', 345, 270, true);
add_image_size('related-entries', 360, 180, true);

// comments
require_once get_parent_theme_file_path('/functions/dreams_comments.php');


// custom login
function dreams_redirect_login_page() {
	$login_page  = home_url(LOGIN_URL);
	$page_viewed = basename($_SERVER['REQUEST_URI']);

	if($page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
		wp_redirect($login_page);
		exit;
	}
}
add_action('init','dreams_redirect_login_page');

function dreams_custom_login_failed() {
	$login_page  = home_url(LOGIN_URL);
	wp_redirect($login_page . '?login=failed');
	exit;
}
add_action('wp_login_failed', 'dreams_custom_login_failed');

function dreams_verify_user_pass($user, $username, $password) {
	$login_page  = home_url(LOGIN_URL);
	if($username == "" || $password == "") {
		wp_redirect($login_page . "?login=empty");
		exit;
	}
}
add_filter('authenticate', 'dreams_verify_user_pass', 1, 3);

function dreams_logout_redirect() {
	$login_page  = home_url(LOGIN_URL);
	wp_redirect($login_page . "?login=false");
	exit;
}
add_action('wp_logout','dreams_logout_redirect');

// needed to translate roles in FE
function dreams_load_admin_textdomain_in_front() {
	if (!is_admin()) {
		load_textdomain('default', WP_LANG_DIR . '/admin-' . get_locale() . '.mo');
	}
}
add_action('init', 'dreams_load_admin_textdomain_in_front');

// custom helpers
function the_subtitle($post_id = null) {
	$post_id = $post_id ?: get_queried_object_id();
	echo get_post_meta($post_id, SUBTITLE_KEY, true);
}

function has_video() {
	return !!get_post_meta(get_queried_object_id(), VIDEO_KEY, true);
}

function the_video() {
	$video_id = get_post_meta(get_queried_object_id(), VIDEO_KEY, true);
	echo '<iframe src="https://www.youtube.com/embed/'.$video_id.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
}

// related helper
function get_related_from_post() {
	$post_id = get_queried_object_id();
	$related_string = get_post_meta($post_id, RELATED_KEY, true);

	if ($related_string) {
		$related_post_ids = explode(',', $related_string);
		$args = [
			'post__in' => $related_post_ids,
			'posts_per_page' => 3,
			'orderby' => 'rand',
		];
	} else {
		$tags = wp_get_post_terms($post_id, 'post_tag', ['fields' => 'ids']);
		$args = [
			'post__not_in' => [$post_id],
			'posts_per_page' => 3,
			'ignore_sticky_posts' => 1,
			'orderby' => 'rand',
			'tax_query' => [
				[
					'taxonomy' => 'post_tag',
					'terms' => $tags
				]
			]
		];
	}

	return new WP_Query($args);
}