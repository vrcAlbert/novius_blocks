<?php
/**
 * Novius Blocs
 *
 * @copyright  2013 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

    $display_type       = uniqid('display_type_');
    $blco_id            = \Input::get('blco_id', false);
    $blocs_ids          = \Input::get('blocs_ids', array());
    $context            = \Input::get('nosContext', false);
    $wrapper_columns    = uniqid('wrapper_colum_');
    $wrapper_blocs      = uniqid('wrapper_blocs_');

    switch ($display_type) {
        case 'column' :
            $blocs_ids = array();
            break;
        case 'blocs' :
            $blco_id = false;
            break;
    }
?>
<script type="text/javascript">
    require(['jquery-nos'], function () {
        var $select_type = $('#<?= $display_type ?>');
        var $wrapper_column = $('#<?= $wrapper_columns ?>');
        var $wrapper_blocs = $('#<?= $wrapper_blocs ?>');
        var b_width = $wrapper_blocs.width();

        $select_type.change(function(){
            display_select();
        });
        display_select();

        function display_select() {
            var type = $select_type.val();
            switch (type) {
                case 'column' :
                    $wrapper_blocs.css({
                        visibility : 'hidden'
                        , position : 'absolute'
                    }).width(b_width);
                    $wrapper_column.css({
                        visibility : 'visible'
                        , position : 'relative'
                    }).width(b_width);
                    break;
                case 'blocs' :
                    $wrapper_column.css({
                        visibility : 'hidden'
                        , position : 'absolute'
                    }).width(b_width);
                    $wrapper_blocs.css({
                        visibility : 'visible'
                        , position : 'relative'
                    }).width(b_width);
                    break;
            }
        }
    });
</script>
<h1><?= __('Display type'); ?></h1>
<select name="display_type" id="<?= $display_type ?>">
    <option value="column"<?= \Input::get('display_type') == 'column' ? ' selected' : '' ?>>Column</option>
    <option value="blocs"<?= \Input::get('display_type') == 'blocs' ? ' selected' : '' ?>>Blocks selection</option>
</select>
<br />&nbsp;
<!-- Columns selection -->
<div id="<?= $wrapper_columns ?>" style="visibility: hidden; position: relative;">
    <?=
    \Novius\Renderers\Renderer_Categories::renderer(array(
        'width'         => '250px',
        'height'        => '100px',
        'namespace'     => 'Novius\Blocs',
        'folder'        => 'novius_blocs',
        'inspector_tree'=> 'bloc/inspector/column',
        'class'         => 'Model_Column',
        'multiple'      => false,
        'columns'       => array(
            array(
                'dataKey'   => 'blco_title',
            ),
        ),
        'treeOptions' => array(
            'context' => $context,
        ),
        'input_name'    => 'blco_id',
        'selected'      => array('id' => $blco_id),
        'label'         => 'Column',
        'reset_default_column' => true,
    ));
    ?>
</div>
<!-- Blocks selection -->
<div id="<?= $wrapper_blocs ?>" style="visibility: hidden; position: relative;">
    <?= \Novius\Renderers\Renderer_Multiselect::renderer(array(
        'options'       => \Arr::assoc_to_keyval(\Novius\Blocs\Model_bloc::find('all', array('where' => array('bloc_context' => $context))), 'bloc_id', 'bloc_title'),
        'name'          => 'blocs_ids[]',
        'values'        => $blocs_ids,
        'order'         => true,
        'renderer_options' => array(
            'sortable' => true,
        ),
        'style'         => array(
            'width'     => '400px',
        ),
    ));
    ?>
</div>