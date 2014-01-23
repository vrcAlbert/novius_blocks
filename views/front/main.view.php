<?php
/**
 * Novius Blocs
 *
 * @copyright  2013 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */


// No blocks ?
if (!count($blocs)) {
    echo '&nbsp;';
    return;
}

// Loading of the templates config
$templates_config = \Config::load('novius_blocs::templates', true);

?>
<div class="blocs_wrapper">
<?php

foreach ($blocs as $bloc) {
    $name = $bloc->bloc_template;
    if (!$template_config = $templates_config[$name]) {
        continue;
    }

    $image = '';
    $config = \Novius\Blocs\Model_Bloc::init_config($template_config, $name);
    if ($config['css']) {
        \Nos\Nos::main_controller()->addCss($config['css']);
    }

    echo \Novius\Blocs\Controller_Front_Bloc::get_bloc_view($bloc, $config, $name);
}

?>
</div>