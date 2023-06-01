<?php


namespace Kreatif\kShopware\StoreApi;


use Kreatif\kShopware\Api;


class LanguageApi extends Api
{
    public function fetchLanguageList($bodyParams = [], $queryParams = [])
    {
        return parent::request('POST', 'store-api/language', $bodyParams, $queryParams);
    }
}

