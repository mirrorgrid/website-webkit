<?php

class Gutenberg_Blocks_Admin {

	public function __construct() {

        add_action( 'admin_init', array($this, 'register_new_blocks'));
        // Ajax hooks.
    }





	public function register_new_blocks() {
		$blocks = MWW_Gutenberg_Blocks::blocks();

		$registered_blocks = get_option( 'mww_gutenberg_blocks', false );

		$new_blocks = [];

		if ( $registered_blocks ) {
			foreach ( $blocks as $block ) {
				if ( ! $this->is_block_registered( $block['name'], $registered_blocks ) ) {
					$new_blocks[] = $block;
				}
			}
			$registered_blocks = array_merge( $registered_blocks, $new_blocks );
			update_option( 'mww_gutenberg_blocks', $registered_blocks );
		} else {
			update_option( 'mww_gutenberg_blocks', $blocks );
		}
	}


	protected function is_block_registered( $name, $registered_blocks ) {
		$blocks = $registered_blocks;
        foreach ( $blocks as $key => $block ) {
			if ( $block['name'] === $name ) {
				return true;
			}
		}
		return false;
	}


}

