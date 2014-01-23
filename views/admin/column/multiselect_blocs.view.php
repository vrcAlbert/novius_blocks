<?php
/**
 * Novius Blocs
 *
 * @copyright  2013 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

    $values = array();
    if ($item->blco_id && $item->blocs) {
        if($item->blco_blocs_ordre) {
            $values_tmp = unserialize($item->blco_blocs_ordre);
            $values = array();
            $bloc_in_column = array();
            foreach ($item->blocs as $bloc) {
                $bloc_in_column[] = $bloc->bloc_id;
            }
            foreach ($values_tmp as $bloc_id) {
                if (in_array($bloc_id, $bloc_in_column)) {
                    $values[] = $bloc_id;
                }
            }
            foreach ($item->blocs as $bloc) {
                if (!in_array($bloc->bloc_id, $values)) {
                    $values[] = $bloc->bloc_id;
                }
            }
        } else {
            foreach ($item->blocs as $bloc) {
                $values[] = $bloc->bloc_id;
            }
        }
    }

    echo \Novius\Renderers\Renderer_Multiselect::renderer(array(
        'options'       => \Arr::assoc_to_keyval(\Novius\Blocs\Model_bloc::find('all', array('where' => array('bloc_context' => $item->blco_context))), 'bloc_id', 'bloc_title'),
        'name'          => 'blocs[]',
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