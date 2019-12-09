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
		this.state = { searchableKeys: [] };
	}

	componentDidUpdate() {
		const { attributes, clientId } = this.props;
		const { isSearchable } = attributes;

		if ( isSearchable ) {
			const blockNode = document.querySelector( '[data-block="' + clientId + '"]' );

			if ( blockNode ) {
				const headNodes = blockNode.getElementsByTagName( 'th' );
				const headArray = [ { value: null, label: 'Select a column', disabled: true } ];

				for ( const [ key, node ] of Object.entries( headNodes ) ) {
					headArray.push( {
						value: key,
						label: node.innerText,
					} );
				}

				if ( JSON.stringify( this.state.searchableKeys ) !== JSON.stringify( headArray ) ) {
					this.setState( { searchableKeys: headArray } );
				}
			}
		}
	}

	render() {
		const { searchableKeys } = this.state;
		const {
			attributes,
			setAttributes,
			tables,
		} = this.props;
		const {
			className,
			columns,
			isSearchable,
			isStriped,
			searchKey,
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
						<ToggleControl
							label={ __( 'Allow searching table by column' ) }
							checked={ isSearchable }
							onChange={ ( value ) => setAttributes( { isSearchable: value } ) }
						/>
						{ isSearchable &&
							<SelectControl
								className={ 'salary-data-search-column-picker__select' }
								label={ __( 'Select column to allow searching in:' ) }
								value={ searchKey }
								options={ searchableKeys }
								onChange={ ( value ) => setAttributes( { searchKey: value } ) }
							/>
						}
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
