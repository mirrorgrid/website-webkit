 <!-- Dashboard Section -->
<?php $modules = mww_get_modules(); ?>
<div class="wrap mww_dashboard_row">
    <h1><?php esc_html_e('Dashboard', 'website-webkit'); ?></h1>
    <?php foreach ($modules as $module_key => $module) { ?>
        <div class="card">
            <img src="<?php echo esc_url(MWW()->plugin_url() . '/assets/images/icons/' . $module['icon']); ?>">
             <h2><?php echo esc_html($module['name']) ?></h2>
            <h4><?php esc_html_e('Description', 'website-webkit'); ?></h4>
            <p><?php echo esc_html($module['description']); ?></p>
            <div class="theme-actions">
                <button type="button" class="button-primary activate" <?php if (mwww_has_activate_module($module_key)) { ?> style="display: none;" <?php } ?>
                onclick="mww_activate('<?php echo $module_key ?>',this)">
                    <?php esc_html_e('Activate', 'website-webkit'); ?></button>
                    <button class="button deactivate button-secondary" <?php if (!mwww_has_activate_module($module_key)) { ?> style="display: none;" <?php } ?>
                       type="button" onclick="mww_deactivate('<?php echo $module_key ?>',this)"><?php esc_html_e('Deactivate', 'website-webkit'); ?></button>
                    <a class="button"
                       href="<?php echo MWW_PLUGIN_PATH; ?>mww-admin-function.php?action=config"><?php esc_html_e('Settings', 'website-webkit'); ?></a>

            </div>
        </div>
    <?php } ?>

</div>

<?php


wp_register_script('website-ids',esc_url(MWW()->plugin_url()) . '/assets/js/webkit_ids.js');
wp_enqueue_script('website-ids');
wp_register_style('website-webkit-style',esc_url(MWW()->plugin_url()) . '/assets/css/style.css');
wp_enqueue_style('website-webkit-style');
wp_localize_script('jquery', 'mww_website_ids_global_object', array('ajax_url' => admin_url('admin-ajax.php')));
