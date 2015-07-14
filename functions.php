<?php
/*
    Copyright 2015 Jorge Rodriguez(jycr753)

    Licensed under the Apache License, Version 2.0 (the "License");
    you may not use this file except in compliance with the License.
    You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

    Unless required by applicable law or agreed to in writing, software
    distributed under the License is distributed on an "AS IS" BASIS,
    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    See the License for the specific language governing permissions and
    limitations under the License.

    Functions File V. 1.0.2
 */

define ('WP_CHILD_THEME_DIR', dirname (get_bloginfo ('stylesheet_url')));

function removeMenuItems () {
	$current_user = get_current_user ();
	if ($current_user != 2 || $current_user != 1) {
		//something to hide here
	}
}
add_action ('admin_init', 'removeMenuItems');

function getChildThemeDirectoryUrl () {
	return WP_CHILD_THEME_DIR;
}

add_shortcode ('content_url', 'getChildThemeDirectoryUrl');


function rename_admin_menu_items ($menu) {
	$menu = str_ireplace ('Dashboard', 'Home', $menu);
	return $menu;
}
add_filter ('gettext', 'rename_admin_menu_items');
add_filter ('ngettext', 'rename_admin_menu_items');


function addScripts () {
	wp_enqueue_style ('css-jycr753', WP_CHILD_THEME_DIR . '/scss/extension.css', array (), '0.1', 'all');
	wp_enqueue_script ('js-jycr753', WP_CHILD_THEME_DIR . '/js/main.js', array ('jquery'), '1.0', false);
}
add_action ('wp_enqueue_scripts', 'addScripts');


function wpChangeTitleForCustomPostType ($title) {
	$screen = get_current_screen ();

	if ('product' == $screen->post_type) {
		$title = 'Enter Item Name';
	}
	return $title;
}
add_filter ('enter_title_here', 'wpChangeTitleForCustomPostType');

function wpChangeFeatureImageTextForCustomPostType ($content) {
	$screen = get_current_screen ();
	if ('profile' == $screen->post_type) {

		$content = str_replace (__ ('Set Featured image'), __ ('Add Profile Image'), $content);
		$content = str_replace (__ ('Remove featured image'), __ ('Remove Profile Image'), $content);
	}
	return $content;
}
add_filter ('admin_post_thumbnail_html', 'wpChangeFeatureImageTextForCustomPostType');

function changeAdminBarMessage ($translated_text, $text, $domain) {
	$new_message = str_replace ('Howdy', 'Hola', $text);
	return $new_message;
}
add_filter ('gettext', 'changeAdminBarMessage', 10, 3);

function customWordpressFooter () {
	echo 'Fueled by <a href="http://www.wordpress.org" target="_blank">WordPress</a> | Develop in part by <a href="http://www.blog.jorgerodriguez.dk" target="_blank">Jorge Rodriguez (jycr753)</a></p>';
}
add_action ('admin_footer_text', 'customWordpressFooter');

function defaultAttachmentDisplaySettings () {
	update_option ('image_default_align', 'none');
	update_option ('image_default_link_type', 'none');
}
add_action ('after_setup_theme', 'defaultAttachmentDisplaySettings');