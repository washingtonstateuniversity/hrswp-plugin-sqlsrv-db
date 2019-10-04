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

## 0.2.0-alpha.1 (:construction: 2019-10-04)

### Changed

- :recycle: Refactor the HRSWP Sqlsrv DB connector class (`MSSQL_DB`) to use its own dedicated database config file and store database connection details as a class property array instead of as globals and to only prepare those connections on initialization instead of immediately connecting to a given database. The connect method will now use the class `datasets` property array.

### Added

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
