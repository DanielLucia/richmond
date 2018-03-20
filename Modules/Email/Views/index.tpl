<a href="{'sync_inbox'|url}">Actualizar</a>
<table class="Table">
    <thead>
        <tr>
            <th width="40"></th>
            <th>Asunto</th>
            <th width="240">De</th>
            <th width="160">Fecha</th>
            <th width="170"></th>
        </tr>
    </thead>
    {foreach from=$emails key=key item=item}
        <tr>
            <td><input type="checkbox" name="email[]" /></td>
            <td>
                <strong><a href="{'inbox_detail'|url:['uid' => $item.uid]}">{$item.title}</a></strong>
            </td>
            <td>{$item.email_from}</td>
            <td><small>{$carbon::now()->diffForHumans($carbon::parse($item.date), true, false, 2)}</small></td>
            <td class="textRight">
                <a href="javascript:void(0);" class="Button Small">Responder</a>
                <a href="javascript:void(0);" class="Button Small">Borrar</a>
            </td>
        </tr>
    {/foreach}
</table>
