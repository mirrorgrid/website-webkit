
<?php

class MWW_Webkit_Ids
{
    function __construct()
    {
        $this->mww_webkit_ids_init();


    }




    public function mww_webkit_ids_init()
    {

        $settings = mww_get_active_modules();
            // For Media Management
            if( is_array( $settings ) && in_array( 'webkit-ids', $settings )) {

                add_action( 'manage_media_columns', array( $this, 'mww_webkit_ids_column' ) );
                add_filter( 'manage_media_custom_column', array( $this, 'mww_webkit_ids_value' ) , 10 , 3 );
            }

            // For Link Management
            add_action( 'manage_link_custom_column', array( $this, 'mww_webkit_ids_value' ), 10, 2 );
            add_filter( 'manage_link-manager_columns', array( $this, 'mww_webkit_ids_column' ) );

            // For Category Management
            add_action( 'manage_edit-link-categories_columns', array( $this, 'mww_webkit_ids_column' ) );
            add_filter( 'manage_link_categories_custom_column', array( $this, 'mww_webkit_ids_return_value' ), 10, 3 );

            // For Category, Tags and other custom taxonomies Management
            foreach( get_taxonomies() as $taxonomy ) {
                if( is_array( $settings ) && in_array( 'webkit-ids', $settings ) ) {
                    add_action( "manage_edit-${taxonomy}_columns" ,  array( $this, 'mww_webkit_ids_column' ) );
                    add_action( "manage_${taxonomy}_custom_column", array($this, 'mww_webkit_ids_column' ), 10, 3 );
                    add_filter( "manage_${taxonomy}_custom_column" , array( $this, 'mww_webkit_ids_return_value' ) , 10 , 3 );
                    if( version_compare($GLOBALS['wp_version'], '3.0.999', '>') ) {
                        add_filter( "manage_edit-${taxonomy}_sortable_columns" , array( $this, 'mww_webkit_ids_column' ) );
                    }
                }
            }

            foreach( get_post_types() as $ptype ) {
                if( is_array( $settings ) && in_array( 'webkit-ids', $settings )){
                    add_action( "manage_edit-${ptype}_columns" ,array( $this, 'mww_webkit_ids_column' ) );
                    add_action( "manage_${ptype}_posts_custom_column", array( $this, 'mww_webkit_ids_value' ), 10, 2 );
                    add_filter( "manage_${ptype}_posts_custom_column" , array( $this, 'mww_webkit_ids_value' ) , 10 , 3 );
                    if( version_compare($GLOBALS['wp_version'], '3.0.999', '>') ) {
                        add_filter( "manage_edit-${ptype}_sortable_columns" , array( $this, 'mww_webkit_ids_column' ) );
                    }
                }
            }

            // For User Management
            if( is_array( $settings ) && in_array( 'webkit-ids', $settings )){
                add_action( 'manage_users_columns', array( $this, 'mww_webkit_ids_column' ) );
                add_action( 'manage_users_custom_column', array( $this, 'mww_webkit_ids_value' ), 10, 3 );
                add_filter( 'manage_users_custom_column', array( $this, 'mww_webkit_ids_return_value' ), 10, 3 );
                if( version_compare($GLOBALS['wp_version'], '3.0.999', '>') ) {
                    add_filter( "manage_users_sortable_columns" , array( $this, 'mww_webkit_ids_column' ) );
                }
            }

            // For Comment Management
            if( is_array( $settings ) && in_array( 'webkit-ids', $settings )){
                add_action( 'manage_edit-comments_columns', array( $this, 'mww_webkit_ids_column' ) );
                add_action( 'manage_comments_custom_column', array( $this, 'mww_webkit_ids_value' ), 10, 3 );
                if( version_compare($GLOBALS['wp_version'], '3.0.999', '>') ) {
                    add_filter( "manage_edit-comments_sortable_columns" , array( $this, 'mww_webkit_ids_column' ) );
                }
            }
        }


    function mww_webkit_ids_column($cols) {
        $column_id = array( 'mww_webkit_ids' => __( 'Id', 'website-webkit' ) );
        $cols      = array_slice( $cols, 0, 1, true ) + $column_id + array_slice( $cols, 1, NULL, true );
        return $cols;
    }
    function mww_webkit_ids_value($column_name, $id) {
        if ( 'mww_webkit_ids' == $column_name ) {
            echo $id;
        }
    }



    function mww_webkit_ids_return_value($value, $column_name, $id)
    {
        if ('mww_webkit_ids' == $column_name) {
            $value .= $id;
        }
        return $value;
    }
}


new MWW_Webkit_Ids();

