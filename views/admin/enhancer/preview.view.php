<?php
/**
 * Novius Blocs
 *
 * @copyright  2013 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */


if (!count($blocs)) {
    echo 'No block will be displayed';
    exit();
}


$templates_config = \Config::load('novius_blocs::templates', true);


?>
<div class="blocs_wrapper blocs_wrapper_enhancer">
<?php
foreach ($blocs as $bloc) {
    $name = $bloc->bloc_template;
    if (!$template_config = $templates_config[$name]) {
        continue;
    }

    $image = '';
    $config = \Novius\Blocs\Model_Bloc::init_config($template_config, $name);
    if ($config['css']) {
        ?>
        <link rel="stylesheet" href="<?= $config['css'] ?>" />
        <?php
    }

    // Does a special admin CSS file exists
    if (is_file(DOCROOT . 'static/css/blocs/admin/' . $name . '.preview.css')) {
        ?>
        <link rel="stylesheet" href="static/css/blocs/admin/<?= $name ?>.preview.css" />
    <?php
    } else if (is_file(DOCROOT . 'static/css/blocs/admin/' . $name . '.css')) {
        ?>
        <link rel="stylesheet" href="static/css/blocs/admin/<?= $name ?>.css" />
    <?php
    }
    echo \Novius\Blocs\Controller_Front_Bloc::get_bloc_view($bloc, $config, $name);
}
?>
</div>