<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function mww_admin_menu_option()
{
    add_menu_page(
        MWW_PLUGIN_NAME,
        MWW_PLUGIN_NAME,
        'manage_options',
        $menu_slug = 'website-webkit',
        $callback_function = 'mww_get_plugin_pages',
        $icon_url = '',
        $position = 10
    );

    add_submenu_page(
        'website-webkit',
         MWW_PLUGIN_NAME . '-' . 'Dashboard',
        'Dashboard',
        'manage_options',
        'dashboard',
        'mww_get_plugin_pages'
    );
    add_submenu_page(
        'website-webkit',
        MWW_PLUGIN_NAME . '-' . 'Setting',
        'Setting',
        'manage_options',
        'setting',
        'mww_get_plugin_pages'
    );

}

function mww_activate()
{
    if (array_key_exists('action', $_POST) && $_POST['action'] == 'activate' && $_POST['module_id']) {
        mwww_activate_module($_POST['module_id']);
        echo 'Activated';
    } elseif (array_key_exists('action', $_POST) && $_POST['action'] == 'deactivate' && $_POST['module_id']) {
        mwww_deactivate_module($_POST['module_id']);
        echo 'Deactivated';
    }

}

add_action('wp_ajax_activate', 'mww_activate'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_activate', 'mww_activate');
add_action('wp_ajax_deactivate', 'mww_activate'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_deactivate', 'mww_activate');

add_action('admin_menu', 'mww_admin_menu_option');

function mww_get_plugin_pages()
{
    $page = $_GET['page'];
    if ($page == 'website-webkit'){
        $page = 'dashboard';
    }
    if (array_key_exists('page', $_GET) && file_exists(MWW_PLUGIN_PATH . 'includes/modules/' . $page . '.php')) {
        include_once MWW_PLUGIN_PATH . 'includes/modules/' . $page . '.php';
    }

}




function mww_register_modules()
{

    return apply_filters(
        'mg-mww-register-modules',
        array(
            'webkit-ids' => array(
                'name' => __('Webkit IDS', 'website-webkit'),
                'description' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut', 'website-webkit'),
                'icon' => 'webkit-id.png'
            ),
            'social-icons' => array(
                'name' => __('Social Icon', 'website-webkit'),
                'description' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut', 'website-webkit'),
                'icon' => 'social.png'
            )
        )

    );


}

function mwww_has_activate_module($module_id)
{

    $activate_module = mww_get_active_modules();
    if (in_array($module_id, $activate_module)) {
        return true;
    }
    return false;
}

function mwww_activate_module($module_id)
{
    $available_modules = array_keys(mww_get_modules());
    if (in_array($module_id, $available_modules)) {

        $active_modules = mww_get_active_modules();
        array_push($active_modules, $module_id);
        $all_active_unique_modules = array_unique($active_modules);
        update_option('mg-mww-activate-modules', $all_active_unique_modules);

    }

}

function mwww_deactivate_module($module_id)
{
    $available_modules = array_keys(mww_get_modules());
    $active_modules = mww_get_active_modules();
    if (in_array($module_id, $available_modules) && in_array($module_id, $active_modules)) {

        $all_active_unique_modules = array_diff($active_modules, array($module_id));
        update_option('mg-mww-activate-modules', $all_active_unique_modules);
    }

}

function mww_get_active_modules()
{
    $active_modules = get_option('mg-mww-activate-modules', array());
    return apply_filters('mg-mww-active-modules', $active_modules);

}

function mww_get_modules()
{
    $register_modules = mww_register_modules();
    $available_modules = array();
    foreach ($register_modules as $module_key => $modules) {
        $class_name = 'MWW_' . str_replace(' ', '_', ucwords(str_replace('-', ' ', $module_key)));
        if (file_exists(MWW_PLUGIN_MODULES_PATH . $module_key . '/' . $module_key . '.php')) {
            $available_modules[$module_key] = $modules;
        }
    }
    return apply_filters('mg-mww-available-modules', $available_modules);
}

add_action('mww-modules-includes', 'mww_modules_includes');

function mww_modules_includes()
{

    $active_modules = mww_get_active_modules();
    foreach ($active_modules as $module_value) {
        if (file_exists(MWW_PLUGIN_MODULES_PATH . $module_value . '/' . $module_value . '.php')) {
            include MWW_PLUGIN_MODULES_PATH . $module_value . '/' . $module_value . '.php';
        }
    }

}




