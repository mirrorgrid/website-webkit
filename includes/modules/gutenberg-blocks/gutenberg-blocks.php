
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
        add_action( 'admin_head', array($this, 'insert_blocks_settings' ));

    }


    public function enqueue_plugin_scripts()
    {


        wp_enqueue_style('gutenberg-blocks-style', esc_url(MWW()->plugin_url()) . '/includes/modules/gutenberg-blocks/assets/css/gutenberg-blocks-admin.css',false);

        wp_enqueue_script('gutenberg-blocks-js', esc_url(MWW()->plugin_url()) . '/includes/modules/gutenberg-blocks/assets/js/gutenberg-blocks-admin.js', array('jquery'));

        wp_enqueue_style('slick-style', esc_url(MWW()->plugin_url()) . '/includes/modules/gutenberg-blocks/assets/css/slick.css',false);
        wp_enqueue_script('slick-js', esc_url(MWW()->plugin_url()) . '/includes/modules/gutenberg-blocks/assets/js/slick.min.js', array('jquery'));


    }

    public function mww_toggle_block_status() {
        check_ajax_referer('mww_toggle_block_status');


        $block_name = sanitize_text_field( $_POST['block_name'] );

        $enable = sanitize_text_field($_POST['enable']);
        if ( ! $this->block_exists( $block_name ) ) {
            wp_send_json_error( array(
                'error_message' => 'Unknown Error',
            ));
        }

        $saved_blocks = get_option( 'mww_gutenberg_blocks', false );
        if ( $saved_blocks ) {
            foreach ( $saved_blocks as $key => $block ) {
                if ( $block['name'] == $block_name ) {
                    $saved_blocks[ $key ]['active'] = ($enable === 'true');
                }
            }
            update_option( 'mww_gutenberg_blocks', $saved_blocks );

        } else {
            update_option( 'mww_gutenberg_blocks', MWW_Gutenberg_Blocks::blocks() );
        }

        wp_send_json_success( get_option( 'mww_gutenberg_blocks', false ) );
    }

    public function insert_blocks_settings() {
        $gutenberg_blocks_settings = wp_json_encode( get_option( 'mww_gutenberg_blocks', array() ) );
        ?>
        <script> window.ultimate_blocks=<?php echo $gutenberg_blocks_settings; ?> </script>
        <?php
    }

     static function block_exists( $name ) {
        $blocks = self::blocks();

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
        $blocks = get_option('mww_gutenberg_blocks', false);
        if (!$blocks) {
            update_option( 'mww_gutenberg_blocks', self::blocks() );
        }
    }

    public static function deactivate_gutenberg_block() {

        delete_option( 'mww_gutenberg_blocks' );

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
                'label'  => 'Star Rating',
                'name'   => 'gutenberg-blocks/star-rating',
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
            array(
                'label'  => 'Blog Post',
                'name'   => 'gutenberg-blocks/blog-post',
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
                    'title' => __('Gutenberg Blocks', 'gutenberg-blocks'),
                ),
            )
        );



    }
}



new MWW_Gutenberg_Blocks();

