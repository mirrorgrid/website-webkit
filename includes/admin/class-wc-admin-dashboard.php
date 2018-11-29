 <?php
/**
 * Admin Dashboard
 *
 * @author      WooThemes
 * @category    Admin
 * @package     WooCommerce/Admin
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'MWW_Admin_Dashboard', false ) ) :

	/**
	 * MWW_Admin_Dashboard Class.
	 */
	class MWW_Admin_Dashboard
    {

        /**
         * Hook in tabs.
         */
        public function __construct()
        {
            // Only hook in admin parts if the user has admin access

        }

        /**
         * Init dashboard widgets.
         */
        public function init()
        {

        }

    }
endif;
return new WC_Admin_Dashboard();