<?php
namespace Lib\Blocs;

use Fuel\Core\DB;

class Controller_Admin_Column_Crud extends \Nos\Controller_Admin_Crud
{
    public function fields($fields)
    {
        $fields = parent::fields($fields);
        $query = Model_Bloc::find();
        $results = $query->get();
        $fields['blocs']['form']['options'] = \Arr::assoc_to_keyval($results, 'bloc_id', 'bloc_title');
        return $fields;
    }

}
