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
        return function(btn_id) {

            var $wrapper = $(this);
            var $btn_ok = $('#' + btn_id);

            $btn_ok.on('click', function(){
                $wrapper.closest('.ui-dialog-content').trigger('retrieve_model');
            });
        }
    }
);