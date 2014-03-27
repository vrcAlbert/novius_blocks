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

use Nos\Controller_Front_Application;

use View;

class Controller_Front_Block extends Controller_Front_Application
{
    public function action_main($args = array())
    {
        return \View::forge($this->config['views'][$args['display_type']], array(
            'blocks'     => self::get_blocks($args),
        ), false);
    }

    /**
     * @param $args
     * @return array
     */
    public static function get_blocks ($args)
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
                    if ($column->blco_blocks_ordre) {
                        $ordre = unserialize($column->blco_blocks_ordre);
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
     * @param Model_Block $block
     * @param $config
     * @param $name
     * @return mixed
     */
    public static function get_block_view (Model_Block $block, $config, $name)
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