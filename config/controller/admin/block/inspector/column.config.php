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
    'model' => 'Novius\Blocks\Model_Column',
    'order_by' => 'blco_title',
    'input' => array(
        'key' => 'blco_id',
        'query' => function ($value, $query)
        {
            if (is_array($value)) {
                foreach ($value as $v) {
                    $query->_join_relation('columns', $join);
                    $query->where($join['alias_to'].'.blco_id', $v);
                }
            }
            return $query;
        },
    ),
    'appdesk' => array(
        'label'     => __('Group'),
    ),
);
