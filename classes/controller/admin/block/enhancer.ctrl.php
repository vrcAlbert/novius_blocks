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

class Controller_Admin_Block_Enhancer extends \Nos\Controller_Admin_Enhancer
{
    public function action_save(array $args = null)
    {
        if (empty($args)) {
            $args = $_POST;
        }
        if (!empty($args['enhancer'])) {
            $enhancers = \Nos\Config_Data::get('enhancers', array());
            if (!empty($enhancers[$args['enhancer']])) {
                $enhancer = $enhancers[$args['enhancer']];
                $icon = \Config::icon($enhancer['application'], 64);
                $this->config['preview']['params'] = array_merge(array(
                    'icon' => !empty($icon) ? $icon : 'static/apps/noviusos_appmanager/img/64/app-manager.png',
                    'title' => \Arr::get($enhancer, 'title', __('I’m an application. Give me a name!')),
                ), $this->config['preview']['params']);
            }
        }

        // Get the selected display
        $display_id = \Arr::get($args, 'display', 'default');

        // Generate the blocks in the selected display
        $blocks = Controller_Front_Block::generate_display($display_id, $args);

        if ($this->config['preview']['custom']) {
            $view = $this->config['preview']['view'];
        } else {
            $view = 'nos::admin/enhancer/preview';
        }
        $blocks = (string) $blocks;
        // Return the blocks wrapped in the selected display type
        $preview = \View::forge($view, array( //$this->config['views'][$args['display_type']]
//            'enhancer_args' => $args,
//            'blocks' => $blocks,
            'layout' => $this->config['preview']['layout'],
            'params' => $this->config['preview']['params'],
            'enhancer_args' => $args,
            'blocks' => $blocks,
        ), false)->render();

        $body = array(
            'debug'  => $this->config['preview'],
            'config'  => $args,
            'preview' => $preview,
        );
//        \View::forge($view, array(
//            'layout' => $this->config['preview']['layout'],
//            'params' => $this->config['preview']['params'],
//            'enhancer_args' => $args,
//            'blocks' => $blocks,
//        ))
        \Response::json($body);
    }
}