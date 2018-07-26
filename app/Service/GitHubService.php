<?php

namespace App\Service;


use App\Service\ValueObject\GitHubUserResponse;
use GuzzleHttp\Client;

class GitHubService
{

    /**
     * @var string $apiUrl
     */
    private $apiUrl = 'https://api.github.com';

    /**
     * @var string $apiEndpoint
     */
    private $apiEndpoint = '';

    /**
     * @param $username
     * @return GitHubUserResponse
     */
    public function getUser($username)
    {
        $this->setApiEndpoint('/users/' . $username);

        $result = $this->callApiGet();

        $result = GitHubUserResponse::createFromJson($result);

        return $result;
    }

    /**
     * @param $params
     * @return string
     */
    protected function callApiGet()
    {
        $client = new Client();
        $response = $client->get(
            $this->apiEndpoint
        );
        $result = $response->getBody()->getContents();

        return $result;
    }

    /**
     * @return string
     */
    public function getApiEndpoint(): string
    {
        return $this->apiEndpoint;
    }

    /**
     * @param string $apiEndpoint
     */
    public function setApiEndpoint(string $apiEndpoint): void
    {
        $this->apiEndpoint = $this->apiUrl . $apiEndpoint;
    }
}