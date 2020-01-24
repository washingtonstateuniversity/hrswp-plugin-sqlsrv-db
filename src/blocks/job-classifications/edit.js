/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { withSelect } = wp.data;
const { Component } = wp.element;
const { InspectorControls } = wp.blockEditor;
const {
	Disabled,
	PanelBody,
	Placeholder,
	RangeControl,
	SelectControl,
	ServerSideRender,
	Spinner,
	ToggleControl,
} = wp.components;

class JobClassifications extends Component {
	constructor() {
		super( ...arguments );
	}

	render() {
		const {
			attributes,
			setAttributes,
			tables,
		} = this.props;
		const {
			className,
			columns,
			isStriped,
			queryTable,
		} = attributes;

		const inspectorControls = (
			<InspectorControls>
				{ 'is-style-list' !== className &&
					<PanelBody title={ __( 'Table Settings' ) }>
						<ToggleControl
							label={ __( 'Striped table rows' ) }
							checked={ isStriped }
							onChange={ ( value ) => setAttributes( { isStriped: value } ) }
						/>
					</PanelBody>
				}
				{ 'is-style-list' === className &&
					<PanelBody title={ __( 'List Settings' ) }>
						<RangeControl
							label={ __( 'List Columns' ) }
							value={ columns || 3 }
							onChange={ ( value ) => setAttributes( { columns: value } ) }
							min={ 1 }
							max={ 6 }
						/>
					</PanelBody>
				}
				<PanelBody title={ __( 'Select Job Data Source' ) }>
					<SelectControl
						className={ 'salary-data-table-picker__select' }
						label={ __( 'Select desired group:' ) }
						value={ queryTable }
						options={ tables }
						onChange={ ( value ) => setAttributes( { queryTable: value } ) }
					/>
				</PanelBody>
			</InspectorControls>
		);

		if ( ! queryTable ) {
			return (
				<>
					{ inspectorControls }
					<Placeholder icon="admin-post" label={ __( 'Job Classification Data' ) }>
						{ ! Array.isArray( tables ) ?
							<Spinner /> :
							__( 'Select a job classification data group to display results.' )
						}
					</Placeholder>
				</>
			);
		}

		return (
			<>
				{ inspectorControls }
				<Disabled>
					<ServerSideRender block="hrswpsqlsrv/job-classifications" attributes={ attributes } />
				</Disabled>
			</>
		);
	}
}

export default withSelect( ( select ) => {
	return {
		tables: select( 'hrswpsqlsrv/salary-data' ).getTableNames(),
	};
} )( JobClassifications );
