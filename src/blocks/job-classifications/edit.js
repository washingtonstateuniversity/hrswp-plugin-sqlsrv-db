/**
 * External dependencies
 */
import { escape, unescape } from 'lodash';

/**
 * WordPress dependencies
 */
const {
	PanelBody,
	Placeholder,
	RangeControl,
	SelectControl,
	Spinner,
	TextControl,
	ToggleControl,
} = wp.components;
const { useSelect } = wp.data;
const { InspectorControls, useBlockProps } = wp.blockEditor;
const { __ } = wp.i18n;

export default function JobClassificationsEdit( {
	attributes: {
		displayAsList,
		columns,
		salaryDataUrl,
		queryTable,
	},
	setAttributes,
} ) {
	const { jobClassificationData, isRequesting, tables } = useSelect(
		( select ) => {
			const {
				getJobClassificationData,
				getTableNames,
				isResolving,
			} = select( 'hrswpsqlsrv/salary-data' );

			return {
				jobClassificationData: queryTable?.length
					? getJobClassificationData( queryTable )
					: {},
				isRequesting: isResolving( 'getJobClassificationData', [
					queryTable,
				] ),
				tables: getTableNames(),
			};
		},
		[ queryTable ]
	);

	const toggleAttribute = ( attributeName ) => ( newValue ) =>
		setAttributes( { [ attributeName ]: newValue } );
	const formatNumber = new Intl.NumberFormat( 'en-US', {
		style: 'currency',
		currency: 'USD',
	} );

	const getQueryTables = () => {
		if ( ! tables?.length ) {
			return [];
		}
		return tables?.reduce( ( accumulator, currentValue ) => {
			if (
				currentValue.value.includes( 'job-class' ) ||
				'' === currentValue.value
			) {
				accumulator.push( currentValue );
			}
			return accumulator;
		}, [] );
	};

	const renderJobClassificationName = ( name ) =>
		! name ? __( '(Untitled)' ) : unescape( name ).trim();
	const renderJobClassificationCurrency = ( number ) =>
		! Number.isNaN( Number( number ) )
			? formatNumber.format( number )
			: renderJobClassificationName( number );
	const renderJobClassificationRangeURL = ( rangeURLParam, range ) => {
		const url = escape( salaryDataUrl + '?filter=' + rangeURLParam );
		return (
			<a href={ url } target="_blank" rel="noreferrer noopener">
				{ renderJobClassificationName( range ) }
			</a>
		);
	};

	const renderJobClassificationTable = () => {
		return (
			<table className="wp-block-table">
				<thead>
					<tr>
						<th>{ __( 'Job Class' ) }</th>
						<th>{ __( 'Job Title' ) }</th>
						<th>{ __( 'Range' ) }</th>
						<th>{ __( 'Salary Min' ) }</th>
						<th>{ __( 'Salary Max' ) }</th>
					</tr>
				</thead>
				<tbody>
					{ jobClassificationData.map( ( jobClassification, key ) =>
						renderJobClassificationTableRow(
							jobClassification,
							key
						)
					) }
				</tbody>
			</table>
		);
	};

	const renderJobClassificationTableRow = ( jobClassification, key ) => {
		const {
			ClassCode: code,
			JobTitle: title,
			SalRangeNum: rangeURLParam,
			Salary_Max: max,
			Salary_Min: min,
			SalrangeWExceptions: range,
		} = jobClassification;

		return (
			<tr key={ key }>
				<td>{ renderJobClassificationName( code ) }</td>
				<td>{ renderJobClassificationName( title ) }</td>
				<td>
					{ renderJobClassificationRangeURL( rangeURLParam, range ) }
				</td>
				<td>{ renderJobClassificationCurrency( min ) }</td>
				<td>{ renderJobClassificationCurrency( max ) }</td>
			</tr>
		);
	};

	const renderJobClassificationList = () => {
		return (
			<ul className={ `has-columns has-columns-${ columns }` }>
				{ jobClassificationData.map( ( jobClassification, key ) =>
					renderJobClassificationListItem( jobClassification, key )
				) }
			</ul>
		);
	};

	const renderJobClassificationListItem = ( jobClassification, key ) => {
		const {
			ClassCode: code,
			JobTitle: title,
			SalRangeNum: rangeURLParam,
			Salary_Max: max,
			Salary_Min: min,
			SalrangeWExceptions: range,
		} = jobClassification;

		return (
			<li key={ key }>
				<strong>{ renderJobClassificationName( title ) }</strong>
				<span>{ ` (${ renderJobClassificationName( code ) })` }</span>
				<ul>
					<li>
						{ ` ${ __( 'Range' ) }: ` }
						{ renderJobClassificationRangeURL(
							rangeURLParam,
							range
						) }
					</li>
					<li>
						{ ` ${ __( 'Salary Min' ) }: ` }
						{ renderJobClassificationCurrency( min ) }
					</li>
					<li>
						{ ` ${ __( 'Salary Max' ) }: ` }
						{ renderJobClassificationCurrency( max ) }
					</li>
				</ul>
			</li>
		);
	};

	return (
		<div { ...useBlockProps() }>
			<InspectorControls>
				<PanelBody title={ __( 'Job Classifications settings' ) }>
					<ToggleControl
						label={ __( 'Display as list' ) }
						checked={ displayAsList }
						onChange={ toggleAttribute( 'displayAsList' ) }
					/>
					{ displayAsList && (
						<RangeControl
							label={ __( 'List Columns' ) }
							value={ columns || 3 }
							onChange={ toggleAttribute( 'columns' ) }
							min={ 1 }
							max={ 6 }
						/>
					) }
					<SelectControl
						className={ 'salary-data-table-picker__select' }
						label={ __( 'Select Job Data source' ) }
						value={ queryTable }
						options={ getQueryTables() }
						onChange={ toggleAttribute( 'queryTable' ) }
					/>
					<TextControl
						label={ __( 'Linked Salary Data URL' ) }
						help={ __(
							'The full URL to a page with a corresponding Salary Data block to link to. Leave blank to link to the current page.'
						) }
						value={ salaryDataUrl }
						onChange={ toggleAttribute( 'salaryDataUrl' ) }
					/>
				</PanelBody>
			</InspectorControls>
			{ ! queryTable && (
				<Placeholder
					icon="admin-post"
					label={ __( 'Job Classification Data' ) }
				>
					{ ! Array.isArray( tables ) ? (
						<Spinner />
					) : (
						__(
							'Select a job classification data group to display results.'
						)
					) }
				</Placeholder>
			) }
			{ queryTable && isRequesting && (
				<Placeholder
					icon="admin-post"
					label={ __( 'Job Classification Data' ) }
				>
					<Spinner />
				</Placeholder>
			) }
			{ ! isRequesting &&
				jobClassificationData?.length > 0 &&
				( displayAsList
					? renderJobClassificationList()
					: renderJobClassificationTable() ) }
		</div>
	);
}
