/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { Fragment } = wp.element;
const {
	PanelBody,
	TextControl,
} = wp.components;
const {
	InspectorControls,
	URLInput,
} = wp.blockEditor;

export default function CourseLocationEdit( {
	attributes,
	className,
	setAttributes,
} ) {
	const {
		onlineLearningUrl,
		onlineLearningLink,
	} = attributes;

	return (
		<Fragment>
			<InspectorControls>
				<PanelBody title={ __( 'Online Course Settings', 'wsuwp-hrs-courses' ) }>
					<TextControl
						label={ __( 'Online Course Link Text', 'wsuwp-hrs-courses' ) }
						help={ __( 'Enter link text here to override the default online course URL link text.', 'wsuwp-hrs-courses' ) }
						value={ onlineLearningLink }
						onChange={ ( value ) => setAttributes( { onlineLearningLink: value } ) }
					/>
				</PanelBody>
			</InspectorControls>
			<div className={ className }>
				<div className={ 'components-base-control' }>
					<p className="components-base-control__label">
						{ __( 'Online course URL' ) }
					</p>
				</div>
				<URLInput
					autoFocus={ false } // eslint-disable-line jsx-a11y/no-autofocus
					value={ onlineLearningUrl }
					onChange={ ( value ) => setAttributes( { onlineLearningUrl: value } ) }
				/>
			</div>
		</Fragment>
	);
}
