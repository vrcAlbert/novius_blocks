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
    protected static $_primary_key = array('blco_id');
    protected static $_table_name = 'novius_blocks_displays';

    protected static $_properties = array(
        'blco_id' => array(
            'default' => null,
            'data_type' => 'int unsigned',
            'null' => false,
        ),
        'blco_title' => array(
            'default' => null,
            'data_type' => 'varchar',
            'null' => false,
        ),
        'blco_parent_id' => array(
            'default' => null,
            'data_type' => 'int unsigned',
            'null' => true,
        ),
        'blco_blocks_ordre' => array(
            'default' => null,
            'data_type' => 'text',
            'null' => true,
        ),
    );

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => true,
            'property'=>'blco_created_at'
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_save'),
            'mysql_timestamp' => true,
            'property'=>'blco_updated_at'
        )
    );

    protected static $_behaviours = array(
        'Nos\Orm_Behaviour_Contextable' => array(
            'events' => array('before_insert'),
            'context_property' => 'blco_context',
        ),
        'Nos\Orm_Behaviour_Twinnable' => array(
            'events' => array('before_insert', 'after_insert', 'before_save', 'after_delete', 'change_parent'),
            'context_property'      => 'blco_context',
            'common_id_property' => 'blco_context_common_id',
            'is_main_property' => 'blco_context_is_main',
            'common_fields'   => array(),
        ),
    );

    protected static $_many_many = array(
        'blocks' => array(
            'table_through' => 'novius_blocks_displays_liaison',
            'key_from' => 'blco_id',
            'key_through_from' => 'blcl_blco_id',
            'key_through_to' => 'blcl_block_id',
            'key_to' => 'block_id',
            'cascade_save' => false,
            'cascade_delete' => false,
            'model_to' => 'Novius\Blocks\Model_Block',
        ),
    );
}
