<?php

namespace Kreatif\kShopware\StoreApi;

use Kreatif\kShopware\Api;


class CategoryApi extends Api
{
    public function fetchCategoryList($bodyParams = [], $queryParams = [])
    {
        return parent::request('POST', 'store-api/category', $bodyParams, $queryParams);
    }

}
