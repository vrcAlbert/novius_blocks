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
                    $input_autocomplete.data('autocomplete-url', 'admin/novius_blocks/block/crud/autocomplete_model/' + model_key);
                    var event = $nos.Event('update_autocomplete.renderer');
                    $input_autocomplete.trigger(event);
                }
                check_display_autocomplete();
                check_display_autocomplete();
            });

            check_display_autocomplete();

            function check_display_autocomplete() {
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