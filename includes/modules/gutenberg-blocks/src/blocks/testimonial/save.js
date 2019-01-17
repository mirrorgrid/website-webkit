import classnames from 'classnames'
import { range } from '../../util'

const save = props => {
	const { className, attributes } = props
	const {
		columns,
		titleColor,
		posColor,
		bodyTextColor,
	} = attributes

    const {
        InspectorControls,
        ColorPalette,
        BlockControls,
        RichText,
    } = wp.editor;

    const mainClasses = classnames( [
		className,
		'ugb-testimonial',
		`columns-${ columns }`,
	] )

	return (
		<div className={ mainClasses }>
			{ range( 1, columns + 1 ).map( i => {
				const mediaURL = attributes[ `mediaURL${ i }` ]
				const name = attributes[ `name${ i }` ]
				const position = attributes[ `position${ i }` ]
				const testimonial = attributes[ `testimonial${ i }` ]
				return (
					<div className="ugb-testimonial-item" key={ i }>
						{ ! RichText.isEmpty( testimonial ) && (
							<RichText.Content
								tagName="p"
								className="ugb-testimonial-body"
								style={ { color: bodyTextColor } }
								value={ testimonial }
							/>
						) }
						{ mediaURL && (
							<div className="testimonial-image" style={ { backgroundImage: `url(${ mediaURL })` } }></div>
						) }
						{ ! RichText.isEmpty( name ) && (
							<RichText.Content
								tagName="h4"
								style={ { color: titleColor } }
								value={ name }
							/>
						) }
						{ ! RichText.isEmpty( position ) && (
							<RichText.Content
								tagName="p"
								className="ugb-testimonial-position"
								style={ { color: posColor } }
								value={ position }
							/>
						) }
					</div>
				)
			} ) }
		</div>
	)
}

export default save
