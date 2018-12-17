<?php

class Gutenberg_Blocks_Admin {

	public function __construct() {


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

	protected function block_exists( $name ) {
		$blocks = $this->blocks();

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


}
