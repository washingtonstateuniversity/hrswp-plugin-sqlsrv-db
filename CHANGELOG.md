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

## 0.1.0 (2019-10-01)

### Changed

- :pencil2: Rename project handles, functions, labels, etc. with correct plugin name from generated files.

### Added

- :construction: MS SQL Query class to manage queries and pass them to the `MSSQL_DB` database abstraction class.
- :sparkles: Microsoft SQL Server database abstraction class to connect to, query, and manage connections with a MS SQL Server database.

### Removed

- :fire: Unneeded generated files from initial project template.
