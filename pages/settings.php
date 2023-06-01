<?php

/**
 * This file is part of the Kreatif\Project package.
 *
 * @author Kreatif GmbH
 * @author a.platter@kreatif.it
 * Date: 12.02.21
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Kreatif\kShopware\StoreApi\LanguageApi;


$apiUrl      = rex_config::get('kreatif/shopware', 'api_url');
$swAccessKey = rex_config::get('kreatif/shopware', 'api_acces_key');

$form = rex_config_form::factory('kreatif/shopware');

$field = $form->addTextField('api_url', null, ["class" => "form-control"]);
$field->setLabel('Shopware API URL');


$field = $form->addTextField('api_acces_key', null, ['class' => 'form-control', 'type' => 'password']);
$field->setLabel('Shopware API Access Key');

if ($apiUrl && $swAccessKey) {
    $clangs      = rex_clang::getAll();
    $languageApi = new LanguageApi();
    $swLanguages = $languageApi->fetchLanguageList();

    $field = $form->addReadOnlyField('info', 'Language Mapping');
    $field->setLabel('');

    foreach ($clangs as $clang) {
        $field = $form->addSelectField('lang_' . $clang->getId(), null, ['class' => 'form-control']);
        $field->setLabel($clang->getName());
        $select = $field->getSelect();
        foreach ($swLanguages->elements as $swLang) {
            $select->addOption($swLang->name, $swLang->id);
        }
    }
} else {
    $field = $form->addReadOnlyField('info', 'Bitte tragen Sie zuerst die Shopware API URL und den Access Key ein.');
    $field->setLabel('Shopware API LanguageMapping');
}


$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', 'Shopware 6 Einstellungen');
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');
