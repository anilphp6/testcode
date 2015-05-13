<?php

/**
 * Performs curl operations.
 * php curl should be enabled in php.ini file
 */

namespace api;

class PostRequest {

    protected $curlsetting = array(
        'port' => '443',
        'timeout' => '90',
    );

    public function getCurlConfig($key = '') {
        if (!empty($key) && isset($this->curlsetting[$key])) {
            return $this->curlsetting[$key];
        }
        return $this->curlsetting;
    }

    /**
     * Execure curl request manage for curl request'
     * 
     * @param string $url   URL to be hit
     * @param array $options    Curl Options
     * @param type $parameters  Extra parameters
     * @param type $httpMethod  Http Method(default: GET)
     * @return mixed 
     * @throws \Exception
     */
    public function executeCurl($url, $options = array(), $parameters = array(),
            $httpMethod = 'GET') {
		//start curl php method
        $curl = curl_init();

        $curlOptions = $this->prepareRequest($url, $options, $parameters,
                $httpMethod
        );

        curl_setopt_array($curl, $curlOptions);

        $response = curl_exec($curl);
        $headers = curl_getinfo($curl);
        $errorNumber = curl_errno($curl);
        #get curl error message
		$errorMessage = curl_error($curl);

        curl_close($curl);
		//echo '<pre>'; print_R($headers);exit;
        if (!in_array($headers['http_code'], array(0, 200, 201))) {
            throw new \Exception($errorMessage, (int) $headers['http_code']);
        }

        if ($errorNumber != '') {
            throw new \Exception('error ' . $errorNumber);
        }

        return $response;
    }

    /**
     * Execure curl options'
     * @param string $url   URL to be hit
     * @param array $options    Curl Options
     * @param type $parameters  Extra parameters
     * @param type $httpMethod  Http Method(default: GET)
     * @return array 
     * 
     */
    protected function prepareRequest($url, $options = array(),
            $parameters = array(), $httpMethod = 'GET') {

        $curlOptions = array();

        if (isset($options['username']) && isset($options['password'])) {
            $curlOptions += array(
                CURLOPT_USERPWD => $options['username'] . ':' . $options['password'],
            );
        }

        if (!empty($parameters)) {
            $queryString = utf8_encode(http_build_query($parameters, '', '&'));

            if ('GET' === $httpMethod) {
                $url .= '?' . $queryString;
            } else {
                $curlOptions += array(
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $queryString
                );
            }
        }

        $curlOptions += array(
            CURLOPT_URL => $url,
            CURLOPT_PORT => $this->getCurlConfig('port'),
            CURLOPT_USERAGENT => $this->getCurlConfig('userAgent'),
            CURLOPT_TIMEOUT => $this->getCurlConfig('timeout'),
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false
        );

        return $curlOptions;
    }

    /**
     * Filter JSON data and transform it to a PHP array
     * 
     * @param mixed $response   Curl Response
     * @param string $dataType  JSON/TEXT
     * 
     * @return  array   The response
     */
    protected function parseResponse($response, $dataType) {
        if ('text' === $dataType) {
            return $response;
        } elseif ('json' === $dataType) {
            return json_decode($response, true);
        }

        throw new Exception(__CLASS__ . ' only supports json & text format, ' . $dataType . ' given.');
    }

}
