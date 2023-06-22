<?php

use Kreatif\Api;


class rex_api_kreatif_shopware_manufacturer extends Api
{
    protected function __getList()
    {
        $term = isset($this->request['term']) ? trim($this->request['term']) : 'Bachmann Konrad';

        $manufacturerApi = new \Kreatif\kShopware\StoreApi\ManufacturerApi();
        $_response       = $manufacturerApi->fetchManufacturerList([
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

        dump($_response);
        exit;
    }
}
