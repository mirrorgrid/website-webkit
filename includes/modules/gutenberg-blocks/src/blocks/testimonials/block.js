
import icon from './icons/icon';
import remove_icon from './icons/remove_icon';

import './style.scss';
import './editor.scss';
import { range } from '../../util'
import classnames from 'classnames'

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

const {
    InspectorControls,
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
        title1: {
            source: 'html',
            selector: '.testimonial-wrapper:nth-child(1) .title',
            default: 'Adam Smith'
        },
        description1: {
            source: 'html',
            selector: '.testimonial-wrapper:nth-child(1) .description',
            default: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent bibendum dolor sit amet eros imperdiet, sit amet hendrerit nisi vehicula.'
        },
        post1: {
            source: 'html',
            selector: '.testimonial-wrapper:nth-child(1) .post',
            default: 'Designer'
        },
        title2: {
            source: 'html',
            selector: '.testimonial-wrapper:nth-child(2) .title',
            default: 'John Doe'
        },
        description2: {
            source: 'html',
            selector: '.testimonial-wrapper:nth-child(2) .description',
            default: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent bibendum dolor sit amet eros imperdiet, sit amet hendrerit nisi vehicula.'
        },
        post2: {
            source: 'html',
            selector: '.testimonial-wrapper:nth-child(2) .post',
            default: 'Developer'
        },
        title3: {
            source: 'html',
            selector: '.testimonial-wrapper:nth-child(3) .title',
            default: 'Bhuwan Ojha'
        },
        description3: {
            source: 'html',
            selector: '.testimonial-wrapper:nth-child(3) .description',
            default: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent bibendum dolor sit amet eros imperdiet, sit amet hendrerit nisi vehicula.'
        },
        post3: {
            source: 'html',
            selector: '.testimonial-wrapper:nth-child(3) .post',
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

    edit: withState({ editable: 'content' })(function (props) {
            const {
                isSelected,
                setState,
                className,
                setAttributes,
                attributes
            } = props;

            const {
                column,
            } = attributes;

        const mainClasses = classnames( [
		className,
		'testimonial-sample2',
            `column_${ column }`,
	] )


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

                <div className={ mainClasses }>
                    { [ 1, 2, 3 ].map( i => {
                        const title = attributes[ `title${ i }` ]
                        const description = attributes[ `description${ i }` ]
                        const post = attributes[ `post${ i }` ]
                        return (
                                <div className="testimonial-wrapper">
                                    <div className={`testimonial testimonial_${i}`}>
                                        <div class="testimonial-content">
                                            <div class="testimonial-icon">
                                                <span class="dashicons dashicons-editor-quote"></span>
                                            </div>

                                    <RichText
                                        tagName="p"
                                        className="description"
                                        value={ attributes[ `description${ i }` ] }
                                        onChange={ description => setAttributes( { [ `description${ i }` ]: description } ) }
                                        placeholder={ __( 'Some feature description for an awesome feature' ) }
                                        keepPlaceholderOnFocus
                                    />
                                        </div>
                                        <RichText
                                            tagName="h3"
                                            className="title"
                                            value={ attributes[ `title${ i }` ] }
                                            onChange={ title => setAttributes( { [ `title${ i }` ]: title } ) }
                                            placeholder={ __( 'Feature Title' ) }
                                            keepPlaceholderOnFocus
                                        />
                                            <RichText
                                                tagName="span"
                                                className="post"
                                                value={ attributes[ `post${ i }` ] }
                                                onChange={ post => setAttributes( { [ `post${ i }` ]: post } ) }
                                                placeholder={ __( 'Designation' ) }
                                                formattingControls={ [ 'bold', 'italic', 'strikethrough' ] }
                                                keepPlaceholderOnFocus
                                            />
                                </div>
                            </div>
                        )
                    } ) }
                </div>

            ];
        },
    ),

    save: function (props) {
        const {
            attributes,
            className
        } = props;
        const {
            column,
        } = attributes;

        const mainClasses = classnames( [
		className,
		'testimonial-sample2',
		`column_${ column }`,
	] )


        return (
            <div className={ mainClasses }>
                { range( 1, column + 1 ).map( i => {
                    return (
                        <div  className="testimonial-wrapper" key={ i }>
                            <div class="testimonial testimonial_1">
                                <div class="testimonial-content">
                                    <div class="testimonial-icon">
                                        <span class="dashicons dashicons-editor-quote"></span>
                                    </div>
                                    { ! RichText.isEmpty( attributes[ `description${ i }` ] ) && (
                                        <RichText.Content
                                            tagName="p"
                                            className="description"
                                            value={attributes[ `description${ i }` ] }
                                        />
                                    ) }
                                </div>
                            { ! RichText.isEmpty( attributes[ `title${ i }` ] ) && (
                                <RichText.Content
                                    tagName="h3"
                                    className="title"
                                    value={ attributes[ `title${ i }` ] }
                                />
                            ) }

                            { ! RichText.isEmpty( attributes[ `post${ i }` ] ) && (
                                <p>
                                    <RichText.Content
                                        tagName="span"
                                        value={ attributes[ `post${ i }` ] }
                                        className="post"
                                    />
                                </p>
                            ) }
                        </div>
                        </div>
                    )
                } ) }
            </div>
        );
    },

});
