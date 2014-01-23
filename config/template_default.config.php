<?php
/**
 * Novius Blocks
 *
 * @copyright  2014 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

return array(
    'title'             => '',
    'css'               => 'static/apps/novius_blocks/css/front/{name}.css',
    'view'              => 'novius_blocks::templates/{name}',
    'fields'            => array(
        'description',
        'link',
        'image',
    ),
    'image_params'      => array(
        'width'         => 300,
        'height'        => 200,
        'width_admin'   => 188,
        'height_admin'  => 100,
        'tpl'           => '<img src="{src}" alt="{title}" border="0" />',
        'tpl_admin'     => '<img src="{src}" alt="{title}" border="0" width="{width}" height="{height}" />',
    ),
    'class'             => '',
    'background'        => 'white', // examples : '#128', 'black' or 'transparent'
);