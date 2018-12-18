<?php

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

function mww_get_active_modules()
{
    $active_modules = get_option('mg-mww-activate-modules', array());
    return apply_filters('mg-mww-active-modules', $active_modules);

}

?>