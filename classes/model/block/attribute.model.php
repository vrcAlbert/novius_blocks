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

use Orm\Model;

class Model_Block_Attribute extends Model
{
    protected static $_table_name = 'novius_blocks_attributes';
    protected static $_primary_key = array('blat_id');

    protected static $_title_property = 'blat_key';
    protected static $_properties = array(
        'blat_id' => array(
            'default' => null,
            'data_type' => 'int',
            'null' => false,
        ),
        'blat_block_id' => array(
            'default' => null,
            'data_type' => 'int',
            'null' => false,
        ),
        'blat_key' => array(
            'default' => '',
            'data_type' => 'varchar',
            'null' => false,
        ),
        'blat_value' => array(
            'default' => '',
            'data_type' => 'varchar',
            'null' => false,
        ),
    );
}
