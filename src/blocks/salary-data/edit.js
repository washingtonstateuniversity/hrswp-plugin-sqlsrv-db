/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { withSelect } = wp.data;
const { InspectorControls } = wp.blockEditor;
const ServerSideRender = wp.serverSideRender;
const {
	Disabled,
	PanelBody,
	Placeholder,
	RangeControl,
	SelectControl,
	Spinner,
	ToggleControl,
} = wp.components;

function SalaryData( {
	attributes,
	setAttributes,
	tables,
} ) {
	const {
		className,
		columns,
		isStriped,
		queryTable,
	} = attributes;

	const inspectorControls = (
		<InspectorControls>
			<PanelBody title={ __( 'Select Data Source' ) }>
				<SelectControl
					className={ 'salary-data-table-picker__select' }
					label={ __( 'Select desired group:' ) }
					value={ queryTable }
					options={ tables }
					onChange={ ( value ) => setAttributes( { queryTable: value } ) }
				/>
			</PanelBody>
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
		</InspectorControls>
	);

	if ( ! queryTable ) {
		return (
			<>
				{ inspectorControls }
				<Placeholder icon="admin-post" label={ __( 'Salary Data' ) }>
					{ ! Array.isArray( tables ) ?
						<Spinner /> :
						__( 'Select a salary data group to display results.' )
					}
				</Placeholder>
			</>
		);
	}

	return (
		<>
			{ inspectorControls }
			<Disabled>
				<ServerSideRender block="hrswpsqlsrv/salary-data" attributes={ attributes } />
			</Disabled>
		</>
	);
}

export default withSelect( ( select ) => {
	return {
		tables: select( 'hrswpsqlsrv/salary-data' ).getTableNames(),
	};
} )( SalaryData );
