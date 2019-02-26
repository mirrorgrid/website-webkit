<?php
class MWW_Widget_Block extends WP_Widget {


    public function __construct() {
        $widget_ops = array(
            'classname' => 'gutenberg-blocks-reusable-widget',
            'description' => __( 'Display Gutenberg Reusable saved Blocks anywhere as widget.', 'gutenberg-blocks-reusable-widget' ),
        );
        parent::__construct( 'mww_gutenberg_blocks_widget', __( 'Gutenberg Blocks Reusable Widgets', 'gutenberg-blocks-reusable-widget' ), $widget_ops );
    }

    public function widget( $args, $instance ) {
        if( isset( $instance['block'] ) && !empty( $instance['block'] ) ){
            echo $args['before_widget'];
            if ( ! empty( $instance['title'] ) ) {
                echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
            }
            echo apply_filters('the_content', get_post_field( 'post_content', $instance['block'] ) );
            echo $args['after_widget'];
        }
    }

    public function form( $instance ) {
        $title 					= ! empty( $instance['title'] ) ? $instance['title'] : '';
        $block_selected 		= ! empty( $instance['block'] ) ? $instance['block'] : '';
        $blocks 				= mww_gutenberg_blocks_widget(); ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'gutenberg-blocks-reusable-widget' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <?php if( !empty( $blocks ) ){ ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'block' ) ); ?>"><?php esc_attr_e( 'Select from saved Reusable Blocks:', 'gutenberg-blocks-reusable-widget' ); ?></label>
                <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'block' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'block' ) ); ?>">
                    <option values=""><?php _e( 'Select Reusable Block', 'gutenberg-blocks-reusable-widget' ); ?></option>
                    <?php foreach( $blocks as $block ){
                        $selected = ( $block_selected == $block->ID ) ? 'selected="selected"' : ''; ?>
                        <option value="<?php echo $block->ID; ?>" <?php echo $selected;?>><?php echo $block->post_title; ?></option>
                    <?php } ?>
                </select>
            </p>
            <?php
        }else{ ?>
            <p><?php esc_attr_e( 'No saved reusable blocks yet.', 'gutenberg-blocks-reusable-widget' ); ?></p>
        <?php }


    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['block'] = ( ! empty( $new_instance['block'] ) ) ? strip_tags( $new_instance['block'] ) : '';

        return $instance;
    }
}
