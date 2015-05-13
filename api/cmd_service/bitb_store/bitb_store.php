<?php

/**
 *  bitbucket api core
 * 
 */

namespace api\cmd_service\bit_bucket;

use api\cmd_service\Commands;
use api\PostRequest;

class bitb_store extends PostRequest implements Commands {

    /**
     * Available bitbucket api urls
     * @access private
     * @var array
     */
    private $bitbucketApis = array(
        'commits' => 'https://bitbucket.org/api/2.0/repositories/:repository/commits'
    );

    /**
     * User inputs
     * @access private
     * @var array
     */
    private $options = array();

    /**
     * Bitbucket Constructor
     * 
     * @access public
     * 
     * @param array $options    User Inputs
     */
    public function __construct($options = array()) {
        $this->setOptions($options);
    }

    /**
     * Get Bitbucket available api url's or a single api based on key
     * 
     * @param string $key    API key
     * 
     * @return mixed
     */
    public function getBitbucketApis($key = '') {
        if (!empty($key) && isset($this->bitbucketApis[$key])) {
            return $this->bitbucketApis[$key];
        }
        return $this->bitbucketApis;
    }

    /**
     * Get user input options or a single user input based on key
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
        $options['dataType'] = 'json';
        $this->options = $options;
        return $this;
    }

    /**
     * Get single/all contributer(s) commit count on a particular bitbucket repository
     * 
     * 
     * @return mixed
     */
    public function getCommitCount() {

        $apiUrl = $this->getBitbucketApis('commits');

        $url = strtr($apiUrl,
                array(
            ':repository' => substr($this->getOptions('path'), 1)
        ));

        $output = $this->executeCurl($url, $this->getOptions());

        $formattedResponse = $this->parseResponse($output,
                $this->getOptions('dataType'));

        $contributors = array();

        if (count($formattedResponse) > 0) {

            foreach ($formattedResponse['values'] as $contributor) {

                $userName = isset($contributor['author']['user']['username']) ? $contributor['author']['user']['username'] : '';
                if (!empty($userName)) {
                    if (array_key_exists($userName, $contributors)) {
                        $contributors[$userName] += 1;
                    } else {
                        $contributors[$userName] = 1;
                    }
                }
            }
        }

        $contributorName = $this->getOptions('contributorName');

        if (!empty($contributorName)) {            
            $totalCount = isset($contributors[$contributorName])?$contributors[$contributorName]:0;            
            return array($contributorName => $totalCount);
        }

        return $contributors;
    }

}
