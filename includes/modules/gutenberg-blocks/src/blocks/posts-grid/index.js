//  Import CSS .
import './style/style.scss';
import './style/editor.scss';

//  Import JS .
import { bokez } from '../../global';
import { PostsGridIcon } from '../../icons';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

const {
    PanelColorSettings,
    InspectorControls, 
} = wp.editor;

const { 
    SelectControl,
    RangeControl,
} = wp.components;

const { withSelect } = wp.data;

registerBlockType( 'bokez/posts-grid', {
    
    title: __( 'Posts Grid' ),
    
    description: __('Add beautiful posts grid.'),
    
    keywords: [__('post'), __('grid'), __('posts')],
    
    icon: PostsGridIcon,
    
    category: 'bokez',
    
    attributes: {
        postsNumber: {
            type: 'number',
            default: 3,
        },
        columns: {
            type: 'number',
            default: 3,
        },
        category: {
            type: 'number',
            default: 0,
        },
        bgColor: {
            type: 'string',
            default: '',
        },
        textColor: {
            type: 'string',
            default: '',
        }
    },
    
    edit: withSelect( ( select, props ) => {

        const getEntityRecords = select( 'core' ).getEntityRecords;

        const { 
            attributes,
        } = props;

        const {
            columns,
            postsNumber,
            category,
        } = attributes;

        const postsQueryArgs = {
            per_page: postsNumber,
        };
        
        if( category != 0 ){
            postsQueryArgs.categories = [ category ];
        }

        const catsQueryArgs = {
            per_page: 100,
            hide_empty: 1,
        };

        return {
            posts: getEntityRecords( 'postType', 'post', postsQueryArgs ),
    		categoriesList: getEntityRecords( 'taxonomy', 'category', catsQueryArgs ),        
        };
        
    } )( ( props ) => {

        const {
            isSelected,
            posts,
            categoriesList,
            setAttributes,
        } = props;

        const {
            category,
            columns,
            postsNumber,
            bgColor,
            textColor,
        } = props.attributes;

        if( ! posts ){
            return "loading !";
        }

        if ( posts.length === 0 ) {
            return "No posts";
        }

        // prepare Posts Output
        const output = posts.map( function( post ){

            return (
                <div className={ '_entry_bokez' + ( post.featured_image_src ? ' _has_thumbnail_bokez' : '' ) } href={ post.link }>

                    { post.featured_image_src && 
                        <div className = { "_entry_thumbnail_bokez" }>
                            <a href = {"#"} rel = { "bookmark" } >
                                <img src = { post.featured_image_src } />
                            </a>
                        </div>
                    }
                    
                    <div className = { "_entry_content_bokez" } style = {{ 'background-color' : bgColor, 'color' : textColor }} >
                        
                        <div className = { "_entry_meta_bokez" } >{ post.date_formated }</div>

                        <h3><a href = { "#" } >{ post.title.rendered }</a></h3>
                    
                    </div>

                </div>
            )
        });

        // Prepare Categories Output
        const categoriesOptions = [ { label : 'All', value : 0 } ];
        
        if( categoriesList != null ){
            categoriesList.map( function( item ){
                categoriesOptions.push( { label : item.name, value : item.id } );
            });
        }
        
        return [

            isSelected && (

                <InspectorControls key = {'inspector'} > 
    
                    <hr/>
                    
                    <SelectControl 
                        label = { __( 'Category' ) }
                        value = { category }
                        options = { categoriesOptions }
                        onChange = { ( newType ) => setAttributes( { category: newType } ) }
                    />

                    <hr/>

                    <RangeControl
                        label = { __( 'Number of Posts' ) }
                        value = { postsNumber }
                        min = { 1 }
                        max = { 50 }
                        step = { 1 }
                        onChange = { ( newValue ) => setAttributes( { postsNumber: newValue } ) } 
				    />

                    <hr/>

                    <RangeControl
                        label = { __( 'Columns' ) }
                        value = { columns }
                        min = { 1 }
                        max = { 4 }
                        step = { 1 }
                        onChange = { ( newValue ) => setAttributes( { columns: newValue } ) } 
				    />
    
                    <PanelColorSettings 
                        title = { __( 'Background Color' ) } 
                        initialOpen = { false } 
                        colorValue = { bgColor } 
                        colorSettings={ [ {
                                value: bgColor,
                                colors: bokez.colors,
                                label: __( 'Background Color' ),
                                onChange: ( newColor ) => setAttributes( { bgColor: newColor } ),
                        } ] } >
                    </PanelColorSettings>

                    <PanelColorSettings 
                        title = { __( 'Text Color' ) } 
                        initialOpen = { false } 
                        colorValue = { textColor } 
                        colorSettings={ [ {
                                value: textColor,
                                colors: bokez.colors,
                                label: __( 'Text Color' ),
                                onChange: ( newColor ) => setAttributes( { textColor: newColor } ),
                        } ] } >
                    </PanelColorSettings>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                

                </InspectorControls>
            ),

            <div className = { 'bokez-posts-grid _' + columns + '_columns_bokez' }>
                { output }
            </div>
            
        ];

    } ),
    
    save: () => null,
})
