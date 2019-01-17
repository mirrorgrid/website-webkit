/**
 * BLOCK: Testimonial Block.
 */
import icon from './icons/icon';
import remove_icon from './icons/remove_icon';

import './style.scss';
import './editor.scss';


const { __ } = wp.i18n;


export const schema = {
	mediaID1: {
		type: 'number',
	},
	mediaID2: {
		type: 'number',
	},
	mediaID3: {
		type: 'number',
	},
	mediaURL1: {
		type: 'string',
	},
	mediaURL2: {
		type: 'string',
	},
	mediaURL3: {
		type: 'string',
	},
	name1: {
		source: 'html',
		selector: '.ugb-testimonial-item:nth-child(1) h4',
		default: __( 'Ben Adams' ),
	},
	name2: {
		source: 'html',
		selector: '.ugb-testimonial-item:nth-child(2) h4',
		default: __( 'Alex Johnson' ),
	},
	name3: {
		source: 'html',
		selector: '.ugb-testimonial-item:nth-child(3) h4',
		default: __( 'Sammy Simpson' ),
	},
	position1: {
		source: 'html',
		selector: '.ugb-testimonial-item:nth-child(1) .ugb-testimonial-position',
		default: __( 'Founder' ),
	},
	position2: {
		source: 'html',
		selector: '.ugb-testimonial-item:nth-child(2) .ugb-testimonial-position',
		default: __( 'Editor' ),
	},
	position3: {
		source: 'html',
		selector: '.ugb-testimonial-item:nth-child(3) .ugb-testimonial-position',
		default: __( 'Programmer' ),
	},
	testimonial1: {
		source: 'html',
		selector: '.ugb-testimonial-item:nth-child(1) .ugb-testimonial-body',
		default: __( 'Stackable: Ultimate Blocks from Gutenberg has all the blocks I need to make a great webpage.' ),
	},
	testimonial2: {
		source: 'html',
		selector: '.ugb-testimonial-item:nth-child(2) .ugb-testimonial-body',
		default: __( 'Stackable: Ultimate Blocks from Gutenberg has all the blocks I need to make a great webpage.' ),
	},
	testimonial3: {
		source: 'html',
		selector: '.ugb-testimonial-item:nth-child(3) .ugb-testimonial-body',
		default: __( 'Stackable: Ultimate Blocks from Gutenberg has all the blocks I need to make a great webpage.' ),
	},
	titleColor: {
		type: 'string',
	},
	posColor: {
		type: 'string',
	},
	bodyTextColor: {
		type: 'string',
	},
	columns: {
		type: 'number',
		default: 2,
	},

	// Keep the old attributes. Gutenberg issue https://github.com/WordPress/gutenberg/issues/10406
	href: {
		type: 'url',
	},
	hrefTwo: {
		type: 'url',
	},
	hrefThree: {
		type: 'url',
	},
	mediaID: {
		type: 'number',
	},
	mediaIDTwo: {
		type: 'number',
	},
	mediaIDThree: {
		type: 'number',
	},
	mediaURL: {
		type: 'string',
		source: 'attribute',
		selector: '.ugb-testimonial-column-one .testimonial-image',
		attribute: 'data-src',
	},
	mediaURLTwo: {
		type: 'string',
		source: 'attribute',
		selector: '.ugb-testimonial-column-two .testimonial-image',
		attribute: 'data-src',
	},
	mediaURLThree: {
		type: 'string',
		source: 'attribute',
		selector: '.ugb-testimonial-column-three .testimonial-image',
		attribute: 'data-src',
	},
	testimonialTitle: {
		source: 'html',
		selector: '.ugb-testimonial-column-one h4',
		default: __( 'Ben Adams' ),
	},
	testimonialTitleTwo: {
		source: 'html',
		selector: '.ugb-testimonial-column-two h4',
		default: __( 'Alex Johnson' ),
	},
	testimonialTitleThree: {
		source: 'html',
		selector: '.ugb-testimonial-column-three h4',
		default: __( 'Sammy Simpson' ),
	},
	position: {
		source: 'html',
		selector: '.ugb-testimonial-position',
		default: __( 'Founder' ),
	},
	positionTwo: {
		source: 'html',
		selector: '.ugb-testimonial-position-two',
		default: __( 'Editor' ),
	},
	positionThree: {
		source: 'html',
		selector: '.ugb-testimonial-position-three',
		default: __( 'Programmer' ),
	},
	body: {
		source: 'html',
		selector: '.ugb-testimonial-body',
		default: __( 'Stackable: Ultimate Blocks from Gutenberg has all the blocks I need to make a great webpage.' ),
	},
	bodyTwo: {
		source: 'html',
		selector: '.ugb-testimonial-body-two',
		default: __( 'Stackable: Ultimate Blocks from Gutenberg has all the blocks I need to make a great webpage.' ),
	},
	bodyThree: {
		source: 'html',
		selector: '.ugb-testimonial-body-three',
		default: __( 'Stackable: Ultimate Blocks from Gutenberg has all the blocks I need to make a great webpage.' ),
	},
	iconColor: {
		type: 'string',
	},
}

export const name = 'ugb/testimonial'

export const settings = {
	title: __( 'Testimonial' ),
	description: __( 'Showcase what your users say about your product or service.' ),
	icon: icon,
	category: 'stackable',
	keywords: [
		__( 'Testimonial' ),
		__( 'Stackable' ),
	],
	attributes: schema,


	// Stackable specific settings.
	sDemoURL: 'https://wpstackable.com/testimonial-block/',
}
