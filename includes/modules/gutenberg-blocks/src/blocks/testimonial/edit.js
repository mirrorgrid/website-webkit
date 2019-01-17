import classnames from 'classnames'
const { __ } = wp.i18n;


const {
    InspectorControls,
    ColorPalette,
    BlockControls,
    RichText,
	Fragment
} = wp.editor;
const {
    PanelBody,
    RangeControl,
} = wp.components;

const edit = props => {
	const {
		className,
		setAttributes,
		attributes,
	} = props

	const {
		columns,
		titleColor,
		posColor,
		bodyTextColor,
	} = attributes

	const mainClasses = classnames( [
		className,
		'ugb-testimonial',
		`columns-${ columns }`,
	] )

	return (
		<Fragment>
			<InspectorControls>
					<PanelBody initialOpen={ false } title={ __( 'Design' ) }>
						<ProControl />
					</PanelBody>
				<PanelBody title={ __( 'General Settings' ) }>
					<RangeControl
						label={ __( 'Columns' ) }
						value={ columns }
						onChange={ columns => setAttributes( { columns } ) }
						min={ 1 }
						max={ 3 }
					/>
				</PanelBody>
				<PanelColorSettings
					initialOpen={ true }
					title={ __( 'Color Settings' ) }
					colorSettings={ [
						{
							value: bodyTextColor,
							onChange: colorValue => setAttributes( { bodyTextColor: colorValue } ),
							label: __( 'Body Text Color' ),
						},
						{
							value: titleColor,
							onChange: colorValue => setAttributes( { titleColor: colorValue } ),
							label: __( 'Title Color' ),
						},
						{
							value: posColor,
							onChange: colorValue => setAttributes( { posColor: colorValue } ),
							label: __( 'Position Color' ),
						},
					] }
				>
				</PanelColorSettings>
			</InspectorControls>
			<div className={ mainClasses }>
				{ [ 1, 2, 3 ].map( i => {
					const mediaURL = attributes[ `mediaURL${ i }` ]
					const mediaID = attributes[ `mediaID${ i }` ]
					const name = attributes[ `name${ i }` ]
					const position = attributes[ `position${ i }` ]
					const testimonial = attributes[ `testimonial${ i }` ]
					return (
						<div className="ugb-testimonial-item" key={ i }>
							<RichText
								tagName="p"
								className="ugb-testimonial-body"
								value={ testimonial }
								onChange={ testimonial => setAttributes( { [ `testimonial${ i }` ]: testimonial } ) }
								style={ {
									color: bodyTextColor,
								} }
								placeholder={ __( 'Stackable: Ultimate Blocks from Gutenberg has all the blocks I need to make a great webpage.' ) }
								keepPlaceholderOnFocus
							/>
							<ImageUploadPlaceholder
								className="testimonial-image"
								imageID={ mediaID }
								imageURL={ mediaURL }
								onRemove={ () => {
									setAttributes( { [ `mediaURL${ i }` ]: '', [ `mediaID${ i }` ]: '' } )
								} }
								onChange={ ( { url, id } ) => {
									setAttributes( { [ `mediaURL${ i }` ]: url, [ `mediaID${ i }` ]: id } )
								} }
								hasRemove={ false }
							/>
							<RichText
								tagName="h4"
								value={ name }
								onChange={ name => setAttributes( { [ `name${ i }` ]: name } ) }
								style={ {
									color: titleColor,
								} }
								placeholder={ __( 'Name' ) }
								keepPlaceholderOnFocus
							/>
							<RichText
								tagName="p"
								value={ position }
								className="ugb-testimonial-position"
								onChange={ position => setAttributes( { [ `position${ i }` ]: position } ) }
								style={ {
									color: posColor,
								} }
								keepPlaceholderOnFocus
							/>
						</div>
					)
				} ) }
			</div>
		</Fragment>
	)
}

export default edit
