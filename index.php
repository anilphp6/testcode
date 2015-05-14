<?php
/**
 * main files that will execute by command Commands
 */
 error_reporting(E_ALL & ~E_NOTICE);
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
	if (isset($argv) && is_array($argv) &&  count($argv)>6) {
		/* reposotry URL*/
		$credentials = array(
			'username' => $argv[2],
			'password' => $argv[4],
			'url' => $argv[5],
			'contributorName' => $argv[6]
		);
		/*$credentials = array(
			'username' 			=> 'anilphp6',
			'password'		 	=> '****',
			'contributor' 		=> 'anilphp6',
			'url' 				=> 'https://github.com/anilphp6/testcode anilphp6' 
		);*/
		//echo $argv[4];exit;
		#create object according to input for github/bitbucket
		$cmd_factory 	= new ClassFactory();
		$cmd_factory->StoreInstance($credentials);
		$response 		= $cmd_factory->service_instance()->getCommitCount();
		#print_r($response);exit;
		if (count($response) > 0) {
			foreach ($response as $user_name => $total_count) {
				echo "Contributor Name: " . $user_name;
				echo $total_count . PHP_EOL;
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
	