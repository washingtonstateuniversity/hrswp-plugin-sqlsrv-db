/**
 * External dependencies
 */
import { unescape } from 'lodash';

/**
 * WordPress dependencies
 */
const { PanelBody, Placeholder, SelectControl, Spinner } = wp.components;
const { dispatch, useSelect } = wp.data;
const { InspectorControls, useBlockProps } = wp.blockEditor;
const { __ } = wp.i18n;

/**
 * Internal dependencies
 */
import { RenderNursesYearsExperienceRow } from './nurses-experience-row';

export default function SalaryDataEdit( {
	attributes: { queryTable },
	setAttributes,
} ) {
	const { salaryData, isRequesting, tables } = useSelect(
		( select ) => {
			const { getSalaryData, getTableNames, isResolving } = select(
				'hrswpsqlsrv/salary-data'
			);

			return {
				salaryData: queryTable?.length
					? getSalaryData( queryTable )
					: {},
				isRequesting: isResolving( 'getSalaryData', [ queryTable ] ),
				tables: getTableNames(),
			};
		},
		[ queryTable ]
	);

	const toggleAttribute = ( attributeName ) => ( newValue ) => {
		if ( 'queryTable' === attributeName ) {
			dispatch(
				'hrswpsqlsrv/salary-data'
			).invalidateResolutionForStoreSelector( 'getSalaryData' );
		}
		setAttributes( { [ attributeName ]: newValue } );
	};
	const getQueryTables = () => {
		if ( ! tables?.length ) {
			return [];
		}
		return tables?.reduce( ( accumulator, currentValue ) => {
			if (
				currentValue.value.includes( 'salary' ) ||
				'' === currentValue.value
			) {
				accumulator.push( currentValue );
			}
			return accumulator;
		}, [] );
	};
	const formatNumber = new Intl.NumberFormat( 'en-US', {
		style: 'currency',
		currency: 'USD',
		maximumFractionDigits: 0,
	} );

	const renderJobClassificationName = ( name ) =>
		! name ? __( '(Untitled)' ) : unescape( name ).trim();
	const renderJobClassificationCurrency = ( number ) =>
		! Number.isNaN( Number( number ) )
			? formatNumber.format( number )
			: renderJobClassificationName( number );

	const renderSalaryDataTable = () => {
		return (
			<figure className="wp-block-table">
				<table>
					<thead>
						<tr>
							{ Object.keys(
								salaryData[ 0 ]
							).map( ( salaryKey, index ) =>
								renderSalaryDataTableHeaderRow(
									salaryKey,
									index
								)
							) }
						</tr>
						{ queryTable.includes( 'nurses' ) &&
							RenderNursesYearsExperienceRow( queryTable ) }
					</thead>
					<tbody>
						{ salaryData.map( ( salary, index ) =>
							renderSalaryDataTableRow( salary, index )
						) }
					</tbody>
				</table>
			</figure>
		);
	};

	const renderSalaryDataTableHeaderRow = ( salaryKey, index ) => {
		const headValue =
			'RANGE' !== salaryKey
				? `Step ${ renderJobClassificationName( salaryKey ) }`
				: 'Range';
		return <th key={ index }>{ headValue }</th>;
	};

	const renderSalaryDataTableRow = ( salary, index ) => {
		return (
			<tr key={ index }>
				{ Object.entries( salary ).map( ( entry, i ) => {
					const [ key, value ] = entry;
					const cell =
						'RANGE' !== key
							? renderJobClassificationCurrency( value )
							: renderJobClassificationName( value );
					return <td key={ i }>{ cell }</td>;
				} ) }
			</tr>
		);
	};

	return (
		<div { ...useBlockProps() }>
			<InspectorControls>
				<PanelBody title={ __( 'Salary Data settings' ) }>
					<SelectControl
						className={ 'salary-data-table-picker__select' }
						label={ __( 'Select Job Data source' ) }
						value={ queryTable }
						options={ getQueryTables() }
						onChange={ toggleAttribute( 'queryTable' ) }
					/>
				</PanelBody>
			</InspectorControls>
			{ ! queryTable && (
				<Placeholder icon="admin-post" label={ __( 'Salary Data' ) }>
					{ ! Array.isArray( tables ) ? (
						<Spinner />
					) : (
						__( 'Select a salary data group to display results.' )
					) }
				</Placeholder>
			) }
			{ queryTable && isRequesting && (
				<Placeholder icon="admin-post" label={ __( 'Salary Data' ) }>
					<Spinner />
				</Placeholder>
			) }
			{ ! isRequesting &&
				salaryData?.length > 0 &&
				renderSalaryDataTable() }
		</div>
	);
}
