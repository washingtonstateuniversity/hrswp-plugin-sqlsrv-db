/**
 * WordPress dependencies
 */
const {	RichText } = wp.blockEditor;
const { Path, SVG } = wp.components;

export default function save( {
	attributes,
	className,
} ) {
	const {
		onlineLearningUrl,
		onlineLearningLink,
	} = attributes;

	if ( ! onlineLearningUrl ) {
		return null;
	}

	return (
		<p className={ className }>
			<SVG
				class="svg-icon"
				viewBox="0 0 20 20"
				width="24"
				height="24"
				xmlns="http://www.w3.org/2000/svg"
			>
				<Path d="M3 3h14c.6 0 1 .4 1 1v10c0 .6-.4 1-1 1H3c-.6 0-1-.4-1-1V4c0-.6.4-1 1-1zm13 2H4v8h12V5zm-3 1H5v4zm6 11v-1H1v1c0 .6.5 1 1.1 1h15.8c.6 0 1.1-.4 1.1-1z" />
			</SVG>
			<RichText.Content
				tagName="a"
				class="course-recorded-video__link"
				href={ onlineLearningUrl }
				value={ onlineLearningLink }
			/>
		</p>
	);
}
