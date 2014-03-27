<?php
/**
 * Novius Blocks
 *
 * @copyright  2014 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */


// No blocks ?
if (!count($blocks)) {
    echo '&nbsp;';
    return;
}

// Loading of the templates config
$templates_config = \Config::load('novius_blocks::templates', true);

?>
<div class="blocks_wrapper">
<?php

foreach ($blocks as $block) {
    $name = $block->block_template;
    if (!$template_config = $templates_config[$name]) {
        continue;
    }

    $image = '';
    $config = \Novius\Blocks\Model_Block::init_config($template_config, $name);
    if ($config['css']) {
        \Nos\Nos::main_controller()->addCss($config['css']);
    }
    echo \Novius\Blocks\Controller_Front_Block::get_block_view($block, $config, $name);
}

?>
</div>