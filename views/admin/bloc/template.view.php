<?php
/**
 * Novius Blocs
 *
 * @copyright  2013 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

$templates_config = \Config::load('novius_blocs::templates', true);
?>
<link rel="stylesheet" href="static/apps/novius_blocs/css/admin/template.css" />
<script type="text/javascript">
    require(['jquery-nos', 'static/apps/novius_blocs/js/admin/blocs.js'], function ($, callback_fn) {
        $(function () {
            callback_fn.call($('#<?= $fieldset->form()->get_attribute('id') ?>'), '<?= uniqid('_this_blocs_'); ?>');
        });
    });
</script>
<div class="blocs_wrapper">
<?php

foreach ($templates_config as $name => $props) {
    $props = \Novius\Blocs\Model_Bloc::init_config($props, $name);
    $props['fields'][] = 'titre';   // Mandatory title

    // We set the transmitted datas
    $title = $item->bloc_title ? $item->bloc_title : 'Title';
    $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ipsum eros, euismod sagittis interdum non, pulvinar in tellus.';
    $url = '#';
    $image = '';
    $link_title = $item->bloc_link_title ? $item->bloc_link_title : 'Link';

    if (isset($props['image_params'])) {
        $image = str_replace(
            array(
                '{src}',
                '{width}',
                '{height}',
            ),
            array(
                'http://lorempixel.com/' . $props['image_params']['width_admin'] . '/' . $props['image_params']['height_admin'],
                $props['image_params']['width_admin'],
                $props['image_params']['height_admin'],
            ),
            $props['image_params']['tpl_admin']
        );
    }

    if ($item->bloc_class) {
        $props['class'] .= ($props['class'] ? ' ' : '') . $item->bloc_class;
    }

    // We load the corresponding view
    $view = \View::forge($props['view'], array(
        'config' => $props,
        'name' => $name,
        'title' => $title,
        'description' => $description,
        'url' => $url,
        'image' => $image,
        'link_title' => $link_title,
        'bloc' => $item
    ), false);

    $view = str_replace(array(
        '{title}',
        '{name}',
        '{description}',
        '{link}',
        '{link_title}',
        '{image}',
        '{class}',
    ), array(
        $title,
        $name,
        $description,
        $url,
        $link_title,
        $image,
        $props['class'],
    ), $view);

    if ($props['css']) {
        ?>
        <link rel="stylesheet" href="<?= $props['css'] ?>" />
        <?php
    }

    // We check if there is an existing CSS file for the administration
    if (is_file(DOCROOT . 'static/css/blocs/admin/' . $name . '.css')) {
        ?>
        <link rel="stylesheet" href="static/css/blocs/admin/<?= $name ?>.css" />
        <?php
    }

    ?>
    <div class="bloc_over_wrapper" style="<?= $props['background'] == 'transparent' ? 'background:url(static/apps/novius_blocs/img/transparent.png) repeat;' : 'background:'.$props['background'] ?>">
        <? if (!empty($props['title'])) { ?>
            <h3 class="bloc_title"><?= $props['title'] ?></h3>
        <? } ?>
        <?= $view ?>
        <div class="bloc_select">
            <label for="template_<?= $name ?>">
                <input data-fields="<?= implode('|', $props['fields']) ?>" class="notransform" type="radio" name="bloc_template" id="template_<?= $name ?>" value="<?= $name ?>"<?= $item->bloc_template == $name ? ' checked' : '' ?> />
            </label>
        </div>
    </div>
    <?php
}
?>
</div>