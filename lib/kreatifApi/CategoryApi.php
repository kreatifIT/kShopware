<?php


use Kreatif\Api;
use Kreatif\kShopware\StoreApi\CategoryApi;


class rex_api_kreatif_shopware_category extends Api
{
    protected function __getList()
    {
        $term = isset($this->request['term']) ? trim($this->request['term']) : '';

        $categoryApi = new CategoryApi();
        $_response   = $categoryApi->fetchCategoryList([
                                                           'json' => [
                                                               'filter' => [
                                                                   [
                                                                       'type'  => 'contains',
                                                                       'field' => 'name',
                                                                       'value' => $term,
                                                                   ],
                                                               ],
                                                           ],
                                                       ]);

        $result = [];
        foreach ($_response->elements as $category) {
            $result[] = [
                'id'   => $category->id,
                'text' => $category->translated->name,
            ];
        }
        return $this->result = $result;
    }
}
