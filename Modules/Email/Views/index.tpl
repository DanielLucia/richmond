<table class="Table">
    <thead>
        <tr>
            <th width="10"></th>
            <th width="120">De</th>
            <th>Asunto</th>
            <th width="80"></th>
        </tr>
    </thead>
    {foreach from=$emails key=key item=item}
        <tr>
            <td><input type="checkbox" name="email[]" /></td>

            <td>{$item.email_from}
                <br /><small>{$carbon::now()->diffForHumans($carbon::parse($item.date), true, false, 2)}</small>
            </td>
            <td>
                {if $item.leido == 0}
                <strong><a href="{'inbox_detail'|url:['uid' => $item.uid]}">{$item.title}</a></strong>
                {else}
                <a href="{'inbox_detail'|url:['uid' => $item.uid]}">{$item.title}</a>
                {/if}
            </td>
            <td class="textRight">
                <a href="javascript:void(0);" class="Button Small">Responder</a>
                <a href="javascript:void(0);" class="Button Small">Borrar</a>
            </td>
        </tr>
    {/foreach}
</table>
