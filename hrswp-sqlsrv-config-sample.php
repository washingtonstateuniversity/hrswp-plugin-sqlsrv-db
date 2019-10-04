<?php
/**
 * The base configuration for the HRSWP Sqlsrv DB plugin.
 *
 * This file should be installed alongside the 'wp-config.php' file (either at
 * root or one level above) and should share its restricted access (400 or
 * 440 permission).
 *
 * This file contains the following configurations:
 *
 * - SQL Server settings
 *
 * @package HRSWP_Sqlsrv_DB
 */

/*
 * *** SAMPLE FILE ***
 *
 * To use:
 *
 *   1. Update this file with the desired server settings
 *   2. Rename to 'hrswp-sqlsrv-config.php'.
 *   3. Move to the same directory as the 'wp-config.php' file.
 */

/**
 * EXAMPLE: Defining a database
 *
 * $this->add_database(
 *     'database-handle',                               // A reference name for accessing this database, between 1 and 20 characters in length. Allowed characters: Lowercase alphanumeric characters, dashes and underscores, @see sanitize_key().
 *     array(
 *         'mssql_db_name'     => 'database_name_here', // The name of the database to connect to.
 *         'mssql_db_user'     => 'username_here',      // The Microsoft SQL Server user for the database.
 *         'mssql_db_password' => 'password_here',      // The Microsoft SQL Server user password.
 *         'mssql_db_host'     => 'host_here',          // The Microsoft SQL Server host.
 *     )
 * );
 */

/**
 * EXAMPLE: Associating tables with databases
 *
 * $this->set_table_names(
 *     'database-handle',                             // The reference name of the database containing the table(s).
 *     array(                                         // An array of one or more tables, each defined as its own array.
 *         array(
 *             'label'      => 'table-label',         // A reference name for referring to this table. Allowed characters: Lowercase alphanumeric characters, dashes and underscores, @see sanitize_key().
 *             'table_name' => 'database_table_name', // The name of the table in the database.
 *         ),
 *         array(
 *             'label'      => 'table-label-2',
 *             'table_name' => 'another_table',
 *         ),
 *     )
 * );
 */

// ** Microsoft SQL Server Configuration ** //

// Add your databases and define your tables here.
