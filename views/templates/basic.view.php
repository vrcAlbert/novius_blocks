<div class="bloc_wrapper {name} {class}">
    <h2>{title}</h2>
    {image}
    <div class="content">
        {description}
    </div>
    <a href="{link}" class="bottom"<?= link_new_page ? ' target="blank"' : '' ?>><?= $config['link_text'] ?></a>
</div>