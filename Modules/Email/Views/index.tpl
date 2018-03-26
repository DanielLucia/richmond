<div class="Container">
<div class="Col-9">
<table class="Table">
    <thead>
        <tr>
            <th width="10"></th>
            <th width="120">De</th>
            <th>Asunto</th>
            <th width="250"></th>
        </tr>
    </thead>
    {foreach from=$emails key=key item=item}
        <tr class="Draggable">
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
                <a href="javascript:void(0);" class="Button Small Link">Responder</a>
                <a href="javascript:void(0);" class="Button Small Danger Link">Borrar</a>
            </td>
        </tr>
    {/foreach}
</table>
</div>
<div class="Col-3">
    <h2 class="Subtitulo">Destacados</h2>
    <table class="Box Table Droppable">
        <thead>
            <tr>
                <th width="10"></th>
                <th width="120">De</th>
                <th>Asunto</th>
                <th width="250"></th>
            </tr>
        </thead>
    </table>
</div>
</div>
