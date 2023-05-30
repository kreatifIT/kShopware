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



$form = rex_config_form::factory('kreatif/shopware');

$field = $form->addTextField('api_url', null, ["class" => "form-control"]);
$field->setLabel('Shopware API URL');


$field = $form->addTextField('api_acces_key',null,['class'=> 'form-control','type'=>'password']);
$field->setLabel('Shopware API Access Key');


$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', 'Shopware 6 Einstellungen');
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');
