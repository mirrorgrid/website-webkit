import icons from "./icons";
//Importing Classname
import classnames from "classnames";
import "./style.scss";
import "./editor.scss";
import {range} from "../../util";


const {__} = wp.i18n; // Import __() from wp.i18n
const {registerBlockType} = wp.blocks;

const {
    RichText,
    BlockControls,
    MediaUpload,
    InspectorControls,
    ColorPalette,
    PanelColorSettings
} = wp.editor;

const {
    Button,
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

export const edit = (props) => {
    const {
        className,
        setAttributes,
        attributes,
    } = props;

    const {
        columns,
        titleColor,
        posColor,
        bodyTextColor,
    } = attributes;

    const mainClasses = classnames([
        className,
        'gutenberg-blocks-testimonial',
        `columns-${columns}`,
    ])


    const {
        isSelected,
        editable,
        setState
    } = props;

    const onSetActiveEditable = (newEditable) => () => {
        setState({editable: newEditable})
    };

    const onSelectImage = img => {
        props.setAttributes({
            imgID: img.id,
            imgURL: img.url,
            imgAlt: img.alt,
        });
    };
    const onRemoveImage = () => {
        props.setAttributes({
            imgID: null,
            imgURL: null,
            imgAlt: null,
        });
    };

    return [

        isSelected && (
            <BlockControls key="controls"/>
        ),

        isSelected && (
            <InspectorControls>
                <PanelBody title={ __('General Settings') }>
                    <RangeControl
                        label={ __('Columns') }
                        value={ columns }
                        onChange={ columns => setAttributes({columns}) }
                        min={ 1 }
                        max={ 3 }
                    />
                </PanelBody>
                <PanelColorSettings
                    title={__('Background Color')}
                    initialOpen={true}
                    colorSettings={[{
                        value: props.attributes.backgroundColor,
                        onChange: (colorValue) => props.setAttributes({backgroundColor: colorValue}),
                        label: ''
                    }]}
                />
                <PanelBody
                    title={__('Testimonial Body')}
                >
                    <p>Font Color</p>
                    <ColorPalette
                        value={props.attributes.textColor}
                        onChange={(colorValue) => props.setAttributes({textColor: colorValue})}
                        allowReset
                    />
                    <RangeControl
                        label={__('Font Size')}
                        value={props.attributes.textSize}
                        onChange={(value) => props.setAttributes({textSize: value})}
                        min={14}
                        max={200}
                        beforeIcon="editor-textcolor"
                        allowReset
                    />
                </PanelBody>
            </InspectorControls>
        ),

        <div className={ mainClasses }>
            { range(1, columns + 1).map(i => {
                const mediaURL = attributes[`imgURL${i}`]
                const mediaID = attributes[`imgID${i}`]
                const name = attributes[`gutenberg_blocks_testimonial_author${i}`]
                const position = attributes[`gutenberg_blocks_testimonial_author_role${i}`]
                const testimonial = attributes[`gutenberg_blocks_testimonial_text${i}`]
                return (
                    <div className={props.className}>
                        <div className="gutenberg_blocks_testimonial"
                             style={{backgroundColor: props.attributes.backgroundColor,color: props.attributes.textColor}}
                        >
                            <div className="gutenberg_blocks_testimonial_content">
                                <RichText
                                    tagName="p"
                                    placeholder={__('This is the testimonial body. Add the testimonial text you want to add here.')}
                                    className="gutenberg_blocks_testimonial_text"
                                    style={{
                                        fontSize: props.attributes.textSize
                                    }}
                                    onChange={ testimonial => setAttributes({[ `gutenberg_blocks_testimonial_text${i}` ]: testimonial}) }
                                    value={testimonial}
                                    isSelected={isSelected && editable === 'testimonial_content'}
                                    onFocus={onSetActiveEditable('testimonial_content')}
                                    keepPlaceholderOnFocus={true}
                                />
                            </div>
                            <div className="gutenberg_blocks_testimonial_sign">
                                <RichText
                                    tagName="p"
                                    placeholder={__('John Doe')}
                                    className="gutenberg_blocks_testimonial_author"
                                    onChange={ name => setAttributes({[ `gutenberg_blocks_testimonial_author${i}` ]: name}) }
                                    value={name}
                                    isSelected={isSelected && editable === 'testimonial_author'}
                                    onFocus={onSetActiveEditable('testimonial_author')}
                                    keepPlaceholderOnFocus={true}
                                />
                                <RichText
                                    tagName="i"
                                    placeholder={__('Founder, Company X')}
                                    className="gutenberg_blocks_testimonial_author_role"
                                    onChange={ position => setAttributes({[ `gutenberg_blocks_testimonial_author_role${i}` ]: position}) }
                                    value={position}
                                    isSelected={isSelected && editable === 'testimonial_author_role'}
                                    onFocus={onSetActiveEditable('testimonial_author_role')}
                                    keepPlaceholderOnFocus={true}
                                />
                            </div>
                        </div>
                    </div>
                )
            })}
        </div>

    ];
}

/**
 * The save function defines the way in which the different attributes should be combined
 * into the final markup, which is then serialized by Gutenberg into post_content.
 *
 * The "save" property must be specified and must be a valid function.
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
 */
export const save = (props) => {
    const {
        className,
        attributes,
    } = props;

    const {
        columns,
    } = attributes;

    const mainClasses = classnames([
        className,
        'gutenberg-blocks-testimonial',
        `columns-${columns}`,
    ])


    return (
        <div className={ mainClasses }>
            { range(1, columns + 1).map(i => {
                const mediaURL = attributes[`imgURL${i}`]
                const mediaID = attributes[`imgID${i}`]
                const name = attributes[`gutenberg_blocks_testimonial_author${i}`]
                const position = attributes[`gutenberg_blocks_testimonial_author_role${i}`]
                const testimonial = attributes[`gutenberg_blocks_testimonial_text${i}`]
                return (
                    <div className={props.className}>
                        <div
                            className="gutenberg_blocks_testimonial"
                            style={{
                                backgroundColor: props.attributes.backgroundColor,
                                color: props.attributes.textColor
                            }}
                        >

                            <div className="gutenberg_blocks_testimonial_content">
                                { !RichText.isEmpty(testimonial) && (
                                    <RichText.Content
                                        tagName='p'
                                        style={{
                                            fontSize: props.attributes.textSize
                                        }}
                                        value={ testimonial }
                                    />
                                )}

                            </div>
                            <div className="gutenberg_blocks_testimonial_sign">
                                { !RichText.isEmpty(name) && (
                                <RichText.Content
                                    className="gutenberg_blocks_testimonial_author"
                                    tagName='p'
                                    value={ name }
                                />
                                )}
                                { !RichText.isEmpty(position) && (
                                <RichText.Content
                                    className="gutenberg_blocks_testimonial_author_role"
                                    tagName='i'
                                    value={ position }
                                />
                                )}
                            </div>
                        </div>
                    </div>
                );
            })}
        </div>
    );
}

export const schema = {
    gutenberg_blocks_testimonial_text: {
        type: 'array',
        source: 'children',
        selector: '.gutenberg_blocks_testimonial_text'
    },
    gutenberg_blocks_testimonial_author: {
        type: 'array',
        source: 'children',
        selector: '.gutenberg_blocks_testimonial_author'
    },
    gutenberg_blocks_testimonial_author_role: {
        type: 'array',
        source: 'children',
        selector: '.gutenberg_blocks_testimonial_author_role'
    },
    imgURL: {
        type: 'string',
        source: 'attribute',
        attribute: 'src',
        selector: 'img',
    },
    imgID: {
        type: 'number',
    },
    imgAlt: {
        type: 'string',
        source: 'attribute',
        attribute: 'alt',
        selector: 'img',
    },
    backgroundColor: {
        type: 'string',
        default: '#f4f6f6'
    },
    textColor: {
        type: 'string',
        default: '#444444'
    },
    textSize: {
        type: 'number',
        default: 17
    },
    columns: {
        type: 'number',
        default: 1
    }
}

registerBlockType('gutenberg-blocks/testimonial', {
    title: __('Testimonial'),
    description: __('Showcase what your users say about your product or service.'),
    icon: icons.testimonial,
    category: 'gutenberg-blocks',
    keywords: [
        __('Testimonial'),
        __('Gutenberg Blocks'),
    ],
    attributes: schema,
    edit,
    save,
});


