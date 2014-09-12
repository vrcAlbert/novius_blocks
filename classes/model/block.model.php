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

class Model_Block extends \Nos\Orm\Model
{

    protected static $_primary_key = array('block_id');
    protected static $_table_name = 'novius_blocks';

    protected static $_properties = array(
        'block_id' => array(
            'default' => null,
            'data_type' => 'int unsigned',
            'null' => false,
        ),
        'block_title' => array(
            'default' => null,
            'data_type' => 'varchar',
            'null' => false,
        ),
        'block_template' => array(
            'default' => null,
            'data_type' => 'varchar',
            'null' => true,
        ),
        'block_link_title' => array(
            'default' => null,
            'data_type' => 'varchar',
            'null' => true,
        ),
        'block_link_new_page' => array(
            'default' => null,
            'data_type' => 'boolean',
            'null' => true,
        ),
        'block_class' => array(
            'default' => null,
            'data_type' => 'varchar',
            'null' => true,
        ),
        'block_model' => array(
            'default' => null,
            'data_type' => 'varchar',
            'null' => true,
        ),
        'block_model_id' => array(
            'default' => null,
            'data_type' => 'int unsigned',
            'null' => true,
        ),
    );

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => true,
            'property'=>'block_created_at'
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_save'),
            'mysql_timestamp' => true,
            'property'=>'block_updated_at'
        ),
        'Orm\Observer_Self' => array(
        ),
    );

    protected static $_behaviours = array(
        'Nos\Orm_Behaviour_Urlenhancer' => array(
            'enhancers' => array('blocks_block'),
        ),
        'Nos\Orm_Behaviour_Contextable' => array(
            'events' => array('before_insert'),
            'context_property' => 'block_context',
        ),
        'Nos\Orm_Behaviour_Twinnable' => array(
            'events' => array('before_insert', 'after_insert', 'before_save', 'after_delete', 'change_parent'),
            'context_property'      => 'block_context',
            'common_id_property' => 'block_context_common_id',
            'is_main_property' => 'block_context_is_main',
            'common_fields' => array(),
        ),
    );

    protected static $_many_many = array(
        'columns' => array(
            'table_through' => 'novius_blocks_columns_liaison',
            'key_from' => 'block_id',
            'key_through_from' => 'blcl_block_id',
            'key_through_to' => 'blcl_blco_id',
            'key_to' => 'blco_id',
            'cascade_save' => false,
            'cascade_delete' => false,
            'model_to' => 'Novius\Blocks\Model_Column',
        ),
    );

    protected static $_has_many = array(
        'attributes' => array(
            'key_from' => 'block_id', // key in this model
            'model_to' => 'Novius\Blocks\Model_Block_Attribute',
            'key_to' => 'blat_block_id', // key in the related model
            'cascade_save' => true, // update the related table on save
            'cascade_delete' => true, // delete the related data when deleting the parent
        ),
    );

    protected static $_eav = array(
        'attributes' => array( // we use the statistics relation to store the EAV data
            'attribute' => 'blat_key', // the key column in the related table contains the attribute
            'value' => 'blat_value', // the value column in the related table contains the value
        )
    );

    /**
     * Return the link that goes with the block
     * @return mixed|\Nos\Orm\Model|null
     */
    public function get_url ()
    {
        if ($this->block_model_id && $this->block_model) {
            $models = \Config::load('novius_blocks::connection_model', true);
            if (!isset($models[$this->block_model])) {
                return $this->block_link;
            }
            $model_config = $models[$this->block_model];
            $class_name = $model_config['model'];
            // If no model is associated, we just return the text link of the block
            if (!$item = $class_name::find($this->block_model_id)) {
                return $this->block_link;
            }

            $url = null;
            if ($item::behaviours('Nos\Orm_Behaviour_Urlenhancer', false) !== false || method_exists($item, 'url')) {
                $url = $item->url();
            }

            if ($url) {
                return $url;
            }
        }
        return $this->block_link;
    }

    /**
     * Return the config of a particular block
     * Default parameters are defined in this function
     * @param $config
     * @param $name
     * @return array
     */
    public static function init_config ($config, $name) {
        $default_config = \Config::load('novius_blocks::template_default', true);
        $default_config['view'] = str_replace('{name}', $name, $default_config['view']);
        $default_config['css'] = str_replace('{name}', $name, $default_config['css']);

        // Loading of the local view
        if (is_file(APPPATH . 'views/novius_blocks/' . $name . '.view.php')) {
            $default_config['view'] = 'local::/novius_blocks/' . $name;
        }

        // We check if a local CSS file has been created
        if (is_file(DOCROOT . 'static/css/blocks/' . $name . '.css')) {
            $default_config['css'] = 'static/css/blocks/' . $name . '.css';
        }
        $retour_config = \Arr::merge($default_config, $config);
        if (isset($config['fields']) && $config['fields']) {
            $retour_config['fields'] = $config['fields'];
        }
        return $retour_config;
    }

    /**
     * If a block is not set in the order field of its columns, it is set in the last position.
     */
    public function _event_after_save()
    {

        foreach ($this->columns as $column) {
            if (!empty($column->blco_blocks_ordre)) {
                $blocks_order = (array) unserialize($column->blco_blocks_ordre);
            } else {
                $blocks_order = array();
            }
            if (!in_array($this->get('id'), $blocks_order)) {
                array_push($blocks_order, $this->get('id'));
                $column->blco_blocks_ordre = serialize($blocks_order);
                $column->save();
            }
        }

    }


}
