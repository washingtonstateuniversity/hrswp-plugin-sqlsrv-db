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
		recordedVideoUrl,
		recordedVideoLink,
	} = attributes;

	return (
		<Fragment>
			<InspectorControls>
				<PanelBody title={ __( 'Course Video Settings', 'wsuwp-hrs-courses' ) }>
					<TextControl
						label={ __( 'Course Video Link Text', 'wsuwp-hrs-courses' ) }
						help={ __( 'Enter link text here to override the default video URL link text.', 'wsuwp-hrs-courses' ) }
						value={ recordedVideoLink }
						onChange={ ( value ) => setAttributes( { recordedVideoLink: value } ) }
					/>
				</PanelBody>
			</InspectorControls>
			<div className={ className }>
				<div className={ 'components-base-control' }>
					<p className="components-base-control__label">
						{ __( 'Course video URL', 'wsuwp-hrs-courses' ) }
					</p>
				</div>
				<URLInput
					autoFocus={ false } // eslint-disable-line jsx-a11y/no-autofocus
					value={ recordedVideoUrl }
					onChange={ ( value ) => setAttributes( { recordedVideoUrl: value } ) }
				/>
			</div>
		</Fragment>
	);
}
