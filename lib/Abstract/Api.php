<?php

namespace Kreatif\kShopware;

use GuzzleHttp;
use Kreatif\ServiceConnector\ApiException;


abstract class Api
{
    public static function request($method, $url, $bodyParams = [], $queryParams = [], $rawBody = '')
    {
        $query = GuzzleHttp\Psr7\Query::build($queryParams);
        $query = $query ? "?{$query}" : '';
        $clangId = \rex_clang::getCurrentId();

        $apiUrl      = \rex_config::get('kreatif/shopware', 'api_url');
        $swAccessKey = \rex_config::get('kreatif/shopware', 'api_acces_key');
        $swLanguageId = \rex_config::get('kreatif/shopware', 'lang_' . $clangId);

        if ($apiUrl == '' || $swAccessKey == '') {
            throw new \Exception('Shopware API URL or Access Key is not set');
        }

        $headers = [
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'sw-access-key' => $swAccessKey,
            'sw-language-id' => $swLanguageId,
        ];

        try {
            $client  = new GuzzleHttp\Client();
            $request = new GuzzleHttp\Psr7\Request($method, rtrim($apiUrl, '/') . '/' . ltrim($url, '/') . $query, $headers, $rawBody);
            /** @var GuzzleHttp\Psr7\Response $response */
            $response = $client->send($request, $bodyParams);

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new \Exception(sprintf('[%d] Error connecting to the API (%s)', $statusCode, ''), $statusCode, $response->getHeaders(), $response->getBody());
            }

            return json_decode($response->getBody()->getContents());
        } catch (GuzzleHttp\Exception\RequestException $e) {
            dump($e->getMessage());
        }
    }
}
