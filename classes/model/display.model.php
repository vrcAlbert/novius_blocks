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

class Model_Display extends \Nos\Orm\Model
{
    protected static $_primary_key = array('blod_id');
    protected static $_table_name = 'novius_blocks_displays';

    protected static $_properties = array(
        'blod_id' => array(
            'default' => null,
            'data_type' => 'int unsigned',
            'null' => false,
        ),
        'blod_title' => array(
            'default' => null,
            'data_type' => 'varchar',
            'null' => false,
        ),
        'blod_structure' => array(
            'default' => null,
            'data_type' => 'serialize',
            'null' => true,
        ),
    );

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => true,
            'property'=>'blod_created_at'
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_save'),
            'mysql_timestamp' => true,
            'property'=>'blod_updated_at'
        ),
        'Orm\\Observer_Typing'
    );

    protected static $_behaviours = array(
    );

    protected static $_many_many = array(
    );
}
