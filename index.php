<?php
/*
    Plugin Name: Kneejerk Menu Swapper
    Plugin URI: https://kneejerk.dev/menu-swapper
    Description: Allows you to configure and swap WordPress Navigation Menus of your theme for logged in users.
    Author: Ryan "Rohjay" Oeltjenbruns
    Author URI: https://rohjay.one/about
    Version: 0.3.1
    Requires at least: 5.0
    Requires PHP: 7.2
    Tags: Menus, Navigation, logged in, users
*/

namespace Kneejerk\MenuSwapper;

require_once __DIR__ . '/src/responder.php';
define( 'KJD_MENU_SWAPPER_OPTION_NAME', 'kjd_menu_swapper_config' );
define( 'KJD_MENU_SWAPPER_URI', plugin_dir_url(__FILE__) );

// Register the Kneejerk Admin Menu
\add_action('admin_menu', 'Kneejerk\MenuSwapper\register_admin_menu');
function register_admin_menu() {
    \add_menu_page(
        $page_title             = 'Menu Swapper by Kneejerk Development',
        $menu_title             = 'Menu Swapper',
        $capability_required    = 'administrator',
        $menu_slug              = 'kneejerk',
        $callable_function      = 'Kneejerk\MenuSwapper\admin_menu',
        $icon_url               = \plugins_url( 'images/wp_logo.png', __FILE__ ) // baller icon incoming!
    );
}

// Admin Menu callback - loads the necessary data to render the page
function admin_menu() {
    $menus = \wp_get_nav_menus();
    $resorted_menus = [];
    foreach ( $menus as $k => $menu ) {
        $resorted_menus[$menu->term_id] = $menu;
    }
    $data = [
        'menus' => $resorted_menus,
        'theme_menus' => \get_registered_nav_menus(),
        'menu_locations' => \get_nav_menu_locations(),
        'config' => \get_option(KJD_MENU_SWAPPER_OPTION_NAME, [])
    ];

    // echo "<plaintext>"; var_dump($data['theme_menus']); exit();

    $responder = new Responder(__DIR__ . DIRECTORY_SEPARATOR . 'templates');
    $responder->view('admin-menu.php', $data);
}

// \add_filter('plugin_action_links', 'plugin_action_links', 10, 2);
function plugin_action_links($links, $file) {
    if ( plugin_basename(__FILE__) == $file && is_array($links) ) {
        $links[] = "<a href='" . __DIR__ . "'>Configure</a>";
    }
    return $links;
}

// Make sure our admin page has jQuery loaded (don't need to load it for everything wp-admin)
\add_action( 'admin_enqueue_scripts', 'Kneejerk\MenuSwapper\enqueue_admin_scripts_and_styles' );
function enqueue_admin_scripts_and_styles($hook) {
    if ( $hook !== 'toplevel_page_kneejerk' ) {
        return;
    }
    \wp_enqueue_script( 'jQuery', null, null, null, false );
}

// Hook our ajax request, but only if we're doing ajax, and only if the request is by an administrator
\add_action( 'init', 'Kneejerk\MenuSwapper\hook_ajax_requests' );
function hook_ajax_requests() {
    if ( defined('DOING_AJAX') && DOING_AJAX && current_user_can('administrator') ) {
        \add_action( 'wp_ajax_kjd_configure_menu_swapper', 'Kneejerk\MenuSwapper\configure_menu_swapper' );
    }
}

// Code that hooks the nav menus, checks for a swappable configuration for a logged in user, and swap them!
\add_filter( 'wp_nav_menu_args', 'Kneejerk\MenuSwapper\wp_nav_menu_swapper', PHP_INT_MAX );
function wp_nav_menu_swapper( $args = [] ) {
    // Get our swapper config
    $kjd_config = \get_option(KJD_MENU_SWAPPER_OPTION_NAME);

    // Pull out the config for this menu location for swapping
    $menu_config = isset($kjd_config[$args['theme_location']]) ? $kjd_config[$args['theme_location']] : false;

    // If we have a config, the user is logged in, there is a menu to swap to, and it's enabled...
    if( $menu_config && \is_user_logged_in() && !empty($menu_config['swap']) && isset($menu_config['enabled']) ) {
        // Swap out the menu =]
        $args['menu'] = $menu_config['swap'];
    }
    return $args;
}

function configure_menu_swapper() {
    $result = \update_option(KJD_MENU_SWAPPER_OPTION_NAME, $_POST, 'yes');

    $responder = new Responder();
    if ( $result ) {
        $responder->json(true);
    } else {
        $original = \get_option(KJD_MENU_SWAPPER_OPTION_NAME);
        if ( $original == $_POST ) {
            $responder->json(true);
        }
        $responder->error('Failed to update option', 500);
    }
}
