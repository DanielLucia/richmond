<table class="Table">
    <thead>
        <tr>
            <th class="hiddenMobile" width="200"></th>
            <th>Módulo</th>
            <th>Descripción</th>
            <th width="250"></th>
        </tr>
    </thead>
    {foreach from=$modules key=key item=item}
        <tr>
            <td class="hiddenMobile">{$key}</td>
            <td>
                <strong>{$item.Title}</strong>
                {if $item.Author}
                    <br /><small>por {$item.Author}</small>
                {/if}
                <br /><small><em>{$item.class_name}</em></small>
            </td>
            <td>{$item.Description}</td>
            <td class="textRight">
                {if $item.installed && $item.configuration}
                    <a href="{$item.configuration}" class="Button Small Link">Configuración</a>
                {/if}
                {if $item.installed}
                    <a href="{$item.url_action}" class="Button Small Danger Question Link" data-question="¿Estás seguro? Se perderán todos los datos realitvos al módulo.">Desinstalar</a>
                {else}
                    <a href="{$item.url_action}" class="Button Small Link">Instalar</a>
                {/if}
            </td>
        </tr>
    {/foreach}
</table>
