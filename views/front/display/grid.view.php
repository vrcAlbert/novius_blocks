<?php
if (empty($blocks)) {
    return false;
}

if (empty($display) || empty($display->blod_structure)) {
    return false;
}

?>
<div class="block-display block-display-<?= $display->blod_id ?>">
    <?php foreach ($display->blod_structure as $columns) { ?>
    <div class="row">
        <?php foreach ($columns as $column) { ?>
        <div class="large-<?= \Arr::get($column, 'w', 12) ?> columns">
            <div class="row">
                <?php
                foreach (\Arr::get($column, 'blocks') as $block) {
                    $next_block = array_shift($blocks);
                    $width = strtr((\Arr::get($block, 'w', 12)) * (100 / \Arr::get($column, 'w', 12)), array(',' => '.'));
                    ?>
                    <div class="block column" style="width: <?= $width ?>%;">
                        <?= \View::forge('novius_blocks::front/display/grid-block', array(
                            'block' => $next_block,
                        ), false) ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
</div>
