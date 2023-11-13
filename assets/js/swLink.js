let mformCustomLink = '.rex-js-widget-customlink';


$(document).on('rex:ready', function (e, container) {
    if (container.find(mformCustomLink).length) {
        container.find(mformCustomLink).each(function () {
            customlinkInitWidget($(this).find('.input-group.custom-link'));
        });
    }

    window.setTimeout(function () {

        /** Mfrom anbindung */
        $('select.sw_search_api').each(function () {
            let timeout;
            const $container = $(this).parent('div'),
                $select = $(this),
                $input = $container.find('input[type="search"]');

            let params = $select.data('params');
                // openerInputField = $select.data('opener-input-field'),
                // openerInputFieldName = $select.data('opener-input-field-name');
            $select.selectpicker();

            $input.on('keyup', function (e) {
                const inputVal = $(this).val();
                clearTimeout(timeout);
                if (inputVal.length >= 3) {
                    timeout = setTimeout(function () {
                        getShopwareData(params, inputVal).then((data) => {
                            $select.empty();
                            if (data) {
                                var $option = $('<option>').val('').text('');
                                $select.append($option);
                                for (let i = 0; i < data.length; i++) {
                                    const swData = data[i];
                                    var $option = $('<option>').val(swData.id).text(swData.text);
                                    $select.append($option);
                                }
                                $select.selectpicker('refresh');
                            }
                        });
                    }, 1000); // 3000 Millisekunden = 3 Sekunden
                }
                e.preventDefault();
            });

            // $select.change(function () {
            //     var selected = $select.find('option:selected');
            //     var linkName = $container.data('sw-search');
            //
            //     console.log('selected', selected);
            //     console.log('linkName', linkName);
            //
            //     // insertLink(openerInputField, openerInputFieldName, linkName + '|' + selected.attr('value'), selected.text());
            // });
        });


        /** CustomLink anbindung */

        $('[data-sw-search]').each(function () {
            const $container = $(this),
                $select = $container.find('select'),
                $input = $container.find('input[type="search"]');

            var params = $select.data('params'),
                openerInputField = $select.data('opener-input-field'),
                openerInputFieldName = $select.data('opener-input-field-name');

            $container.find('select').selectpicker();

            $container.find('input[type="search"]').on('keyup', function (e) {
                const inputVal = $(this).val();
                if (inputVal.length >= 3) {
                    getShopwareData(params, inputVal).then((data) => {
                        $select.empty();
                        if (data) {
                            var $option = $('<option>').val('').text('');
                            $select.append($option);
                            for (let i = 0; i < data.length; i++) {
                                const swData = data[i];

                                console.log('swData', swData);

                                var $option = $('<option>').val(swData.id).text(swData.text);
                                $select.append($option);
                            }
                            $select.selectpicker('refresh');
                        }
                    });
                }
                e.preventDefault();
            });

            $select.change(function () {
                var selected = $select.find('option:selected');
                var linkName = $container.data('sw-search');
                insertLink(openerInputField, openerInputFieldName, linkName + '|' + selected.attr('value'), selected.text());
            });
        });
    }, 500);

    function getShopwareData(params, value) {
        return new Promise((resolve) => {
            return fetch(params.ajax.url, {
                body: JSON.stringify({
                    term: value
                }),
                method: 'POST',
            }).then((response) => response.json()).then((data) => {
                resolve(data.message.data);
            });
        });
    }

    function insertLink(openerInputField, openerInputFieldName, link, name) {
        var event = opener.jQuery.Event('rex:selectLink');
        opener.jQuery(window).trigger(event, [link, name]);
        if (!event.isDefaultPrevented()) {
            window.opener.document.getElementById(openerInputField).value = link;
            window.opener.document.getElementById(openerInputField + '_NAME').value = name;
            self.close();
        }
    }
});


function customlinkInitWidget(element) {
    let clang = element.data('clang');

    element.find('a.shopware_link').unbind().bind('click', function () {
        let id = element.find('input:hidden').attr('id'),
            query = '&clang=' + clang;
        newLinkMapWindow('index.php?page=shopwarelinks&opener_input_field=' + id, query);
    });
}

