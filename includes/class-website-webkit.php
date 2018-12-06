<?php
/**
 * Website Webkit setup
 *
 * @package Website Webkit
 * @since   1.0.0
 */

defined('ABSPATH') || exit;


/**
 * Main Website Webkit Class.
 *
 * @class Website Webkit
 */
final class Website_Webkit
{

    /**
     * Website Webkit version.
     *
     * @var string
     */
    public $version = '1.0.0';

    /**
     * The single instance of the class.
     *
     * @var Website Webkit
     * @since 1.0.0
     */
    protected static $_instance = null;


    /**
     * Main Website Webkit Instance.
     *
     * Ensures only one instance of Website Webkit is loaded or can be loaded.
     *
     * @since 1.0.0
     * @static
     * @see WC()
     * @return Website Webkit - Main instance.
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Cloning is forbidden.
     *
     * @since 1.0.0
     */
    public function __clone()
    {
        wc_doing_it_wrong(__FUNCTION__, __('Cloning is forbidden.', 'website-webkit'), '1.0.0');
    }

    /**
     * Unserializing instances of this class is forbidden.
     *
     * @since 1.0.0
     */
    public function __wakeup()
    {
        wc_doing_it_wrong(__FUNCTION__, __('Unserializing instances of this class is forbidden.', 'website-webkit'), '1.0.0');
    }

    /**
     * Auto-load in-accessible properties on demand.
     *
     * @param mixed $key Key name.
     * @return mixed
     */


    /**
     * Website Webkit Constructor.
     */
    public function __construct()
    {
        $this->define_constants();
        $this->includes();
        $this->init_hooks();
        $this->script_register();
    }

    /**
     * Hook into actions and filters.
     *
     * @since 2.3
     */
    private function init_hooks()
    {
        add_action('init', array($this, 'include_modules'));

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

        /**
         * Interfaces.
         */
        //include_once MWW_ABSPATH . 'includes/';

        /**
         * Abstract classes.
         */
        //include_once MWW_ABSPATH . 'includes/';


        /**
         * Core classes.
         */
        //include_once MWW_ABSPATH . 'includes/';


        /**
         * Data stores - used to store and retrieve CRUD object data from the database.
         */
        //include_once MWW_ABSPATH . 'includes/';


        /**
         * REST API.
         */
        //include_once MWW_ABSPATH . 'includes/';

        /**
         * Libraries
         */
        //include_once MWW_ABSPATH . 'includes/';

        if ($this->is_request('admin')) {
            include_once MWW_ABSPATH . 'includes/admin/class-mww-admin.php';
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

       // do_action('website_webkit_script_register');
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




    /**
     * Get Ajax URL.
     *
     * @return string
     */


}
