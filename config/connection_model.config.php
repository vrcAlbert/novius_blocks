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
    'pages' => array(
        'model'                         => 'Nos\Page\Model_Page',
        'label'                         => 'A page',
        'search_autocomplete_fields'    => array(
            'page_title',
        ),
        'autocomplete_value'            => 'page_id',
        'autocomplete_label'            => 'page_title',
        'display_label'                 => 'page_title',
        'data_mapping'                  => array(
            'title'                     => array(
                'field' => 'page_title',
                'label' => 'Title',
            ),
            'description'               => array(
                'field' => 'content',
                'label' => 'Description',
                'type'  => 'wysiwyg',
            ),
        ),
    ),
);