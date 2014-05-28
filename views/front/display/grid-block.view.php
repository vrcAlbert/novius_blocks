<?php
if (empty($block)) {
    return false;
}

$config = \Config::load('display', true);

$block = \Novius\Blocks\Controller_Front_Block::display_block($block);

if (\Arr::get($config, 'force_grid_square')) {
    ?>
    <div class="block-square" style="height: 0; padding-bottom: 100%; width: 100%; position: relative; overflow: hidden;">
        <div class="block-square-layout" style="width: 100%; height: 100%; position: absolute; left: 0;">
            <?= $block; ?>
        </div>
    </div>
    <?php
} else {
    echo $block;
}
