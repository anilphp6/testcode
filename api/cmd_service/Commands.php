<?php

/**
 * API common methods for GIT/BITBUCKET
 */

namespace api\cmd_service;

interface Commands {

    /**
     * Get single/all contributer(s) commit count on a particular git/bitbucket repository
     * 
     */
    public function getCommitCount();
    
}
