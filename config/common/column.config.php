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
    'data_mapping' => array(
        'blco_title' => array(
            'title' => __('Groups'),
        ),
    ),
    'controller' => 'column/crud',
    'actions' => array(
        'add' => array(
            'label' => __('Add a group'),
        ),
    ),
);