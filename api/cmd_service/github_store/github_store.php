<?php

/**
 * Manage github api core 
 */

namespace api\cmd_service\github_store;

use api\cmd_service\Commands;
use api\PostRequest;

class github_store extends PostRequest implements Commands {

    /**
     * Available git api urls
     * @access private
     * @var array
     */
    private $gitApis = array(
        'contributors' => 'https://api.github.com/repos/:repository/contributors'
    );
    
    /**
     * User inputs
     * @var array
     */
    private $options = array();

    /**
     * Github Constructor
     * 
     * 
     * @param array $options    User Inputs
     */
    public function __construct($options = array()) {
        $options['dataType'] = 'json';
        $this->setOptions($options);
    }

    /**
     * Get Github available api url's or a single api based on key
     * 
     * 
     * @param string $key    API key
     * 
     * @return mixed
     */
    public function getGitApis($key = '') {
        if (!empty($key) && isset($this->gitApis[$key])) {
            return $this->gitApis[$key];
        }
        return $this->gitApis;
    }

    /**
     * Get user input options or a single user input based on key
     * 
     * 
     * @param string $key    API key
     * @return mixed
     */
    public function getOptions($key = '') {
        if (!empty($key) && isset($this->options[$key])) {
            return $this->options[$key];
        }
        return $this->options;
    }

    /**
     * Set user input options
     * 
     * @param options $options    User Inputs
     * @return void
     */
    public function setOptions($options) {
        $this->options = $options;
    }

    /**
     * Get single/all contributer(s) commit count on a particular git repository
     * 
     * @return mixed
     */
    public function getCommitCount() {

        $apiUrl = $this->getGitApis('contributors');

        $url = strtr($apiUrl,
                array(
            ':repository' => substr($this->getOptions('path'), 1)
        ));

        $output = $this->executeCurl($url, $this->getOptions());

        $formattedResponse = $this->parseResponse($output,
                $this->getOptions('dataType'));

        $contributors = array();

        if (count($formattedResponse) > 0) {
            foreach ($formattedResponse as $contributor) {
                $contributors[$contributor['login']] = $contributor['contributions'];
            }
        }
        
        $contributorName = $this->getOptions('contributorName');
        if (!empty($contributorName)) {
            return array($contributorName => $contributors[$contributorName]);
        }

        return $contributors;
    }

}
