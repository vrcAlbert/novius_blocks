<?php
/**
 * Novius Blocs
 *
 * @copyright  2013 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */
?>
<script type="text/javascript">
    require(['jquery-nos'], function ($nos) {
        $nos(function () {
            // We retrieve the value of the type to hide or not the wanted fields
            var $container = $(this);
            var $select_type = $container.find('select[name=bloc_type]');
            var inited = false;

            $select_type.change(function() {
                adapte_form();
            });

            function adapte_form() {
                var type = $select_type.val();
                var $expanders = $container.find('.wrapper_bloc').parent().parent();

                if (type == 'folder') {
                    $expanders.each(function(){
                        $(this).wijexpander({'afterCollapse' : function(){
                            $(this).wijexpander({'allowExpand' : false});
                        }});
                        $(this).wijexpander("collapse");
                    });
                } else {
                    $expanders.each(function(){
                        $(this).wijexpander({'allowExpand' : true});
                        $(this).wijexpander("expand");
                    });
                }
            }
        })
    });
</script>