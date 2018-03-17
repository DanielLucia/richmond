<table class="Table">
    <tr>
        <th>Widget</th>
        <th>Descripción</th>
        <th width="250"></th>
    </tr>
    {foreach from=$widgets key=key item=item}
        <tr>
            <td>
                <strong>{$item.titulo}</strong>
            </td>
            <td>{$item.descripcion}</td>
            <td class="textRight">
                <a href="" class="Button Small">Habilitar</a>
            </td>
        </tr>
    {/foreach}
</table>
