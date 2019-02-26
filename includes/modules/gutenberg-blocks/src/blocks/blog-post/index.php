<?php

/**
 * Posts Grid Block
 * Server-side Rendering
 */

function gutenberg_blocks_render_block_posts_grid( $attributes ) {
	$recent_posts = wp_get_recent_posts( array(
        'numberposts' => $attributes['postsNumber'],
        'post_status' => 'publish',
		'category' => $attributes['category'],
    ), 'OBJECT' );

    if ( count( $recent_posts ) === 0 ) {
        return 'No posts';
    }

	$output = '';
    $post_thumb_size = 'gutenberg-blocks-posts-grid';

    if( $attributes['columns'] == 1 ){
        $post_thumb_size = 'original';
    }

    foreach( $recent_posts as $post ){

        $post_thumb_id = get_post_thumbnail_id( $post->ID );
        $post_thumb_class = '';
        $thumbnail = '';
        $date = '';
        $comments = '';

		if ( $post_thumb_id ) {
            $post_thumb_class = '_has_thumbnail_gutenberg_blocks';

            $thumbnail = '
                <div class="_entry_thumbnail_gutenberg_blocks">
                    <a href="'.esc_url( get_permalink( $post->ID ) ).'" rel="bookmark">
                        '.wp_get_attachment_image( $post_thumb_id, $post_thumb_size ).'
                    </a>
                </div>';
		}

        $post_title = '
            <h5>
                <a href="' .esc_url( get_permalink( $post->ID ) ). '">' .esc_html( get_the_title( $post->ID ) ). '</a>
            </h5>';

        $date = '<div class="_entry_meta_gutenberg_blocks">' .get_the_date( '', $post->ID ). '</div>';


        // Comments.
        $comments = '';
        if ( ! empty( $attributes['displayComments'] ) ) {
            $num = get_comments_number( $post->ID );
            $num = sprintf( _n( '%d comment', '%d comments', $num, 'gutenberg-blocks' ), $num );

            $comments = sprintf(
                '<span>%s</span>',
                $num
            );
        }

        // Excerpt.
        $excerpt = '';
        if ( ! empty( $attributes['displayExcerpt'] ) ) {

            $excerpt = gutenberg_blocks__get_excerpt( $post->ID, $post );
            if ( ! empty( $excerpt ) ) {
                $excerpt = sprintf(
                    '<div class="gutenberg-blocks-blog-posts__excerpt">%s</div>',
                    wp_kses_post( $excerpt )
                );
            }
        }

        $output .= '
            <div class="_entry_gutenberg_blocks'.'" >
                <div class="_entry_content_gutenberg_blocks" style="background-color:'.$attributes['bgColor'].'; color:'.$attributes['textColor'].';">
                     '. $post_title.'
                    '.$date.' '.$comments.'
                      <div class="'.$post_thumb_class. '" >
                    '.$thumbnail.'
                    '.$excerpt.'
                </div>
               </div>
            </div>';

    }

	return sprintf(
        '<div class="gutenberg-blocks-posts-grid _%2$s_columns_gutenberg_blocks">%1$s</div>',
        $output,
        $attributes['columns']
    );
}


function gutenberg_blocks__get_excerpt( $post_id, $post = null ) {
    $excerpt = apply_filters( 'the_excerpt', get_post_field( 'post_excerpt', $post_id, 'display' ) );
    if ( ! empty( $excerpt ) ) {
        return $excerpt;
    }

    if ( ! empty( $post->post_content ) ) {

        return apply_filters( 'the_excerpt', wp_trim_words( $post->post_content, 55 ) );
    }

    $post_content = apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) );
    return apply_filters( 'the_excerpt', wp_trim_words( $post_content, 55 ) );
}

function gutenberg_blocks_init_block_posts_grid(){

	// Check if the register function exists
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
    }
	register_block_type( 'gutenberg-blocks/blog-post', array(
        'attributes' => array(
            'postsNumber' => array(
                'type' => 'number',
                'default' => 3
            ),
            'displayComments' => array(
                'type' => 'boolean',
                'default' => true,
            ),
            'displayAuthor' => array(
                'type' => 'boolean',
                'default' => true,
            ),
            'displayExcerpt' => array(
                'type' => 'string',
                'default' => true,
            ),
            'columns' => array(
                'type' => 'number',
                'default' => 3
            ),
            'category' => array(
                'type' => 'number',
                'default' => 0
            ),
            'bgColor' => array(
                'type' => 'string',
                'default' => ''
            ),
            'textColor' => array(
                'type' => 'string',
                'default' => ''
            ),
        ),
		'render_callback' => 'gutenberg_blocks_render_block_posts_grid',
    ) );

}
add_action( 'wp_loaded', 'gutenberg_blocks_init_block_posts_grid' );


/**
 * Create API fields for additional post info
 */
function gutenberg_blocks_posts_grid_register_rest_fields() {

	register_rest_field(
		'post',
		'featured_image_src',
		array(
			'get_callback' => 'gutenberg_blocks_posts_grid_get_image_src_square',
			'update_callback' => null,
			'schema' => null,
		)
    );

	register_rest_field(
		'post',
		'date_formated',
		array(
			'get_callback' => 'gutenberg_blocks_posts_grid_get_date_formated',
			'update_callback' => null,
			'schema' => null,
        )
		);

    register_rest_field(
        'post',
        'excerptData',
        array(
            'get_callback' => 'gutenberg_blocks_blog_post_excerpt',
            'update_callback' => null,
            'schema' => null,
        ));
}
add_action( 'rest_api_init', 'gutenberg_blocks_posts_grid_register_rest_fields' );

/**
 * Get featured image source for the rest field
 */
function gutenberg_blocks_posts_grid_get_image_src_square( $object, $field_name, $request ) {
	$img_array = wp_get_attachment_image_src(
		$object['featured_media'],
		'gutenberg-blocks-posts-grid',
		false
	);
	return $img_array[0];
}

/**
 * Get formated date for the rest field
 */
function gutenberg_blocks_posts_grid_get_date_formated( $object, $field_name, $request ) {

    $date = new DateTime( $object['date'] );

	return $date->format( get_option('date_format') );
}

function gutenberg_blocks_blog_post_excerpt( $object, $field_name, $request ) {
    $excerpt = get_the_excerpt($object['excerpt']);
    if ( ! empty( $excerpt ) ) {
        return trim_excerpt(strip_tags($excerpt));
    }
}

function trim_excerpt($text){
    return rtrim(str_replace('[&hellip', '', $text), '[...]');
}
add_filter('get_the_excerpt', 'trim_excerpt');
/**
 * Image Sizes
 */
function gutenberg_blocks_posts_grid_image_sizes(){
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'gutenberg-blocks-posts-grid', '656', '456', true );
}
add_action( 'after_setup_theme', 'gutenberg_blocks_posts_grid_image_sizes' );
