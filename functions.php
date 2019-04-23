<?php
define('THEME_VERSION', wp_get_theme()->version);
define('EDITORIAL_SLUG', 'editorial');
define('PODCAST_SLUG', 'podcast');
define('REVIEW_SLUG', 'analisis');
define('SEARCH_URL', '/buscador/');
define('LOGIN_URL', '/login/');
define('REGISTER_URL', '/registro/');
define('LOST_PASSWORD', '/recuperar-password/');
define('SUBTITLE_KEY', 'subtitulo');
define('VIDEO_KEY', 'video');
define('RELATED_KEY', 'relacionados');
define('AVATAR_META_KEY', 'avatar');
define('AVATAR_FOLDER', '/avatar/');

add_action('wp_enqueue_scripts', 'dreams_load_comments_js');
add_action('wp_enqueue_scripts', 'dreams_load_audio_player_js');
add_action('wp_enqueue_scripts', 'dreams_load_profile_js');

// support stuff
add_theme_support('automatic-feed-links');
add_theme_support('title-tag');
add_theme_support('post-thumbnails');

add_filter('show_admin_bar', 'dreams_hide_admin_bar');
add_filter('rewrite_rules_array', 'dreams_disable_embeds_rewrites');
add_filter('get_avatar', 'dreams_get_avatar', 10, 5);
add_filter('comment_text', 'dreams_bbcode_format_comments');
add_filter('comment_text', 'dreams_mention_comments');

add_action('init', 'dreams_menus');
add_action('wp_enqueue_scripts', 'dreams_style');
add_action('init', 'dreams_load_admin_textdomain_in_front');

// login stuff
add_action('init','dreams_redirect_login_page');
add_filter('login_redirect', 'dreams_after_login_redirect', 10, 3);
add_action('wp_logout','dreams_logout_redirect');
add_action('login_form_lostpassword', 'dreams_lostpassword_page');

// add extra thumbnail sizes
add_image_size('book-cover', 240, 340, true);
add_image_size('mini-entry', 345, 270, true);
add_image_size('related-entries', 360, 180, true);

// remove oEmbed shizzle
add_filter('embed_oembed_discover', '__return_false');
remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
remove_action('rest_api_init', 'wp_oembed_register_route');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');

add_action('admin_menu', 'dreams_admin_menu');
add_action('wp_ajax_dreams_comment_submit', 'dreams_comment_submit');
add_action('wp_ajax_nopriv_dreams_comment_submit', 'dreams_comment_submit');

require_once get_parent_theme_file_path('/functions/dreams_comments.php');

function dreams_load_comments_js() {
	if (is_single()){
		$params = [
			'ajaxurl' => admin_url('admin-ajax.php'),
			'ajax_nonce' => wp_create_nonce('ajax'),
		];
		wp_enqueue_script( 'dreams_comments_js', get_template_directory_uri() . '/js/comments.js', [], THEME_VERSION);
		wp_localize_script('dreams_comments_js', 'ajax_object', $params);
	}
}

function dreams_load_audio_player_js() {
	if (is_home()) {
		wp_enqueue_script( 'dreams_audio_player_js', get_template_directory_uri() . '/js/audio-player.js', [], THEME_VERSION);
	}
}

function dreams_load_profile_js() {
	if (is_page_template('page-templates/perfil.php')) {
		wp_enqueue_script( 'dreams_profile_js', get_template_directory_uri() . '/js/profile.js', [], THEME_VERSION);
	}
}

function dreams_mention_comments($comment_text) {
	return preg_replace('/@([A-Za-z0-9_]+)/', '<span class="mention">@$1</span>', $comment_text);
}

