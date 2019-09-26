module.exports = {
	plugins: [
		require( 'postcss-import' )( {
			path: 'src/_css/',
		} ),
		require( 'postcss-preset-env' ),
		require( 'cssnano' )( {
			preset: 'default',
		} ),
	],
};
