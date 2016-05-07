<?php

namespace pwf\helpers;

class HttpHelper
{

    /**
     * Send post request to $_url
     *
     * @param string $_url
     * @param mixed $_data
     * @param array $_headers
     * @param bool $_return_header
     * @return string
     */
    public static function sendPost($_url, $_data, $_headers = [],
                                    $_return_header = true)
    {
        return self::sendCurl($_url,
                array(
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_FOLLOWLOCATION => 0,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => $_data,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_HTTPHEADER => $_headers,
                CURLOPT_HEADER => $_return_header
        ));
    }

    /**
     * Send request to $_url
     *
     * @param type $_url
     * @param array $_params
     * @return type
     */
    public static function sendCurl($_url, $_params)
    {
        $Curl                 = curl_init();
        $_params[CURLOPT_URL] = $_url;
        curl_setopt_array($Curl, $_params);

        $CurlOutput = curl_exec($Curl);

        if (curl_errno($Curl)) {
            echo("Remote service error: ".curl_error($Curl).".");
        }

        curl_close($Curl);

        return $CurlOutput;
    }

    /**
     * Check is url absolute
     *
     * @param string $_path
     * @return bool
     */
    public static function isAbsoluteUrl($_path)
    {
        $url = parse_url($_path);

        return $url !== false && isset($url['scheme']) && $url['scheme'] != '';
    }

    /**
     * Invoke SOAP method
     *
     * @param string $wsdlURL
     * @param string $method
     * @param array $params
     * @param array $options
     * @return mixed
     */
    public static function invokeSoap($wsdlURL, $method,
                                      array $params = array(),
                                      array $options = array())
    {
        try {
            $soapClient = new \SoapClient($wsdlURL, $options);
            $result     = $soapClient->$method($params);
        } catch (\SoapFault $ex) {
            $result = false;
        }
        return $result;
    }
}