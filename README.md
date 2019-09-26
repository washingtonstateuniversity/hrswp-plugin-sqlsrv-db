# HRSWP Sqlsrv DB

[![Build Status](https://travis-ci.org/washingtonstateuniversity/hrswp-plugin-sqlsrv-db.svg?branch=master)](https://travis-ci.org/washingtonstateuniversity/hrswp-plugin-sqlsrv-db)

## Overview

A WSU HRS WordPress plugin to connect to and query external Microsoft SQL Server databases.

## Description


## Installation

This plugin is not in the WordPress plugins directory. You have to install it manually either with SFTP or from the WordPress plugins screen:

1. [Download the latest version from GitHub](https://github.com/washingtonstateuniversity/hrswp-plugin-sqlsrv-db/archive/master.zip) and rename the .zip file to: `hrswp-plugin-sqlsrv-db.zip`.
2. From here you can either extract the files into your plugins directory via SFTP or navigate to the Plugins screen in the admin area of your site to upload it through the plugin uploader (steps 3-5).
3. Select Plugins > Add New and then select the "Upload Plugin" button.
4. Select "Browse" and locate the downloaded .zip file for the plugin (it **must** be a file in .zip format) on your computer. Select "Install Now."
5. You should receive a message that the plugin installed correctly. Select "Activate Plugin" or return to the plugins page to activate later.

### Updates

Please note that this plugin will not update automatically and will not notify of new available updates. It is your responsibility to make sure you stay up to date with the latest version.

### Deactivating and Deleting: Plugin Data


## For Developers

The HRSWP Sqlsrv DB plugin development environment relies primarily on NPM and Composer. The `package.json` and `composer.json` configuration files manage necessary dependencies for testing and building the production version of the theme. The NPM scripts in `package.json` do most of the heavy lifting.

### Initial Setup

1. Clone the HRSWP Sqlsrv DB plugin to a directory on your computer.
2. Change into that directory.
3. Install the NPM and Composer dependencies.
4. Ensure linting and coding standards checks are working -- this should exit with zero (0) errors.
5. Create a new branch for local development.

In a terminal:

~~~bash
git clone https://github.com/washingtonstateuniversity/hrswp-plugin-sqlsrv-db.git hrswp-plugin-sqlsrv-db
cd hrswp-plugin-sqlsrv-db
npm install; composer install
npm test -s
git checkout -b new-branch-name
~~~

### Build Commands

The following commands will handle basic build functions. (Remove the `-s` flag to show additional debug info.)

- `npm run build -s`: Remove old compiled files such as minified CSS, lint PHP and CSS, and then compile new versions.
- `npm test -s`: Check all PHP and CSS files for coding standards compliance.
- `npm run clean -s`: Remove old compiled files such as minified CSS.
- `npm run build:styles -s`: Compile CSS.

See the scripts section of `package.json` for additional available commands.

## HRSWP Sqlsrv DB Issues

Please submit bugs, fixes, and feature requests through [GitHub Issues](https://github.com/washingtonstateuniversity/hrswp-plugin-sqlsrv-db/issues). Please read (and adhere to) the guidelines for contributions detailed in the issue templates.

Read the [CHANGELOG.md](https://github.com/washingtonstateuniversity/hrswp-plugin-sqlsrv-db/blob/master/CHANGELOG.md) to review release and update notes.
