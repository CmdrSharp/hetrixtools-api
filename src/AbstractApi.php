<?php

namespace CmdrSharp\HetrixtoolsApi;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client;

abstract class AbstractApi
{
    /**
     * Make a POST request to the remote API.
     *
     * @param String $apiKey
     * @param String $api
     * @param String $uri
     * @param array $post
     * @return mixed
     * @throws \ErrorException
     */
    public static function post(String $apiKey, String $api, String $uri, String $type, array $post)
    {
        return self::request($apiKey, $api, 'post', $uri, $type, $post);
    }

    /**
     * Make a GET request to the Remote API.
     *
     * @param String $apiKey
     * @param String $api
     * @param String $uri
     * @return mixed
     * @throws \ErrorException
     */
    public static function get(String $apiKey, String $api, String $uri, String $type = 'json')
    {
        return self::request($apiKey, $api, 'get', $uri, $type);
    }

    /**
     * Make a request to the remote API.
     *
     * @param String $apiKey
     * @param String $api
     * @param String $method
     * @param String $uri
     * @param array $post
     * @return mixed
     * @throws \ErrorException
     */
    protected static function request(String $apiKey, String $api, String $method, String $uri, String $type = 'json', ?array $post = null)
    {
        $client = new Client(['base_uri' => 'https://api.hetrixtools.com/' . $api . '/' . $apiKey . '/']);

        switch ($method) {
            case 'post':
                $response = $client->request('POST', $uri, [
                    $type => $post
                ]);
                break;

            case 'get':
                $response = $client->request('GET', $uri);
                break;

            default:
                throw new \ErrorException('Invalid method for request');
        }

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
     * @param $response
     * @return bool
     * @throws \ErrorException
     */
    private static function validateResponseContents($response)
    {
        if (is_array($response)) {
            return true;
        }

        if (is_object($response)) {
            if (isset($response->status) && $response->status === 'ERROR') {
                $message = isset($response->error_message) ? $response->error_message : 'Unknown';
                throw new \ErrorException('Remote API Procedure failed. Cause: ' . $message);
            }

            return true;
        }

        return false;
    }
}
