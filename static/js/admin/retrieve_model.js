define(
    [
//        'jquery-nos-wysiwyg',
        'jquery-nos'
    ],
    function($) {
        "use strict";
        return function(btn_id) {

            var $wrapper = $(this);
            var $btn_ok = $('#' + btn_id);

            $btn_ok.on('click', function(){
                $wrapper.closest('.ui-dialog-content').trigger('retrieve_model');
            });
        }
    }
);