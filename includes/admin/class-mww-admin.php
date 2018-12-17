 <?php

/**
 * Created by PhpStorm.
 * User: Bhuwan Ojha
 * Date: 2018-11-26
 * Time: 9:49 AM
 */

class MWW_Admin
{
    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'init', array( $this, 'includes' ) );
    }

    /**
     * Output buffering allows admin screens to make redirects later on.
     */
    public function buffer() {
        ob_start();
    }

    /**
     * Include any classes we need within admin.
     */
    public function includes() {
       include_once dirname(__FILE__) . '/admin-functions.php';



        // Help Tabs
        if ( apply_filters( 'website_webkit_enable_admin_help_tab', true ) ) {
            //include_once dirname( __FILE__ ) . '/class-wc-admin-help.php';
        }

        // Setup/welcome
        if ( ! empty( $_GET['page'] ) ) {
            switch ( $_GET['page'] ) {
                case 'mww-setup':
                    //include_once dirname( __FILE__ ) . '/';
                    break;
            }
        }

        // Importers
        if ( defined( 'WP_LOAD_IMPORTERS' ) ) {
            //include_once dirname( __FILE__ ) . '/class-wc-admin-importers.php';
        }

        // Helper
        //include_once dirname( __FILE__ ) . '/helper/';

    }

    /**
     * Include admin files conditionally.
     */
    public function conditional_includes() {
        if ( ! $screen = get_current_screen() ) {
            return;
        }

        switch ( $screen->id ) {
            case 'dashboard':
                include 'class-mww-admin-dashboard.php';
                break;
            case 'users':
            case 'user':
            case 'profile':
            case 'user-edit':
                include 'class-mww-admin-profile.php';
                break;
        }
    }

    /**
     * Handle redirects to setup/welcome page after install and updates.
     *
     * For setup wizard, transient must be present, the user must have access rights, and we must ignore the network/bulk plugin updaters.
     */
    public function admin_redirects()
    {
        // Nonced plugin install redirects (whitelisted)

    }

    /**
     * Prevent any user who cannot 'edit_posts' (subscribers, customers etc) from accessing admin.
     */
    public function prevent_admin_access()
    {


    }


}

return new MWW_Admin();