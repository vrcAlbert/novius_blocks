<?php
/**
 * Novius Blocks
 *
 * @copyright  2014 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

$blocks = trim($blocks);

// Nothing to display ?
if (empty($blocks)) {
    ?>
    <div>
        <?= __('No block to display') ?>
    </div>
    <?php
    return ;
}

?>
<div>
    <style type="text/css">
    .blocks_wrapper {
        clear: both;
    }
    .blocks_wrapper .block_wrapper {
        margin: 20px 0 0 0;
    }

    .novius_blocks_preview *,
    .novius_blocks_preview *:before,
    .novius_blocks_preview *:after {
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }

    .novius_blocks_preview .row {
        width: 100%;
        margin: 0 auto;
        max-width: 100%;
        *zoom: 1;
    }
    .novius_blocks_preview .row:before,
    .novius_blocks_preview .row:after {
        content: " ";
        display: table;
    }
    .novius_blocks_preview .row:after {
        clear: both;
    }
    .novius_blocks_preview .row.collapse > .column,
    .novius_blocks_preview .row.collapse > .columns {
        position: relative;
        padding-left: 0;
        padding-right: 0;
        float: left;
    }
    .novius_blocks_preview .row.collapse .row {
        margin-left: 0;
        margin-right: 0;
    }
    .novius_blocks_preview .row .row {
        width: auto;
        margin-left: -10px;
        margin-right: -10px;
        margin-top: 0;
        margin-bottom: 0;
        max-width: none;
        *zoom: 1;
    }
    .novius_blocks_preview .row .row:before,
    .novius_blocks_preview .row .row:after {
        content: " ";
        display: table;
    }
    .novius_blocks_preview .row .row:after {
        clear: both;
    }
    .novius_blocks_preview .row .row.collapse {
        width: auto;
        margin: 0;
        max-width: none;
        *zoom: 1;
    }
    .novius_blocks_preview .row .row.collapse:before,
    .novius_blocks_preview .row .row.collapse:after {
        content: " ";
        display: table;
    }
    .novius_blocks_preview .row .row.collapse:after {
        clear: both;
    }

    .novius_blocks_preview .column,
    .novius_blocks_preview .columns {
        position: relative;
        padding-left: 10px;
        padding-right: 10px;
        width: 100%;
        float: left;
    }

    .novius_blocks_preview .small-1 {
        position: relative;
        width: 8.33333%;
    }

    .novius_blocks_preview .small-2 {
        position: relative;
        width: 16.66667%;
    }

    .novius_blocks_preview .small-3 {
        position: relative;
        width: 25%;
    }

    .novius_blocks_preview .small-4 {
        position: relative;
        width: 33.33333%;
    }

    .novius_blocks_preview .small-5 {
        position: relative;
        width: 41.66667%;
    }

    .novius_blocks_preview .small-6 {
        position: relative;
        width: 50%;
    }

    .novius_blocks_preview .small-7 {
        position: relative;
        width: 58.33333%;
    }

    .novius_blocks_preview .small-8 {
        position: relative;
        width: 66.66667%;
    }

    .novius_blocks_preview .small-9 {
        position: relative;
        width: 75%;
    }

    .novius_blocks_preview .small-10 {
        position: relative;
        width: 83.33333%;
    }

    .novius_blocks_preview .small-11 {
        position: relative;
        width: 91.66667%;
    }

    .novius_blocks_preview .small-12 {
        position: relative;
        width: 100%;
    }

    .novius_blocks_preview .small-offset-0 {
        position: relative;
        margin-left: 0%;
    }

    .novius_blocks_preview .small-offset-1 {
        position: relative;
        margin-left: 8.33333%;
    }

    .novius_blocks_preview .small-offset-2 {
        position: relative;
        margin-left: 16.66667%;
    }

    .novius_blocks_preview .small-offset-3 {
        position: relative;
        margin-left: 25%;
    }

    .novius_blocks_preview .small-offset-4 {
        position: relative;
        margin-left: 33.33333%;
    }

    .novius_blocks_preview .small-offset-5 {
        position: relative;
        margin-left: 41.66667%;
    }

    .novius_blocks_preview .small-offset-6 {
        position: relative;
        margin-left: 50%;
    }

    .novius_blocks_preview .small-offset-7 {
        position: relative;
        margin-left: 58.33333%;
    }

    .novius_blocks_preview .small-offset-8 {
        position: relative;
        margin-left: 66.66667%;
    }

    .novius_blocks_preview .small-offset-9 {
        position: relative;
        margin-left: 75%;
    }

    .novius_blocks_preview .small-offset-10 {
        position: relative;
        margin-left: 83.33333%;
    }


    .novius_blocks_preview .large-1 {
        position: relative;
        width: 8.33333%;
    }

    .novius_blocks_preview .large-2 {
        position: relative;
        width: 16.66667%;
    }

    .novius_blocks_preview .large-3 {
        position: relative;
        width: 25%;
    }

    .novius_blocks_preview .large-4 {
        position: relative;
        width: 33.33333%;
    }

    .novius_blocks_preview .large-5 {
        position: relative;
        width: 41.66667%;
    }

    .novius_blocks_preview .large-6 {
        position: relative;
        width: 50%;
    }

    .novius_blocks_preview .large-7 {
        position: relative;
        width: 58.33333%;
    }

    .novius_blocks_preview .large-8 {
        position: relative;
        width: 66.66667%;
    }

    .novius_blocks_preview .large-9 {
        position: relative;
        width: 75%;
    }

    .novius_blocks_preview .large-10 {
        position: relative;
        width: 83.33333%;
    }

    .novius_blocks_preview .large-11 {
        position: relative;
        width: 91.66667%;
    }

    .novius_blocks_preview .large-12 {
        position: relative;
        width: 100%;
    }

    .novius_blocks_preview [class*="column"] + [class*="column"]:last-child {
        float: right;
    }

    .novius_blocks_preview [class*="column"] + [class*="column"].end {
        float: left;
    }
    </style>
    <div class="blocks_wrapper blocks_wrapper_enhancer novius_blocks_preview">
        <?= $blocks ?>
    </div>
</div>
