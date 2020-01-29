# HRSWP Sqlsrv DB Changelog

Author: Adam Turner  
Author: Washington State University  
URI: https://github.com/washingtonstateuniversity/hrswp-plugin-sqlsrv-db

<!--
Changelog formatting (http://semver.org/):

## Major.MinorAddorDeprec.Bugfix YYYY-MM-DD

### To Do (for upcoming changes)
### Security (in case of fixed vulnerabilities)
### Fixed (for any bug fixes)
### Changed (for changes in existing functionality)
### Added (for new features)
### Deprecated (for once-stable features removed in upcoming releases)
### Removed (for deprecated features removed in this release)
-->

## 0.6.0-beta.1 (:construction: 2020-01-29)

### Fixed

- :alien: Fix #18, replace deprecated wp.components.ServerSideRender with wp.serverSideRender.
- :bug: Fix #12, remove overflow property on block parent to un-hide editor UI handles.
- Fix #13, add default columns number value to salary and job blocks.
- :art: Fix #17, Job Classifications block list style display broken without inner div.

### Changed

- Close #14, make Job Classifications block salary range links editable to facilitate linking to pages with corresponding Salary Grid block.
- :arrow_up: rimraf => 3.0.1

## 0.5.0 (2020-01-27)

### Fixed

- :bug: Fix #15, bad anonymous function assignment in API stores.
- Mistyped selector in salary data frontend stylesheet.

### Changed

- Simplify Salary Data and Job Classification blocks edit scripts now that they don't need to use Components.
- :zap: Load frontend plugin styles and scripts conditionally based on whether the block is active on the page.
- :arrow_up: dealerdirect/phpcodesniffer-composer-installer => 0.6.1
- :arrow_up: phpcompatibility/php-compatibility => 9.3.5
- :arrow_up: roave/security-advisories => latest
- :arrow_up: @wordpress/babel-preset-default => 4.9.0
- :arrow_up: @wordpress/jest-preset-default  => 5.3.1
- :arrow_up: eslint => 6.8.0
- :arrow_up: jest => 25.1.0
- :arrow_up: postcss-cli => 7.1.0
- :arrow_up: puppeteer => 2.1.0
- :arrow_up: stylelint => 13.0.0
- :arrow_up: stylelint-config-wordpress => 15.0.0
- :arrow_up: webpack => 4.41.5

### Removed

- Remove the search filter functionality into a separate plugin. Delete all logic and block components related to search. Close #8

## 0.4.0 (2019-12-19)

### Fixed

- :bug: Fix #9 Add missing "years of experience" row to the nurses salary data tables.
- :alien: Rename MS SQL connector class from `mssql` to `sqlsrv` to resolve confusion with 'mssql' PHP extension removed in PHP 7.0.
- :warning: Fix php lint function inspection warning.
- :warning: Fix php lint unused variable warnings.
- :warning: Fix php lint docblock and line spacing warnings.
- :warning: Fix php lint textdomain warnings.
- Set a default column number for the Salary Data block.

### Changed

- Increment "tested up to" to WordPress 5.3.1.
- :wrench: Update php sniffing rules.
- Replace block icons and use local SVG includes for missing dashicon hooks.
- :arrow_up: @wordpress/babel-preset-default 4.7.0 -> 4.8.0
- :arrow_up: @wordpress/eslint-plugin 3.2.0 -> 3.3.0
- :arrow_up: @wordpress/jest-preset-default 5.2.0 -> 5.3.0
- :arrow_up: jest-puppeteer 4.3.0 -> 4.4.0
- :arrow_up: copy-webpack-plugin 5.0.5 -> 5.1.1
- :arrow_up: npm-package-json-lint 4.4.0 -> 4.5.0
- :arrow_up: webpack 4.41.2 -> 4.41.4

### Added

- :art: Style awards list block grid and list layouts.
- :sparkles: Class to handle sideloading images into the WP uploads directory and media library from binary data.
- :sparkles: Block to handle displaying awards in grid or list format.
- :sparkles: Block to handle displaying job classification data for different groups in either table or list format.
- :heavy_plus_sign: squizlabs/php_codesniffer Composer dev dependency.
- :heavy_plus_sign: sirbrillig/phpcs-variable-analysis Composer dev dependency to sniff unused variables.
- :heavy_plus_sign: roave/security-advisories Composer dev dependency to monitor Composer dependency security.

### Removed

- Remove unit tests until they are working correctly.

## 0.3.1 (2019-12-06)

### Changed

- :arrow_up: puppeteer 1.20.0 -> 2.0.0
- :arrow_up: stylelint 11.1.1 -> 12.0.0
- :arrow_up: stylelint-config-wordpress 12.0.0 -> 15.0.0

## 0.3.0 (2019-12-06)

### Fixed

- :bug: Fix #2 Allow multiple salary data blocks on a single page. Fix issue where table data didn't load for subsequent blocks.

### Changed

- Use built-in Dashicon for block icon instead of custom SVG.
- Add style options to salary data table layout option to match default table styles.
- Add salary data block option to make table searchable.
- Create a default option for the tables list data object to help clarify its use to users.
- :memo: Expand API documentation.
- Increment WP tested version to 5.3.
- :arrow_up: @wordpress/babel-preset-default 4.6.0 -> 4.7.0
- :arrow_up: @wordpress/dependency-extraction-webpack-plugin 2.0.0 -> 2.1.0
- :arrow_up: @wordpress/eslint-plugin 3.1.0 -> 3.2.0
- :arrow_up: @wordpress/jest-preset-default 5.1.0 -> 5.2.0
- :arrow_up: copy-webpack-plugin 5.0.4 -> 5.0.5
- :arrow_up: eslint 6.4.0 -> 6.7.2
- :arrow_up: npm-package-json-lint 3.7.0 -> 4.4.0
- :arrow_up: stylelint 11.0.0 -> 11.1.1
- :arrow_up: webpack 4.40.2 -> 4.41.2
- :arrow_up: webpack-bundle-analyzer 3.5.1 -> 3.6.0
- :arrow_up: webpack-cli 3.3.0 -> 3.3.10
- :arrow_up: wp-coding-standards/wpcs 2.1.1 -> 2.2.0

### Added

- :art: Frontend styling with editor styling to match.
- Custom WP blocks category for plugin blocks.
- A plugin data store for the block editor to allow sharing table groups with the salary data block using the plugin API route.
- Database class method to retrieve a list of table labels.
- :sparkles: A plugin API class to set up a custom route with an endpoint for accessing the table labels list from inside the block editor.
- :sparkles: Block to handle displaying salary data for different groups in either table or list format.

## 0.2.0 (2019-10-09)

### Changed

- Don't require a database connection for escaping a MS SQL string since we're not using the SQLSRV method to do so.
- :recycle: Refactor the HRSWP Sqlsrv DB connector class (`MSSQL_DB`) to use its own dedicated database config file and store database connection details as a class property array instead of as globals and to only prepare those connections on initialization instead of immediately connecting to a given database. The connect method will now use the class `datasets` property array.

### Added

- :sparkles: Add methods to MS SQL Query class to parse query variables into a database request and to get records from a database.
- Method to retrieve a database name given a table has been assigned.
- Method to retrieve a database table name given its label.
- Method to save database table details, including name and associated database, as a class property.
- Method to save database connection details in the plugin config file as a class property array.
- Method to check for the database connections config file and display an admin notice (and a frontend error if debugging is enabled) if it's missing.
- :lock: A sample configuration file to store database connection details. This file should be treated like the 'wp-config' file: placed in the same directory (either root or one level above) and given restricted permissions (400 or 440).

### Removed

- HRSWP Sqlsrv DB connector class (`MSSQL_DB`) properties for individual databases in favor of a `datasets` array.

## 0.1.0 (2019-10-01)

### Changed

- :pencil2: Rename project handles, functions, labels, etc. with correct plugin name from generated files.

### Added

- :construction: MS SQL Query class to manage queries and pass them to the `MSSQL_DB` database abstraction class.
- :sparkles: Microsoft SQL Server database abstraction class to connect to, query, and manage connections with a MS SQL Server database.

### Removed

- :fire: Unneeded generated files from initial project template.
