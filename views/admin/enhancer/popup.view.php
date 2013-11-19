<?php
    $type_affichage     = uniqid('type_affichage_');
    $blco_id            = \Input::get('blco_id', false);
    $blocs_ids          = \Input::get('blocs_ids', array());
    $context            = \Input::get('nosContext', false);
    $wrapper_columns    = uniqid('wrapper_colum_');
    $wrapper_blocs      = uniqid('wrapper_blocs_');

    switch ($type_affichage) {
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
        var $select_type = $('#<?= $type_affichage ?>');
        var $wrapper_column = $('#<?= $wrapper_columns ?>');
        var $wrapper_blocs = $('#<?= $wrapper_blocs ?>');

        $select_type.change(function(){
            affiche_select();
        });
        affiche_select();

        function affiche_select() {
            var type = $select_type.val();
            switch (type) {
                case 'column' :
                    $wrapper_blocs.css({
                        visibility : 'hidden'
                        , position : 'absolute'
                    });
                    $wrapper_column.css({
                        visibility : 'visible'
                        , position : 'relative'
                    });
                    break;
                case 'blocs' :
                    $wrapper_column.css({
                        visibility : 'hidden'
                        , position : 'absolute'
                    });
                    $wrapper_blocs.css({
                        visibility : 'visible'
                        , position : 'relative'
                    });
                    break;
            }
        }
    });
</script>
<h1><?= __('Display type'); ?></h1>
<select name="type_affichage" id="<?= $type_affichage ?>">
    <option value="column"<?= \Input::get('type_affichage') == 'column' ? ' selected' : '' ?>>Column</option>
    <option value="blocs"<?= \Input::get('type_affichage') == 'blocs' ? ' selected' : '' ?>>Séléction de blocs</option>
</select>
<br />&nbsp;

<!-- Séléction de columns -->
<div id="<?= $wrapper_columns ?>" style="visibility: hidden; position: absolute;">
    <?=
    \Lib\Renderers\Renderer_Categories::renderer(array(
        'width'         => '250px',
        'height'        => '100px',
        'namespace'     => 'Lib\Blocs',
        'folder'        => 'lib_blocs',
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
<!-- Séléction de blocs -->
<div id="<?= $wrapper_blocs ?>" style="visibility: hidden; position: absolute;">
    <?= \Lib\Renderers\Renderer_Multiselect::renderer(array(
        'options'       => \Arr::assoc_to_keyval(\Lib\Blocs\Model_bloc::find('all', array('where' => array('bloc_context' => $context))), 'bloc_id', 'bloc_title'),
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