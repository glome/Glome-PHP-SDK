<?php

namespace Glome\Sdk\HttpClient;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;

class Guzzle implements HttpClientInterface
{
    protected $apiUserId;
    protected $apiKey;
    protected $debugMode;

    protected $httpClient;

    public function __construct($configs, $debugMode = false)
    {
        $this->apiUserId    = $configs['glome']['api-uid'];
        $this->apiKey       = $configs['glome']['api-key'];
        $this->debugMode = $debugMode;

        $this->httpClient = new HttpClient(
            array(
                'base_uri' => $configs['glome']['api-uri'],
                'query' => [
                    'application[uid]' => $this->apiUserId,
                    'application[apikey]' => $this->apiKey
                ]
            )
        );

        if ($this->debugMode) {
            $this->testCredentials();
        }
    }

    public function get($path)
    {
        try {
            $body = $this->httpClient->get($path)->getBody();
            return json_decode($body->read($body->getSize()), true);
        }
        catch (ClientException $ex) {
            if ($debugMode) {
                var_dump($ex->getMessage());
            }
            else {
                throw $ex;
            }
        }
    }

    public function post($path, $params = [])
    {
        try {
            $options = [];
            if (is_array($params) && count($params) > 0) {
                $options['query'] = $this->httpClient->getConfig()['query'] + $params;
            }

            $body = $this->httpClient->post($path, $options)->getBody();
            return json_decode($body->read($body->getSize()), true);
        }
        catch (ClientException $ex) {
            if ($debugMode) {
                var_dump($ex->getMessage());
            }
            else {
                throw $ex;
            }
        }
    }

    private function testCredentials()
    {
        try {
            // Guzzle should throw exceptions by default for non 2xx responses
            $this->get('applications/check/' . base64_encode($this->apiUserId) . '.json');
        } catch (ClientException $ex) {
            throw new GlomeException('Invalid Api Credentials');
        }
    }
}
