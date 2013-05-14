define(
    [
//        'jquery-nos-wysiwyg',
        'jquery-nos'
    ],
    function($) {
        "use strict";
        return function(select_id) {
            var $container = $(this);
            var $select = $('#' + select_id);

            $select.change(function(){
                var model_key = $(this).val();
                if (model_key) {
                    //on ouvre la popup de recherche
                    $select.nosDialog('open', {
                        contentUrl:  'admin/lib_blocs/bloc/crud/synchro?model_key=' + model_key,
                        title: 'Nouveau lieu',
                        ajax: true
                    });
                } else {
                    //on vide les infos
                }
            });
        }
    }
);