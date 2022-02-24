/**
 * WordPress dependencies
 */
const apiFetch = wp.apiFetch;
const { registerStore } = wp.data;

const DEFAULT_STATE = {
	tableNames: {},
	jobClassificationData: {},
	salaryData: {},
};

const actions = {
	getTableNames( tableNames ) {
		return {
			type: 'GET_TABLE_NAMES',
			tableNames,
		};
	},
	getJobClassificationData( jobClassificationData ) {
		return {
			type: 'GET_JOB_CLASSIFICATION_DATA',
			jobClassificationData,
		};
	},
	getSalaryData( salaryData ) {
		return {
			type: 'GET_SALARY_DATA',
			salaryData,
		};
	},
	fetchFromAPI( path ) {
		return {
			type: 'FETCH_FROM_API',
			path,
		};
	},
};

export default function registerStores() {
	registerStore( 'hrswpsqlsrv/salary-data', {
		reducer( state = DEFAULT_STATE, action ) {
			switch ( action.type ) {
				case 'GET_TABLE_NAMES':
					return {
						...state,
						tableNames: action.tableNames,
					};
				case 'GET_JOB_CLASSIFICATION_DATA':
					return {
						...state,
						jobClassificationData: action.jobClassificationData,
					};
				case 'GET_SALARY_DATA':
					return {
						...state,
						salaryData: action.salaryData,
					};
			}

			return state;
		},

		actions,

		selectors: {
			getTableNames( state ) {
				const { tableNames } = state;
				return tableNames;
			},
			getJobClassificationData( state ) {
				const { jobClassificationData } = state;
				return jobClassificationData;
			},
			getSalaryData( state ) {
				const { salaryData } = state;
				return salaryData;
			},
		},

		controls: {
			FETCH_FROM_API( action ) {
				return apiFetch( { path: action.path } );
			},
		},

		resolvers: {
			*getTableNames() {
				const path = '/hrswp-sqlsrv-db/v1/tables/';
				const tableNames = yield actions.fetchFromAPI( path );
				return actions.getTableNames( tableNames );
			},
			*getJobClassificationData( table ) {
				const path = `/hrswp-sqlsrv-db/v1/jobclassification/table/${ table }`;
				const jobClassificationData = yield actions.fetchFromAPI(
					path
				);
				return actions.getJobClassificationData(
					jobClassificationData
				);
			},
			*getSalaryData( table ) {
				const path = `/hrswp-sqlsrv-db/v1/salarydata/table/${ table }`;
				const salaryData = yield actions.fetchFromAPI(
					path
				);
				return actions.getSalaryData( salaryData );
			},
		},
	} );
}
