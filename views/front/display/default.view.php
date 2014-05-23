<?php

if (empty($blocks)) {
    return ;
}

// Display the blocks
foreach ($blocks as $block) {
    echo \Novius\Blocks\Controller_Front_Block::display_block($block);
}
