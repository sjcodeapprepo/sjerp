<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
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
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = '192.168.1.215';
$db['default']['username'] = 'programsawit';
$db['default']['password'] = '';
$db['default']['database'] = 'wbarjuna';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'latin1';
$db['default']['dbcollat'] = 'latin1_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = TRUE;

//--------------------------------------eof ----------------------------------------------.
/* End of file database.php */
/* Location: ./application/config/database.php */
$db['lokal']['hostname'] = 'localhost';
$db['lokal']['username'] = 'root';
$db['lokal']['password'] = '';
$db['lokal']['database'] = '';
$db['lokal']['dbdriver'] = 'mysql';
$db['lokal']['dbprefix'] = '';
$db['lokal']['pconnect'] = FALSE;
$db['lokal']['db_debug'] = TRUE;
$db['lokal']['cache_on'] = FALSE;
$db['lokal']['cachedir'] = '';
$db['lokal']['char_set'] = 'latin1';
$db['lokal']['dbcollat'] = 'latin1_general_ci';
$db['lokal']['swap_pre'] = '';
$db['lokal']['autoinit'] = TRUE;
$db['lokal']['stricton'] = TRUE;

$db['server']['hostname'] = '';
$db['server']['username'] = '';
$db['server']['password'] = '';
$db['server']['database'] = '';
$db['server']['dbdriver'] = 'mysql';
$db['server']['dbprefix'] = '';
$db['server']['pconnect'] = TRUE;
$db['server']['db_debug'] = TRUE;
$db['server']['cache_on'] = FALSE;
$db['server']['cachedir'] = '';
$db['server']['char_set'] = 'latin1';
$db['server']['dbcollat'] = 'latin1_general_ci';
$db['server']['swap_pre'] = '';
$db['server']['autoinit'] = TRUE;
$db['server']['stricton'] = TRUE;
