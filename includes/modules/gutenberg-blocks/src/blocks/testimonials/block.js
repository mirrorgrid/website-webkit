
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
    BlockControls,
    RichText,
    ColorPalette,
    PanelColorSettings
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
            default: '#8a8a8a'
        },
        textBackgroundColor: {
            type: 'string',
            default: '#fff'
        },
        backgroundColor: {
            type: 'string',
            default: '#f4f6f6'
        },
        titleColor: {
            type: 'string',
            default: '#525252'
        },
        designationColor: {
            type: 'string',
            default: '#FF5722'
        },
        quoteBackgroundColor: {
            type: 'string',
            default: '#FF5722'
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
                            title={__('Testimonial')}
                        >
                            <p>Background Color</p>
                            <ColorPalette
                                value={props.attributes.backgroundColor}
                                onChange={(colorValue) => props.setAttributes({ backgroundColor: colorValue })}
                                allowReset
                            />
                            <p>Quote Background Color</p>
                            <ColorPalette
                                value={props.attributes.quoteBackgroundColor}
                                onChange={(colorValue) => props.setAttributes({ quoteBackgroundColor: colorValue })}
                                allowReset
                            />
                        </PanelBody>
                        <PanelBody
                            title={__('Title')}
                        >
                            <p>Font Color</p>
                            <ColorPalette
                                value={props.attributes.titleColor}
                                onChange={(colorValue) => props.setAttributes({ titleColor: colorValue })}
                                allowReset
                            />
                        </PanelBody>
                        <PanelBody
                            title={__('Designation')}
                        >
                            <p>Font Color</p>
                            <ColorPalette
                                value={props.attributes.designationColor}
                                onChange={(colorValue) => props.setAttributes({ designationColor: colorValue })}
                                allowReset
                            />
                        </PanelBody>
                        <PanelBody
                            title={__('Description')}
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

                <div className={ mainClasses }
                     style={{
                    backgroundColor: props.attributes.backgroundColor,
                }}
                >
                    { [ 1, 2, 3 ].map( i => {
                        const title = attributes[ `title${ i }` ]
                        const description = attributes[ `description${ i }` ]
                        const post = attributes[ `post${ i }` ]
                        return (
                                <div id="testimonial-slider" className="testimonial-wrapper">
                                    <div className={`testimonial testimonial_${i}`}>
                                        <div class="testimonial-content">
                                            <div class="testimonial-icon" style={{
                                                backgroundColor: props.attributes.quoteBackgroundColor,
                                            }}>
                                                <span class="dashicons dashicons-editor-quote"></span>
                                            </div>

                                    <RichText
                                        style={{
                                            color: props.attributes.textColor,
                                        }}
                                        tagName="p"
                                        className="description"
                                        value={ attributes[ `description${ i }` ] }
                                        onChange={ description => setAttributes( { [ `description${ i }` ]: description } ) }
                                        placeholder={ __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent bibendum dolor sit amet eros imperdiet, sit amet hendrerit nisi vehicula.' ) }
                                        keepPlaceholderOnFocus
                                    />
                                        </div>
                                        <RichText
                                            style={{
                                                color: props.attributes.titleColor,
                                            }}
                                            tagName="h3"
                                            className="title"
                                            value={ attributes[ `title${ i }` ] }
                                            onChange={ title => setAttributes( { [ `title${ i }` ]: title } ) }
                                            placeholder={ __( 'Name' ) }
                                            keepPlaceholderOnFocus
                                        />
                                            <RichText
                                                style={{
                                                    color: props.attributes.designationColor,
                                                }}
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
            <div className={ mainClasses }  style={{
                backgroundColor: props.attributes.backgroundColor,
            }}>
                { range( 1, column + 1 ).map( i => {
                    return (
                        <div id="testimonial-slider" className="testimonial-wrapper" key={ i }>
                            <div class="testimonial testimonial_1">
                                <div class="testimonial-content">
                                    <div class="testimonial-icon" style={{
                                        backgroundColor: props.attributes.quoteBackgroundColor,
                                    }}>
                                        <span class="dashicons dashicons-editor-quote"></span>
                                    </div>
                                    { ! RichText.isEmpty( attributes[ `description${ i }` ] ) && (
                                        <RichText.Content
                                            style={{
                                                color: props.attributes.textColor,
                                            }}
                                            tagName="p"
                                            className="description"
                                            value={attributes[ `description${ i }` ] }
                                        />
                                    ) }
                                </div>
                            { ! RichText.isEmpty( attributes[ `title${ i }` ] ) && (
                                <RichText.Content
                                    style={{
                                        color: props.attributes.titleColor,
                                    }}
                                    tagName="h3"
                                    className="title"
                                    value={ attributes[ `title${ i }` ] }
                                />
                            ) }

                            { ! RichText.isEmpty( attributes[ `post${ i }` ] ) && (
                                <p>
                                    <RichText.Content
                                        style={{
                                            color: props.attributes.designationColor,
                                        }}
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
