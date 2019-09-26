/**
 * External dependencies
 */
import { isUndefined, pickBy } from 'lodash';

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { withSelect } = wp.data;
const apiFetch = wp.apiFetch;
const { addQueryArgs } = wp.url;
const { Component } = wp.element;
const {
	InspectorControls,
	BlockControls,
} = wp.blockEditor;
const {
	Disabled,
	PanelBody,
	Placeholder,
	QueryControls,
	RangeControl,
	Spinner,
	ToggleControl,
	Toolbar,
	RadioControl,
	ServerSideRender,
} = wp.components;

/**
 * Module constants
 */
const LEARNING_PROGRAMS_LIST_QUERY = {
	per_page: -1,
};
const MAX_POST_COLUMNS = 6;

class ListCoursesEdit extends Component {
	constructor() {
		super( ...arguments );
		this.state = {
			taxLearningProgramsList: [],
		};
	}

	componentDidMount() {
		this.isStillMounted = true;
		this.fetchRequest = apiFetch( {
			path: addQueryArgs( `/wp/v2/learning_program`, LEARNING_PROGRAMS_LIST_QUERY ),
		} ).then(
			( taxLearningProgramsList ) => {
				if ( this.isStillMounted ) {
					this.setState( { taxLearningProgramsList } );
				}
			}
		).catch(
			() => {
				if ( this.isStillMounted ) {
					this.setState( { taxLearningProgramsList: [] } );
				}
			}
		);
	}

	componentWillUnmount() {
		this.isStillMounted = false;
	}

	render() {
		const { attributes, setAttributes, ListCourses } = this.props;
		const { taxLearningProgramsList } = this.state;
		const {
			displayCourseContentRadio,
			displayCourseContent,
			displayPostDate,
			postLayout,
			columns,
			order,
			orderBy,
			learningPrograms,
			coursesToShow,
			excerptLength,
		} = attributes;

		const inspectorControls = (
			<InspectorControls>
				<PanelBody title={ __( 'Course Content Settings' ) }>
					<ToggleControl
						label={ __( 'Display course content' ) }
						checked={ displayCourseContent }
						onChange={ ( value ) => setAttributes( { displayCourseContent: value } ) }
					/>
					{ displayCourseContent &&
					<RadioControl
						label="Show:"
						selected={ displayCourseContentRadio }
						options={ [
							{ label: 'Excerpt', value: 'excerpt' },
							{ label: 'Full post', value: 'full_post' },
						] }
						onChange={ ( value ) => setAttributes( { displayCourseContentRadio: value } ) }
					/>
					}
					{ displayCourseContent && displayCourseContentRadio === 'excerpt' &&
						<RangeControl
							label={ __( 'Max number of words in excerpt' ) }
							value={ excerptLength }
							onChange={ ( value ) => setAttributes( { excerptLength: value } ) }
							min={ 10 }
							max={ 100 }
						/>
					}
				</PanelBody>

				<PanelBody title={ __( 'Post Meta Settings' ) }>
					<ToggleControl
						label={ __( 'Display post date' ) }
						checked={ displayPostDate }
						onChange={ ( value ) => setAttributes( { displayPostDate: value } ) }
					/>
				</PanelBody>

				<PanelBody title={ __( 'Sorting and Filtering' ) }>
					<QueryControls
						{ ...{ order, orderBy } }
						numberOfItems={ coursesToShow }
						categoriesList={ taxLearningProgramsList }
						selectedCategoryId={ learningPrograms }
						onCategoryChange={ ( value ) => setAttributes( { learningPrograms: '' !== value ? value : undefined } ) }
						onOrderChange={ ( value ) => setAttributes( { order: value } ) }
						onOrderByChange={ ( value ) => setAttributes( { orderBy: value } ) }
						onNumberOfItemsChange={ ( value ) => setAttributes( { coursesToShow: value } ) }
					/>
					{ postLayout === 'grid' &&
						<RangeControl
							label={ __( 'Columns' ) }
							value={ columns }
							onChange={ ( value ) => setAttributes( { columns: value } ) }
							min={ 2 }
							max={ ! hasPosts ? MAX_POST_COLUMNS : Math.min( MAX_POST_COLUMNS, ListCourses.length ) }
							required
						/>
					}
				</PanelBody>
			</InspectorControls>
		);

		const hasPosts = Array.isArray( ListCourses ) && ListCourses.length;
		if ( ! hasPosts ) {
			return (
				<>
					{ inspectorControls }
					<Placeholder icon="admin-post" label={ __( 'List Courses' ) }>
						{ ! Array.isArray( ListCourses ) ?
							<Spinner /> :
							__( 'No courses found.' )
						}
					</Placeholder>
				</>
			);
		}

		const layoutControls = [
			{
				icon: 'list-view',
				title: __( 'List View' ),
				onClick: () => setAttributes( { postLayout: 'list' } ),
				isActive: postLayout === 'list',
			},
			{
				icon: 'grid-view',
				title: __( 'Grid View' ),
				onClick: () => setAttributes( { postLayout: 'grid' } ),
				isActive: postLayout === 'grid',
			},
		];

		return (
			<>
				{ inspectorControls }
				<BlockControls>
					<Toolbar controls={ layoutControls } />
				</BlockControls>
				<Disabled>
					<ServerSideRender block="hrscourses/list-courses" attributes={ attributes } />
				</Disabled>
			</>
		);
	}
}

export default withSelect( ( select, props ) => {
	const { coursesToShow, order, orderBy, learningPrograms } = props.attributes;
	const { getEntityRecords } = select( 'core' );

	const ListCoursesQuery = pickBy( {
		learningPrograms,
		order,
		orderby: orderBy,
		per_page: coursesToShow,
	}, ( value ) => ! isUndefined( value ) );

	return {
		ListCourses: getEntityRecords( 'postType', 'wsuwp_hrs_courses', ListCoursesQuery ),
	};
} )( ListCoursesEdit );
