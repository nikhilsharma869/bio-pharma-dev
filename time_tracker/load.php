<?php
define( 'ABPATH', dirname(__FILE__) . '/' );

	require_once( ABPATH . 'includes/max-framwork/max_framwork.php' );

	if(!_d('ADMPATH')){
		_d('ADMPATH', ABPATH.'');

	}
	if(!_d('ADMINC')){
		_d('ADMINC', ADMPATH.'includes/');
	}
	if ( !_d('ADMINFOLDER') )
	_d('ADMINFOLDER','apanel');
	
	if ( !_d('INCPATH') )
		_d('INCPATH',ADMPATH.'includes/');

	if ( !_d('GLOPATH') )
		_d('GLOPATH',INCPATH.'global/');
 
	
	if ( !_d('MEDPATH') )
	_d('MEDPATH',ABPATH.'mediafile/');
	
	if( _isFile(ABPATH . 'config.php') ) {

		_req1( ABPATH .'config.php' );

	}else{
		_gourl("http://www.anciletech.com/");
	}
?>
<?php
function rqDB(){
	return new_mysql(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);	
}
function run_quary($sql){
	$DB=rqDB();
	$DB->run($sql);	
} 
define('SITE_NAME','');
?>
