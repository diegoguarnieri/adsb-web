<?php

namespace App\Apps\Util;

use Illuminate\Support\Facades\Log;

class HttpRequest {

    private $url;
    private $method;
    private $bearer = false;
    private $basic = false;
    private $jsonBody = false;
    private $requestType = 'sync';
    private $contentType;
    private $accept;
    private $userAgent;
    private $fields;
    private $response;
    private $responseCode;
    

    public function __construct() {

    }

    public function exec() {
        if($this->method == 'get') {
            $this->get();

        } elseif($this->method == 'post') {
            $this->post();

        } elseif($this->method == 'put') {
            $this->put();

        } elseif($this->method == 'delete') {
            $this->delete();
        }
    }

    public function get() {
        $ch = curl_init();

        $url = $this->url . (($this->fields != null) ? '?' . http_build_query($this->fields) : '');
        $headers = $this->getHeaders();
        //Log::info(json_encode($headers));

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_HEADER, true);

        if($this->requestType == 'async') {
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        }

        $response = curl_exec($ch);

        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

        $header = substr($response, 0, $headerSize);
        $headers = $this->parseHeader($header);
        //Log::info('Header:', [json_encode($headers)]);

        $body = substr($response, $headerSize);
        $this->response = $body;
        //Log::info('Body:', [$body]);

        $info = curl_getinfo($ch);
        //Log::info('Request:', [$info]);

        $this->responseCode = $info['http_code'];

        curl_close($ch);
    }

    public function post() {
        $ch = curl_init();

        $headers = $this->getHeaders();

        if($this->jsonBody) {
            $fields = json_encode($this->fields);
        } elseif(isset($this->fields) && $this->fields != null) {
            $fields = http_build_query($this->fields);
        } else {
            $fields = '';
        }

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        if($this->requestType == 'async') {
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        }

        $response = curl_exec($ch);

        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

        $header = substr($response, 0, $headerSize);
        $headers = $this->parseHeader($header);
        //Log::info('Header:', [json_encode($headers)]);

        $body = substr($response, $headerSize);
        $this->response = $body;
        //Log::info('Body:', [$body]);

        $info = curl_getinfo($ch);
        //Log::info('Request:', [$info]);

        $this->responseCode = $info['http_code'];

        curl_close($ch);
    }

    public function delete() {

    }

    public function put() {

    }

    public function parseHeader($header) {
        $headers = array();

        $arrRequests = explode("\r\n\r\n", $header);

        for($i = 0; $i < count($arrRequests) -1; $i++) {
            foreach (explode("\r\n", $arrRequests[$i]) as $i => $line) {
                if($i === 0) {
                    $headers['http_code'] = $line;
                } else {
                    list($key, $value) = explode(': ', $line);
                    $headers[$key] = $value;
                }
            }
        }

        return $headers;
    }

    public function getHeaders() {
        $headers = array();

        if($this->contentType != '' && $this->contentType != null) {
            $headers[] = 'Content-Type: ' . $this->contentType;
        }

        if($this->accept != '' && $this->accept != null) {
            $headers[] = 'Accept: ' . $this->accept;
        }

        if($this->bearer) {
            $headers[] = 'Authorization: Bearer ' . $this->token;
        }

        if($this->basic) {
            $headers[] = 'Authorization: Basic ' . $this->token;
        }

        if($this->userAgent != '' && $this->userAgent != null) {
            $headers[] = 'User-Agent: ' . $this->userAgent;
        }

        return $headers;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function setMethod($method) {
        $this->method = $method;
    }

    public function setBearer($bearer) {
        $this->bearer = $bearer;
    }

    public function setBasic($basic) {
        $this->basic = $basic;
    }

    public function setJsonBody($jsonBody) {
        $this->jsonBody = $jsonBody;
    }

    public function setToken($token) {
        $this->token = $token;
    }

    public function setContentType($contentType) {
        if($contentType == 'json') {
            $this->contentType = 'application/json';

        } elseif($contentType == 'xml') {
            $this->contentType = 'application/xml';

        } elseif($contentType == 'text') {
            $this->contentType = 'application/text';

        } elseif($contentType == 'www-form') {
            $this->contentType = 'application/x-www-form-urlencoded';
        }
    }

    public function setAccept($accept) {
        if($accept == 'json') {
            $this->accept = 'application/json';

        } elseif($accept == 'xml') {
            $this->accept = 'application/xml';

        } elseif($accept == 'text') {
            $this->accept = 'application/text';
        }
    }

    public function setUserAgent($userAgent) {
        $this->userAgent = $userAgent;
    }

    public function setFields($fields) {
        $this->fields = $fields;
    }

    public function setRequestType($requestType) {
        $this->requestType = $requestType;
    }

    public function getResponse() {
        return $this->response;
    }

    public function getResponseCode() {
        return $this->responseCode;
    }
}