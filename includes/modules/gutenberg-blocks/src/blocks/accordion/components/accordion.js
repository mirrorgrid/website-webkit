/**
 * Ultimate Accordion
 */
const { __ } = wp.i18n;
const { Component } = wp.element;
const { RichText } = wp.editor;

/**
 * Create an Inspector Controls wrapper Component
 */
export default class Accordion extends Component {
	render() {
		const { isSelected, accordion, i, attributes, accordionsState, onChangeContent, onChangeTitle, showControls, deleteAccord, addAccord, toggleAccordionState, count } = this.props;

		return <div className="wp-block-gutenberg-blocks-content-toggle-accordion" style={ { borderColor: attributes.theme } } key={ i }>
			<div className="wp-block-gutenberg-blocks-content-toggle-accordion-title-wrap" style={ { backgroundColor: attributes.theme } }>
				<RichText
					tagName="span"
					style={{
						color: attributes.titleColor
					}}
					className="wp-block-gutenberg-blocks-content-toggle-accordion-title"
					value={ accordion.title }
					formattingControls={ [ 'italic' ] }
					isSelected={ attributes.activeControl === 'title-' + i && isSelected  }
					onClick={ () => showControls( 'title', i ) }
					onChange={ ( title ) => onChangeTitle( title, i ) }
					placeholder={ __( 'Accordion Title' ) }
					keepPlaceholderOnFocus={ true }
				/>
				<span onClick={ () => { toggleAccordionState( i ) } } className={ 'wp-block-gutenberg-blocks-content-toggle-accordion-state-indicator dashicons dashicons-arrow-right-alt2 ' + ( accordionsState[ i ] ? 'open' : '' ) }></span>
			</div>
			{ accordionsState[ i ] &&
			<div className="wp-block-gutenberg-blocks-content-toggle-accordion-content-wrap">
				<RichText
					tagName="div"
					className="wp-block-gutenberg-blocks-content-toggle-accordion-content"
					value={ accordion.content }
					formattingControls={ [ 'bold', 'italic', 'strikethrough', 'link' ] }
					isSelected={ attributes.activeControl === 'content-' + i && isSelected }
					onClick={ () => showControls( 'content', i ) }
					onChange={ ( content ) => onChangeContent( content, i ) }
					placeholder={ __( 'Accordion Content' ) }
					keepPlaceholderOnFocus={ true }
				/>
			</div> }
			<div className="wp-block-gutenberg-blocks-content-toggle-accordion-controls-top">
				<span title={ __( 'Insert New Accordion Above' ) } onClick={ () => addAccord( i ) } className="dashicons dashicons-plus-alt"></span>
			{ count > 1 && <span title={ __( 'Delete This Accordion' ) } onClick={ () => deleteAccord( i ) } class="dashicons dashicons-dismiss"></span> }
			</div>
			<div className="wp-block-gutenberg-blocks-content-toggle-accordion-controls-bottom">
				<span title={ __( 'Insert New Accordion Below' ) } onClick={ () => addAccord( i + 1 ) } className="dashicons dashicons-plus-alt"></span>
			</div>
		</div>;
	}
}
