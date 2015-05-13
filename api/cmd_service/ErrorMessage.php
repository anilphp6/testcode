<?php

/**
 * Class to manage application messages
 *
 */

namespace api\cmd_service;

class ErrorMessage{
    const DEFAULT_ERROR_MESSAGE = 'Please run command as: php index.php -u yourusername -p ******** https://github.com/username/repositoryname  contributorName';
    const SERVICE_NOT_FOUND = 'Service not found test.';
    const RECORD_NOT_FOUND = 'No record.';
    
    const USERNAME_REQUIRED = 'Please enter user name: ';
    const PASSWORD_REQUIRED = 'Please enter Password: ';
    const REPOSITORY_URL_REQUIRED = 'Please enter Repository url that you have created: ';
    const CONTRIBUTOR_REQUIRED = 'Please enter contributor Name that you want: ';
    
}