/**
 * Since Gutenberg keeps changing component locations,
 * we just manage all the components & classes here
 * and import this within all blocks to make maintenance easier.
 */

export const { registerBlockType } = wp.blocks

export const { __ } = wp.i18n

export const {
	RangeControl,
	SelectControl,
	TextControl,
	ToggleControl,
	Dashicon,
	IconButton,
	Button,
	Toolbar,
	PanelBody,
	RadioControl,
	BaseControl,
	QueryControls,
} = wp.components

export const {
	InspectorControls,
	BlockControls,
	AlignmentToolbar,
	RichText,
	URLInput,
	MediaUpload,
} = wp.editor.InspectorControls ? wp.editor : wp.blocks

export const {
	PanelColorSettings,
	BlockAlignmentToolbar,
	InnerBlocks,
} = wp.editor

export const {
	Fragment,
	renderToString, // Renders a WP Component into a string.
} = wp.element

export const {
	omit,
	merge,
} = lodash

export const {
	doAction,
	addAction,
	applyFilters,
	addFilter,
} = wp.hooks

export const {
	withSelect,
} = wp.data

