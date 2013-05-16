<link rel="stylesheet" href="static/apps/lib_blocs/css/front/tpl3.css" />
<div class="bloc_wrapper tpl3">
    <h2><?= $title ?></h2>
    <?php if ($image) {
        ?>
            <?= $image ?>
        <?php
    } ?>
    <a href="<?= $url ?>">Lire la suite</a>
</div>