<?php


namespace kShopware\mform;

use Kreatif\kShopware\StoreApi\CategoryApi;
use Kreatif\kShopware\StoreApi\ProductApi;
use MForm\DTO\MFormElement;
use MForm\DTO\MFormItem;


class customLink
{

    public static function ext__getCustomLinkText(\rex_extension_point $ep)
    {
        $subject = $ep->getSubject();

        [$name, $id] = explode('|', $subject);
        if ($name === 'shopware_product_link') {
            $productApi = new ProductApi();
            $_response  = $productApi->fetchProduct($id);

            $subject = $_response->product->translated->name;
        } elseif ($name === 'shopware_category_link') {
            $categoryApi = new CategoryApi();
            $_response   = $categoryApi->fetchCategory($id);
            $subject     = $_response->translated->name;
        }

        $ep->setSubject($subject);
    }

    public static function ext__generateCustomLinkElement(\rex_extension_point $ep)
    {
        /** @var MFormElement $subject */
        $subject = $ep->getSubject();
        /** @var MFormItem $item */
        $item       = $ep->getParam('item');
        $attributes = $item->getAttributes();

        if ($attributes && $attributes['data-shopware'] && $attributes['data-shopware'] === 'enable') {
            $id               = $item->getId();
            $swLink           = '<a href="#" class="btn btn-popup shopware_link" id="shopware_table_' . $id . '" title="Shopware"><i class="rex-icon rex-icon-shop"></i></a>';
            $html             = $subject->element;
            $pattern          = '/(.*)(<a\b[^>]*>)(.*)(<\/a>)/s';
            $newHtml          = preg_replace($pattern, '$1' . $swLink . '$2$3$4', $html);
            $subject->element = $newHtml;
            $ep->setSubject($subject);
        }
    }
}
