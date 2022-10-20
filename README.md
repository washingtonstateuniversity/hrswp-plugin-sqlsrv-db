# HRSWP Sqlsrv DB

[![Support Level](https://img.shields.io/badge/support-active-green.svg)](#support-level) [![Build Status](https://github.com/washingtonstateuniversity/hrswp-plugin-sqlsrv-db/actions/workflows/coding-standards.yml/badge.svg)](https://github.com/washingtonstateuniversity/hrswp-plugin-sqlsrv-db/actions) [![Release Version](https://img.shields.io/github/v/release/washingtonstateuniversity/hrswp-plugin-sqlsrv-db)](https://github.com/washingtonstateuniversity/hrswp-plugin-sqlsrv-db/releases/latest) ![WordPress tested up to version 6.0.3](https://img.shields.io/badge/WordPress-v6.0.3%20tested-success.svg) [![code style: prettier](https://img.shields.io/badge/code_style-prettier-ff69b4.svg)](https://github.com/prettier/prettier) [![GPLv3 License](https://img.shields.io/github/license/washingtonstateuniversity/hrswp-plugin-sqlsrv-db)](https://github.com/washingtonstateuniversity/hrswp-plugin-sqlsrv-db/blob/develop/LICENSE.md)

## Overview

A WSU HRS WordPress plugin to connect to and query external Microsoft SQL Server databases.

## Description

This plugin enables reading from Microsoft SQL Server databases. It stores database credentials and table information in a restricted config file similar to `wp-config`.

## Installation

This plugin is not in the WordPress plugins directory. You have to install it manually either with SFTP or from the WordPress plugins screen:

1. [Download the latest version from GitHub](https://github.com/washingtonstateuniversity/hrswp-plugin-sqlsrv-db/archive/stable.zip) and rename the .zip file to: `hrswp-plugin-sqlsrv-db.zip`.
2. From here you can either extract the files into your plugins directory via SFTP or navigate to the Plugins screen in the admin area of your site to upload it through the plugin uploader (steps 3-5).
3. Select Plugins > Add New and then select the "Upload Plugin" button.
4. Select "Browse" and locate the downloaded .zip file for the plugin (it **must** be a file in `.zip` format) on your computer. Select "Install Now."
5. You should receive a message that the plugin installed correctly. Select "Activate Plugin" or return to the plugins page to activate later.

### Updates

Please note that this plugin will not update automatically and will not notify of available updates. It is your responsibility to make sure you stay up to date with the latest version. It does include a GitHub repository URL in the Update URI field, so if you have a plugin that can update from GitHub then this plugin should be compatible with that.

## For Developers

The HRSWP Sqlsrv DB plugin development environment relies primarily on NPM and Composer. The `package.json` and `composer.json` configuration files manage necessary dependencies for testing. The NPM scripts in `package.json` do most of the heavy lifting.

### Initial Setup

1. Clone the HRSWP Sqlsrv DB plugin to a directory on your computer.
2. Change into that directory.
3. Install the NPM and Composer dependencies.
4. Ensure linting and coding standards checks are working -- this should exit with zero (0) errors.
5. Create a new branch for local development.

In a terminal:

~~~bash
git clone https://github.com/washingtonstateuniversity/hrswp-plugin-sqlsrv-db.git
cd hrswp-plugin-sqlsrv-db
npm install
composer install
npm lint
git checkout -b new-branch-name
~~~

## Support Level

**Active:** WSU HRS actively works on this plugin. We plant to continue work for the foreseeable future, adding new features, enhancing existing ones, and maintaining compatability with the latest version of WordPress. Bug reports, feature requests, questions, and pull requests are welcome.

## Changelog

All notable changes are documented in the [CHANGELOG.md](https://github.com/washingtonstateuniversity/hrswp-plugin-sqlsrv-db/blob/develop/CHANGELOG.md), with dates and version numbers.

## Contributing

Please submit bugs and feature requests through [GitHub Issues](https://github.com/washingtonstateuniversity/hrswp-plugin-sqlsrv-db/issues). Refer to [CONTRIBUTING.md](https://github.com/washingtonstateuniversity/hrswp-plugin-sqlsrv-db/blob/develop/CONTRIBUTING.md) for the development workflow and details for submitting pull requests.
