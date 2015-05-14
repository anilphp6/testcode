<?php
/**
 * main files that will execute by command Commands
 */
#include api file/bootstrap
require_once 'API_loader.php';

#common class need to incude on all pages
require_once 'common.php';

#register request
API_loader::auth();

use api\cmd_service\ClassFactory;
use api\cmd_service\ErrorMessage;
try {
	#get agument from command line should be 7 agrument
	//if (isset($argv) && count($argv)>3) {
	if (1) {
		/* reposotry URL*/
		$credentials = array(
			'username' 			=> $argv[1],
			'password'		 	=> $argv[2],
			'contributor' 		=> $argv[3],
			'url' 				=> $argv[4] 
		);
		/*$credentials = array(
			'username' 			=> '*****',
			'password'		 	=> '****',
			'contributor' 			=> '******',
			'url' 				=> 'https://github.com/anilphp6/test' 
		);*/
		//echo $argv[4];exit;
		#create object according to input for github/bitbucket
		$cmd_factory 	= new ClassFactory();
		$cmd_factory->StoreInstance($credentials);
		$response 		= $cmd_factory->service_instance()->getCommitCount();
		
		if (count($response) > 0) {
			foreach ($response as $user_name => $total_count) {
				echo "Contributor Name: " . $user_name;
				echo " :: Total Commits: " . $total_count . PHP_EOL;
			}
		} else {
			echo ErrorMessage::RECORD_NOT_FOUND;
		}
	}else{
			throw new customException();
	}
}
catch (customException $e) {	
	echo $e->errorMessage();
}
	
