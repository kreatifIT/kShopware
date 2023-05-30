<?php


namespace Kreatif\kShopware\StoreApi;


use Kreatif\kShopware\Api;


class ProductApi extends Api
{
    public function fetchProductList($bodyParams = [], $queryParams = [])
    {
        return parent::request('POST', 'store-api/product', $bodyParams, $queryParams);
    }

    public function fetchProduct($id, $bodyParams = [], $queryParams = [])
    {
        return parent::request('POST', 'store-api/product/' . $id, $bodyParams, $queryParams);
    }
}
