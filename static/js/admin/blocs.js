define(
    [
//        'jquery-nos-wysiwyg',
        'jquery-nos'
    ],
    function($) {
        "use strict";
        return function(uniqid) {
            var $container = $(this);
            //le radio qui permet de séléctionner le template
            var $template = $container.find('input[name="bloc_template"]');
            var init = false;
            var $wrapper_links = $container.find('.wrapper_links');
            var $model_id = $container.find('input[name="bloc_model_id"]');

            //On va recenser tous les expanders qui contiennent des champs facultatifs
            var fieldsets = new Array();
            var nb = 0;
            $container.find('.expander').each(function(i){
                var $options = $(this).data('wijexpander-options') || $(this).attr('data-wijexpander-options') || false;


                if ($options.fieldset) {
                    $(this).attr('id', $options.fieldset + uniqid);
//                    $(this).css('visibility', 'hidden');
                    $(this).hide();
                    fieldsets[nb] = $options.fieldset;
                    nb++;
                }
            });

            //on rend cliquable les templates
            $container.find('.bloc_over_wrapper').each(function(){
                var $wrapper = $(this);
                if ($(this).find('input[name="bloc_template"]').attr('checked')) {
                    $wrapper.addClass('on');
                }
                $(this).css('cursor', 'pointer').click(function(){
                    if (!$(this).find('input[name="bloc_template"]').attr('checked')) {
                        $container.find('.bloc_over_wrapper').removeClass('on');
                        $(this).find('input[name="bloc_template"]').attr('checked', true);
                        $wrapper.addClass('on');
                        display_expanders();
                    }
                    return false;
                });
            });

            //on équilibre l'affichage des preview de template
            var max_height = 0;
            $container.find('.bloc_over_wrapper').each(function(){
                if ($(this).height() > max_height) {
                    max_height = $(this).height();
                }
            });
            $container.find('.bloc_over_wrapper').css('min-height', max_height);

            check_link();
            display_expanders();

            $wrapper_links.on('action_links', function() {
                check_link();
            });

//            $template.change(function(){
//                display_expanders();
//            });

//            $.each(fieldsets, function(i,o){
//                console.log(i);
//                console.log(o);
//            });

            function check_link ()
            {
                var model_id = $model_id.val();
                var $wrapper_default = $wrapper_links.find('.link_default').find('tr').first();
                var $wrapper_model = $wrapper_links.find('.link_model');
                var model_key = $container.find('input[name="bloc_model"]').val();
                var $wrapper_assoc_model_choice = $container.find('.wrapper_assoc_model_choice');
                var $wrapper_assoc_model_done = $container.find('.wrapper_assoc_model_done');
                var $wrapper_autocompletion = $wrapper_assoc_model_done.next();
                var $select_model = $container.find('select[name="select_model"]');
                var $first_option = $select_model.find('option').first();

                if (model_id && model_key) {
                    $wrapper_default.hide();
//                    $wrapper_assoc_model_choice.hide();
                    $wrapper_assoc_model_choice.css('visibility', 'hidden');
                    $wrapper_autocompletion.hide();
                    //on recherche le contenu assoc
                    $nos.ajax({
                        'url': 'admin/lib_blocs/bloc/crud/get_model_assoc_infos/' + model_key + '/' + model_id,
                        'success' : function(vue) {
                            $wrapper_assoc_model_done.html(vue);
                            $wrapper_assoc_model_done.fadeIn();
                            $wrapper_model.html(vue);
                            $wrapper_model.fadeIn();
                            //on active le js
                            $container.find('.delete_liaison_model').on('click', function(){
                                if (!confirm('Souhaitez vous supprimer cette relation ?')) {
                                    return false;
                                }
                                $model_id.val('');
                                $container.find('input[name="bloc_model"]').val('');
                                $select_model.find('option').attr('selected', false);
                                $first_option.attr('selected', 'selected');
                                $select_model.wijdropdown('refresh');
                                $wrapper_links.trigger('action_links');
                                return false;
                            });
                        }
                    });

                } else {
                    $wrapper_assoc_model_choice.css('visibility', 'visible');
//                    $wrapper_autocompletion.fadeIn();
                    $wrapper_default.fadeIn().nosOnShow();

                    $wrapper_model.html('');
                    $wrapper_model.hide();
                    $wrapper_assoc_model_done.html('');
                    $wrapper_assoc_model_done.hide();
                }
            }

            /**
             * Permet d'afficher seulement les expanders qui nous intéressent
             */
            function display_expanders()
            {
//                if (!init) {
                    $.each(fieldsets, function(i,name){
                        $('#' + name + uniqid).hide();
//                        $('#' + name + uniqid).css('visibility', 'visible');
                    });
                    init = true;
//                }
                var $template_selected = $('input[name="bloc_template"]:checked');
                var fields = explode('|', $template_selected.data('fields') || $template_selected.attr('data-fields') || '');
                $.each(fieldsets, function(i,name){
                    if (in_array(name, fields)) {
                        $('#' + name + uniqid).fadeIn();
                    }
                });
            }

            /**
             *
             * @param delimiter
             * @param string
             * @param limit
             * @returns {*}
             */
            function explode (delimiter, string, limit)
            {
                if ( arguments.length < 2 || typeof delimiter === 'undefined' || typeof string === 'undefined' ) return null;
                if ( delimiter === '' || delimiter === false || delimiter === null) return false;
                if ( typeof delimiter === 'function' || typeof delimiter === 'object' || typeof string === 'function' || typeof string === 'object'){
                    return { 0: '' };
                }
                if ( delimiter === true ) delimiter = '1';

                // Here we go...
                delimiter += '';
                string += '';

                var s = string.split( delimiter );


                if ( typeof limit === 'undefined' ) return s;

                // Support for limit
                if ( limit === 0 ) limit = 1;

                // Positive limit
                if ( limit > 0 ){
                    if ( limit >= s.length ) return s;
                    return s.slice( 0, limit - 1 ).concat( [ s.slice( limit - 1 ).join( delimiter ) ] );
                }

                // Negative limit
                if ( -limit >= s.length ) return [];

                s.splice( s.length + limit );
                return s;
            }

            /**
             *
             * @param needle
             * @param haystack
             * @param argStrict
             * @returns {boolean}
             */
            function in_array (needle, haystack, argStrict) {
                var key = '',
                    strict = !! argStrict;

                if (strict) {
                    for (key in haystack) {
                        if (haystack[key] === needle) {
                            return true;
                        }
                    }
                } else {
                    for (key in haystack) {
                        if (haystack[key] == needle) {
                            return true;
                        }
                    }
                }

                return false;
            }

        }
    }
);