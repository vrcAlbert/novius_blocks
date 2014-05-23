<?php
/**
 * Novius Blocks
 *
 * @copyright  2014 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

namespace Novius\Blocks;

class Controller_Front_Block extends \Nos\Controller_Front_Application
{
    public function action_main($args = array())
    {
        // Get the available displays
        $displays = \Config::load('novius_blocks::displays', true);
        if (empty($displays)) {
            return false;
        }

        // Get the selected display
        $display = \Arr::get($displays, \Arr::get($args, 'display', 'default'));
        if (empty($display)) {
            return false;
        }

        // Generate the blocks in the selected display
        $blocks = \View::forge(\Arr::get($display, 'view'), array(
            'enhancer_args' => $args,
            'blocks'     => self::get_blocks($args),
        ), false);

        // Return the blocks wrapped in the selected display type
        return \View::forge($this->config['views'][$args['display_type']], array(
            'enhancer_args' => $args,
            'blocks' => $blocks,
        ), false);
    }

    /**
     * @param $args
     * @return array
     */
    public static function get_blocks($args)
    {
        $blocks = array();
        switch ($args['display_type']) {
            case 'blocks' :
                if (!empty($args['blocks_ids'])) {
                    $blocks_tmp = Model_Block::find('all', array(
                        'where' => array(
                            array('block_id', 'in', $args['blocks_ids'])
                        ),
                    ));
                    $blocks = array();
                    foreach ($args['blocks_ids'] as $id) {
                        $blocks[$blocks_tmp[$id]->block_id] = $blocks_tmp[$id];
                    }
                }
                break;
            case 'column' :
                if (!empty($args['blco_id'])) {
                    $column = Model_Column::find($args['blco_id']);
                    $blocks_tmp = $column->blocks;
                    if (!empty($column->blco_blocks_ordre)) {
                        $ordre = (array) unserialize($column->blco_blocks_ordre);
                        $ids = array();
                        foreach ($blocks_tmp as $tmp_block) {
                            $ids[$tmp_block->block_id] = $tmp_block->block_id;
                        }
                        foreach ($ordre as $block_id) {
                            if (in_array($block_id, $ids)) {
                                $blocks[] = $blocks_tmp[$block_id];
                                unset($ids[$block_id]);
                            }
                        }
                        if (count($ids)) {
                            foreach ($ids as $block_id) {
                                $blocks[] = $blocks_tmp[$block_id];
                            }
                        }
                    }
                }
                break;
        }
        return $blocks;
    }

    /**
     * Display a block
     *
     * @param $block
     * @return bool|mixed
     */
    public static function display_block($block)
    {
        if (empty($block)) {
            return false;
        }

        // Get the template configuration
        $templates_config = \Config::load('novius_blocks::templates', true);
        $template_config = \Arr::get($templates_config, $block->block_template);
        if (empty($template_config)) {
            return false;
        }

        // Get the block configuration
        $config = Model_Block::init_config($template_config, $block->block_template);

        // Append the custom stylesheet
        if ($config['css']) {
            \Nos\Nos::main_controller()->addCss($config['css']);
        }

        return static::get_block_view($block, $config, $block->block_template);
    }

    /**
     * @param Model_Block $block
     * @param $config
     * @param $name
     * @return mixed
     */
    public static function get_block_view(Model_Block $block, $config, $name)
    {
        $image = '';
        if (!empty($block->medias->image)) {
            $image = str_replace(
                array(
                    '{src}',
                    '{title}',
                ),
                array(
                    $block->medias->image->get_public_path_resized($config['image_params']['width'], $config['image_params']['height']),
                    $block->block_title,
                ),
                $config['image_params']['tpl']
            );
        }
        $description = \Nos\Nos::parse_wysiwyg($block->wysiwygs->description);
        $title = $block->block_title;
        $link = $block->get_url();
        $link_title = $block->block_link_title;

        if ($block->block_class) {
            $config['class'] .= ($config['class'] ? ' ' : '') . $block->block_class;
        }

        return str_replace(array(
            '{title}',
            '{name}',
            '{description}',
            '{link}',
            '{link_title}',
            '{image}',
            '{class}',
        ), array(
            $title,
            $name,
            $description,
            $link,
            $link_title,
            $image,
            $config['class'],
        ), \View::forge($config['view'], array(
            'config'        => $config,
            'description'   => $description,
            'title'         => $title,
            'link'          => $link,
            'link_title'    => $link_title,
            'link_new_page' => $block->block_link_new_page,
            'image'         => $image,
            'block'          => $block
        ), false));
    }
}