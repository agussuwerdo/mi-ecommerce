<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['dsn']      The full DSN string describe a connection to the database.
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database driver. e.g.: mysqli.
|			Currently supported:
|				 cubrid, ibase, mssql, mysql, mysqli, oci8,
|				 odbc, pdo, postgre, sqlite, sqlite3, sqlsrv
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Query Builder class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['encrypt']  Whether or not to use an encrypted connection.
|
|			'mysql' (deprecated), 'sqlsrv' and 'pdo/sqlsrv' drivers accept TRUE/FALSE
|			'mysqli' and 'pdo/mysql' drivers accept an array with the following options:
|
|				'ssl_key'    - Path to the private key file
|				'ssl_cert'   - Path to the public key certificate file
|				'ssl_ca'     - Path to the certificate authority file
|				'ssl_capath' - Path to a directory containing trusted CA certificates in PEM format
|				'ssl_cipher' - List of *allowed* ciphers to be used for the encryption, separated by colons (':')
|				'ssl_verify' - TRUE/FALSE; Whether verify the server certificate or not
|
|	['compress'] Whether or not to use client compression (MySQL only)
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|	['ssl_options']	Used to set various SSL options that can be used when making SSL connections.
|	['failover'] array - A array with 0 or more data for connections if the main should fail.
|	['save_queries'] TRUE/FALSE - Whether to "save" all executed queries.
| 				NOTE: Disabling this will also effectively disable both
| 				$this->db->last_query() and profiling of DB queries.
| 				When you run a query, with this setting set to TRUE (default),
| 				CodeIgniter will store the SQL statement for debugging purposes.
| 				However, this may cause high memory usage, especially if you run
| 				a lot of SQL queries ... disable this to avoid that problem.
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $query_builder variables lets you determine whether or not to load
| the query builder class.
*/
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => getenv('DB_HOST') ?: '127.0.0.1',
	'username' => getenv('DB_USERNAME') ?: 'mi',
	'password' => getenv('DB_PASSWORD') ?: 'miecommerce',
	'database' => getenv('DB_DATABASE') ?: 'midb',
	'dbdriver' => getenv('DB_CONNECTION') ?: 'mysqli',
	'port' => getenv('DB_PORT') ?: 3306,
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => getenv('APP_DEBUG') !== FALSE
		? filter_var(getenv('APP_DEBUG'), FILTER_VALIDATE_BOOLEAN)
		: (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	// 'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

// Prefer the direct endpoint: database-backed sessions use session-level
// advisory locks, which are incompatible with PgBouncer transaction pooling.
$postgres_url = getenv('DATABASE_URL_UNPOOLED') ?: getenv('POSTGRES_URL_NON_POOLING')
	?: getenv('DATABASE_URL') ?: getenv('POSTGRES_URL');

if ($postgres_url) {
	$postgres_parts = parse_url($postgres_url);
	if ($postgres_parts === FALSE || !isset($postgres_parts['scheme'], $postgres_parts['host'], $postgres_parts['path'])
		|| !in_array($postgres_parts['scheme'], array('postgres', 'postgresql'), TRUE)) {
		throw new RuntimeException('Invalid PostgreSQL connection URL. Check the database environment variables.');
	}
	if (strpos($postgres_parts['host'], '-pooler.') !== FALSE) {
		throw new RuntimeException('Set DATABASE_URL_UNPOOLED to the direct Neon endpoint. Database sessions require session-level locks.');
	}
	// Pass the URI straight to libpq, preserving encoded credentials, TLS and
	// channel_binding options without exposing them in application source.
	$db['default'] = array_merge($db['default'], array(
		'dsn' => $postgres_url,
		'dbdriver' => 'postgre',
		'hostname' => $postgres_parts['host'],
		'port' => isset($postgres_parts['port']) ? $postgres_parts['port'] : 5432,
		'username' => isset($postgres_parts['user']) ? rawurldecode($postgres_parts['user']) : '',
		'password' => isset($postgres_parts['pass']) ? rawurldecode($postgres_parts['pass']) : '',
		'database' => rawurldecode(ltrim($postgres_parts['path'], '/')),
		'dbcollat' => '',
		'schema' => 'public', // Required for CodeIgniter's column/default-field discovery.
	));
}
