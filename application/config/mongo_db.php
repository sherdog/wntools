<?php 
// Codeigniter access check, remove it for direct use
if( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

/**
 * Configuration file for the MongoDB driver
 *
 * @author      Carlos Cessa <carlos@bitslice.net>
 * @author_url  http://www.bitslice.net
 */

/*
| -------------------------------------------------------------------
| MONGODB CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access mongodb.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|   ['mongo_host']             The hostname of the database server
|   ['mongo_port']             The port of the database server
|   ['mongo_user']             The username used to connect to the database
|   ['mongo_pass']             The password used to connect to the database
|   ['mongo_db']               The name of the database you want to connect to
|   ['mongo_replicaset']       Wether the connection is being made to a replicaset or not
|   ['mongo_slave_ok']         Allow to run read queries on slave servers for performance
|   ['mongo_write_timeout']    The time to wait for the server in milliseconds
|   ['mongo_ensure_replicas']  The number of replicas to wait for when writing data
|   ['mongo_update_all']       Update all the docs matching a criteria or just the first one
|   ['mongo_remove_all']       Remove all the docs matching a criteria or just the first one
|   ['mongo_use_upsert']       Create a new document when updating a non-existent one
|   ['mongo_expand_dbrefs']    Decide to autamagically expand any DBRefs while running queries
*/

//mongodb://:@candidate.37.mongolayer.com:11053,candidate.21.mongolayer.com:11027/app35138037
//rAQ1hbxEHmcdYYiROJrQw0YIUI4dwpVJds-x8N6_ymwLs9UIgkqC3Ltn1lTj9bQ_4juNNEishPzcNaM4dumfag
//mongodb://
/*

heroku:
rAQ1hbxEHmcdYYiROJrQw0YIUI4dwpVJds-x8N6_ymwLs9UIgkqC3Ltn1lTj9bQ_4juNNEishPzcNaM4dumfag
@candidate.37.mongolayer.com:11053,
candidate.21.mongolayer.com:11027/app35138037
*/
$config['mongo_db']['active'] = 'default';

$config['mongo_db']['local']['no_auth'] = TRUE;
$config['mongo_db']['local']['hostname'] = 'localhost';
$config['mongo_db']['local']['port'] = '27017';
$config['mongo_db']['local']['username'] = 'sherdog';
$config['mongo_db']['local']['password'] = 'michael5';
$config['mongo_db']['local']['database'] = 'local';
$config['mongo_db']['local']['db_debug'] = TRUE;
$config['mongo_db']['local']['return_as'] = 'array';
$config['mongo_db']['local']['write_concerns'] = (int)1;
$config['mongo_db']['local']['journal'] = TRUE;
$config['mongo_db']['local']['read_preference'] = NULL;
$config['mongo_db']['local']['read_preference_tags'] = NULL;
$config['mongo_db']['local']['mongo_expand_dbrefs']   = TRUE;
$config['mongo_db']['local']['mongo_use_upsert'] = TRUE;


$config['mongo_db']['default']['no_auth'] = FALSE;
$config['mongo_db']['default']['hostname'] = 'candidate.21.mongolayer.com';
$config['mongo_db']['default']['port'] = '11027';
$config['mongo_db']['default']['username'] = 'heroku';
$config['mongo_db']['default']['password'] = 'rAQ1hbxEHmcdYYiROJrQw0YIUI4dwpVJds-x8N6_ymwLs9UIgkqC3Ltn1lTj9bQ_4juNNEishPzcNaM4dumfag';
$config['mongo_db']['default']['database'] = 'app35138037';
$config['mongo_db']['default']['db_debug'] = TRUE;
$config['mongo_db']['default']['return_as'] = 'array';
$config['mongo_db']['default']['write_concerns'] = (int)1;
$config['mongo_db']['default']['journal'] = TRUE;
$config['mongo_db']['default']['read_preference'] = NULL;
$config['mongo_db']['default']['read_preference_tags'] = NULL;
$config['mongo_db']['default']['mongo_expand_dbrefs']   = TRUE;
$config['mongo_db']['default']['mongo_use_upsert'] = TRUE;

/*

$config['mongo_host']            = 'localhost';
$config['mongo_port']            = 27017;
$config['mongo_user']            = 'sherdog';
$config['mongo_pass']            = 'michael5';
$config['mongo_db']              = 'local';
$config['mongo_replicaset']      = FALSE;
$config['mongo_slave_ok']        = TRUE;
$config['mongo_write_timeout']   = 5000;
$config['mongo_ensure_replicas'] = 0;
$config['mongo_update_all']      = TRUE;
$config['mongo_remove_all']      = TRUE;
$config['mongo_use_upsert']      = TRUE;
$config['mongo_expand_dbrefs']   = TRUE;
$config['activate']				= TRUE;


*/

/* End of file mongodb.php */
/* Location: ./{APPLICATION}/config/mongodb.php */