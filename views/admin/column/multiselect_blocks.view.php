<?php
/**
 * Novius Blocks
 *
 * @copyright  2014 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

    $values = array();
    if ($item->blco_id && $item->blocks) {
        if($item->blco_blocks_ordre) {
            $values_tmp = unserialize($item->blco_blocks_ordre);
            $values = array();
            $block_in_column = array();
            foreach ($item->blocks as $block) {
                $block_in_column[] = $block->block_id;
            }
            foreach ($values_tmp as $block_id) {
                if (in_array($block_id, $block_in_column)) {
                    $values[] = $block_id;
                }
            }
            foreach ($item->blocks as $block) {
                if (!in_array($block->block_id, $values)) {
                    $values[] = $block->block_id;
                }
            }
        } else {
            foreach ($item->blocks as $block) {
                $values[] = $block->block_id;
            }
        }
    }

    $where_options = array();
    if ($item->blco_context) {
        $where_options['bloc_context'] = $item->blco_context;
    }
    $options = \Arr::assoc_to_keyval(\Lib\Blocs\Model_bloc::find('all', array('where' => $where_options)), 'bloc_id', 'bloc_title');
    echo \Novius\Renderers\Renderer_Multiselect::renderer(array(
        'options'       => $options,
        'name'          => 'blocks[]',
        'values'        => $values,
        'order'         => true,
        'renderer_options' => array(
            'sortable' => true,
        ),
        'style'         => array(
            'width'     => '70%',
            'height'    => '400px',
        ),
    ));