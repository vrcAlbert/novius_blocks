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
    'basic' => array(
        'image_params' => array(
            'width_admin'   => 130,
            'height_admin'  => 80,
            'tpl'           => '<div class="wrapper_img"><img src="{src}" alt="{title}" border="0" /></div>',
            'tpl_admin'     => '<div class="wrapper_img"><img src="{src}" alt="{title}" border="0" width="{width}" height="{height}" /></div>',
            'width'         => 220,
            'height'        => 150,
        ),
    ),
    'image_large' => array(
        'fields' => array(
            'image',
            'link',
        ),
    ),
    'only_wysiwyg' => array(
        'css' => '',
        'fields' => array(
            'description',
        ),
    ),
//    'tpl' => array(
//        'view' => 'novius_blocks::templates/tpl', //optional : wiew of the template
//        'fields' => array( //optional : list of the available fields of this template
//            'description',
//            'link',
//            'title',
//            'image',
//        ),
//    ),
);