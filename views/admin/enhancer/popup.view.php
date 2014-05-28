<?php
/**
 * Novius Blocks
 *
 * @copyright  2014 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

// Current context
$context = \Input::get('nosContext', false);

// Display type
$display_type_id = uniqid('display_type_');
$display_type = \Input::get('display_type', false);

// Display

$displays = \Novius\Blocks\Display::available();
$display_id = uniqid('display_');
$display = \Input::get('display', false);


// Initialize block or block list
$blco_id            = \Input::get('blco_id', false);
$blocks_ids          = \Input::get('blocks_ids', array());
switch ($display_type) {
    case 'column' :
        $blocks_ids = array();
        break;
    case 'blocks' :
        $blco_id = false;
        break;
}

$wrapper_columns = uniqid('wrapper_colum_');
$wrapper_blocks = uniqid('wrapper_blocks_');

?>
<div>
    <!-- Display type -->
    <fieldset>
        <h1><?= __('Source'); ?></h1>
        <select name="display_type" id="<?= $display_type_id ?>">
            <option value="column"<?= \Input::get('display_type') == 'column' ? ' selected' : '' ?>><?= __('Column'); ?></option>
            <option value="blocks"<?= \Input::get('display_type') == 'blocks' ? ' selected' : '' ?>><?= __('Blocks selection'); ?></option>
        </select>
    </fieldset>

    <!-- Columns selection -->
    <div id="<?= $wrapper_columns ?>" style="visibility: hidden; position: relative; overflow: hidden;">
        <fieldset>
            <?php
            $options_renderer_categories = array(
                'width'         => '100%',
                'height'        => '200px',
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
                'label'         => __('Column'),
                'reset_default_column' => true,
            );
            if ($context) {
                $options_renderer_categories['treeOptions'] = array(
                    'context' => $context,
                );
            }
            echo \Novius\Renderers\Renderer_Categories::renderer($options_renderer_categories);
            ?>
        </fieldset>
    </div>

    <!-- Blocks selection -->
    <?php
    $where_blocks = array();
    if ($context) {
        $where_blocks['block_context'] = $context;
    }
    $blocks = \Arr::assoc_to_keyval(\Novius\Blocks\Model_Block::find('all', array('where' => $where_blocks)), 'block_id', 'block_title');
    ?>
    <div id="<?= $wrapper_blocks ?>" style="visibility: hidden; position: relative; overflow: hidden;">
        <fieldset>
        <?= \Novius\Renderers\Renderer_Multiselect::renderer(array(
            'options'       => $blocks,
            'name'          => 'blocks_ids[]',
            'values'        => $blocks_ids,
            'order'         => true,
            'renderer_options' => array(
                'sortable' => true,
            ),
            'style'         => array(
                'width'     => '100%',
                'height'    => '200px',
            ),
        ));
        ?>
        </fieldset>
    </div>

    <!-- Display -->
    <?php if (!empty($displays) && (!isset($displays['default']) || count($displays) > 1)) { ?>
    <fieldset>
        <h1><?= __('Display') ?></h1>
        <select name="display" id="<?= $display_id ?>">
            <?php foreach (\Arr::get($displays, 'views') as $id => $props) { ?>
            <option value="<?= $id ?>"<?= $id == $display ? ' selected="selected"' : '' ?>><?= \Arr::get($props, 'title') ?></option>
            <?php } ?>
            <optgroup label="Personnalisés">
                <?php foreach (\Arr::get($displays, 'model') as $id => $props) { ?>
                    <option value="<?= $id ?>"<?= $id == $display ? ' selected="selected"' : '' ?>><?= \Arr::get($props, 'title') ?></option>
                <?php } ?>
            </optgroup>
        </select>

    </fieldset>
    <?php } ?>

    <script type="text/javascript">
    require(['jquery-nos'], function () {
        var $select_type = $('#<?= $display_type_id ?>');
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
                        , height   : 0
                    }).width(b_width);
                    $wrapper_column.css({
                        visibility : 'visible'
                        , position : 'relative'
                        , height   : 'auto'
                    }).width(b_width);
                    break;
                case 'blocks' :
                    $wrapper_column.css({
                        visibility : 'hidden'
                        , position : 'absolute'
                        , height   : 0
                    }).width(b_width);
                    $wrapper_blocks.css({
                        visibility : 'visible'
                        , position : 'relative'
                        , height   : 'auto'
                    }).width(b_width);
                    break;
            }
        }
    });
    </script>

    <style type="text/css">
    h1 {
        font-size: 16px;
        margin: 15px 0 8px 0;
    }
    fieldset {
        margin: 0 0 10px 0;
    }
    fieldset:after {
        content: '';
        margin: 0;
        padding: 0;
        clear: both;
        display: block;
        height: 0;
        font-size: 0;
        line-height: 0;
    }
    </style>
</div>
