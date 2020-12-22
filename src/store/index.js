/**
 * WordPress dependencies
 */
const apiFetch = wp.apiFetch;
const { registerStore } = wp.data;

const DEFAULT_STATE = {
	tableNames: {},
};

const actions = {
	getTableNames( tableNames ) {
		return {
			type: 'GET_TABLE_NAMES',
			tableNames,
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
			}

			return state;
		},

		actions,

		selectors: {
			getTableNames( state ) {
				const { tableNames } = state;

				return tableNames;
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
		},
	} );
}
