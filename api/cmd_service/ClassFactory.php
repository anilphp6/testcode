<?php

/**
 * Application factory to manage instantiation of GIT/BITBUCKE class
 */

namespace api\cmd_service;

use api\cmd_service\github_store\github_store;
use api\cmd_service\Bitb_store\Bitb_store;
use api\cmd_service\AppConstant;
use api\cmd_service\ErrorMessage;

class ClassFactory {

    private $_serviceInstance = null;
	public function StoreInstance($options = array()) {
		// Determine which class to instantiate based on repository url
        $serviceType = $this->_extractServiceType($options);

        if ($serviceType == 'github.com') {
            $this->_setGithubInstance($options);
        } else if ($serviceType == 'bitbucket.org') {
            $this->_setBitbucketInstance($options);
        } else {
            throw new \Exception(ErrorMessage::SERVICE_NOT_FOUND);
        }
    }

    /**
     * Get service instance
     * 
     * @return  object
     */
    public function service_instance() {
        return $this->_serviceInstance;
    }

    /**
     * Instantiate github class and set setvice instance
     * 
     * @return  void
     */
    protected function _setGithubInstance($options) {
        $this->_serviceInstance = new github_store($options);
    }

    /**
     * Instantiate bitbucket class and set setvice instance
     * @return  void
     */
    protected function _setBitbucketInstance($options) {
        $this->_serviceInstance = new bitb_store($options);
    }

    /**
     * Parse repository url and update $option
     * 
     * @return  string
     */
    private function _extractServiceType(& $options) {

        $hostName = '';
        $repositoryUrl = $options['url'];

        $temp = parse_url($repositoryUrl);

        $options = $options + $temp;

        if (isset($options['host']) && !empty($options['host'])) {
            $hostName = $options['host'];
        }
		//echo $hostName;exit;
        return $hostName;
    }

}
