<?php

namespace Glome\Sdk;

use Glome\Sdk\HttpClient\HttpClientInterface;

class GlomeService
{
    protected $client;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->client = $httpClient;
    }

    public function createUser()
    {
        return $this->client->post('users.json');
    }

    public function getUserProfile($glomeId)
    {
        return $this->client->get('users/' . $glomeId . '.json');
    }

    public function getSyncCode($glomeId, $kind = 'b')
    {
        return $this->client->post('users/' . $glomeId . '/sync.json',
            ['synchronization[kind]' => $kind]);
    }

    public function pairSyncCode($glomeId, $syncCode)
    {
        $syncSplits = str_split($syncCode, 4);

        return $this->client->post('users/' . $glomeId . '/sync/pair.json',
            [
                'pairing[code_1]' => $syncSplits[0],
                'pairing[code_2]' => $syncSplits[1],
                'pairing[code_3]' => $syncSplits[2]
            ]);
    }

    public function pairGlomeIds($firstGlomeId, $secondGlomeId)
    {
        $syncCode = $this->getSyncCode($firstGlomeId)['code'];
        return $this->pairSyncCode($secondGlomeId, $syncCode);
    }

    public function getUserSharedServices($glomeId)
    {
        return $this->client->get('users/' . $glomeId . '/services.json');
    }

    public function getUserSharedData($glomeId, $serviceId)
    {
        return $this->client->get('users/' . $glomeId . '/data/' . $serviceId . '.json');
    }

    public function recordUserData($glomeId, $content, $subjectId = null, $kind = null)
    {
        $params['userdata[content'] = $content;

        if ($subjectId) {
            $params['userdata[subject_id'] = $subjectId;
        }

        if ($kind) {
            $params['userdata[kind'] = $kind;
        }

        return $this->client->post('users/' . $glomeId . '/data.json', $params);
    }

    public function getUserEarnings($glomeId)
    {
        return $this->client->get('users/' . $glomeId . '/earnings.json');
    }
}
