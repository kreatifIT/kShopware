<?php


if (rex::isBackend()) {
    rex_view::addJsFile($this->getAssetsUrl('js/swLink.js'));

    rex_extension::register('mform/mformParser.generateCustomLinkElement', ['\kShopware\mform\customLink', 'ext__generateCustomLinkElement']);
    rex_extension::register('mform/varCustomLink.getCustomLinkText', ['\kShopware\mform\customLink', 'ext__getCustomLinkText']);
}

