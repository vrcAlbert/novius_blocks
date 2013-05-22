<div class="bloc_wrapper {name}">
    <h2><?= $title ?></h2>
    <?php if ($image) {
        if ($url) {
            echo '<a href="' . $url . '">';
        }
            echo $image;
        if ($url) {
            echo '</a>';
        }
    }
    if ($url) {
    ?>
    <a class="bottom" href="<?= $url ?>">{link_title}</a>
    <? } ?>
</div>