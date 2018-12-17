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
                <input type="hidden" name="webkit_ids_nonce" value="<?php echo wp_create_nonce('webkit-ids-nonce');?>">
            <select class="select2-class js-example-responsive" multiple="multiple" style="width: 30%"
                    name="mww_all_types_list[]" multiple="multiple">
                <optgroup label="Post Types">
                    <?php $post_type = get_post_types();
                    $taxonomies = get_taxonomies();
                    $enabledType = get_option('mww_enable_all_post_taxonomies_users_media_types');
                    if ($enabledType==null){
                        $enabledType = array();
                    }
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
                <optgroup label="Remove From All">
                    <option value="none" <?php if (in_array('none',$enabledType)){?>selected <?php } ?>><?php esc_html_e('None', 'website-webkit'); ?></option>
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

<?php }else if($active_tab == 'social-icons' && in_array('social-icons',mww_get_active_modules())) { ?>
    <div class="wrap popover__wrapper">
        <button type="button" class="button add-popup popover__title" data-toggle="popover" data-placement="bottom" >
            <svg aria-hidden="true" role="img" focusable="false" class="dashicon dashicons-insert" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                <path d="M10 1c-5 0-9 4-9 9s4 9 9 9 9-4 9-9-4-9-9-9zm0 16c-3.9 0-7-3.1-7-7s3.1-7 7-7 7 3.1 7 7-3.1 7-7 7zm1-11H9v3H6v2h3v3h2v-3h3V9h-3V6z"></path>
            </svg>
        </button>
        <div class="push popover__content">
           <div class="wrap">
            <button type="button" class="button"><span class="dashicons dashicons-facebook"></span></span> </button>
            <button type="button" class="button"><span class="dashicons dashicons-twitter"></span></span> </button>
            <button type="button" class="button"><span class="dashicons dashicons-googleplus"></span></span> </button>
           </div>
        </div>


    </div>
    <?php } ?>
<?php if ($active_tab == 'gutenberg-blocks' && in_array('gutenberg-blocks',mww_get_active_modules())) { ?>
    <div id="gutenberg_blocks_main-menu">
        <div id="gutenberg_blocks_main-menu__header">
            <div class="gutenberg_blocks_header-container">
                <div class="ub_collection_filter">
                    <span class="filter-action active" data-filter-status="all"><?php esc_html_e( 'All', 'gutenberg-blocks' ); ?></span>
                    <span class="filter-action" data-filter-status="enabled"><?php esc_html_e( 'Enabled', 'gutenberg-blocks' ); ?></span>
                    <span class="filter-action" data-filter-status="disabled"><?php esc_html_e( 'Disabled', 'gutenberg-blocks' ); ?></span>
                </div>
            </div>
        </div>

        <div id="gutenberg_blocks_main-menu__body">

            <div class="gutenberg_blocks_collection <?php echo count( get_option( 'gutenberg_blocks', [] ) ) === 0 ? 'empty' : ''; ?>">

                <?php foreach ( get_option( 'gutenberg_blocks', array() ) as $block ) : ?>
                    <div class="gutenberg_blocks_collection__item <?php echo $block['active'] ? 'active' : ''; ?> " data-id="<?php echo esc_html( $block['name'] ); ?>">
                        <div class="gutenberg_blocks_collection__item__header">
                            <h3 class="gutenberg_blocks_collection__item__title"><?php printf( esc_html__( '%s', 'gutenberg-blocks' ), $block['label'] ); ?></h3>
                            <label class="gutenberg-blocks-switch-input">
                                <input type="checkbox" name="block_status" <?php echo $block['active'] ? 'checked' : ''; ?>>
                                <span class="gutenberg-blocks-switch-input-slider"></span>
                            </label>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
            <input type="hidden" name="gutenberg_blocks_nonce" value="<?php echo esc_html( wp_create_nonce( 'toggle_block_status' ) ); ?>">
            <input type="hidden" name="gutenberg_blocks_ajax_url" value="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
        </div>

    </div>

<?php } ?>

<?php
wp_register_script('website-webkit-js', esc_url(MWW()->plugin_url()) . '/assets/js/website-webkit.js');
wp_register_script('gutenberg-blocks-js', esc_url(MWW()->plugin_url()) . '/includes/modules/gutenberg-blocks/assets/js/gutenberg-blocks-admin.js');
wp_register_style('gutenberg-blocks-style', esc_url(MWW()->plugin_url()) . '/includes/modules/gutenberg-blocks/assets/css/gutenberg-blocks-admin.css');
wp_register_style('website-webkit-style', esc_url(MWW()->plugin_url()) . '/assets/css/style.css');
wp_register_script('select2-js', esc_url(MWW()->plugin_url()) . '/assets/js/select2.full.min.js');
wp_register_style('select2-style', esc_url(MWW()->plugin_url()) . '/assets/css/select2.min.css');
wp_localize_script('jquery', 'mww_website_ids_global_object', array('ajax_url' => admin_url('admin-ajax.php')));

wp_enqueue_script('website-webkit-js');
wp_enqueue_script('select2-js');
wp_enqueue_script('gutenberg-blocks-js');
wp_enqueue_style('select2-style');
wp_enqueue_style('website-webkit-style');
wp_enqueue_style('gutenberg-blocks-style');

