/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { select, withSelect } = wp.data;
const { Component } = wp.element;
const { InspectorControls } = wp.blockEditor;
const {
	Disabled,
	PanelBody,
	PanelRow,
	Placeholder,
	SelectControl,
	ServerSideRender,
	Spinner,
} = wp.components;

class SalaryGrid extends Component {
	constructor() {
		super( ...arguments );
	}

	render() {
		const { attributes, setAttributes, tables } = this.props;
		const { queryTable } = attributes;

		const inspectorControls = (
			<InspectorControls>
				<PanelBody title={ __( 'Select Salary Grid' ) }>
					<PanelRow>
						<SelectControl
							className={ 'salary-grid-table-picker__select' }
							label={ __( 'Select desired group to display grid:' ) }
							value={ queryTable }
							options={ tables }
							onChange={ ( value ) => setAttributes( { queryTable: value } ) }
						/>
					</PanelRow>
				</PanelBody>
			</InspectorControls>
		);

		if ( ! queryTable ) {
			return (
				<>
					{ inspectorControls }
					<Placeholder icon="admin-post" label={ __( 'Salary Grid' ) }>
						{ ! Array.isArray( tables ) ?
							<Spinner /> :
							__( 'Select a Salary Grid group to display data.' )
						}
					</Placeholder>
				</>
			);
		}

		return (
			<>
				{ inspectorControls }
				<Disabled>
					<ServerSideRender block="hrswpsqlsrv/salary-grid" attributes={ attributes } />
				</Disabled>
			</>
		);
	}
}

export default withSelect( ( select, props ) => {
	return {
		tables: select( 'hrswpsqlsrv/salary-grid' ).getTableNames(),
	};
} )( SalaryGrid );
