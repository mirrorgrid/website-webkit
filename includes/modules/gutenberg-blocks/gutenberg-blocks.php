
<?php

class MWW_Gutenberg_Blocks
{

    function __construct()
    {
        $this->activate_gutenberg_block();
        $this->mww_init_hook();
        $this->includes();

    }

    function mww_init_hook()
    {
        add_filter( 'block_categories', array( $this, 'block_categories' ));
        add_action( 'wp_enqueue_scripts', array($this, 'enqueue_plugin_scripts'));
        add_action( 'admin_enqueue_scripts', array($this, 'enqueue_plugin_scripts'));
        add_action( 'wp_ajax_mww_toggle_block_status', array($this, 'mww_toggle_block_status'));

    }


    public function enqueue_plugin_scripts()
    {
        wp_enqueue_style('gutenberg-blocks-style', esc_url(MWW()->plugin_url()) . '/includes/modules/gutenberg-blocks/assets/css/gutenberg-blocks-admin.css',false);
        wp_enqueue_script('gutenberg-blocks-js', esc_url(MWW()->plugin_url()) . '/includes/modules/gutenberg-blocks/assets/js/gutenberg-blocks-admin.js', array('jquery'));

    }

    public function mww_toggle_block_status() {
        check_ajax_referer('mww_toggle_block_status');

        $block_name = sanitize_text_field( $_POST['block_name'] );

        $enable = sanitize_text_field( $_POST['enable'] );
        if ( ! $this->block_exists( $block_name ) ) {
            wp_send_json_error( array(
                'error_message' => 'Unknown Error',
            ));
        }

        $saved_blocks = get_option( 'gutenberg_blocks', false );
        if ( $saved_blocks ) {
            foreach ( $saved_blocks as $key => $block ) {
                if ( $block['name'] === $block_name ) {
                    $saved_blocks[ $key ]['active'] = ( $enable === 'true' );
                }
            }
            update_option( 'gutenberg_blocks', $saved_blocks );
        } else {
            update_option( 'gutenberg_blocks', MWW_Gutenberg_Blocks::blocks() );
        }

        wp_send_json_success( get_option( 'gutenberg_blocks', false ) );
    }

     static function block_exists( $name ) {
        $blocks = MWW_Gutenberg_Blocks::blocks();

        $unknown_block = true;
        foreach ( $blocks as $key => $block ) {
            if ( $block['name'] === $name ) {
                return true;
            }
        }
        return false;
    }





    function includes()
    {
        require_once plugin_dir_path( __FILE__ ) . 'src/init.php';
    }


    function activate_gutenberg_block()
    {
        self::blocks();

        $blocks = get_option( 'gutenberg_blocks', false );
        if ( ! $blocks ) {
            update_option( 'gutenberg_blocks', self::blocks() );
        }
    }

    public static function deactivate_gutenberg_block() {

        delete_option( 'gutenberg_blocks' );

    }


    public static function blocks() {

        return [
           array(
                'label'  => 'Testimonials',
                'name'   => 'gutenberg-blocks/testimonials',
                'active' => true,
            ),
            array(
                'label'  => 'Buttons',
                'name'   => 'gutenberg-blocks/button-block',
                'active' => true,
            ),
            array(
                'label'  => 'Progress Bar',
                'name'   => 'gutenberg-blocks/progress-bar',
                'active' => true,
            ),
            array(
                'label'  => 'Star Rating',
                'name'   => 'gutenberg-blocks/star-rating',
                'active' => true,
            ),
            array(
                'label'  => 'Social Share',
                'name'   => 'gutenberg-blocks/social-share',
                'active' => true,
            ),
            array(
                'label'  => 'Tabs',
                'name'   => 'gutenberg-blocks/tabbed-content',
                'active' => true,
            ),
            array(
                'label'  => 'Accordion',
                'name'   => 'gutenberg-blocks/accordion',
                'active' => true,
            ),
        ];
    }

    public function block_categories( $categories ) {
        return array_merge(
            $categories,
            array(
                array(
                    'slug'  => 'gutenberg-blocks',
                    'title' => __( 'Gutenberg Blocks', 'gutenberg-blocks' ),
                ),
            )
        );



    }
}


new MWW_Gutenberg_Blocks();

