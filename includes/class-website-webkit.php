<?php


defined('ABSPATH') || exit;


final class Website_Webkit
{

    public $version = '1.0.0';


    protected static $_instance = null;


    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct()
    {
        $this->define_constants();
        $this->includes();
        $this->init_hooks();
    }

    /**
     * Hook into actions and filters.
     *
     * @since 2.3
     */
    private function init_hooks()
    {
        /*add_action('init', array($this, 'include_modules'));*/
        $this->include_modules();
        add_action('admin_enqueue_scripts', array($this, 'script_register'));
        add_action('plugins_loaded', array($this, 'load_plugin_textdomain'));


    }

    function include_modules()
    {

        do_action('mww-modules-includes');
        do_action('mww_module_config_hook');
    }

    /**
     * Ensures fatal errors are logged so they can be picked up in the status report.
     *
     * @since 3.2.0
     */
    public function log_errors()
    {
        $error = error_get_last();
        if (in_array($error['type'], array(E_ERROR, E_PARSE, E_COMPILE_ERROR, E_USER_ERROR, E_RECOVERABLE_ERROR))) {
            $logger = wc_get_logger();
            $logger->critical(
            /* translators: 1: error message 2: file name and path 3: line number */
                sprintf(__('%1$s in %2$s on line %3$s', 'website-webkit'), $error['message'], $error['file'], $error['line']) . PHP_EOL,
                array(
                    'source' => 'fatal-errors',
                )
            );
            do_action('website_webkit_shutdown_error', $error);
        }
    }

    /**
     * Define WC Constants.
     */
    private function define_constants()
    {
        $upload_dir = wp_upload_dir(null, false);

        $this->define('MWW_ABSPATH', dirname(MWW_PLUGIN_FILE) . '/');
        $this->define('MWW_PLUGIN_BASENAME', plugin_basename(MWW_PLUGIN_FILE));
        $this->define('MWW_PLUGIN_MODULES_PATH', MWW_ABSPATH . 'includes/modules/');

    }

    /**
     * Define constant if not already set.
     *
     * @param string $name Constant name.
     * @param string|bool $value Constant value.
     */
    private function define($name, $value)
    {
        if (!defined($name)) {
            define($name, $value);
        }
    }

    /**
     * What type of request is this?
     *
     * @param  string $type admin, ajax, cron or frontend.
     * @return bool
     */
    private function is_request($type)
    {
        switch ($type) {
            case 'admin':
                return is_admin();
            case 'ajax':
                return defined('DOING_AJAX');
            case 'cron':
                return defined('DOING_CRON');
            case 'frontend':
                return (!is_admin() || defined('DOING_AJAX')) && !defined('DOING_CRON') && !defined('REST_REQUEST');
        }
    }

    /**
     * Include required core files used in admin and on the frontend.
     */
    public function includes()
    {


        /**
         * Class autoloader.
         */
        include_once MWW_ABSPATH . 'notification/notification.php';

        include_once MWW_ABSPATH . 'includes/functions.php';


        if (!empty($this->is_request('admin'))) {
            include_once MWW_ABSPATH . 'includes/admin/admin-functions.php';

        }

        if ($this->is_request('frontend')) {
            $this->frontend_includes();
        }

    }


    /**
     * Include required frontend files.
     */
    public function frontend_includes()
    {

    }

    /**
     * Function used to Init Website Webkit Template Functions - This makes them pluggable by plugins and themes.
     */
    public function include_template_functions()
    {
        //include_once MWW_ABSPATH . 'includes/wc-template-functions.php';
    }

    /**
     * Init Website Webkit when WordPress Initialises.
     */
    public function script_register()
    {
        wp_enqueue_style('website-webkit-style', esc_url(MWW()->plugin_url()) . '/assets/css/style.css');
        wp_enqueue_script('website-webkit-js', esc_url(MWW()->plugin_url()) . '/assets/js/website-webkit.js');
        wp_enqueue_script('select2-js', esc_url(MWW()->plugin_url()) . '/assets/js/select2.full.min.js');
        wp_enqueue_style('select2-style', esc_url(MWW()->plugin_url()) . '/assets/css/select2.min.css');
        wp_localize_script('jquery', 'mww_website_ids_global_object', array('ajax_url' => admin_url('admin-ajax.php')));
        wp_tinymce_inline_scripts();
        wp_enqueue_editor();

    }


    /**
     * Get the plugin url.
     *
     * @return string
     */
    public function plugin_url()
    {
        return untrailingslashit(plugins_url('/', MWW_PLUGIN_FILE));
    }

    /**
     * Get the plugin path.
     *
     * @return string
     */
    public function plugin_path()
    {
        return untrailingslashit(plugin_dir_path(MWW_PLUGIN_FILE));
    }

    /**
     * Get the template path.
     *
     * @return string
     */
    public function template_path()
    {
        return apply_filters('website_webkit_template_path', 'website_webkit_');
    }

    public function load_plugin_textdomain()
    {

        load_plugin_textdomain(
            'website-webkit',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );

    }


}
