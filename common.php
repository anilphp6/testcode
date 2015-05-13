<?php
/**
 * class for manage exception handling
 */
class customException extends Exception {
  public function errorMessage() {
    #error message
    $errorMsg = 'You can not access on browser Or may you forget to pass credentails, can be run only command line by below mentioned details: </br>';
	$errorMsg .= 'username</br> password <br> repository_url <br> contributor';	
				
    return $errorMsg;
  }
  
}