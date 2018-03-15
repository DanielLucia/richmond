<ul class="menuTop inlineBlock">
{foreach from=$menu.configuracion item=item}
    <li>
        <a href="{$item.url}" class="{$item.class}">{$item.texto}</a>
    </li>
{/foreach}
</ul>
