#this index.php file will run by command line or if you want to run directly by browser then use below mentioned code

index.php line number : 27
$credentials = array(
			'username' 			=> '',
			'password'		 	=> '',
			'contributor' 		=> '',
			'url' 				=> '' 
		);
		
by command line


#for  get total project contribute by contributor

$php index.php -username anilphp6 -pass ****  https://github.com/:username/repositryname  contributorname	

#for get comments only 

$php index.php -username anilphp6 -pass ****  https://github.com/:username/repositryname  contributorname -c