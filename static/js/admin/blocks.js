/**
 * Novius Blocks
 *
 * @copyright  2014 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

define(
    [
        'jquery-nos-wysiwyg',
        'jquery-nos',
        'tinymce'
    ],
    function($) {
        "use strict";
        return function(uniqid) {
            var $container = $(this);
            // The radio which allows to select the template
            var $template = $container.find('input[name="block_template"]');
            var init = false;
            var $wrapper_links = $container.find('.wrapper_links');
            var $model_id = $container.find('input[name="block_model_id"]');

            // We identify all the expanders that contain optional fields
            var fieldsets = new Array();
            var nb = 0;

            $container.find('.expander').each(function(i){
                var $options = $(this).data('wijexpander-options') || $(this).attr('data-wijexpander-options') || false;


                if ($options.fieldset) {
                    $(this).attr('id', $options.fieldset + uniqid);
                    $(this).hide();
                    fieldsets[nb] = $options.fieldset;
                    nb++;
                }
            });

            // We make the templates clickables
            $container.find('.block_over_wrapper').each(function(e){
                var $wrapper = $(this);
                var $checkbox = $(this).find('input[name="block_template"]');
                if ($checkbox.is(':checked')) {
                    $wrapper.addClass('on');
                }
                $wrapper.css('cursor', 'pointer').click(function(ev){
                    var $this = $(this);
                    var $this_checkbox = $this.find('input[name="block_template"]');
                    if (!$this_checkbox.is(':checked')) {
                        var $block_over_wrapper = $container.find('.block_over_wrapper');
                        $block_over_wrapper.removeClass('on');
                        $this_checkbox.prop('checked', true);
                        $wrapper.addClass('on');
                        display_expanders($container);
                    }
                    ev.preventDefault();
                });
            });

            // We equilibrate the display of the template's preview
            var max_height = 0;
            $container.find('.block_over_wrapper').each(function(){
                if ($(this).height() > max_height) {
                    max_height = $(this).height();
                }
            });
            $container.find('.block_over_wrapper').css('min-height', max_height);

            check_link();
            display_expanders($container);

            $wrapper_links.on('action_links', function() {
                check_link();
            });

            function check_link ()
            {
                var model_id = $model_id.val();
                var $wrapper_default = $wrapper_links.find('.link_default').find('tr').first();
                var $wrapper_model = $wrapper_links.find('.link_model');
                var model_key = $container.find('input[name="block_model"]').val();
                var $wrapper_assoc_model_choice = $container.find('.wrapper_assoc_model_choice');
                var $wrapper_assoc_model_done = $container.find('.wrapper_assoc_model_done');
                var $wrapper_autocompletion = $wrapper_assoc_model_done.next();
                var $select_model = $container.find('select[name="select_model"]');
                var $first_option = $select_model.find('option').first();

                if (model_id && model_key) {
                    $wrapper_default.hide();
                    $wrapper_assoc_model_choice.css('visibility', 'hidden');
                    $wrapper_autocompletion.hide();
                    // We search for the associated content
                    $nos.ajax({
                        'url': 'admin/novius_blocks/block/crud/get_model_assoc_infos',
                        data : {
                            key : model_key,
                            id : model_id
                        },
                        'success' : function(vue) {
                            $wrapper_assoc_model_done.html(vue);
                            $wrapper_assoc_model_done.fadeIn();
                            $wrapper_model.html(vue);
                            $wrapper_model.fadeIn();
                            // We activate the js
                            $container.find('.delete_liaison_model').on('click', function(e){
                                if (!confirm('Do you want to delete this relation ?')) {
                                    return false;
                                }
                                $model_id.val('');
                                $container.find('input[name="block_model"]').val('');
                                $select_model.find('option').prop('selected', false);
                                $first_option.prop('selected', 'selected');
                                $wrapper_links.trigger('action_links');
                                e.preventDefault();
                                $select_model.wijdropdown('refresh');
                            });
                        }
                    });

                } else {
                    $wrapper_assoc_model_choice.css('visibility', 'visible');
                    $wrapper_default.fadeIn().nosOnShow();

                    $wrapper_model.html('');
                    $wrapper_model.hide();
                    $wrapper_assoc_model_done.html('');
                    $wrapper_assoc_model_done.hide();
                }
            }

            /**
             * Display only the required expanders
             */
            function display_expanders($container)
            {
                    $.each(fieldsets, function(i,name){
                        $('#' + name + uniqid).hide();
                    });
                    init = true;
                var $template_selected = $container.find('input[name="block_template"]:checked');
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
                // From: http://phpjs.org/functions
                // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
                // *     example 1: explode(' ', 'Kevin van Zonneveld');
                // *     returns 1: {0: 'Kevin', 1: 'van', 2: 'Zonneveld'}
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
                // From: http://phpjs.org/functions
                // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
                // +   improved by: vlado houba
                // +   input by: Billy
                // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
                // *     example 1: in_array('van', ['Kevin', 'van', 'Zonneveld']);
                // *     returns 1: true
                // *     example 2: in_array('vlado', {0: 'Kevin', vlado: 'van', 1: 'Zonneveld'});
                // *     returns 2: false
                // *     example 3: in_array(1, ['1', '2', '3']);
                // *     returns 3: true
                // *     example 3: in_array(1, ['1', '2', '3'], false);
                // *     returns 3: true
                // *     example 4: in_array(1, ['1', '2', '3'], true);
                // *     returns 4: false
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