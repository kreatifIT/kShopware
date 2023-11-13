<?php

use Kreatif\Api;
use Kreatif\kShopware\StoreApi\ProductApi;


class rex_api_kreatif_shopware_products extends Api
{
    protected function __getList()
    {
        $term       = isset($this->request['term']) ? trim($this->request['term']) : '';
        $productApi = new ProductApi();
        $_response  = $productApi->fetchProductList(
            [
                'json' => [
                    'filter' => [
                        [
                            'type'     => 'multi',
                            'operator' => 'or',
                            'queries'  => [
                                [
                                    'type'  => 'contains',
                                    'field' => 'name',
                                    'value' => $term,
                                ],
                                [
                                    'type'  => 'contains',
                                    'field' => 'productNumber',
                                    'value' => $term,
                                ],
                            ],
                        ],
                        [
                            'type'  => 'equals',
                            'field' => 'active',
                            'value' => true,
                        ],
                    ],
                    'total-count-mode' => true,
                ],
            ]
        );


        $result = [];
        foreach ($_response->elements as $product) {
            $productNumber = $product->productNumber;
            $result[]      = [
                'id'   => $product->id,
                'text' => $product->translated->name . ' (' . $productNumber . ')',
            ];
        }
        return $this->result = $result;
    }

}
