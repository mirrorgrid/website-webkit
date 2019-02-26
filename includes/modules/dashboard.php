 <!-- Dashboard Section -->
<?php $modules = mww_get_modules(); ?>
 <?php do_action('mww_module_config_hook');?>

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
                onclick="mww_activate('<?php echo $module_key ?>','<?php echo wp_create_nonce('mww-ajax-nonce');?>',this)">
                    <?php esc_html_e('Activate', 'website-webkit'); ?></button>
                    <button class="button deactivate button-secondary" <?php if (!mwww_has_activate_module($module_key)) { ?> style="display: none;" <?php } ?>
                       type="button" onclick="mww_deactivate('<?php echo $module_key ?>','<?php echo wp_create_nonce('mww-ajax-nonce');?>',this)"><?php esc_html_e('Deactivate', 'website-webkit'); ?></button>
                <?php if ($module['setting'] == true){?>
                <a class="button"
                       href="<?php admin_url();?>admin.php?page=setting&tab=<?php echo $module_key ?>"><?php esc_html_e('Settings', 'website-webkit'); ?>
                </a>
                <?php } ?>

            </div>
        </div>
    <?php } ?>
</div>