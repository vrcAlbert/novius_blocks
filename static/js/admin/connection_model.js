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
            var $input_autocomplete = $container.find('input[name="model_autocomplete"]');
            var $autocomplete_wrapper = $input_autocomplete.parents('p:first');

            $select.change(function(){
                var model_key = $(this).val();
                if (model_key) {
                    $input_autocomplete.data('autocomplete-url', 'admin/lib_blocs/bloc/crud/autocomplete_model/' + model_key);
                    var event = $nos.Event('update_autocomplete.renderer');
                    $input_autocomplete.trigger(event);
                }
                verif_affiche_autocomplete();
            });

            verif_affiche_autocomplete();

            function verif_affiche_autocomplete() {
                var model_key = $select.val();
                if (model_key) {
                    $autocomplete_wrapper.show();
                } else {
                    $autocomplete_wrapper.hide();
                }
            }
        }
    }
);