<?php
/**
 * Novius Blocs
 *
 * @copyright  2013 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

namespace Novius\Blocs;

use Nos\Controller_Front_Application;

use View;

class Controller_Front_Bloc extends Controller_Front_Application
{
    public function action_main($args = array())
    {
        return \View::forge($this->config['views'][$args['display_type']], array(
            'blocs'     => self::get_blocs($args),
        ), false);
    }

    /**
     * @param $args
     * @return array
     */
    public static function get_blocs ($args)
    {
        $blocs = array();
        switch ($args['display_type']) {
            case 'blocs' :
                if (!empty($args['blocs_ids'])) {
                    $blocs_tmp = Model_Bloc::find('all', array(
                        'where' => array(
                            array('bloc_id', 'in', $args['blocs_ids'])
                        ),
                    ));
                    $blocs = array();
                    foreach ($args['blocs_ids'] as $id) {
                        $blocs[$blocs_tmp[$id]->bloc_id] = $blocs_tmp[$id];
                    }
                }
                break;
            case 'column' :
                if (!empty($args['blco_id'])) {
                    $column = Model_Column::find($args['blco_id']);
                    $blocs_tmp = $column->blocs;
                    if ($column->blco_blocs_ordre) {
                        $ordre = unserialize($column->blco_blocs_ordre);
                        $ids = array();
                        foreach ($blocs_tmp as $tmp_bloc) {
                            $ids[$tmp_bloc->bloc_id] = $tmp_bloc->bloc_id;
                        }
                        foreach ($ordre as $bloc_id) {
                            if (in_array($bloc_id, $ids)) {
                                $blocs[] = $blocs_tmp[$bloc_id];
                                unset($ids[$bloc_id]);
                            }
                        }
                        if (count($ids)) {
                            foreach ($ids as $bloc_id) {
                                $blocs[] = $blocs_tmp[$bloc_id];
                            }
                        }
                    }
                }
                break;
        }
        return $blocs;
    }

    /**
     * @param Model_Bloc $bloc
     * @param $config
     * @param $name
     * @return mixed
     */
    public static function get_bloc_view (Model_Bloc $bloc, $config, $name)
    {
        $image = '';
        if (!empty($bloc->medias->image)) {
            $image = str_replace(
                array(
                    '{src}',
                    '{title}',
                ),
                array(
                    $bloc->medias->image->get_public_path_resized($config['image_params']['width'], $config['image_params']['height']),
                    $bloc->bloc_title,
                ),
                $config['image_params']['tpl']
            );
        }
        $description = \Nos\Nos::parse_wysiwyg($bloc->wysiwygs->description);
        $title = $bloc->bloc_title;
        $link = $bloc->get_url();
        $link_title = $bloc->bloc_link_title;

        if ($bloc->bloc_class) {
            $config['class'] .= ($config['class'] ? ' ' : '') . $bloc->bloc_class;
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
            'link_new_page' => $bloc->bloc_link_new_page,
            'image'         => $image,
            'bloc'          => $bloc
        ), false));
    }
}