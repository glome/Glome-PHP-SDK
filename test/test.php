<?php
namespace Glome\Sdk;

require 'vendor/autoload.php';

use Glome\Sdk\GlomeService;
use Glome\Sdk\HttpClient\Guzzle;

$configs = json_decode(file_get_contents('config/config.json'), true);
$httpClient = new Guzzle($configs, true);
$glomeClient = new GlomeService($httpClient);

$firstGlomeId = $glomeClient->createUser()['glomeid'];
$secondGlomeId = $glomeClient->createUser()['glomeid'];
$glomeClient->pairGlomeIds($firstGlomeId, $secondGlomeId);
var_dump($glomeClient->getUserProfile($firstGlomeId));
var_dump($glomeClient->getUserProfile($secondGlomeId));
