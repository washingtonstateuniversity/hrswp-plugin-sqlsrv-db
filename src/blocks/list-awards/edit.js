/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { withSelect } = wp.data;
const { Component } = wp.element;
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

class ListAwards extends Component {
	render() {
		const {
			attributes,
			setAttributes,
			tables,
		} = this.props;
		const {
			className,
			columns,
			imageCrop,
			queryTable,
		} = attributes;

		const inspectorControls = (
			<InspectorControls>
				{ 'is-style-list' !== className &&
					<PanelBody title={ __( 'Grid Settings' ) }>
						<RangeControl
							label={ __( 'List Columns' ) }
							value={ columns || 3 }
							onChange={ ( value ) => setAttributes( { columns: value } ) }
							min={ 1 }
							max={ 6 }
						/>
					</PanelBody>
				}
				<PanelBody title={ __( 'Awards List Settings' ) }>
					<ToggleControl
						label={ __( 'Crop Images' ) }
						checked={ imageCrop }
						onChange={ ( value ) => setAttributes( { imageCrop: value } ) }
					/>
				</PanelBody>
				<PanelBody title={ __( 'Select Awards Data Source' ) }>
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
					<Placeholder icon="admin-post" label={ __( 'Awards Data' ) }>
						{ ! Array.isArray( tables ) ?
							<Spinner /> :
							__( 'Select an awards data group to display results.' )
						}
					</Placeholder>
				</>
			);
		}

		return (
			<>
				{ inspectorControls }
				<Disabled>
					<ServerSideRender block="hrswpsqlsrv/list-awards" attributes={ attributes } />
				</Disabled>
			</>
		);
	}
}

export default withSelect( ( select ) => {
	return {
		tables: select( 'hrswpsqlsrv/salary-data' ).getTableNames(),
	};
} )( ListAwards );
