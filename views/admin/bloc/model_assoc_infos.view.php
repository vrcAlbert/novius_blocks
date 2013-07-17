<h2>Ce bloc est lié à un objet (<?= $config['label'] ?>)</h2>
&nbsp;
<p>Nom de l'objet : <strong>"<?= $item->{$config['display_label']} ?>"</strong></p>
&nbsp;
<p>
    <button class="delete_liaison_model ui-state-error ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false">
        <span class="ui-button-icon-primary ui-icon ui-icon-trash"></span>
        <span class="ui-button-text">Supprimer cette liaison</span>
    </button>
</p>