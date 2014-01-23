<?php
/**
 * Novius Blocs
 *
 * @copyright  2013 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

if (is_array($content) && !empty($content['view'])) {
    $content = (string) View::forge($content['view'], $view_params + $content['params'], false);
} else {
    $content = (string) is_callable($content) ? $content() : $content;
}

if (!empty($content) || !empty($show_when_empty)) {
    ?>
    <div class="expander fieldset" style="margin-bottom:1.5em;" <?= !empty($options) ? 'data-wijexpander-options="'.htmlspecialchars(Format::forge()->to_json($options)).'"' : '' ?>>
        <h3><?= $title ?></h3>
        <div class="wrapper_links" style="overflow:visible;<?= !empty($nomargin) ? 'margin:0;padding:0;' : '' ?>">
            <div class="link_default">
            <?= $content; ?>
            </div>
            <div class="link_model" style="margin:0 15px 15px 15px; padding: 15px 0 0 0;">
            </div>
        </div>
    </div>
<?php
}
