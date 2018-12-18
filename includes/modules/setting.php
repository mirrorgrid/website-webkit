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
<?php if ($active_tab == 'webkit-ids' && in_array('webkit-ids', mww_get_active_modules())) { ?>
    <div class="wrap">
        <?php do_action('enable_post_types'); ?>
        <h3><?php esc_html_e('Update Webkit Ids Setting.', 'website-webkit'); ?></h3>
        <div class="wrapper">
            <h4><u><?php esc_html_e('Select Custom Types to enable webkit ids on them.', 'website-webkit'); ?></u></h4>
            <form action="" method="post">
                <input type="hidden" name="webkit_ids_nonce" value="<?php echo wp_create_nonce('webkit-ids-nonce'); ?>">
                <select class="select2-class js-example-responsive" multiple="multiple" style="width: 30%"
                        name="mww_all_types_list[]" multiple="multiple">
                    <optgroup label="Post Types">
                        <?php $post_type = get_post_types();
                        $taxonomies = get_taxonomies();
                        $enabledType = get_option('mww_enable_all_post_taxonomies_users_media_types');
                        if ($enabledType == null) {
                            $enabledType = array();
                        }
                        foreach ($post_type as $post_value) {
                            ?>
                            <option value="<?php echo $post_value; ?>"
                                    <?php if (in_array($post_value, $enabledType)){ ?>selected <?php } ?>><?php echo esc_html_e(str_replace('_', ' ', ucwords(str_replace('-', ' ', $post_value)))); ?></option>
                        <?php } ?>
                    </optgroup>
                    <optgroup label="Taxonomies">
                        <?php foreach ($taxonomies as $taxonomy) { ?>
                            <option value="<?php echo $taxonomy; ?>"
                                    <?php if (in_array($taxonomy, $enabledType)){ ?>selected <?php } ?>><?php echo esc_html_e(str_replace('_', ' ', ucwords(str_replace('-', ' ', $taxonomy)))); ?></option>
                        <?php } ?>
                    </optgroup>
                    <optgroup label="Users">
                        <option value="users"
                                <?php if (in_array('users', $enabledType)){ ?>selected <?php } ?>><?php esc_html_e('User', 'website-webkit'); ?></option>
                    </optgroup>
                    <optgroup label="Media">
                        <option value="media"
                                <?php if (in_array('media', $enabledType)){ ?>selected <?php } ?>><?php esc_html_e('Media', 'website-webkit'); ?></option>
                    </optgroup>
                    <optgroup label="Comments">
                        <option value="comments"
                                <?php if (in_array('comments', $enabledType)){ ?>selected <?php } ?>><?php esc_html_e('Comment', 'website-webkit'); ?></option>
                    </optgroup>
                    <optgroup label="Remove From All">
                        <option value="none"
                                <?php if (in_array('none', $enabledType)){ ?>selected <?php } ?>><?php esc_html_e('None', 'website-webkit'); ?></option>
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

<?php } else if ($active_tab == 'social-icons' && in_array('social-icons', mww_get_active_modules())) { ?>
    <div class="wrap popover__wrapper">
        <button type="button" class="button add-popup popover__title" data-toggle="popover" data-placement="bottom">
            <svg aria-hidden="true" role="img" focusable="false" class="dashicon dashicons-insert"
                 xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                <path d="M10 1c-5 0-9 4-9 9s4 9 9 9 9-4 9-9-4-9-9-9zm0 16c-3.9 0-7-3.1-7-7s3.1-7 7-7 7 3.1 7 7-3.1 7-7 7zm1-11H9v3H6v2h3v3h2v-3h3V9h-3V6z"></path>
            </svg>
        </button>
        <div class="push popover__content">
            <div class="wrap">
                <button type="button" class="button"><span class="dashicons dashicons-facebook"></span></span> </button>
                <button type="button" class="button"><span class="dashicons dashicons-twitter"></span></span> </button>
                <button type="button" class="button"><span class="dashicons dashicons-googleplus"></span></span>
                </button>
            </div>
        </div>


    </div>
<?php } ?>
<?php if ($active_tab == 'gutenberg-blocks' && in_array('gutenberg-blocks', mww_get_active_modules())) { ?>
    <div>
        <div id="gutenberg_blocks_main-menu__header">
            <div class="gutenberg_blocks_header-container">
                <div class="gutenberg_blocks_collection_filter">
                    <span class="filter-action active"
                          data-filter-status="all"><?php esc_html_e('All', 'gutenberg-blocks'); ?></span>
                    <span class="filter-action"
                          data-filter-status="enabled"><?php esc_html_e('Enabled', 'gutenberg-blocks'); ?></span>
                    <span class="filter-action"
                          data-filter-status="disabled"><?php esc_html_e('Disabled', 'gutenberg-blocks'); ?></span>
                </div>
            </div>
        </div>

        <table class="wp-list-table widefat fixed">
            <thead>
            <tr>
                <th scope="col" class="manage-column">Blocks</th>
                <th scope="col" class="manage-column">Action</th>

            </tr>
            </thead>
            <tbody id="the-list">
            <?php if (count(get_option('gutenberg_blocks', [])) !== 0) { ?>
                <?php foreach (get_option('gutenberg_blocks', array()) as $block) { ?>
                    <tr class="gutenberg_blocks_collection__item <?php echo $block['active'] ? 'active' : ''; ?>">
                        <td class="title block_name" data-id="<?php echo esc_html($block['name']); ?>">
                            <strong><a class="row-title"
                                       href="#"><?php printf(esc_html__('%s', 'gutenberg-blocks'), $block['label']); ?></a></strong>
                        </td>
                        <td>
                            <input type="checkbox" name="block_status" <?php echo $block['active'] ? 'checked' : ''; ?>>
                        </td>
                    </tr>
                <?php } ?>
                <input type="hidden" name="gutenberg_blocks_nonce"
                       value="<?php echo esc_html(wp_create_nonce('toggle_block_status')); ?>">
                <input type="hidden" name="gutenberg_blocks_ajax_url"
                       value="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">
            <?php } ?>
            </tbody>
        </table>
    </div>

<?php } ?>

<?php





