<?php
if (!function_exists('gutenberg_blocks_dropdown')) :
    function gutenberg_blocks_dropdown()
    {
        $gutenbergBlocks = get_option( 'mww_gutenberg_blocks', array());
        $gutenberg_blocks_dropdown['0'] = esc_html__('Select Blocks', 'widget_blocks');
        foreach ($gutenbergBlocks as $key=> $gutenberg_blocks) {
            $gutenberg_blocks_dropdown[$key] = $gutenberg_blocks['label'];
        }

        return $gutenberg_blocks_dropdown;
    }
endif;

