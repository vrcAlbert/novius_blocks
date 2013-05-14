<?php
    $title_id = uniqid('search_title_');
    $titre_liste_id = uniqid('titre_liste_');
    $wrapper_liste_id = uniqid('wrapper_liste_');
?>
<?= d($config_model); ?>
<form action="#">
    <div>
        <h1>Recherche d'un élément à synchroniser :</h1>
        <h2><label for="<?= $title_id ?>">Par titre :</label></h2>
        <input type="text" name="search_title" value="" id="<?= $title_id ?>" />
        <h2 id="<?= $titre_liste_id ?>">Derniers éléments ajoutés :</h2>
        <div id="<?= $wrapper_liste_id ?>">

        </div>
    </div>
</form>
