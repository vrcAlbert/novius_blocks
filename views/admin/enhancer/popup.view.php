<?php
/**
 * Novius Blocks
 *
 * @copyright  2014 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

    $display_type       = uniqid('display_type_');
    $blco_id            = \Input::get('blco_id', false);
    $blocks_ids          = \Input::get('blocks_ids', array());
    $context            = \Input::get('nosContext', false);
    $wrapper_columns    = uniqid('wrapper_colum_');
    $wrapper_blocks      = uniqid('wrapper_blocks_');

    switch ($display_type) {
        case 'column' :
            $blocks_ids = array();
            break;
        case 'blocks' :
            $blco_id = false;
            break;
    }
?>
<script type="text/javascript">
    require(['jquery-nos'], function () {
        var $select_type = $('#<?= $display_type ?>');
        var $wrapper_column = $('#<?= $wrapper_columns ?>');
        var $wrapper_blocks = $('#<?= $wrapper_blocks ?>');
        var b_width = $wrapper_blocks.width();

        $select_type.change(function(){
            display_select();
        });
        display_select();

        function display_select() {
            var type = $select_type.val();
            switch (type) {
                case 'column' :
                    $wrapper_blocks.css({
                        visibility : 'hidden'
                        , position : 'absolute'
                    }).width(b_width);
                    $wrapper_column.css({
                        visibility : 'visible'
                        , position : 'relative'
                    }).width(b_width);
                    break;
                case 'blocks' :
                    $wrapper_column.css({
                        visibility : 'hidden'
                        , position : 'absolute'
                    }).width(b_width);
                    $wrapper_blocks.css({
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
    <option value="blocks"<?= \Input::get('display_type') == 'blocks' ? ' selected' : '' ?>>Blocks selection</option>
</select>
<br />&nbsp;
<!-- Columns selection -->
<div id="<?= $wrapper_columns ?>" style="visibility: hidden; position: relative;">
    <?php
    $options_renderer_categories = array(
        'width'         => '250px',
        'height'        => '100px',
        'namespace'     => 'Novius\Blocks',
        'folder'        => 'novius_blocks',
        'inspector_tree'=> 'block/inspector/column',
        'class'         => 'Model_Column',
        'multiple'      => false,
        'columns'       => array(
            array(
                'dataKey'   => 'blco_title',
            ),
        ),
        'input_name'    => 'blco_id',
        'selected'      => array('id' => $blco_id),
        'label'         => 'Column',
        'reset_default_column' => true,
    );
    if ($context) {
        $options_renderer_categories['treeOptions'] = array(
            'context' => $context,
        );
    }
    ?>
    <?=
    \Novius\Renderers\Renderer_Categories::renderer($options_renderer_categories);
    ?>
</div>
<!-- Blocks selection -->
<?php
$where_blocks = array();
if ($context) {
    $where_blocks['block_context'] = $context;
}
$blocs = \Arr::assoc_to_keyval(\Novius\Blocks\Model_Block::find('all', array('where' => $where_blocks)), 'block_id', 'block_title');
?>
<div id="<?= $wrapper_blocks ?>" style="visibility: hidden; position: relative;">
    <?= \Novius\Renderers\Renderer_Multiselect::renderer(array(
        'options'       => $blocs,
        'name'          => 'blocks_ids[]',
        'values'        => $blocks_ids,
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