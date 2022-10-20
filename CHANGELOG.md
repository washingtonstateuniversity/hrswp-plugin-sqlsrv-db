# HRSWP Sqlsrv DB Changelog

Author: Adam Turner  
Author: Washington State University  
URI: https://github.com/washingtonstateuniversity/hrswp-plugin-sqlsrv-db

<!--
Changelog formatting (http://semver.org/):

## Major.MinorAddorDeprec.Bugfix YYYY-MM-DD

### Added (for new features.)
### Changed (for changes in existing functionality.)
### Deprecated (for soon-to-be removed features.)
### Removed (for now removed features.)
### Fixed (for any bug fixes.)
### Security (in case of vulnerabilities.)
-->

## 0.11.0 (2022-10-20)

### Changed

- Bump WP tested-to to 6.0.3.
- Bump PHP required version from 7.0 to 7.4. (2ed5a84)
- Update README to reflect removal of blocks, close #91. (2ed5a84)
- Switch from setup class to functions, close #92. (99a93a8)
- Move classes into dedicated directory. (99a93a8)
- Switch to phpcompatibility-wp and `"prefer-stable"` and update phpcs config.
- Switch to GitHub forms for handling issues. (16383d7)
- Remove unneeded checks from CS actions. (03e76d1)
- Add limit handling in to query. (81815a0)
- Update Composer dependencies.

### Removed

- Remove plugin status option, close #93. (4be0004)
- Separate employee data blocks from SQL Server tools, close #90 (06ad169)
- Remove job classifications block. (1db10b0)
- Remove salary data block. (e6e849c)
- Remove awards list block. (aa57885)
- Remove custom block category. (aa57885)
- Remove sideload image class. (aa57885)
- Remove the REST API store. (cf52646, 9aa4d19)
- Remove unneeded npm dev dependencies and build tools. (06ad169)

### Fixed

- Restore @wordpress/npm-package-json-lint-config.
- Fix missing `ORDER BY` statement when selecting all columns (`*`). (e104a13)
- Fix missing `WHERE` statement handling in query. (28295c2)

## 0.10.0 (2022-06-06)

### Added

- Add WP Rest API endpoint and store for salary data. (b1eb163)
- Add rest route for Job Classification data. (f3bb06b)

### Changed

- Bump WP tested-to to 6.0.0.
- Convert salary data block to API v2 and stop using `serverSideRender`. (b1eb163)
- Refactor Job Classifications block to use API v2 and replace `ServerSideRender`. (f3bb06b)
- Switch to using the HRS theme global style variables. (1f7db38)
- Add GitHub API to plugin header for updates. (510192d)
- Modify WebPack config to copy `block.json` files to the `build` directory for block registration. (f3bb06b)
- Bump nanoid from 3.1.30 to 3.2.0. (34fe424)

## 0.9.0 (2021-12-23)

### Changed

- Ignore the Prettier config file when creating zip file. (311e445)
- Allow non-integer values in job class data, close #78. (4d9f294, 0d979b1)
- Update browserlist datebase. (b0e46cd)
- Update eslint from 8.4.1 to 8.5.0. (3801695)
- Update postcss-preset-ent from 7.0.2 to 7.1.0. (7bd566a)
- Update roave/security-advisories from dev-master b9421ed to dev-master fff5363. (4575d13)

### Fixed

- Fix #77 allow string values in Salary Data block data. (5219566, 0d979b1)

### Security

- Bump cssnano from 5.0.13 to 5.0.14. (07f10ef)

## 0.8.0 (2021-12-17)

### Added

- Add new WordPress Stylelint config package. (b66fdc5)
- Add stylelint-a11y package. (b66fdc5)

### Changed

- Bump WP tested-to to 5.8.2.
- Update Styleling config for WordPress config changes. (b66fdc5)
- Add Babel parser options to eslint config. (3091898)
- Upgrade eslint from 7.29.0 to 8.4.1. (3091898)
- Upgrade postcss-cli from 8.3.1 to 9.1.0. (cb02dd1)
- Upgrade postcss-preset-env from 6.7.0 to 7.0.2. (cb02dd1)
- Upgrade resolve-bin from 0.4.0 to 1.0.0. (7f40af2)
- Upgrade copy-webpack-plugin from 9.0.1 to 10.2.0. (2d12b2e)
- Update @babel/core from 7.14.6 to 7.16.5. (53a8ea8)
- Update @babel/runtime from 7.14.6 to 7.16.5. (53a8ea8)
- Update @wordpress/babel-preset-default from 6.2.0 to 6.4.1. (53a8ea8)
- Update webpack from 5.41.1 to 5.65.0. (2d12b2e)
- Update webpack-cli from 4.7.2 to 4.9.1. (2d12b2e)
- Update webpack-bundle-analyzer from 4.4.2 to 4.5.0. (2d12b2e)
- Update @wordpress/dependency-extraction-webpack-plugin from 3.1.4 to 3.2.1. (2d12b2e)
- Update @wordpress/eslint-plugin from 9.0.6 to 9.3.0. (3091898)
- Update postcss from 8.3.5 to 8.4.5. (cb02dd1)
- Update cssnano from 5.0.6 to 5.0.13. (6e17989)
- Update npm-package-json-lint from 5.1.0 to 5.4.2. (cf6e450)
- Update @wordpress/npm-package-json-lint-config from 4.0.5 to 4.1.0. (cf6e450)
- Update @wordpress/prettier-config from 1.0.5 to 1.1.1. (17e1b58)
- Update roave/security-advisories from dev-master ce3f116 to dev-master b9421ed. (ed07506)

### Removed

- Remove stylelint-config-wordpress. (b66fdc5)

### Fixed

- Fix #74 replace block_categories with block_categories_all. (902e643)

### Security

- Bump sirbrillig/phpcs-variable-analysis from 2.11.1 to 2.11.2. (b4a08a6)
- Bump squizlabs/php_codesniffer from 3.6.0 to 3.6.2. (d11d03c)
- Bump babel-loader from 8.2.2 to 8.2.3. (53a8ea8)
- Bump ansi-regex from 5.0.0 to 5.0.1. (8aa18d0)
- Bump nth-check from 2.0.0 to 2.0.1. (30e7c30)
- Bump path-parse from 1.0.6 to 1.0.7. (1a5afa2)

## 0.7.1 (2021-07-02)

### Added

- Add contributing guide.

### Changed

- Match editor styles to frontend styles. (54cbeb6, 593ba02)
- Remove `disabled` because the component is redundant with server side render component. (54cbeb6)
- Match inspector options sections order across blocks. (ca36faf)
- Simplify Composer coding standards scripts. (5dd708a)
- Enable PostCSS nesting rules. (745d96b)
- Update Copy Webpack Plugin syntax for version 8 changes. (1003ea2)
- Update GitHub issue and pull request templates with more help text. (6a4c549)
- Replace Travis CI with GitHub Actions for coding standards tests. (37cb066)
- Update squizlabs/php_codesniffer from 3.5.8 to 3.6.0 and sirbrillig/phpcs-variable-analysis from 2.10.0 to 2.11.1. (5dd708a)
- Update webpack from 5.11.1 to 5.41.1. (1003ea2, a201cd5)
- Update webpack-bundle-analyzer from 4.3.0 to 4.4.2. (1003ea2)
- Update webpack-cli from 4.3.1 to 4.7.2. (1003ea2)
- Update classnames from 2.2.6 to 2.3.1. (ed5f4bf)
- Update @babel/core from 7.12.10 to 7.14.6 and @babel/runtime from 7.12.5 to 7.14.6. (8c256e0)
- Update postcss from 8.2.2 to 8.3.5. (745d96b)
- Update eslint from 7.17.0 to 7.29.0 and stylelint from 13.8.0 to 13.13.1. (ebc7de0)
- Upgrade @wordpress/babel-preset-default from 4.20.0 to 6.2.0. (8c256e0)
- Upgrade copy-webpack-plugin from 7.0.0 to 9.0.1. (1003ea2, a201cd5)
- Upgrade @wordpress/dependency-extraction-webpack-plugin from 2.9.0 to 3.1.4. (1003ea2)
- Upgrade source-map-loader from 2.0.0 to 3.0.0. (1003ea2)
- Upgrade cssnano from 4.1.10 to 5.0.6. (745d96b)
- Upgrade @wordpress/eslint-plugin from 7.4.0 to 9.0.6. (ebc7de0)
- Upgrade @wordpress/npm-package-json-lint-config from 3.1.0 to 4.0.5. (ebc7de0)
- Upgrade @wordpress/prettier-config from 0.4.0 to 1.0.5. (ebc7de0)

### Fixed

- Fix #4 filter data tables options per block. (2353e4d)
- Fix #69 exit early on empty table value. (9175916)
- Correct unresolved import error to `wp.components`. (177943e)
- Update lingering references to GPL license 2.0 to 3.0. (6a4c549, 5dd708a)

### Security

- Bump glob-parent from 5.1.0 to 5.1.2. (5318127)
- Bump browserslist from 4.7.0 to 4.16.6. (fcba9af)
- Bump hosted-git-info from 2.8.4 to 2.8.9. (e1f542f)
- Bump postcss-import from 14.0.0 to 14.0.2. (745d96b)
- Bump lodash from 4.17.20 to 4.17.21. (ed5f4bf)
- Bump thread-loader from 3.0.1 to 3.0.4. (1003ea2)
- Bump ws from 7.4.1 to 7.5.0. (2d438df)
- Bump trim-newlines from 3.0.0 to 3.0.1. (c3e6b70)

## 0.7.0 (2021-01-05)

### Enhancements

- Update README with some badges and links for project management and build status. (73202c0)

### Code Quality

- Fix Prettier and ESLint issues. (618e407)

### Build Tools

- Minor ESLint update to newest version. (8a3f889)
- Update PostCSS to newest version. (5993f1b)
- Update WP babel preset dependency. (3e73f71)
- Update ESLint and WordPress ESLint Plugin to most current versions. (4eb5312)
- Fix #24 Add os definition to Travis config. (b95fc5b)
- Upgrade Webpack to version 5 along with associated plugins, and update Copy Webpack Plugin script for new version. (b95fc5b and d9a935b)
- Modify the Travis CI config file to use jobs and simplify installation, close #23. (f12f635)
- Add Babel Core and Babel Runtime npm dependencies. (e420dc5)

### Project Management

- Replace GPL version 2 license with version 3. (fedd08c and 18bb600)

## 0.6.2 (2020-12-17)

### Fixed

- Remove now-unused Group column from the job classifications block output. (7f07e77)
- Upgrade `dealerdirect/phpcodesniffer-composer-installer` to support Composer 2. (fffd835)

### Changed

- Increment WP tested-to to 5.6.0.

## 0.6.1 (2020-06-10)

### Changed

- Rename "master" branch to "stable." See the Internet Engineering Task Force (IEFT), [Terminology, Power and Oppressive Language](https://tools.ietf.org/id/draft-knodel-terminology-00.html#rfc.section.1.1.1).

## 0.6.0 (2020-02-04)

### Fixed

- :memo: Close #21, `hrswp-sqlsrv-config.php` must be in the web server group in order to be readable by WordPress.
- :alien: Fix #18, replace deprecated wp.components.ServerSideRender with wp.serverSideRender.
- :bug: Fix #12, remove overflow property on block parent to un-hide editor UI handles.
- Fix #13, add default columns number value to salary and job blocks.
- :art: Fix #17, Job Classifications block list style display broken without inner div.

### Changed

- :memo: Provide more description of the plugin and its data handling.
- Close #14, make Job Classifications block salary range links editable to facilitate linking to pages with corresponding Salary Grid block.
- :arrow_up: @wordpress/babel-preset-default => 4.10.0
- :arrow_up: @wordpress/dependency-extraction-webpack-plugin => 2.2.0
- :arrow_up: @wordpress/eslint-plugin => 3.4.1
- :arrow_up: @wordpress/jest-preset-default => 5.4.0
- :arrow_up: @wordpress/npm-package-json-lint-config => 2.2.0
- :arrow_up: npm-package-json-lint => 4.6.0
- :arrow_up: rimraf => 3.0.1
- :arrow_up: dealerdirect/phpcodesniffer-composer-installer => 0.6.2
- :arrow_up: squizlabs/php_codesniffer => 3.5.4
- :arrow_up: wp-coding-standards/wpcs => 2.2.1

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
