<?php

class Gutenberg_Blocks_Admin {

	public function __construct() {

        add_action( 'admin_init', array($this, 'register_new_blocks'));
        // Ajax hooks.

        // Insert blocks setting.
        add_action( 'admin_head', array($this, 'insert_blocks_settings'));
    }



	public function insert_blocks_settings() {
		$gutenberg_blocks_settings = wp_json_encode( get_option( 'gutenberg_blocks', array() ) );
		?>

		<script> window.gutenberg_blocks=<?php echo $gutenberg_blocks_settings; ?> </script>

		<?php
	}

	public function register_new_blocks() {
		$blocks = MWW_Gutenberg_Blocks::blocks();

		$registered_blocks = get_option( 'gutenberg_blocks', false );

		$new_blocks = [];

		if ( $registered_blocks ) {
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


}

