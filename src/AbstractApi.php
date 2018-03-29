<?php

namespace CmdrSharp\HetrixtoolsApi;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client;

abstract class AbstractApi
{
    /**
     * Make a request to the remote API.
     *
     * @param String $apiKey
     * @param String $uri
     * @param array $post
     * @return mixed
     * @throws \ErrorException
     */
    public static function request(String $apiKey, String $uri, array $post)
    {
        $client = new Client(['base_uri' => 'https://api.hetrixtools.com/v2/' . $apiKey . '/']);
        $request = [
            'json' => $post,
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ];

        $response = $client->request('POST', $uri, $request);

        if (self::validateResponse($response)) {
            return $response;
        } else {
            throw new \ErrorException('An error has occurred: The response was likely not of the expected type.');
        }
    }

    /**
     * @param $response
     * @return bool
     * @throws \ErrorException
     */
    private static function validateResponse($response)
    {
        if (!$response instanceof ResponseInterface) {
            throw new \ErrorException('Response is not an instance of ResponseInterface');
        }

        return self::validateResponseContents(json_decode((string)$response->getBody()));
    }

    /**
     * @param \stdClass $response
     * @return bool
     * @throws \ErrorException
     */
    private static function validateResponseContents(\stdClass $response)
    {
        if (!isset($response->status) || $response->status === 'ERROR') {
            $message = isset($response->error_message) ? $response->error_message : 'Unknown';
            throw new \ErrorException('Remote API Procedure failed. Cause: ' . $message);
        }

        return true;
    }
}
