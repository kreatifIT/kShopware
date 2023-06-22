<?php

/**
 * This file is part of the Kreatif\Project package.
 *
 * @author Kreatif GmbH
 * @author p.parth@kreatif.it
 * Date: 14.12.21
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Kreatif\Api;


$apiUrlProducts = Api::getUrl(rex_api_kreatif_shopware_products::class, 'getList');
$apiUrlCategory = Api::getUrl(rex_api_kreatif_shopware_category::class, 'getList');

$opener_input_field      = rex_request::get('opener_input_field', 'string');
$opener_input_field_name = $opener_input_field . '_NAME';

$select2ParamsProduct  = [
    'ajax' => [
        'url'                => $apiUrlProducts,
        'dataType'           => 'json',
        'delay'              => 1000,
        'minimumInputLength' => 3,
    ],
];
$select2ParamsCategory = [
    'ajax' => [
        'url'                => $apiUrlCategory,
        'dataType'           => 'json',
        'delay'              => 1000,
        'minimumInputLength' => 3,
    ],
];
?>
<section class="rex-page-section">
    <div class="rex-slice-input" style="margin-top: 50px">
        <div class="rex-page-nav">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-content-product" data-toggle="tab">Produkte</a></li>
                <li><a href="#tab-content-category" data-toggle="tab">Kategorie</a></li>
            </ul>
        </div>

        <div class="tab-content lang-tab-content">
            <div class="tab-pane fade in active" id="tab-content-product">
                <fieldset class="form-horizontal ">
                    <div class="form-group">
                        <div class="col-sm-2 control-label"><label for="product_search">Produkte</label></div>
                        <div class="col-sm-10" data-sw-search="shopware_product_link">
                            <select class="form-control product_search_api"
                                    data-live-search="true"
                                    id="product_search"
                                    data-opener-input-field="<?= $opener_input_field ?>"
                                    data-opener-input-field-name="<?= $opener_input_field_name ?>"
                                    data-params="<?= rex_escape(json_encode($select2ParamsProduct), 'html_attr') ?>"></select>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="tab-pane fade in" id="tab-content-category">
                <fieldset class="form-horizontal ">
                    <div class="col-sm-2 control-label"><label for="category_search">Kategorie</label></div>
                    <div class="col-sm-10" data-sw-search="shopware_category_link">
                        <select class="form-control category_search_api"
                                data-live-search="true"
                                id="category_search"
                                data-opener-input-field="<?= $opener_input_field ?>"
                                data-opener-input-field-name="<?= $opener_input_field_name ?>"
                                data-params="<?= rex_escape(json_encode($select2ParamsCategory), 'html_attr') ?>"></select>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</section>
