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

            display_expanders();

//            $template.change(function(){
//                display_expanders();
//            });

//            $.each(fieldsets, function(i,o){
//                console.log(i);
//                console.log(o);
//            });

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