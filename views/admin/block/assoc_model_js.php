<?php
/**
 * Novius Blocks
 *
 * @copyright  2014 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */
?>
<script type="text/javascript">

    function click_model (infos)
    {

        require(['jquery-nos'], function($nos) {
            var model_id = infos.value;
            var $select = $nos('#<?= $config_select ?>');
            var model_config_key = $select.val();
            var $form_global = $('#<?= $form_id ?>');
            var $wrapper_links = $form_global.find('.wrapper_links');

            $dialog = $select.nosDialog('open', {
                contentUrl:  'admin/novius_blocks/block/crud/retrieve_model/' + model_config_key + '/' + model_id + '/<?= $config_select ?>',
                title: 'Retrieve model',
                ajax: true,
                width: 600,
                height: 400
            });

            $dialog.on('retrieve_model', function() {
                $dialog.find('input[type="checkbox"]:checked').each(function(i){
                    var t_name = $(this).attr('name');
                    var t_id = $(this).attr('id');

                    if (t_name == 'get_link') {
                        var model_id = $dialog.find('input[name="retrieve_model_id"]').val();
                        var model_name = $form_global.find('select[name="select_model"]').val();
                        $form_global.find('input[name="block_model_id"]').val(model_id);
                        $form_global.find('input[name="block_model"]').val(model_name);
                        $wrapper_links.trigger('action_links');
                    } else {
                        var $wrapper_value = $dialog.find('#' + t_id + '_value');
                        var type = $wrapper_value.data('type') || $(this).attr('data-type') || false;
                        var t_val = $dialog.find('#' + t_id + '_value').val();
                        switch (type) {
                            case 'wysiwyg' :
                                tinyMCE.activeEditor.setContent(t_val);
                                break;
                            default :
                                var $elem = $form_global.find('[name="block_' + t_name + '"]');
                                if ($elem.length) {
                                    $elem.val(t_val);
                                }
                                break;
                        }
                    }
                });
                $dialog.nosDialog('close');
            });
        });
    }
</script>