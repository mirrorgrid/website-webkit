
<?php

class MWW_Gutenberg_Blocks
{

    function __construct()
    {
        $this->activate_gutenberg_block();
        $this->mww_init_hook();
        $this->includes();
    }

    function includes()
    {
        require_once plugin_dir_path( __FILE__ ) . 'src/init.php';
    }

    function mww_init_hook()
    {
        add_filter( 'block_categories', array( $this, 'block_categories' ));
        add_action( 'admin_init', array($this, 'register_new_blocks'));
        // Ajax hooks.
        add_action( 'wp_ajax_toggle_block_status', array($this, 'toggle_block_status'));
        // Insert blocks setting.
        add_action( 'admin_head', array($this, 'insert_blocks_settings'));
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
                'label'  => 'Testimonial',
                'name'   => 'gutenberg-blocks/testimonial-block',
                'active' => true,
            )
        ];
    }

    public function register_new_blocks() {
        $blocks = $this->blocks();

        $registered_blocks = get_option( 'gutenberg_blocks', false );

        $new_blocks = [];

        if ($registered_blocks) {
            foreach ( $blocks as $block ) {
                if ( ! $this->is_block_registered( $block['name'], $registered_blocks ) ) {
                    $new_blocks[] = $block;
                }
            }
            $registered_blocks = array_merge( $registered_blocks, $new_blocks );
            update_option( 'gutenberg_blocks', $registered_blocks );
        } else {
            update_option( 'gutenberg_blocks', $blocks );
        }
    }

    protected function block_exists( $name ) {
        $blocks = self::blocks();

        $unknown_block = true;
        foreach ( $blocks as $key => $block ) {
            if ( $block['name'] === $name ) {
                return true;
            }
        }
        return false;
    }
    protected function is_block_registered( $name, $registered_blocks ) {
        $blocks = $registered_blocks;

        $unknown_block = true;
        foreach ( $blocks as $key => $block ) {
            if ( $block['name'] === $name ) {
                return true;
            }
        }
        return false;
    }

    public function toggle_block_status() {

        check_ajax_referer( 'toggle_block_status' );

        $block_name = sanitize_text_field( $_POST['block_name'] );

        $enable = sanitize_text_field( $_POST['enable'] );

        if ( ! $this->block_exists( $block_name ) ) {
            wp_send_json_error( array(
                'error_message' => 'Unknown block name',
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
            update_option( 'gutenberg_blocks', $this->blocks() );
        }

        wp_send_json_success( get_option( 'gutenberg_blocks', false ) );
    }

    public function insert_blocks_settings() {
        $gutenberg_blocks_settings = wp_json_encode( get_option( 'gutenberg_blocks', array() ) );
        ?>

        <script> window.gutenberg_blocks=<?php echo $gutenberg_blocks_settings; ?> </script>

        <?php
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

