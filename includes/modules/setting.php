<?php
$active_tab = 'general';
if (isset($_GET['tab'])) {
    $active_tab = $_GET['tab'];
} // end if
?>

    <div class="wrap">
    <h2>Website Webkit - Setting</h2>
    <nav class="nav-tab-wrapper woo-nav-tab-wrapper">
        <a href="<?php echo admin_url(); ?>admin.php?page=setting&amp;tab=general"
           class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>">General</a>
        <?php $activeModule = mww_get_active_modules();
        if (!empty($activeModule)) {
            foreach ($activeModule as $module) {
                ?>
                <a href="<?php echo admin_url(); ?>admin.php?page=setting&amp;tab=<?php echo $module; ?>"
                   class="nav-tab <?php echo $active_tab == $module ? 'nav-tab-active' : ''; ?>"><?php echo esc_html(ucwords(str_replace('-', ' ', $module))) ?></a>
            <?php }
        } ?>
    </nav>
<?php if ($active_tab == 'webkit-ids' && in_array('webkit-ids',mww_get_active_modules())) { ?>
    <div class="wrap">
        <?php do_action('enable_post_types');?>
        <h3><?php esc_html_e('Update Webkit Ids Setting.', 'website-webkit'); ?></h3>
        <div class="wrapper">
            <h4><u><?php esc_html_e('Select Custom Types to enable webkit ids on them.', 'website-webkit'); ?></u></h4>
            <form action="" method="post">
            <select class="select2-class js-example-responsive" multiple="multiple" style="width: 30%"
                    name="mww_all_types_list[]" multiple="multiple">
                <optgroup label="Post Types">
                    <?php $post_type = get_post_types();
                    $taxonomies = get_taxonomies();
                    $enabledType = get_option('mww_enable_all_post_taxonomies_users_media_types');
                    foreach ($post_type as $post_value) {
                        ?>
                        <option value="<?php echo $post_value; ?>" <?php if (in_array($post_value,$enabledType)){?>selected <?php } ?>><?php echo esc_html_e(str_replace('_', ' ', ucwords(str_replace('-', ' ', $post_value)))); ?></option>
                    <?php } ?>
                </optgroup>
                <optgroup label="Taxonomies">
                    <?php foreach ($taxonomies as $taxonomy) { ?>
                        <option value="<?php echo $taxonomy; ?>" <?php if (in_array($taxonomy,$enabledType)){?>selected <?php } ?>><?php echo esc_html_e(str_replace('_', ' ', ucwords(str_replace('-', ' ', $taxonomy)))); ?></option>
                    <?php } ?>
                </optgroup>
                <optgroup label="Users">
                    <option value="users" <?php if (in_array('users',$enabledType)){?>selected <?php } ?>><?php esc_html_e('User', 'website-webkit'); ?></option>
                </optgroup>
                <optgroup label="Media">
                    <option value="media" <?php if (in_array('media',$enabledType)){?>selected <?php } ?>><?php esc_html_e('Media', 'website-webkit'); ?></option>
                </optgroup>
                <optgroup label="Comments">
                    <option value="comments" <?php if (in_array('comments',$enabledType)){?>selected <?php } ?>><?php esc_html_e('Comment', 'website-webkit'); ?></option>
                </optgroup>
            </select>
            <div class="wrap">
                <button type="submit" class="button-primary activate">
                    <?php esc_html_e('Save', 'website-webkit'); ?></button>
            </div>
            </form>
        </div>
    </div>
    </div>

<?php } ?>

    </div>
<?php
wp_register_script('website-webkit-js', esc_url(MWW()->plugin_url()) . '/assets/js/website-webkit.js');
wp_register_style('website-webkit-style', esc_url(MWW()->plugin_url()) . '/assets/css/style.css');
wp_register_script('select2-js', esc_url(MWW()->plugin_url()) . '/assets/js/select2.full.min.js');
wp_register_style('select2-style', esc_url(MWW()->plugin_url()) . '/assets/css/select2.min.css');
wp_localize_script('jquery', 'mww_website_ids_global_object', array('ajax_url' => admin_url('admin-ajax.php')));

wp_enqueue_script('website-webkit-js');
wp_enqueue_script('select2-js');
wp_enqueue_style('select2-style');
wp_enqueue_style('website-webkit-style');

