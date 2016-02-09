<?php

namespace Glome\Sdk\HttpClient;

interface HttpClientInterface
{
    public function get($path);

    public function post($path, $params = []);
}
