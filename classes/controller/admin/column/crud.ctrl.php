<?php
/**
 * Novius Blocs
 *
 * @copyright  2013 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

namespace Novius\Blocs;

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
