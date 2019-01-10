/**
 * BLOCK: testimonial
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//Import Icon
import icon from './icons/icon';
import remove_icon from './icons/remove_icon';

//  Import CSS.
import './style.scss';
import './editor.scss';



const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

const {
    InspectorControls,
    AlignmentToolbar,
    ColorPalette,
    BlockControls,
    RichText,
} = wp.editor;

const {
    PanelBody,
    RangeControl,
} = wp.components;

const {
    withState,
} = wp.compose;


/**
 * Register: aa Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType('gutenberg-blocks/testimonials', {

    title: __('Testimonials'),
    icon: icon,
    category: 'gutenberg-blocks',
    keywords: [
        __('Feature Box'),
        __('Column'),
        __('Gutenberg Blocks'),
    ],
    attributes: {
        column: {
            type: 'number',
            default: 1
        },
        columnOneTitle: {
            type: 'array',
            source: 'children',
            selector: '.title',
            default: 'John Doe'
        },
        columnTwoTitle: {
            type: 'array',
            source: 'children',
            selector: '.title',
            default: 'John Doe'
        },
        columnThreeTitle: {
            type: 'array',
            source: 'children',
            selector: '.title',
            default: 'John Doe'
        },
        columnOneBody: {
            type: 'array',
            source: 'children',
            selector: '.description',
            default: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent bibendum dolor sit amet eros imperdiet, sit amet hendrerit nisi vehicula.'
        },
        columnTwoBody: {
            type: 'array',
            source: 'children',
            selector: '.description',
            default: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent bibendum dolor sit amet eros imperdiet, sit amet hendrerit nisi vehicula.'
        },
        columnThreeBody: {
            type: 'array',
            source: 'children',
            selector: '.description',
            default: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent bibendum dolor sit amet eros imperdiet, sit amet hendrerit nisi vehicula.'
        },
        columnOneDesignation: {
            type: 'array',
            source: 'children',
            selector: '.post',
            default: 'Designation'
        },
        columnTwoDesignation: {
            type: 'array',
            source: 'children',
            selector: '.post',
            default: 'Designation'
        },
        columnThreeDesignation: {
            type: 'array',
            source: 'children',
            selector: '.post',
            default: 'Designation'
        },
        textSize: {
            type: 'number',
            default: 17
        },
        textColor: {
            type: 'string',
            default: '#444444'
        },
    },

	/**
	 * The edit function describes the structure of your block in the context of the editor.
	 * This represents what the editor will render when the block is used.
	 *
	 * The "edit" property must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 */
    edit: withState({ editable: 'content' })(function (props) {
        const {
            isSelected,
            editable,
            setState
        } = props;

        const {
            column,
            columnOneTitle,
            columnTwoTitle,
            columnThreeTitle,
            columnOneBody,
            columnTwoBody,
            columnThreeBody,
            columnOneDesignation,
            columnTwoDesignation,
            columnThreeDesignation,
        } = props.attributes;


        const onSetActiveEditable = (newEditable) => () => {
            setState({ editable: newEditable })
        };
        return [

            isSelected && (
                <BlockControls key="controls" />
            ),

            isSelected && (
                <InspectorControls key={'inspector'}>
                    <PanelBody title={ __('General Settings') }>
                        <RangeControl
                            label={ __('Columns') }
                            value={column}
                            onChange={(value) => {
                                props.setAttributes({ column: value })
                            }}
                            min={ 1 }
                            max={ 3 }
                        />
                    </PanelBody>
                    <PanelBody
                        title={__('Testimonial Body')}
                    >
                        <p>Font Color</p>
                        <ColorPalette
                            value={props.attributes.textColor}
                            onChange={(colorValue) => props.setAttributes({ textColor: colorValue })}
                            allowReset
                        />
                    </PanelBody>
                </InspectorControls>
            ),

            <div key={'editable'} className={props.className}>
                    <div className={`testimonial-sample2 column_${column}`}>
                        <div id="testimonial-slider123" className="testimonial-wrapper">
                            <div class="testimonial testimonial_1">
                                <div class="testimonial-content">
                                    <div class="testimonial-icon">
                                      <span class="dashicons dashicons-editor-quote"></span>
                                    </div>
                                    <RichText
                                        tagName="p"
                                        className="description"
                                        style={{
                                            color: props.attributes.textColor,
                                        }}
                                        value={columnOneBody}
                                        onChange={(value) => props.setAttributes({ columnOneBody: value })}
                                        isSelected={isSelected && editable === 'body_one'}
                                        onFocus={onSetActiveEditable('body_one')}
                                        keepPlaceholderOnFocus={true}
                                    />
                                </div>
                                <RichText
                                    tagName="h3"
                                    className="title"
                                    value={columnOneTitle}
                                    onChange={(value) => props.setAttributes({ columnOneTitle: value })}
                                    isSelected={isSelected && editable === 'title_one'}
                                    onFocus={onSetActiveEditable('title_one')}
                                    keepPlaceholderOnFocus={true}
                                />
                                    <RichText
                                        tagName="span"
                                        className="post"
                                        value={columnOneDesignation}
                                        onChange={(value) => props.setAttributes({ columnOneDesignation: value })}
                                        isSelected={isSelected && editable === 'designation_one'}
                                        onFocus={onSetActiveEditable('designation_one')}
                                        keepPlaceholderOnFocus={true}
                                    />
                            </div>
                        <div class="testimonial testimonial_2">
                            <div class="testimonial-content">
                                <div class="testimonial-icon">
                                    <span class="dashicons dashicons-editor-quote"></span>
                                </div>
                                    <RichText
                                        tagName="p"
                                        className="description"
                                        value={columnTwoBody}
                                        onChange={(value) => props.setAttributes({ columnTwoBody: value })}
                                        isSelected={isSelected && editable === 'body_two'}
                                        onFocus={onSetActiveEditable('body_two')}
                                        keepPlaceholderOnFocus={true}
                                    />
                            </div>
                            <RichText
                                tagName="h3"
                                className="title"
                                value={columnTwoTitle}
                                onChange={(value) => props.setAttributes({ columnTwoTitle: value })}
                                isSelected={isSelected && editable === 'title_two'}
                                onFocus={onSetActiveEditable('title_two')}
                                keepPlaceholderOnFocus={true}
                            />
                            <RichText
                                tagName="span"
                                className="post"
                                value={columnTwoDesignation}
                                onChange={(value) => props.setAttributes({ columnTwoDesignation: value })}
                                isSelected={isSelected && editable === 'designation_two'}
                                onFocus={onSetActiveEditable('designation_two')}
                                keepPlaceholderOnFocus={true}
                            />
                        </div>

                        <div class="testimonial testimonial_3">
                            <div class="testimonial-content">
                                <div class="testimonial-icon">
                                    <span class="dashicons dashicons-editor-quote"></span>
                                </div>

                                <RichText
                                    tagName="p"
                                    className="description"
                                    value={columnThreeBody}
                                    onChange={(value) => props.setAttributes({ columnThreeBody: value })}
                                    isSelected={isSelected && editable === 'body_three'}
                                    onFocus={onSetActiveEditable('body_three')}
                                    keepPlaceholderOnFocus={true}
                                />
                            </div>
                            <RichText
                                tagName="h3"
                                className="title"
                                value={columnThreeTitle}
                                onChange={(value) => props.setAttributes({ columnThreeTitle: value })}
                                isSelected={isSelected && editable === 'title_three'}
                                onFocus={onSetActiveEditable('title_three')}
                                keepPlaceholderOnFocus={true}
                            />
                            <RichText
                                tagName="span"
                                className="post"
                                value={columnThreeDesignation}
                                onChange={(value) => props.setAttributes({ columnThreeDesignation: value })}
                                isSelected={isSelected && editable === 'designation_three'}
                                onFocus={onSetActiveEditable('designation_three')}
                                keepPlaceholderOnFocus={true}
                            />
                        </div>
                    </div>
                    </div>
                </div>

        ];
    },
    ),

	/**
	 * The save function defines the way in which the different attributes should be combined
	 * into the final markup, which is then serialized by Gutenberg into post_content.
	 *
	 * The "save" property must be specified and must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 */
    save: function (props) {
        const {
            column,
            columnOneTitle,
            columnTwoTitle,
            columnThreeTitle,
            columnOneBody,
            columnTwoBody,
            columnThreeBody,
            columnOneDesignation,
            columnTwoDesignation,
            columnThreeDesignation,
        } = props.attributes;

        return (
            <div className={props.className}>
                <div className={`testimonial-sample2 column_${column}`}>
                    <div id="testimonial-slider123" className="testimonial-wrapper">
                    <div class="testimonial testimonial_1">
                        <div class="testimonial-content">
                            <div class="testimonial-icon">
                                <span class="dashicons dashicons-editor-quote"></span>
                            </div>

                            <p class="description">
                                {columnOneBody}
                            </p>
                        </div>
                        <h3 class="title">{columnOneTitle}</h3>
                        <span class="post">{columnOneDesignation}</span>
                    </div>
                    <div class="testimonial testimonial_2">
                        <div class="testimonial-content">
                            <div class="testimonial-icon">
                                <span class="dashicons dashicons-editor-quote"></span>
                            </div>

                            <p class="description">
                                {columnTwoBody}
                            </p>
                        </div>
                        <h3 class="title">{columnTwoTitle}</h3>
                        <span class="post">{columnTwoDesignation}</span>
                    </div>
                    <div class="testimonial testimonial_3">
                        <div class="testimonial-content">
                            <div class="testimonial-icon">
                                <i class="fa fa-quote-left"></i>
                            </div>
                            <p class="description">
                                {columnThreeBody}
                            </p>
                        </div>
                        <h3 class="title">{columnThreeTitle}</h3>
                        <span class="post">{columnThreeDesignation}</span>
                    </div>
                </div>
                </div>
            </div>
        );
    },
});
