<?php
/**
 * Novius Blocs
 *
 * @copyright  2013 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

return array(
    'name'    => __('Blocs'),
    'version' => 'dev',
    'icons' => array(
        64 => 'static/apps/novius_blocs/img/64-blocs.png',
        32 => 'static/apps/novius_blocs/img/32-blocs.png',
        16 => 'static/apps/novius_blocs/img/16-blocs.png',
    ),
    'permission' => array(
    ),
    'provider' => array(
        'name' => 'Novius',
    ),
    'requires' => array('novius_renderers'),
    'namespace' => 'Novius\Blocs',
    'launchers' => array(
		'novius_blocs' => array(
            'name'    => 'Blocs',
            'action' => array(
                'action' => 'nosTabs',
                'tab' => array(
                    'url' => 'admin/novius_blocs/bloc/appdesk',
                ),
            ),
        ),
    ),
    'enhancers' => array(
        'blocs' => array(
            'title' => 'Blocs',
            'id' => 'blocs',
            'desc' => '',
            'enhancer' => 'novius_blocs/front/bloc/main',
            'previewUrl' => 'admin/novius_blocs/bloc/enhancer/preview',
            'dialog' => array(
                'contentUrl' => 'admin/novius_blocs/bloc/enhancer/popup',
                'ajax' => true,
                'width' => 500,
                'height' => 300,
            ),
        ),
    ),
    'data_catchers' => array(
        'novius_blocs' => array(
            'title' => 'Blocs',
            'description'  => 'Put forward this element',
            'action' => array(
                'action' => 'nosTabs',
                'tab' => array(
                    'url' => 'admin/novius_blocs/bloc/crud/insert_update/?context={{context}}&title={{urlencode:'.\Nos\DataCatcher::TYPE_TITLE.'}}&summary={{urlencode:'.\Nos\DataCatcher::TYPE_TEXT.'}}&thumbnail={{urlencode:'.\Nos\DataCatcher::TYPE_IMAGE.'}}&absolute_url={{urlencode:absolute_url}}',
                    'label' => 'Bloc',
                ),
            ),
            'onDemand' => true,
            'specified_models' => false,
            'required_data' => array(
                \Nos\DataCatcher::TYPE_TITLE,
            ),
            'optional_data' => array(
                \Nos\DataCatcher::TYPE_TEXT,
                \Nos\DataCatcher::TYPE_IMAGE,
                \Nos\DataCatcher::TYPE_URL,
            ),
        ),
    ),
);
