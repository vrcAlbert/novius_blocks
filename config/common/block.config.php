<?php
/**
 * Novius Blocks
 *
 * @copyright  2014 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

$templates_config = \Config::load('novius_blocks::templates', true);

return array(
    'controller' => 'block/crud',
    'data_mapping' => array(
        'block_title' => array(
            'title' => __('Title'),
        ),
        'block_template' => array(
            'title' => __('Type'),
            'value' => function ($item) use ($templates_config) {
                $template_config = \Arr::get($templates_config, $item->block_template.'.title', $item->block_template);
                return $template_config;
            },
        ),
    ),
    'actions' => array(
        'add' => array(
            'label' => __('Add a block'),
        ),
    ),
);