function dreams_bbcode_format_comments($comment_text) {
	$quote_limit = 3;

	$quotes_find = [
		'~\[quote\](.*?)\[/quote\]~s',
		'~\[quote=&#8221;(.*?)&#8221;\](.*?)\[/quote\]~s',
	];

	$quotes_replace = [
		'<blockquote>$1</blockquote>',
		'<blockquote><cite>$1 dijo:</cite><br>$2</blockquote>',
	];

	for ($count = 0; $count < $quote_limit; $count++) {
		$comment_text = preg_replace($quotes_find, $quotes_replace, $comment_text);
	}

	$find = [
		'~\[b\](.*?)\[/b\]~s',
		'~\[i\](.*?)\[/i\]~s',
		'~\[u\](.*?)\[/u\]~s',
		'~\[strike\](.*?)\[/strike\]~s',
		'~\[url\]((?:ftp|https?)://[^"><]*?)\[/url\]~s',
		'~\[url=((?:ftp|https?)://[^"><]*?)\](.*?)\[/url\]~s',
		'~\[img\](https?://[^"><]*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s',
	];

	$replace = [
		'<b>$1</b>',
		'<i>$1</i>',
		'<span style="text-decoration:underline;">$1</span>',
		'<del>$1</del>',
		'<a rel="nofollow" href="$1">$1</a>',
		'<a rel="nofollow" href="$1">$2</a>',
		'<img src="$1" alt="" />',
	];

	return preg_replace($find, $replace, $comment_text);
}

function dreams_admin_menu() {
	add_menu_page('Configuración Portada', 'Portada', 'edit_theme_options', 'dreams-admin-menu', 'dreams_admin_menu_portada');
}

function dreams_admin_menu_portada() {
	include(get_template_directory() . '/admin/portada.php');
}

// Show admin bar only for administrators
function dreams_hide_admin_bar($content) {
	return current_user_can('manage_options') ? $content : false;
}

function dreams_disable_embeds_rewrites($rules) {
	foreach($rules as $rule => $rewrite) {
		if(false !== strpos($rewrite, 'embed=true')) {
			unset($rules[$rule]);
		}
	}
	return $rules;
}

function dreams_comment_submit() {
	$comment = wp_handle_comment_submission(wp_unslash($_POST));
	$options = ([
		'style'      => 'ol',
		'short_ping' => true,
		'avatar_size' => 38,
		'callback' => 'dreams_comments'
	]);
	echo wp_list_comments($options, [$comment]);
	wp_die();
}

// add menus
function dreams_menus() {
	register_nav_menus([
		'header-menu' => 'Header',
		'nav-menu' => 'Sidebar',
		'footer-menu' => 'Footer',
		'legal-menu' => 'Legal',
	]);
}

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

// custom login
function dreams_redirect_login_page() {
	if(basename($_SERVER['REQUEST_URI']) == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET' && get_page_by_path(LOGIN_URL)) {
		wp_redirect(home_url(LOGIN_URL));
		exit;
	}
}

function dreams_after_login_redirect($redirect_to, $requested_redirect_to, $user) {
	if (is_wp_error($user) && get_page_by_path(LOGIN_URL)) {
		$error = array_keys($user->errors)[0];
		wp_redirect(home_url(LOGIN_URL) . '?login=failed&reason=' . $error);
		exit;
	}

	return $redirect_to;
}

function dreams_logout_redirect() {
	if (get_page_by_path(LOGIN_URL)) {
		wp_redirect(home_url(LOGIN_URL) . "?login=false");
		exit;
	}
}

function dreams_lostpassword_page() {
	if (get_page_by_path(LOST_PASSWORD)) {
		wp_redirect(home_url(LOST_PASSWORD));
		exit;
	}
}

// needed to translate roles in FE
function dreams_load_admin_textdomain_in_front() {
	if (!is_admin()) {
		load_textdomain('default', WP_LANG_DIR . '/admin-' . get_locale() . '.mo');
	}
}

// avatar filter
function dreams_get_avatar($avatar, $id_or_email, $size, $default, $alt) {

	if(!is_numeric($id_or_email) && is_string($id_or_email) && is_email($id_or_email)) {
		$user = get_user_by('email', $id_or_email);
		if($user){
			$id_or_email = $user->ID;
		}
	}

	if(!is_numeric($id_or_email)) {
		return $avatar;
	}

	$saved = get_user_meta($id_or_email, AVATAR_META_KEY, true);
	if(!empty($saved)) {
		$image_path = wp_upload_dir()['baseurl'] . AVATAR_FOLDER . $saved;
		return "<img alt='{$alt}' src='{$image_path}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
	}

	return $avatar;
}

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